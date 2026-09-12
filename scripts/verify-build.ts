import { existsSync, readFileSync, readdirSync, statSync } from 'node:fs';
import { readFile } from 'node:fs/promises';
import path from 'node:path';
import { parse } from 'parse5';
import { unzipSync } from 'fflate';
import { inventorySources, readSource } from '../src/lib/sources.ts';
import { createPluginZip } from '../src/lib/downloads.ts';
import { withBase } from '../src/lib/urls.ts';
import { BASE_PATH, SITE_URL } from '../src/lib/site.ts';

const dist = path.resolve('dist');
const fail = (message: string): never => { throw new Error(message); };
const assert = (condition: unknown, message: string) => { if (!condition) fail(message); };
const htmlPath = (route: string) => path.join(dist, route, 'index.html');
const walkFiles = (directory: string): string[] => readdirSync(directory).flatMap((entry) => { const file = path.join(directory, entry); return statSync(file).isDirectory() ? walkFiles(file) : [file]; });

const elements = (html: string) => {
  const found: any[] = [];
  const visit = (node: any) => { if (node.tagName) found.push(node); for (const child of node.childNodes ?? []) visit(child); };
  visit(parse(html));
  return found;
};
const attr = (node: any, name: string) => node.attrs?.find((attribute: any) => attribute.name === name)?.value;
const text = (node: any): string => (node.value ?? '') + (node.childNodes ?? []).map(text).join('');

const markdown = walkFiles(path.resolve('src/content/snippets')).filter((file) => file.endsWith('.md'));
const sources = await inventorySources();
assert(markdown.length === sources.length, `Expected ${sources.length} companions, found ${markdown.length}`);
const snippets = markdown.map((file) => {
  const content = readFileSync(file, 'utf8');
  const source = content.match(/^source: (.+)$/m)?.[1]?.trim() ?? fail(`Missing source in ${file}`);
  const kind = content.match(/^kind: (.+)$/m)?.[1]?.trim() ?? fail(`Missing kind in ${file}`);
  const gated = content.includes('status: needs-review');
  const plugin = path.basename(path.dirname(file));
  const slug = path.basename(file, '.md');
  return { file, source, kind, gated, plugin, slug };
});
assert(snippets.length === 22, `Expected 22 snippets, found ${snippets.length}`);

const index = JSON.parse(readFileSync(path.join(dist, 'search-index.json'), 'utf8'));
assert(index.length === snippets.length, `Search index has ${index.length} records`);
assert(new Set(index.map((item: any) => item.id)).size === index.length, 'Duplicate search records');
assert(existsSync(path.join(dist, 'sitemap-index.xml')), 'Missing sitemap');
const sitemap = readFileSync(path.join(dist, 'sitemap-0.xml'), 'utf8');
assert(sitemap.includes(`${SITE_URL}${BASE_PATH}/`), 'Sitemap does not use the project URL');
assert(existsSync(path.join(dist, '404.html')), 'Missing 404 page');

const license = await readFile('LICENSE');
let sourceDownloads = 0;
let zipDownloads = 0;
for (const snippet of snippets) {
  const route = `snippets/${snippet.plugin}/${snippet.slug}`;
  const file = htmlPath(route);
  assert(existsSync(file), `Missing page ${route}`);
  const html = readFileSync(file, 'utf8');
  const source = await readSource(snippet.source);
  assert(index.some((item: any) => item.id === `${snippet.plugin}/${snippet.slug}` && item.url === withBase(`/${route}/`)), `Missing search record ${snippet.slug}`);
  const nodes = elements(html);
  if (snippet.gated) {
    assert(!nodes.some((node) => attr(node, 'data-copy') !== undefined), `Gated copy control leaked for ${snippet.slug}`);
    assert(!nodes.some((node) => node.tagName === 'a' && ['Download PHP', 'Download plugin ZIP'].includes(text(node).trim())), `Gated download leaked for ${snippet.slug}`);
    assert(!existsSync(path.join(dist, `downloads/source/${snippet.plugin}/${snippet.slug}.php.txt`)), `Gated source exists for ${snippet.slug}`);
    assert(!existsSync(path.join(dist, `downloads/plugins/${snippet.plugin}/${snippet.slug}.zip`)), `Gated ZIP exists for ${snippet.slug}`);
    continue;
  }
  const download = path.join(dist, `downloads/source/${snippet.plugin}/${snippet.slug}.php.txt`);
  assert(readFileSync(download).equals(source.bytes), `Source download differs for ${snippet.slug}`);
  sourceDownloads++;
  assert(nodes.some((node) => attr(node, 'data-copy') !== undefined) && nodes.some((node) => node.tagName === 'a' && text(node).trim() === 'Download PHP'), `Missing source controls for ${snippet.slug}`);
  if (snippet.kind === 'plugin') {
    const zipPath = path.join(dist, `downloads/plugins/${snippet.plugin}/${snippet.slug}.zip`);
    assert(existsSync(zipPath), `Missing ZIP for ${snippet.slug}`);
    const expected = createPluginZip(snippet.plugin, snippet.slug, source.filename, source.bytes, license);
    assert(readFileSync(zipPath).equals(Buffer.from(expected)), `ZIP is not deterministic for ${snippet.slug}`);
    const files = unzipSync(expected);
    assert(files[`wzcl-${snippet.plugin}-${snippet.slug}/${source.filename}`] && files[`wzcl-${snippet.plugin}-${snippet.slug}/LICENSE`], `Invalid ZIP payload for ${snippet.slug}`);
    zipDownloads++;
  }
}
assert(sourceDownloads === 18, `Expected 18 source downloads, found ${sourceDownloads}`);
assert(zipDownloads === 12, `Expected 12 ZIP downloads, found ${zipDownloads}`);

for (const file of walkFiles(dist).filter((name) => name.endsWith('.html'))) {
  const html = readFileSync(file, 'utf8');
  const nodes = elements(html);
  assert(nodes.some((node) => node.tagName === 'title' && text(node).trim()), `Missing title in ${file}`);
  assert(nodes.some((node) => node.tagName === 'meta' && attr(node, 'name') === 'description' && attr(node, 'content')), `Missing description in ${file}`);
  assert(nodes.some((node) => node.tagName === 'main' && attr(node, 'id') === 'main'), `Missing main landmark in ${file}`);
  assert(nodes.some((node) => node.tagName === 'h1'), `Missing h1 in ${file}`);
  for (const node of nodes) {
    if (node.tagName === 'img') assert(attr(node, 'alt') !== undefined, `Image without alt in ${file}`);
    if (node.tagName === 'a') {
      const href = attr(node, 'href');
      assert(href && href !== '#', `Empty link in ${file}`);
      if (href?.startsWith('/')) assert(href === '/code-library' || href.startsWith('/code-library/'), `Internal link misses base in ${file}: ${href}`);
    }
    if (node.tagName === 'button') assert(text(node).trim() || attr(node, 'aria-label'), `Unlabeled button in ${file}`);
  }
}
console.log(`Verified ${snippets.length} snippets, ${sourceDownloads} source downloads, ${zipDownloads} ZIPs and static HTML accessibility checks.`);

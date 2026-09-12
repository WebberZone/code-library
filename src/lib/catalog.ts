import { getCollection } from 'astro:content';
import type { SearchRecord } from './search.ts';
import { inventorySources, readSource, validateCoverage } from './sources.ts';
import { gitDates, newestDate } from './dates.ts';
import { canDownload, canZip } from './downloads.ts';
import { snippetPath, withBase, sourcePath, zipPath } from './urls.ts';
import { pluginName } from './site.ts';

async function loadCatalog() {
  const entries = await getCollection('snippets');
  validateCoverage(await inventorySources(), entries.map((entry) => entry.data.source));
  const dates = gitDates();
  const routes = new Set<string>();
  const catalog = await Promise.all(entries.map(async (entry) => {
    const data = entry.data;
    const id = `${data.primaryPlugin}/${data.slug}`;
    if (entry.id !== id) throw new Error(`Companion path must match ${id}.md: ${entry.id}`);
    if (routes.has(id)) throw new Error(`Duplicate snippet route: ${id}`);
    routes.add(id);
    const source = await readSource(data.source);
    if ((data.kind === 'plugin') !== Boolean(source.pluginHeader)) throw new Error(`Plugin header and kind disagree: ${data.source}`);
    const contentPath = `src/content/snippets/${entry.id}.md`;
    return {
      ...source,
      id,
      data,
      entry,
      contentPath,
      updated: newestDate([dates.get(data.source), dates.get(contentPath)]),
      url: withBase(snippetPath(data.primaryPlugin, data.slug)),
      sourceUrl: canDownload(data) ? withBase(sourcePath(data.primaryPlugin, data.slug)) : undefined,
      zipUrl: canZip(data) ? withBase(zipPath(data.primaryPlugin, data.slug)) : undefined,
    };
  }));
  return catalog.sort((a, b) => a.data.title.localeCompare(b.data.title, 'en') || a.id.localeCompare(b.id));
}

let cached: ReturnType<typeof loadCatalog> | undefined;
export function getCatalog() {
  if (import.meta.env.DEV) return loadCatalog();
  return cached ??= loadCatalog();
}

export type Snippet = Awaited<ReturnType<typeof loadCatalog>>[number];
export function searchRecord(snippet: Snippet): SearchRecord {
  return {
    id: snippet.id, title: snippet.data.title, description: snippet.data.description,
    plugins: snippet.data.plugins, pluginNames: snippet.data.plugins.map(pluginName),
    category: snippet.data.category, kind: snippet.data.kind, tags: snippet.data.tags,
    requiresPro: snippet.data.requiresPro, status: snippet.data.review.status,
    references: snippet.data.references.map((reference) => reference.label),
    updated: snippet.updated ?? '', url: snippet.url,
  };
}

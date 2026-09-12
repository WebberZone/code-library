import type { APIContext } from 'astro';
import { getCatalog } from '../../../../lib/catalog.ts';
import { canZip, createPluginZip } from '../../../../lib/downloads.ts';

export async function getStaticPaths() {
  const catalog = await getCatalog();
  return catalog.filter((snippet) => canZip(snippet.data)).map((snippet) => ({ params: { plugin: snippet.data.primaryPlugin, slug: snippet.data.slug } }));
}

export async function GET({ params }: APIContext) {
  const snippet = (await getCatalog()).find((item) => item.data.primaryPlugin === params.plugin && item.data.slug === params.slug);
  if (!snippet || !canZip(snippet.data)) return new Response('Not found', { status: 404 });
  const zip = createPluginZip(snippet.data.slug, snippet.filename, snippet.bytes);
  return new Response(zip.slice().buffer, { headers: { 'content-type': 'application/zip', 'content-disposition': `attachment; filename="${snippet.data.slug}.zip"`, 'x-content-type-options': 'nosniff' } });
}

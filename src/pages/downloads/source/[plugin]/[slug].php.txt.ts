import type { APIContext } from 'astro';
import { getCatalog } from '../../../../lib/catalog.ts';
import { canDownload } from '../../../../lib/downloads.ts';

export async function getStaticPaths() {
  const catalog = await getCatalog();
  return catalog.filter((snippet) => canDownload(snippet.data)).map((snippet) => ({ params: { plugin: snippet.data.primaryPlugin, slug: snippet.data.slug } }));
}

export async function GET({ params }: APIContext) {
  const snippet = (await getCatalog()).find((item) => item.data.primaryPlugin === params.plugin && item.data.slug === params.slug);
  if (!snippet || !canDownload(snippet.data)) return new Response('Not found', { status: 404 });
  return new Response(snippet.code, { headers: { 'content-type': 'text/plain; charset=utf-8', 'content-disposition': `attachment; filename="${snippet.filename}"`, 'x-content-type-options': 'nosniff' } });
}

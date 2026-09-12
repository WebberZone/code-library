import { getCatalog, searchRecord } from '../lib/catalog.ts';

export async function GET() {
  const catalog = await getCatalog();
  return Response.json(catalog.map(searchRecord), { headers: { 'cache-control': 'public, max-age=300' } });
}

export interface SearchRecord {
  id: string;
  title: string;
  description: string;
  plugins: string[];
  pluginNames: string[];
  category: string;
  kind: string;
  tags: string[];
  requiresPro: boolean;
  status: 'available' | 'needs-review';
  references: string[];
  updated: string;
  url: string;
}

export interface SearchFilters {
  query?: string;
  plugin?: string;
  category?: string;
  kind?: string;
  pro?: string;
  status?: string;
  tag?: string;
  sort?: string;
  page?: number;
}

export interface Page<T> {
  items: T[];
  page: number;
  pages: number;
  total: number;
}

const normalize = (value: string) => value.normalize('NFD').replace(/[\u0300-\u036f]/g, '').toLowerCase().replace(/[^a-z0-9]+/g, ' ').trim();

export function queryScore(record: SearchRecord, rawQuery = ''): number | null {
  const query = normalize(rawQuery.slice(0, 120));
  if (!query) return 0;
  const title = normalize(record.title);
  const tokens = query.split(' ').filter(Boolean);
  const fields = [title, normalize(record.description), normalize(record.pluginNames.join(' ')), normalize(record.references.join(' ')), normalize(record.tags.join(' '))];
  if (!tokens.every((token) => fields.some((field) => field.includes(token)))) return null;
  let score = title === query ? 100 : title.startsWith(query) ? 70 : title.includes(query) ? 50 : 20;
  if (record.references.some((reference) => normalize(reference).includes(query))) score += 15;
  if (record.tags.some((tag) => tag === query.replace(/ /g, '-'))) score += 12;
  score += Math.min(fields[1].split(' ').filter((field) => tokens.includes(field)).length * 2, 10);
  return score;
}

export function applyFilters(records: SearchRecord[], filters: SearchFilters): SearchRecord[] {
  const filtered = records.filter((record) => {
    if (filters.plugin && !record.plugins.includes(filters.plugin)) return false;
    if (filters.category && record.category !== filters.category) return false;
    if (filters.kind && record.kind !== filters.kind) return false;
    if (filters.pro === 'yes' && !record.requiresPro) return false;
    if (filters.pro === 'no' && record.requiresPro) return false;
    if (filters.status && record.status !== filters.status) return false;
    if (filters.tag && !record.tags.includes(filters.tag)) return false;
    return queryScore(record, filters.query) !== null;
  });
  const scores = new Map(filtered.map((record) => [record.id, queryScore(record, filters.query) ?? 0]));
  filtered.sort((a, b) => {
    if (filters.sort === 'title') return a.title.localeCompare(b.title, 'en') || a.id.localeCompare(b.id);
    if (filters.sort === 'updated') return (b.updated || '').localeCompare(a.updated || '') || a.title.localeCompare(b.title, 'en');
    return (scores.get(b.id)! - scores.get(a.id)!) || a.title.localeCompare(b.title, 'en') || a.id.localeCompare(b.id);
  });
  return filtered;
}

export function paginate<T>(items: T[], requested: number | undefined, pageSize = 24): Page<T> {
  const pages = Math.max(1, Math.ceil(items.length / pageSize));
  const page = Math.min(Math.max(1, requested ?? 1), pages);
  return { items: items.slice((page - 1) * pageSize, page * pageSize), page, pages, total: items.length };
}

import { BASE_PATH, REPOSITORY, SITE_URL } from './site.ts';

export function withBase(path: string, base = BASE_PATH): string {
  const prefix = base.replace(/\/$/, '');
  const pathname = path.startsWith('/') ? path : `/${path}`;
  if (prefix && (pathname === prefix || pathname.startsWith(`${prefix}/`))) return pathname;
  return `${prefix}${pathname}`;
}

export const snippetPath = (plugin: string, slug: string) => `/snippets/${plugin}/${slug}/`;
export const canonicalUrl = (path: string) => new URL(withBase(path), SITE_URL).href;
export const githubUrl = (path: string, action: 'blob' | 'edit' | 'commits' = 'blob') => `${REPOSITORY}/${action}/master/${path.split('/').map(encodeURIComponent).join('/')}`;
export const sourcePath = (plugin: string, slug: string) => `/downloads/source/${plugin}/${slug}.php.txt`;
export const zipPath = (plugin: string, slug: string) => `/downloads/plugins/${plugin}/${slug}.zip`;

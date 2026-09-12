import { zipSync } from 'fflate';

interface DownloadPolicy {
  kind: string;
  review: { status: string };
}

export const canDownload = (data: DownloadPolicy) => data.review.status === 'available';
export const canZip = (data: DownloadPolicy) => canDownload(data) && data.kind === 'plugin';

export function createPluginZip(plugin: string, slug: string, filename: string, source: Uint8Array, license: Uint8Array): Uint8Array {
  if (![plugin, slug].every((part) => /^[a-z0-9-]+$/.test(part)) || !/^[a-z0-9-]+\.php$/.test(filename)) throw new Error('Invalid ZIP path');
  const folder = `wzcl-${plugin}-${slug}`;
  return zipSync({ [`${folder}/LICENSE`]: license, [`${folder}/${filename}`]: source }, { level: 9, mtime: new Date(1980, 0, 1) });
}

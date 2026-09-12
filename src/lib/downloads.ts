import { zipSync } from 'fflate';

interface DownloadPolicy {
  kind: string;
  review: { status: string };
}

export const canDownload = (data: DownloadPolicy) => data.review.status === 'available';
export const canZip = (data: DownloadPolicy) => canDownload(data) && data.kind === 'plugin';

export function createPluginZip(slug: string, filename: string, source: Uint8Array): Uint8Array {
  if (!/^[a-z0-9-]+$/.test(slug) || !/^[a-z0-9-]+\.php$/.test(filename)) throw new Error('Invalid ZIP path');
  return zipSync({ [`${slug}/${filename}`]: source }, { level: 9, mtime: new Date(1980, 0, 1) });
}

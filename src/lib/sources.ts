import { readdir, readFile, realpath, lstat } from 'node:fs/promises';
import path from 'node:path';
import { PLUGINS } from './site.ts';

export function validateSourcePath(source: string): void {
  const parts = source.split('/');
  if (!/^[a-z0-9-]+(?:\/[a-z0-9-]+)+\.php$/.test(source) || !PLUGINS.some((plugin) => plugin.slug === parts[0])) {
    throw new Error(`Invalid source path: ${source}`);
  }
}

export async function readSource(source: string, root = process.cwd()) {
  validateSourcePath(source);
  const base = await realpath(root);
  let current = base;
  for (const segment of source.split('/')) {
    current = path.join(current, segment);
    if ((await lstat(current)).isSymbolicLink()) throw new Error(`Source symlinks are not allowed: ${source}`);
  }
  const resolved = await realpath(current);
  if (!resolved.startsWith(`${base}${path.sep}`)) throw new Error(`Source escapes repository: ${source}`);
  const bytes = await readFile(resolved);
  const code = bytes.toString('utf8');
  if (!Buffer.from(code, 'utf8').equals(bytes)) throw new Error(`Source is not valid UTF-8: ${source}`);
  const pluginHeader = bytes.subarray(0, 8192).toString('utf8').match(/^[ \t/*#@]*Plugin Name:[ \t]*(.+)$/mi)?.[1]?.trim();
  return { code, bytes, filename: path.basename(source), pluginHeader };
}

export async function inventorySources(root = process.cwd()): Promise<string[]> {
  const files: string[] = [];
  async function walk(relative: string) {
    const directory = path.join(root, relative);
    if ((await lstat(directory)).isSymbolicLink()) throw new Error(`Source symlinks are not allowed: ${relative}`);
    for (const entry of await readdir(directory, { withFileTypes: true })) {
      const name = `${relative}/${entry.name}`;
      if (entry.isSymbolicLink()) throw new Error(`Source symlinks are not allowed: ${name}`);
      if (entry.isDirectory()) await walk(name);
      else if (entry.name.endsWith('.php')) files.push(name);
    }
  }
  for (const plugin of PLUGINS) await walk(plugin.slug);
  return files.sort();
}

export function validateCoverage(sources: string[], entries: string[]): void {
  const seen = new Set<string>();
  for (const source of entries) {
    validateSourcePath(source);
    if (seen.has(source)) throw new Error(`Duplicate companion for source: ${source}`);
    if (!sources.includes(source)) throw new Error(`Missing source: ${source}`);
    seen.add(source);
  }
  for (const source of sources) {
    if (!seen.has(source)) throw new Error(`Missing Markdown companion for source: ${source}`);
  }
}

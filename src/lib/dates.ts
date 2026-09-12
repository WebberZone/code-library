import { execFileSync } from 'node:child_process';
import { PLUGINS } from './site.ts';

export function parseGitDates(output: string): Map<string, string> {
  const dates = new Map<string, string>();
  let current: string | undefined;
  for (const line of output.split('\n')) {
    if (line.startsWith('@@')) {
      const date = new Date(line.slice(2));
      current = Number.isNaN(date.valueOf()) ? undefined : date.toISOString();
    } else if (line && current && !dates.has(line)) dates.set(line, current);
  }
  return dates;
}

export function newestDate(dates: (string | undefined)[]): string | undefined {
  return dates.filter((date): date is string => Boolean(date)).sort().at(-1);
}

export function gitDates(root = process.cwd()): Map<string, string> {
  try {
    const options = { cwd: root, encoding: 'utf8' as const, maxBuffer: 32 * 1024 * 1024, stdio: ['ignore', 'pipe', 'pipe'] as ['ignore', 'pipe', 'pipe'] };
    if (execFileSync('git', ['rev-parse', '--is-shallow-repository'], options).trim() === 'true') {
      console.warn('Git history is shallow; update dates are omitted. Use fetch-depth: 0.');
      return new Map();
    }
    return parseGitDates(execFileSync('git', ['log', '--format=@@%cI', '--name-only', '--no-renames', '--', ...PLUGINS.map((plugin) => plugin.slug), 'src/content', 'CONTRIBUTING.md'], options));
  } catch {
    console.warn('Git history is unavailable; update dates are omitted.');
    return new Map();
  }
}

export const displayDate = (date: string) => new Intl.DateTimeFormat('en', { month: 'short', day: 'numeric', year: 'numeric', timeZone: 'UTC' }).format(new Date(date));

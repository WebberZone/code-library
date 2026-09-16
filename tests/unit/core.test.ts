import { test } from 'node:test';
import assert from 'node:assert/strict';
import { withBase, snippetPath, canonicalUrl } from '../../src/lib/urls.ts';
import { parseGitDates, newestDate } from '../../src/lib/dates.ts';
import { validateSourcePath, validateCoverage } from '../../src/lib/sources.ts';
import { unzipSync } from 'fflate';
import { canDownload, canZip, createPluginZip } from '../../src/lib/downloads.ts';
import { snippetSchema } from '../../src/lib/schema.ts';

test('URLs preserve the project base without doubling it', () => {
  assert.equal(withBase('/snippets/'), '/code-library/snippets/');
  assert.equal(withBase('/code-library/snippets/'), '/code-library/snippets/');
  assert.equal(withBase('/snippets/', '/'), '/snippets/');
  assert.equal(withBase('/search-index.json'), '/code-library/search-index.json');
  assert.equal(snippetPath('top-10', 'counter'), '/snippets/top-10/counter/');
  assert.equal(canonicalUrl('/snippets/'), 'https://webberzone.github.io/code-library/snippets/');
});

test('source paths reject traversal, executable extensions and unknown roots', () => {
  assert.doesNotThrow(() => validateSourcePath('top-10/outputs/example.php'));
  for (const source of ['../private.php', '/top-10/example.php', 'top-10/../private.php', 'top-10\\example.php', 'vendor/example.php', 'top-10/example.js']) {
    assert.throws(() => validateSourcePath(source), /source/i);
  }
});

test('catalog coverage rejects missing, orphaned and duplicate entries', () => {
  assert.doesNotThrow(() => validateCoverage(['top-10/a.php'], ['top-10/a.php']));
  assert.throws(() => validateCoverage(['top-10/a.php'], []), /companion/i);
  assert.throws(() => validateCoverage([], ['top-10/a.php']), /missing/i);
  assert.throws(() => validateCoverage(['top-10/a.php'], ['top-10/a.php', 'top-10/a.php']), /duplicate/i);
});

test('dates use the newest committed change, without a build-time fallback', () => {
  const dates = parseGitDates('@@2026-08-02T12:00:00Z\ntop-10/a.php\n@@2026-07-01T12:00:00Z\ntop-10/a.php\ntop-10/b.php\n');
  assert.equal(dates.get('top-10/a.php'), '2026-08-02T12:00:00.000Z');
  assert.equal(newestDate([undefined, dates.get('top-10/b.php'), dates.get('top-10/a.php')]), '2026-08-02T12:00:00.000Z');
  assert.equal(newestDate([]), undefined);
});

test('review status gates all downloads and only plugin entries get ZIPs', () => {
  assert.equal(canDownload({ review: { status: 'available' }, kind: 'function' }), true);
  assert.equal(canZip({ review: { status: 'available' }, kind: 'function' }), false);
  assert.equal(canZip({ review: { status: 'available' }, kind: 'plugin' }), true);
  assert.equal(canDownload({ review: { status: 'needs-review' }, kind: 'plugin' }), false);
  assert.equal(canZip({ review: { status: 'needs-review' }, kind: 'plugin' }), false);
});

test('snippet metadata rejects inconsistent plugin and review fields', () => {
  const valid = {
    title: 'Example snippet', description: 'A sufficiently descriptive example for validation.',
    slug: 'example-snippet', source: 'top-10/example.php', primaryPlugin: 'top-10', plugins: ['top-10'],
    category: 'display', kind: 'function', tags: ['example'], requiresPro: false,
    requirements: ['Top 10'], review: { status: 'available' }, references: [],
  };
  assert.equal(snippetSchema.safeParse(valid).success, true);
  assert.equal(snippetSchema.safeParse({ ...valid, plugins: ['better-search'] }).success, false);
  assert.equal(snippetSchema.safeParse({ ...valid, review: { status: 'needs-review' } }).success, false);
  assert.equal(snippetSchema.safeParse({ ...valid, review: { status: 'available', reasons: ['Unsafe output needs escaping.'] } }).success, false);
  assert.equal(snippetSchema.safeParse({ ...valid, source: 'better-search/example.php' }).success, false);
  assert.equal(snippetSchema.safeParse({ ...valid, preview: { image: '/images/snippets/example.png', alt: 'Example card grid screenshot', caption: 'Example output.', width: 645, height: 1679 } }).success, true);
  assert.equal(snippetSchema.safeParse({ ...valid, preview: { image: '../example.png', alt: 'Example card grid screenshot', caption: 'Example output.', width: 645, height: 1679 } }).success, false);
});

test('plugin ZIPs use the snippet slug as the root folder', () => {
  const encoder = new TextEncoder();
  const files = unzipSync(createPluginZip('example-snippet', 'example.php', encoder.encode('<?php')));
  assert.ok(files['example-snippet/example.php']);
  assert.equal(Object.keys(files).length, 1);
});

import { z } from 'astro/zod';
import { PLUGINS, CATEGORIES } from './site.ts';

const plugin = z.enum(PLUGINS.map((item) => item.slug));
const slug = z.string().regex(/^[a-z][a-z0-9-]*$/);
const httpsUrl = z.url().refine((value) => new URL(value).protocol === 'https:', 'Use HTTPS reference URLs');

export const snippetSchema = z.object({
  title: z.string().min(5).max(100),
  description: z.string().min(20).max(240),
  slug,
  source: z.string().min(1),
  primaryPlugin: plugin,
  plugins: z.array(plugin).min(1),
  category: z.enum(CATEGORIES.map((item) => item.slug)),
  kind: z.enum(['plugin', 'function', 'template']),
  tags: z.array(slug).min(1),
  requiresPro: z.boolean(),
  requirements: z.array(z.string().min(1)).min(1),
  preview: z.object({
    image: z.string().regex(/^\/images\/(?:[a-z0-9-]+\/)*[a-z0-9-]+\.(?:png|jpe?g|webp)$/),
    alt: z.string().min(10).max(240),
    caption: z.string().min(1).max(240),
    width: z.number().int().positive(),
    height: z.number().int().positive(),
  }).strict().optional(),
  review: z.object({ status: z.enum(['available', 'needs-review']), reasons: z.array(z.string().min(10)).default([]) }).strict(),
  references: z.array(z.object({ label: z.string().min(1), url: httpsUrl }).strict()).default([]),
}).strict().superRefine((data, context) => {
  if (!data.plugins.includes(data.primaryPlugin)) context.addIssue({ code: 'custom', message: 'Primary plugin must be included in plugins', path: ['plugins'] });
  if (new Set(data.plugins).size !== data.plugins.length) context.addIssue({ code: 'custom', message: 'Duplicate plugin membership', path: ['plugins'] });
  if (data.review.status === 'needs-review' && !data.review.reasons.length) context.addIssue({ code: 'custom', message: 'Needs-review entries require a reason', path: ['review'] });
  if (data.review.status === 'available' && data.review.reasons.length) context.addIssue({ code: 'custom', message: 'Entries with review reasons must be gated', path: ['review'] });
  if (data.source.split('/')[0] !== data.primaryPlugin) context.addIssue({ code: 'custom', message: 'Source root must match primaryPlugin', path: ['source'] });
});

export type SnippetData = z.infer<typeof snippetSchema>;

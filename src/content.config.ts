import { defineCollection } from 'astro:content';
import { glob } from 'astro/loaders';
import { z } from 'astro/zod';
import { snippetSchema } from './lib/schema.ts';

export const collections = {
  snippets: defineCollection({
    loader: glob({ pattern: '**/*.md', base: './src/content/snippets', generateId: ({ entry }) => entry.replace(/\.md$/, '') }),
    schema: snippetSchema,
  }),
  guides: defineCollection({
    loader: glob({ pattern: '*.md', base: './src/content/guides' }),
    schema: z.object({ title: z.string(), description: z.string() }).strict(),
  }),
};

import { defineConfig } from 'astro/config';
import sitemap from '@astrojs/sitemap';
import { unified } from '@astrojs/markdown-remark';
import { SITE_URL, BASE_PATH, PLUGINS } from './src/lib/site.ts';
import { rejectHtml } from './scripts/markdown-policy.mjs';

export default defineConfig({
  site: SITE_URL,
  base: BASE_PATH,
  output: 'static',
  trailingSlash: 'always',
  markdown: { processor: unified({ remarkPlugins: [rejectHtml] }), shikiConfig: { theme: 'github-dark' } },
  integrations: [
    sitemap({ filter: (page) => !page.endsWith('/404/') && !page.endsWith('/404.html') }),
    {
      name: 'snippet-source-watcher',
      hooks: {
        'astro:server:setup': ({ server }) => {
          server.watcher.add(PLUGINS.map((plugin) => `${process.cwd()}/${plugin.slug}`));
          server.watcher.on('all', (event, path) => {
            if (['add', 'change', 'unlink'].includes(event) && path.endsWith('.php')) server.ws.send({ type: 'full-reload' });
          });
        },
      },
    },
  ],
});

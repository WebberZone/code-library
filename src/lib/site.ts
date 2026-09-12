export const SITE_URL = 'https://webberzone.github.io';
export const BASE_PATH = '/code-library';
export const REPOSITORY = 'https://github.com/WebberZone/code-library';
export const PAGE_SIZE = 24;

export const PLUGINS = [
  { slug: 'better-search', name: 'Better Search', description: 'Customize search results, term highlighting and search heatmaps.', url: 'https://webberzone.com/plugins/better-search/', short: 'BS' },
  { slug: 'contextual-related-posts', name: 'Contextual Related Posts', description: 'Tailor related posts, their presentation and the queries behind them.', url: 'https://webberzone.com/plugins/contextual-related-posts/', short: 'CRP' },
  { slug: 'top-10', name: 'Top 10', description: 'Change popular-post lists, view counts and visitor tracking.', url: 'https://webberzone.com/plugins/top-10/', short: 'T10' },
] as const;

export const CATEGORIES = [
  { slug: 'display', name: 'Display', description: 'Change how your plugin output looks and reads.' },
  { slug: 'queries', name: 'Queries', description: 'Control which posts appear in your results.' },
  { slug: 'tracking', name: 'Tracking', description: 'Adjust counting, exclusions and link tracking.' },
  { slug: 'integrations', name: 'Integrations', description: 'Connect WebberZone plugins with other tools.' },
] as const;

export const KINDS = { plugin: 'Plugin', function: 'Function snippet', template: 'Template example' } as const;
export type PluginSlug = typeof PLUGINS[number]['slug'];
export type CategorySlug = typeof CATEGORIES[number]['slug'];
export type SnippetKind = keyof typeof KINDS;
export const pluginName = (slug: string) => PLUGINS.find((plugin) => plugin.slug === slug)?.name ?? slug;
export const categoryName = (slug: string) => CATEGORIES.find((category) => category.slug === slug)?.name ?? slug;

---
title: Index Easy Footnotes content
description: Include Easy Footnotes text in the custom content index used by Better Search Pro and Contextual Related Posts Pro.
slug: bsearch-easy-footnotes-integration
source: better-search/custom-tables/bsearch-easy-footnotes-integration.php
primaryPlugin: better-search
plugins: [better-search, contextual-related-posts]
category: integrations
kind: plugin
tags: [easy-footnotes, indexing, custom-tables]
requiresPro: true
requirements: ["Better Search Pro or Contextual Related Posts Pro with custom content indexing enabled.", "Easy Footnotes must be installed and active.", "Reindex existing content after installing this integration."]
review:
  status: available
references:
  - label: bsearch_pre_index_content_parts
    url: https://webberzone.dev/better-search/hooks/bsearch_pre_index_content_parts/
  - label: crp_pre_index_content_parts
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_pre_index_content_parts/
---
## Why the integration is needed

Easy Footnotes moves footnote text into output added through `the_content`. The custom content indexer does not run that filter. This integration extracts enclosed footnote text before shortcode content is discarded.

[Better Search Pro](https://webberzone.com/plugins/better-search/) and [Contextual Related Posts Pro](https://webberzone.com/plugins/contextual-related-posts/) share the custom content table. The snippet registers both indexing filters so it can run whichever plugin performs the index update.

## After installation

Run a reindex to update previously published posts. For Better Search Pro, use **Tools** to rebuild the index, or run the following on the intended WordPress site:

```bash
wp bsearch ecsi reindex --force
```

The integration recognizes the `efn_note` and `note` shortcode names. Escaped shortcodes are skipped. It does not change how footnotes appear to visitors.

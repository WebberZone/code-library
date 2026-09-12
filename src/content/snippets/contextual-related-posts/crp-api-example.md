---
title: Build a related-stories template
description: A styled Contextual Related Posts template for six articles in the news category. The helper declaration needs review before use.
slug: crp-api-example
source: contextual-related-posts/crp-api-example.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: display
kind: template
tags: [templates, query-api, styling]
requiresPro: false
requirements: ["Contextual Related Posts and its CRP_Query class.", "A PHP theme template with a current post and WordPress loaded."]
review:
  status: needs-review
  reasons:
    - The template calls crp_render_showcase_styles() before its conditional function declaration executes, which can cause an undefined-function error when results exist.
references:
  - label: CRP_Query
    url: https://webberzone.dev/contextual-related-posts/classes/CRP_Query/
---
## Reference template

This example uses [Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/)' query class to request six related articles in the `news` category. It includes card markup and inline CSS.

## Review required

The stylesheet helper must be available before it is called. Its current declaration is inside a conditional block after the rendering code, so it is not available in time on a normal first execution with results.

This is a template example, not an installable plugin or a top-level `functions.php` snippet. No visual preview is generated. Source is retained for reference; copy controls and downloads are withheld.

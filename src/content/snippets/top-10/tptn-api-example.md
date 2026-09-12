---
title: Build a trending-posts template
description: A styled Top 10 template example showing six popular posts from the last 30 days. The helper declaration needs review before use.
slug: tptn-api-example
source: top-10/tptn-api-example.php
primaryPlugin: top-10
plugins: [top-10]
category: display
kind: template
tags: [templates, query-api, styling]
requiresPro: false
requirements: ["Top 10 and its Top_Ten_Query class.", "A PHP theme template with WordPress loaded."]
review:
  status: needs-review
  reasons:
    - The template calls tptn_render_showcase_styles() before its conditional function declaration executes, which can cause an undefined-function error when results exist.
references:
  - label: Top_Ten_Query
    url: https://webberzone.dev/top-10/classes/Top_Ten_Query/
---
## Reference template

This example uses [Top 10](https://webberzone.com/plugins/top-10/)'s query class to request six posts from the last 30 days. It includes card markup, rank numbers and inline CSS.

## Review required

The stylesheet helper must be available before it is called. Its current declaration is inside a conditional block after the rendering code, so it is not available in time on a normal first execution with results.

This is a template example, not an installable plugin or a top-level `functions.php` snippet. No visual preview is generated. Source is retained for reference; copy controls and downloads are withheld.

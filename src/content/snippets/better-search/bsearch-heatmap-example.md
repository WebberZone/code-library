---
title: Display a customized search heatmap
description: Render a Better Search heatmap with your own colors, font sizes, number of terms and date range.
slug: bsearch-heatmap-example
source: better-search/bsearch-heatmap-example.php
primaryPlugin: better-search
plugins: [better-search]
category: display
kind: template
tags: [heatmap, search-terms, templates]
requiresPro: false
requirements: ["Better Search must be active.", "Use a PHP theme template after WordPress and the plugin have loaded."]
review:
  status: available
references:
  - label: get_bsearch_heatmap()
    url: https://webberzone.dev/better-search/functions/get_bsearch_heatmap/
---
## Where to use it

Place this example in a PHP template at the point where you want the [Better Search](https://webberzone.com/plugins/better-search/) heatmap to appear. It outputs markup immediately. Do not paste it at the top level of `functions.php` or activate it as a plugin.

## What to change

Set `number` to the number of terms to display. Adjust `smallest`, `largest`, `unit`, `cold` and `hot` for your theme. The sample uses all-time searches because `daily` is `false`; set it to `true` to use the `daily_range` value.

The `function_exists()` check prevents the call when the heatmap function is unavailable. It does not guarantee that search data exists.

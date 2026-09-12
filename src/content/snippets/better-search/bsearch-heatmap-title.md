---
title: Change heatmap link titles
description: Replace the title attribute on Better Search heatmap links with a message containing the search term.
slug: bsearch-heatmap-title
source: better-search/bsearch-heatmap-title.php
primaryPlugin: better-search
plugins: [better-search]
category: display
kind: function
tags: [heatmap, link-titles, search-terms]
requiresPro: false
requirements: ["Better Search must be active and displaying a heatmap."]
review:
  status: available
references:
  - label: bsearch_heatmap_title
    url: https://webberzone.dev/better-search/hooks/bsearch_heatmap_title/
---
## What it changes

This filter changes the HTML `title` attribute of each [Better Search](https://webberzone.com/plugins/better-search/) heatmap link. It does not change the heading above the heatmap or the visible search term.

## What to change

Replace `Search for %1$s` with your preferred wording. Keep `%1$s` where the search term should appear. Register the function before the heatmap renders, using a custom functionality plugin or your child theme's `functions.php`.

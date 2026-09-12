---
title: Customize search highlight markup
description: Change the HTML element and CSS class that Better Search uses to highlight matching search terms.
slug: bsearch-highlight-tag
source: better-search/bsearch-highlight-tag.php
primaryPlugin: better-search
plugins: [better-search]
category: display
kind: plugin
tags: [highlighting, markup, styling]
requiresPro: false
requirements: ["Better Search must be active with search-term highlighting enabled."]
review:
  status: available
references:
  - label: bsearch_highlight_tag
    url: https://webberzone.dev/better-search/hooks/bsearch_highlight_tag/
  - label: bsearch_highlight_class
    url: https://webberzone.dev/better-search/hooks/bsearch_highlight_class/
---
## What it changes

[Better Search](https://webberzone.com/plugins/better-search/) normally wraps highlighted terms in a `mark` element. This example changes the element to `strong` and the class to `search-highlight`.

## What to change

Edit the return values in `bsearch_custom_highlight_tag()` and `bsearch_custom_highlight_class()`. Supply a tag name without angle brackets and a CSS class name without a leading period.

The snippet does not add CSS. Add styling for your chosen class in your theme if needed.

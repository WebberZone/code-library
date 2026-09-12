---
title: Change related-post headings by post type
description: Give products, recipes and other post types their own Contextual Related Posts heading.
slug: crp-heading-title
source: contextual-related-posts/crp-heading-title.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: display
kind: plugin
tags: [headings, post-types, customization]
requiresPro: false
requirements: ["Contextual Related Posts must be active.", "Any custom post types in the mapping must already be registered."]
review:
  status: available
references:
  - label: crp_heading_title
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_heading_title/
---
## What it changes

This example chooses the [Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/) heading from the current source post's type. It uses the supplied `postid` when available and falls back to the current post ID.

## What to change

Edit `$headings` to map post-type slugs to your preferred wording. The sample includes `product`, `series` and `recipe`. It does not register those post types.

For any post type not in the mapping, the existing heading is returned unchanged.

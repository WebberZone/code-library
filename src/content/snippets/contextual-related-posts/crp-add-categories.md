---
title: Add categories to related posts
description: Append category links to each item in a Contextual Related Posts list.
slug: crp-add-categories
source: contextual-related-posts/crp-add-categories.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: display
kind: plugin
tags: [categories, output, related-posts]
requiresPro: false
requirements: ["Contextual Related Posts must be active and rendering a related-posts list."]
review:
  status: available
references:
  - label: crp_after_list_item
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_after_list_item/
---
## What it changes

This example appends the categories of each related post using the [Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/) `crp_after_list_item` filter. WordPress generates the category links.

## What to change

Change the `', '` separator passed to `get_the_category_list()` if you want a different separator between categories. Check the placement with your selected output style; the snippet does not add its own CSS.

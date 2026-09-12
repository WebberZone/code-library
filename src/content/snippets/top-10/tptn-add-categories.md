---
title: Add categories to popular posts
description: Append category links to each item in a Top 10 popular-posts list.
slug: tptn-add-categories
source: top-10/outputs/tptn-add-categories.php
primaryPlugin: top-10
plugins: [top-10]
category: display
kind: plugin
tags: [categories, output, popular-posts]
requiresPro: false
requirements: ["Top 10 must be active and rendering a popular-posts list."]
review:
  status: available
references:
  - label: tptn_list
    url: https://webberzone.dev/top-10/hooks/tptn_list/
---
## What it changes

This example adds each popular post's category links to the output filtered by [Top 10](https://webberzone.com/plugins/top-10/). WordPress supplies the category-list markup.

## What to change

Change the separator passed to `get_the_category_list()` if you do not want comma-separated links. Check the result with your selected Top 10 output style. The snippet adds no CSS of its own.

---
title: Limit popular posts to selected post types
description: Replace the post types queried by Top 10 with a specific allowlist.
slug: tptn-restrict-post-types
source: top-10/outputs/tptn-restrict-post-types.php
primaryPlugin: top-10
plugins: [top-10]
category: queries
kind: plugin
tags: [post-types, filtering, products]
requiresPro: false
requirements: ["Top 10 must be active.", "Custom post types in the allowlist must already exist."]
review:
  status: available
references:
  - label: top_ten_posts_post_types
    url: https://webberzone.dev/top-10/hooks/top_ten_posts_post_types/
---
## What it changes

This filter replaces the post-type array used by [Top 10](https://webberzone.com/plugins/top-10/) with the values in `$allowed_post_types`.

## What to change

The example includes `post` and `product`. Replace them with your required post-type slugs. A `product` post type must already be registered by WooCommerce or another plugin; this snippet does not create it.

The filter applies wherever this query hook runs, not just to one specific widget.

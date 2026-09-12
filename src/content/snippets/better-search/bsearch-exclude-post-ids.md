---
title: Exclude specific posts from search results
description: Exclude a chosen set of post IDs and the current global post from Better Search results.
slug: bsearch-exclude-post-ids
source: better-search/query/bsearch-exclude-post-ids.php
primaryPlugin: better-search
plugins: [better-search]
category: queries
kind: function
tags: [exclusions, post-ids, search-results]
requiresPro: false
requirements: ["Better Search must be active.", "Current-post exclusion depends on a populated global post object."]
review:
  status: available
references:
  - label: bsearch_exclude_post_ids
    url: https://webberzone.dev/better-search/hooks/bsearch_exclude_post_ids/
---
## What it changes

This function merges your exclusions into the post IDs that [Better Search](https://webberzone.com/plugins/better-search/) already excludes. It also adds the current global post ID when one is available, then removes duplicate IDs.

## What to change

Replace `42` and `57` in `$always_exclude` with your own post IDs. The global post may not represent the page you expect in every query context, so verify that part of the behavior where your search results render.

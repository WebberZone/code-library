---
title: Exclude related posts on selected articles
description: Hide specific related posts only when the related-post list is displayed on selected source articles.
slug: crp-exclude-specific-post
source: contextual-related-posts/crp-exclude-specific-post.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: queries
kind: function
tags: [exclusions, post-ids, related-posts]
requiresPro: false
requirements: ["Contextual Related Posts must be active."]
review:
  status: available
references:
  - label: crp_exclude_post_ids
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_exclude_post_ids/
---
## What it changes

Use this filter when a [Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/) exclusion should apply only on particular articles. Other source posts retain their existing exclusions.

## What to change

Set `$exclude_ids` to the IDs of posts you do not want recommended. Set `$exclude_on_ids` to the source article IDs where that rule should apply. Replace all four sample IDs before use.

The comparison uses strict matching, so keep the IDs as integers rather than quoted strings.

---
title: Shuffle the related-post results
description: Randomize the order of posts already selected by the Contextual Related Posts query.
slug: crp-random-posts
source: contextual-related-posts/crp-random-posts.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: queries
kind: function
tags: [random-order, query-results, related-posts]
requiresPro: false
requirements: ["Contextual Related Posts must be active."]
review:
  status: available
references:
  - label: crp_query_the_posts
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_query_the_posts/
---
## What it changes

[Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/) first selects its results. This filter shuffles that result array before returning it.

## Limits of the example

This does not select random posts from the entire site or expand the number of results. It only changes their order. Page or output caching may cause visitors to see the same ordering until that cached output is refreshed.

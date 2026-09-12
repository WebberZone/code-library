---
title: Add UTM parameters to related-post links
description: Append campaign parameters to Contextual Related Posts links so you can identify their source in analytics.
slug: crp-utm-links
source: contextual-related-posts/crp-utm-links.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: tracking
kind: plugin
tags: [utm, analytics, links]
requiresPro: false
requirements: ["Contextual Related Posts must be active."]
review:
  status: available
references:
  - label: crp_permalink
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_permalink/
---
## What it changes

This filter appends `utm_source`, `utm_medium` and `utm_campaign` to links produced by [Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/). The sample values are `related-posts`, `internal` and `crp`.

## What to change

Edit `$utm_params` to match your campaign naming convention. `add_query_arg()` replaces existing values for matching parameter names.

Check how your analytics system treats campaign parameters on internal links before enabling this across your site. The snippet adds parameters; it does not configure or verify analytics collection.

---
title: Customize the related-post date range
description: Replace the Contextual Related Posts date query with a range derived from the current post's publication date.
slug: crp-change-query-dates
source: contextual-related-posts/crp-change-query-dates.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: queries
kind: function
tags: [date-query, publication-date, filtering]
requiresPro: false
requirements: ["Contextual Related Posts must be active.", "A current global post must be available when the query runs."]
review:
  status: available
references:
  - label: crp_query_date_query
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_query_date_query/
---
## What it changes

This example replaces the date query used by [Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/). It derives an `after` date from the current post and a `before` date by adding one day, then enables inclusive bounds.

## Check the boundaries

Despite the source comment describing a same-day restriction, both dates are inclusive. A date-only upper bound can include the following day. The example also mixes the post timestamp with `gmdate()`, so review your timezone and boundary requirements before relying on it for a precise calendar-day filter.

This replaces the existing date-query array rather than adding another condition to it.

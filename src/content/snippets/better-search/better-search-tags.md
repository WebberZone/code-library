---
title: Search post tags with a legacy query filter
description: A reference example of extending Better Search through a tag-query filter. It requires a security and compatibility review before use.
slug: better-search-tags
source: better-search/query/better-search-tags.php
primaryPlugin: better-search
plugins: [better-search]
category: queries
kind: plugin
tags: [tags, taxonomy, legacy, sql]
requiresPro: false
requirements: ["Requires review against the installed Better Search release before use."]
review:
  status: needs-review
  reasons:
    - Search terms are interpolated directly into SQL without prepared placeholders or LIKE escaping.
    - The legacy bsearch_posts_where hook needs compatibility verification, and the plugin header uses the same name as Better Search.
---
## Reference only

This example attempts to extend [Better Search](https://webberzone.com/plugins/better-search/) by appending a tag-name subquery to its SQL conditions. It splits the search text on spaces and inserts each term into a `LIKE` expression.

## Review required

The query construction must be reviewed and rewritten using prepared values and appropriate `LIKE` escaping before this is offered for installation. The current hook signature and query behavior also need verification.

The source is retained for reference. Copy controls and website downloads are withheld; its presence here is not a recommendation to install it.

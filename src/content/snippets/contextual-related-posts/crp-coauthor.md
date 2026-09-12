---
title: Display related-post co-authors
description: A reference integration for listing co-authors in Contextual Related Posts. Output escaping needs review before installation.
slug: crp-coauthor
source: contextual-related-posts/crp-coauthor.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: integrations
kind: plugin
tags: [authors, co-authors, output]
requiresPro: false
requirements: ["Contextual Related Posts and a co-author plugin providing get_coauthors()."]
review:
  status: needs-review
  reasons:
    - Author names and author URLs are concatenated into HTML without contextual escaping.
    - The get_coauthors() dependency is called without checking that it is available.
references:
  - label: crp_author
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_author/
---
## Reference integration

This example replaces the author text in [Contextual Related Posts](https://webberzone.com/plugins/contextual-related-posts/) with a list returned by `get_coauthors()`. It builds links using the WordPress author archive URL.

## Review required

The author text and link URLs need context-appropriate escaping. The external co-author dependency also needs an availability guard before this can be offered for installation.

The source is visible for reference, but copy controls and website downloads are withheld.

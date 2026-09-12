---
title: Show comment counts beside popular posts
description: Append the number of comments to each result in a Top 10 popular-posts list.
slug: tptn-comments-count
source: top-10/outputs/tptn-comments-count.php
primaryPlugin: top-10
plugins: [top-10]
category: display
kind: plugin
tags: [comments, counts, popular-posts]
requiresPro: false
requirements: ["Top 10 must be active and provide a comment_count value on each result."]
review:
  status: available
references:
  - label: tptn_list
    url: https://webberzone.dev/top-10/hooks/tptn_list/
---
## What it changes

The function appends the result object's `comment_count` value and the text `comments` to the [Top 10](https://webberzone.com/plugins/top-10/) list item.

## Presentation

The example uses the same wording for every count, including one comment. Review the label and placement for your site. This displays comments, not the post's view count.

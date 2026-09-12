---
title: Remove parentheses around list counts
description: Remove opening and closing parentheses from the count displayed in Top 10 list items.
slug: tptn-remove-brackets
source: top-10/outputs/tptn-remove-brackets.php
primaryPlugin: top-10
plugins: [top-10]
category: display
kind: plugin
tags: [counts, formatting, popular-posts]
requiresPro: false
requirements: ["Top 10 must be active and display counts in its list output."]
review:
  status: available
references:
  - label: tptn_list_count
    url: https://webberzone.dev/top-10/hooks/tptn_list_count/
---
## What it changes

The function removes every `(` and `)` from the formatted count string passed through [Top 10](https://webberzone.com/plugins/top-10/)'s `tptn_list_count` filter.

## Scope

It changes the formatted list count, not the stored view count. If your count format contains parentheses elsewhere in its text, those are removed too.

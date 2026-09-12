---
title: Abbreviate view counts
description: Format Top 10 counts with k, m, bn and tn suffixes instead of displaying every digit.
slug: tptn-restyle-count
source: top-10/outputs/tptn-restyle-count.php
primaryPlugin: top-10
plugins: [top-10]
category: display
kind: plugin
tags: [counts, formatting, numbers]
requiresPro: false
requirements: ["Top 10 must be active."]
review:
  status: available
references:
  - label: tptn_post_count_only
    url: https://webberzone.dev/top-10/hooks/tptn_post_count_only/
---
## What it changes

This example turns the count returned by [Top 10](https://webberzone.com/plugins/top-10/) into an abbreviated string. It uses `k` from 1,000, `m` from 1,000,000, `bn` from 1,000,000,000 and `tn` from 1,000,000,000,000.

## What to change

Edit the suffixes in `$thresholds` or the precision passed to `round()`. Counts below 1,000 are returned as strings without a suffix.

This changes the representation returned by the count filter, not the stored number of views. Check integrations that expect a numeric return value.

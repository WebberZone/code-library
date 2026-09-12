---
title: Suppress counter output on later post pages
description: Remove Top 10's filtered counter output when a multipage post is viewed beyond its first page.
slug: tptn-no-nextpage-tracking
source: top-10/outputs/tptn-no-nextpage-tracking.php
primaryPlugin: top-10
plugins: [top-10]
category: tracking
kind: plugin
tags: [pagination, counter, tracking]
requiresPro: false
requirements: ["Top 10 must be active.", "Applies to counter output that passes through tptn_view_post_count."]
review:
  status: available
references:
  - label: tptn_view_post_count
    url: https://webberzone.dev/top-10/hooks/tptn_view_post_count/
---
## What it changes

This filter returns an empty string when the main query's `page` variable is greater than one. It targets [Top 10](https://webberzone.com/plugins/top-10/) counter output on later pages of a post split into multiple pages.

## Check your tracking setup

The filtered output can include the counter's tracking script or count markup. Removing it is not a universal switch for every possible tracking path. Verify your actual tracking configuration before relying on this example to prevent duplicate views.

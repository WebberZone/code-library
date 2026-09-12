---
title: Exclude additional bots from view counts
description: Add monitoring tools and other known user-agent strings to Top 10's bot exclusion list.
slug: tptn-custom-bots
source: top-10/tptn-custom-bots.php
primaryPlugin: top-10
plugins: [top-10]
category: tracking
kind: plugin
tags: [bots, user-agents, exclusions]
requiresPro: false
requirements: ["Top 10 must be active and use its bot exclusion checks."]
review:
  status: available
references:
  - label: tptn_bots
    url: https://webberzone.dev/top-10/hooks/tptn_bots/
---
## What it changes

The filter adds several monitoring-service user-agent strings to [Top 10](https://webberzone.com/plugins/top-10/)'s existing bot list. The example includes UptimeRobot, Pingdom, StatusCake, Site24x7 and HetrixTools.

## What to change

Edit `$custom_bots` to include the strings you want excluded. Matching uses case-insensitive substrings, so avoid broad terms that could also occur in legitimate browsers.

User-agent strings can be changed or spoofed. This is a counting exclusion, not a security control or proof that a visitor is a bot.

---
title: Display related posts in an editorial card grid
description: Use crp_custom_template to replace the default markup with publication-style related-post cards and custom CSS.
slug: crp-custom-template-card-grid
source: contextual-related-posts/crp-custom-template-card-grid.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: display
kind: plugin
tags: [templates, cards, grid]
requiresPro: false
requirements: ["Contextual Related Posts must be active.", "Activate only one custom-template example at a time."]
preview:
  image: /images/snippets/contextual-related-posts/crp-custom-template-card-grid.png
  alt: Two-column related-post card grid with featured images, excerpts, and publication dates.
  caption: Example output captured on a local multisite test site.
  width: 645
  height: 1679
review:
  status: available
references:
  - label: crp_custom_template
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_custom_template/
  - label: Customizing the output of Contextual Related Posts
    url: https://webberzone.com/support/knowledgebase/customising-the-output-of-contextual-related-posts/
---
## What it changes

This installable example renders related posts as responsive editorial cards with optional featured images, excerpts, publication dates, and scoped inline CSS. Its warm paper palette, serif headlines, and restrained accent are a starting point for a publication-style layout. It uses CRP’s heading settings when headings are enabled and builds excerpts from stored fields to avoid re-entering CRP’s content filter.

## Install and customize

Download the plugin ZIP from this page, upload it in **Plugins » Add New Plugin » Upload Plugin**, and activate it. The filter runs in CRP’s standard display renderer: automatic content output, shortcode, widget, native Related Posts block, and manual `get_crp()` or `echo_crp()` calls. Direct `CRP_Query` and `get_crp_posts()` loops are not affected. Edit the CSS in the enqueue callback and the card markup in the template callback to match your design.

Each template example uses the same `crp_custom_template` filter. Activate only one at a time unless you intentionally want to chain custom-template callbacks.

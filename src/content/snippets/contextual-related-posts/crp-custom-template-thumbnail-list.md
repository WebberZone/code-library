---
title: Display related posts in a thumbnail list
description: Replace the default related-post output with linked thumbnails, post titles, and short excerpts.
slug: crp-custom-template-thumbnail-list
source: contextual-related-posts/crp-custom-template-thumbnail-list.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: display
kind: plugin
tags: [templates, thumbnails, excerpts]
requiresPro: false
requirements: ["Contextual Related Posts must be active.", "Activate only one custom-template example at a time."]
review:
  status: available
references:
  - label: crp_custom_template
    url: https://webberzone.dev/contextual-related-posts/hooks/crp_custom_template/
  - label: Customizing the output of Contextual Related Posts
    url: https://webberzone.com/support/knowledgebase/customising-the-output-of-contextual-related-posts/
---
## What it changes

This installable example renders each related post with an optional featured image, linked title, and plain-text excerpt. It uses the stored excerpt or stripped post content, avoiding a recursive call to CRP’s content filter. Posts without a featured image still render with their title and excerpt.

## Install and customize

Download the plugin ZIP from this page, upload it in **Plugins » Add New Plugin » Upload Plugin**, and activate it. The filter runs in CRP’s standard display renderer: automatic content output, shortcode, widget, native Related Posts block, and manual `get_crp()` or `echo_crp()` calls. Direct `CRP_Query` and `get_crp_posts()` loops are not affected. Adjust the thumbnail size, excerpt length, markup, or CSS classes in the callback to fit your site.

Each template example uses the same `crp_custom_template` filter. Activate only one at a time unless you intentionally want to chain custom-template callbacks.

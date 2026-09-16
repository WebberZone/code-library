---
title: Replace related posts with a simple linked list
description: Use the crp_custom_template filter to render related posts as an accessible, escaped list of links.
slug: crp-custom-template-simple-list
source: contextual-related-posts/crp-custom-template-simple-list.php
primaryPlugin: contextual-related-posts
plugins: [contextual-related-posts]
category: display
kind: plugin
tags: [templates, custom-html, lists]
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

This installable example replaces CRP’s generated HTML with a simple list of related-post links. It uses CRP’s heading settings when headings are enabled and retains the `crp_related` wrapper class.

## Install and customize

Download the plugin ZIP from this page, upload it in **Plugins » Add New Plugin » Upload Plugin**, and activate it. The filter runs in CRP’s standard display renderer: automatic content output, shortcode, widget, native Related Posts block, and manual `get_crp()` or `echo_crp()` calls. Direct `CRP_Query` and `get_crp_posts()` loops are not affected. Edit the function’s markup or CSS classes to match your theme.

Each template example uses the same `crp_custom_template` filter. Activate only one at a time unless you intentionally want to chain custom-template callbacks.

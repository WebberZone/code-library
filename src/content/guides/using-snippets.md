---
title: Using code snippets
description: Choose the right installation method for a plugin-formatted snippet, function snippet or template example.
---

## Before you install

Every entry states the plugin it targets, the kind of code it contains and its review status. Snippets are examples, not drop-in guarantees: test them on a staging site and keep a backup before changing a production site.

Each page carries a compatibility note unless a concrete issue is known. A **Needs review** label means copy or download controls are intentionally unavailable while the issue remains unresolved.

## Installable mini-plugins

Entries labeled **Plugin** include a WordPress plugin header. Download the ZIP when available, then use **Plugins → Add New → Upload Plugin** in WordPress. Activate it like any other plugin.

If only the PHP source is available, create a folder named after the plugin slug, save the PHP file inside it, compress the folder and upload that ZIP. Keep the filename unchanged.

## Function snippets

Entries labeled **Function snippet** register hooks or define helper functions. Install them in one of these places:

- A small custom functionality plugin.
- A child theme's `functions.php` file when the customization is theme-specific.
- An MU plugin when it should always run.

Check whether the example outputs markup immediately. Code that echoes markup usually belongs in a template or a hooked callback, not at the top level of `functions.php`.

## Template examples

Entries labeled **Template example** are reference implementations for theme templates. Copy the relevant query, markup or callback into the correct template context. Do not upload the file to `wp-content/plugins` unless its page explicitly calls it an installable plugin.

## After installation

If a snippet changes indexed content, search behavior or related-post matching, run any required plugin reindex or clear the plugin's cache. Visit several affected posts and compare output before and after activation.

## Requirements

Review each page's plugin, Pro and PHP requirements before use. A Pro-only snippet needs the corresponding Pro plugin active. The companion page links to the relevant developer documentation where available.

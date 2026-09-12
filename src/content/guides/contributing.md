---
title: Contributing snippets
description: Add a useful, documented PHP example to the WebberZone code library with a fork and pull request.
---

## Contribution scope

Contribute practical customizations for WebberZone plugins: hooks, query adjustments, integrations, template examples and small installable plugins. Keep snippets focused and avoid duplicating an existing example.

## Add the PHP source

Place the file in the plugin's directory. Use a descriptive lowercase filename with hyphens. Existing category subdirectories may be used when they clarify the example.

A mini-plugin must include a valid WordPress plugin header and use the GPL-compatible license expected by the repository. A standalone snippet should not invent a plugin header.

## Add the Markdown companion

Create a matching Markdown file under `src/content/snippets/<plugin>/<slug>.md`. The frontmatter identifies the source path, plugin membership, curated category, kind, tags, requirements and review status. The body explains what the example does, where it runs and what to do after installation.

The build validates the metadata and requires every committed PHP source to have exactly one companion page.

## Test the site

Run these checks before opening a pull request:

```bash
pnpm test
pnpm exec astro check
pnpm run build
pnpm run verify:build
```

The build fails for invalid metadata, missing source files, broken source mappings and download-policy violations.

## Submit the change

Fork the repository, commit the PHP source and companion Markdown together, then open a pull request. Describe the use case, the tested plugin version and any limitations. Do not claim compatibility or runtime testing that has not been performed.

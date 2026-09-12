# Design Review — WebberZone Code Library

Date: 2026-09-12 · Mode: review · Register: Product (learning/browse surface) · Constraint: must follow WebberZone brand assets (colours and style)

## Score: 38 / 50

| Lens | Score | Key finding |
|---|---|---|
| First impression | 8 / 10 | Confident, specific hero. "Practical plugin customizations, ready to inspect" names the product and its proof. |
| Hierarchy | 8 / 10 | Eyebrow → H1 → lead → search → CTAs is clean; card hierarchy (badges/title/description/meta) is consistent. |
| Color voice | 7 / 10 | Palette tokens are exact, but two colour deviations: primary CTA and the code-block theme. |
| Type voice | 8 / 10 | League Spartan / Plus Jakarta Sans / Fira Code exactly per brand, self-hosted, well scaled. |
| Interaction feel | 7 / 10 | Combobox is genuinely keyboard-complete; empty filter state and copy feedback are missing. |
| **Total** | **38 / 50** | |

## Verdict: Needs changes

Nothing blocks use. Brand palette, type, and contrast are applied carefully — the audit found no accessibility escalation triggers (no HIGH findings). Four MEDIUM findings remain: two colour-voice deviations from the brand spec, an incomplete on-page TOC, and a missing empty state.

## First impression

Clean, on-brand, direct. The teal W / navy Z mark, off-white canvas, navy headings, and rust eyebrows read as WebberZone immediately. The hero is left-aligned with a real headline, not a generic centered gradient. The one moment that breaks the brand voice is the snippet page's code block: a GitHub-grey syntax theme sitting under a brand-navy shell.

## Flow walk

Arrive on home → hero names the product and the count (22 PHP examples) → search-as-you-type works with keyboard → browse by plugin/topic/latest → filter browser narrows 22 records live, no server round trip → snippet page explains what changes, what to change, requirements, then source with copy/download → gated snippets warn and disable copy/download → footer routes onward. The story holds end to end; it weakens at the snippet page where the TOC omits the page's three main sections, and at zero-results where the grid goes blank with no guidance.

## Findings

| # | Severity | Discipline | Location | Before | After | Why |
|---|---|---|---|---|---|---|
| 1 | MEDIUM | Color | `src/styles/global.css` `.btn` | Primary button bg `var(--teal-text)` `#2d5867`; hover bg `var(--rust)` | Bg `var(--teal)` `#4a7c8a` (white text passes AA at 4.62:1); hover `#3d6875` (teal dark) | Brand usage rules: teal `#4a7c8a` for button backgrounds, teal dark for button hover. Rust is reserved for secondary buttons and link hover. The CTA currently reads navy, not brand teal. |
| 2 | MEDIUM | Color | `src/pages/snippets/[plugin]/[slug].astro` `theme="github-dark"` | Code block renders `#24292e` bg with GitHub's red/green/blue palette inside the navy `.source-shell` | Custom Shiki theme keyed to brand hues (navy surface, teal/amber/stone accents) | The source block is the page's primary artifact and its largest coloured region; GitHub's palette is the only off-brand colour system on the site. Two different dark surfaces stack (navy shell over grey code). |
| 3 | MEDIUM | Layout | `src/components/Toc.astro` (h2 scope) + `[slug].astro` | TOC collects only `.markdown-body h2`; Requirements, Source, Details h2s live outside that wrapper and never appear | Generate TOC from all h2s in the article, or move the three template sections inside the collected scope | "On this page" lists 2 of 5 sections; Source — the reason the page exists — is unreachable from the TOC. Guide pages work correctly, so the inconsistency is visible. |
| 4 | MEDIUM | Interaction | `src/components/SnippetBrowser.astro` (render) | Zero matches: empty `.grid`, count reads "0 of 22 snippets", no message or reset | Render a "No snippets match these filters" state with a clear-filters action | The filter is the core work pattern of the browse page; an empty grid with a dangling count is a dead end. |
| 5 | LOW | Accessibility | `global.css` `.source-actions button, .source-actions a` | Code actions are `min-height:36px`; pagination links ~37px | Raise to 44px min-height (keep visual weight, expand hit area) | Below the 44px comfortable touch target on mobile, where copy/download are the primary actions. |
| 6 | LOW | Accessibility | `[slug].astro` copy script | Success feedback is a text swap only; no live region | Add `aria-live="polite"` (or toggle `aria-label` on the button) | Screen readers never hear that the copy succeeded. |
| 7 | LOW | Writing | `src/pages/index.astro` "Browse by plugin" section | `.list-head` has no counterpart link; Topics has "All topics", Latest has "View all" | Add "View all" link to `/plugins/` | Same header pattern rendered three times, one instance missing its action — reads as unfinished. |
| 8 | LOW | Accessibility | `src/layouts/Base.astro` mobile nav summary | `aria-label="Open navigation"` is static | Toggle label on open/close | The control announces "Open navigation" while it is already open. |

## Considered but rejected

| Location | Candidate | Rejected because |
|---|---|---|
| `global.css` focus ring | Swap teal focus ring for a higher-contrast colour | Teal `#4a7c8a` on white/off-white is 4.19–4.62:1, above the 3:1 non-text AA bar; teal is the brand's reserved non-text accent |
| `global.css` `.eyebrow` | Darken rust eyebrow text | Rust on off-white computes at 5.20:1 — passes AA even at 0.78rem |
| `SearchBox.astro` | Report the blur/click race on the suggestion list | The 150ms close delay works; click-through verified in practice |
| `[slug].astro` `pre tabindex="0"` | Add an aria-label to the scrollable code region | Shiki's default; low impact, not worth the churn |
| `SnippetCard.astro` | Make whole card clickable | Card contains multiple distinct links (title, badges, meta); full-card links would create nested-interaction problems |

## Verification

Checks run:

- Built site previewed via `astro preview` (port 4322) and walked in headless Chromium (1440px, 375px, 320px).
- Screenshots reviewed: home, snippets browser, snippet detail (regular + gated), using-snippets guide, plugins index, mobile home, mobile snippets, 320px snippet detail.
- WCAG contrast computed programmatically for 13 token pairs — all pass AA (eyebrow rust 5.20, teal focus ring 4.62, review badge 6.27, teal-text links 7.77, footer 9.15+).
- Keyboard: first Tab lands on visible skip link; combobox ArrowDown/Enter navigation verified end to end (landed on the right snippet page).
- Empty filter state reproduced: "0 of 22 snippets", zero cards, no empty-state message.
- Brand fidelity: `public/mark.svg` uses teal W `#4a7c8a` + navy Z `#1a2e3a`; footer recolour matches the on-dark variant; fonts self-hosted per brand; teal is never used as text (links use `#2d5867`).
- 320px reflow: no horizontal scroll, badges wrap, TOC stacks below content.

Not verified:

- Screen-reader announcement pass (no screen reader available).
- Copy-to-clipboard success announcement (identified from code; could not hear it).
- Hover states on touch devices.

## Next modes

1. `recolor` — primary CTA to brand teal/teal-dark, custom Shiki theme keyed to navy/teal (findings 1, 2).
2. `relayout` or `refine` — include Requirements/Source/Details in the snippet TOC (finding 3).
3. `interaction` — empty filter state, copy success announcement, 44px code-action targets (findings 4, 5, 6).
4. `finish` — the two small consistency items (findings 7, 8).

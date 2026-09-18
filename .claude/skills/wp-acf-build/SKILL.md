---
name: wp-acf-build
description: Turn a design (Figma export, PDF, screenshot, or a plain description) into a WordPress site built on ramarketing's base theme — page-builder modules, ACF fields as local JSON, and a live DDEV preview including wp-admin. Use whenever the task is "build this design in WordPress", "turn this Figma into a WP site", or extending an existing ramarketing WP+ACF project with a new page/module.
---

# WordPress + ACF build

This skill has two halves that stay separate on purpose:

1. **Design → component → code + ACF fields.** A real decomposition problem —
   this is what the rest of this document is about.
2. **Local server + live preview (incl. wp-admin).** Solved by DDEV + WP-CLI,
   not by clever prompting. See `bin/setup.sh` and `README.md` at the repo
   root. Don't reinvent this per project — run the script.

Read `docs/CONVENTIONS.md` once before the first build in a session. It
documents every naming convention below with the actual reasoning, plus a
list of bugs that were already fixed in the base theme (don't reintroduce
them).

## Step 0 — is there already a project?

If `public/content/themes/<something other than base>/` exists, or the repo
isn't this scaffold repo at all, you're extending a real project, not
starting one. Read that theme's `functions.php`, `_parts/modules/`, and
`acf-json/` first — an existing project's own conventions win over this
skill's defaults if they conflict (this skill describes *ramarketing's*
conventions, and a specific project may have justified departures).

Otherwise, starting fresh: copy `public/content/themes/base/` to
`public/content/themes/<project-slug>/`, update `style.css`'s `Theme Name`,
and work in the copy. Never edit `base/` itself for a real build — it's the
scaffold other projects fork from.

## Step 1 — get the design, decompose it into modules

Whatever the input (Figma link/export, PDF, screenshot, verbal description),
break each page into a vertical stack of **modules** — self-contained,
full-width-or-contained sections that don't depend on their neighbours to
render correctly. This maps directly onto the page-builder pattern: each
module becomes one layout in the `page-builder` flexible-content field.

For each section, ask:

- **Does an existing layout already cover this?** Check
  `acf-json/group_page_builder_modules.json` and
  `_parts/modules/*.php` in the theme you're building in. The base theme
  ships 15: `text_and_image`, `cta`, `video_full_width`, `display_posts`,
  `accordion`, `quote`, `vacancies`, `team`, `timeline`, `text_only`,
  `image_gallery`, `contact_form`, `map`, `carousel`, `spacer`. A design's
  "hero with image and button" is `text_and_image`. A logo grid, FAQ
  accordion, testimonial carousel — check the list before writing a new one.
- **Does it need new fields on an existing layout?** Extend the layout's
  `sub_fields` array in the JSON (see Step 3) rather than duplicating the
  whole layout for a minor variant.
- **Is it genuinely new?** Add a new layout entry (Step 3) and a matching
  `_parts/modules/{layout_name}.php` template (Step 4).

Don't build a from-scratch component system per project. The value of this
skill is that every ramarketing WP build recognisably shares the same
module vocabulary.

## Step 2 — naming conventions (non-negotiable, match these exactly)

| Thing | Convention | Example |
|---|---|---|
| Flexible content field | always `page-builder` on `field group: Page builder modules`, post type `page` | — |
| Module layout name | `snake_case`, matches the template filename | `text_and_image` → `_parts/modules/text_and_image.php` |
| PHP functions in `_includes/` | `rb_<file>__<action>()` | `rb_scripts__enqueue_script()` |
| Page-builder render functions | `ra__<action>()` (deliberately different prefix — matches the source, don't "fix" it) | `ra__render_modules()` |
| Custom post type slug | `cpt-{name}` | `cpt-articles` |
| Taxonomy slug | `tax-{name}` | `tax-content-type` |
| Site-wide option field (General Options page) | `global--{name}` | `global--telephone` |
| Feature-toggle field (Theme Options sub-page) | `theme--{name}` | `theme--map` |
| ACF JSON filename | `group_{snake_case_title}.json` | `group_page_builder_modules.json` |

## Step 3 — ACF fields as local JSON

Field groups live in `acf-json/` at the theme root — ACF Pro auto-loads from
there by default (no filter needed). **Never** use
`acf_add_local_field_group()` in PHP for this; local JSON is the convention
because it's git-diffable and syncs through the ACF admin UI automatically.

Rules when editing these files by hand:

- Every `key` (`group_*`, `field_*`, `layout_*`) must be **globally unique**
  across every JSON file in the folder. Generate fresh ones — don't copy an
  existing key and change one character. A duplicate key was a real bug
  found in the source export (see `docs/CONVENTIONS.md`) and it's easy to
  reintroduce by copy-pasting a field as a starting point.
- Don't use `acfe_*` prefixed attributes or ACF Extended field types
  (`acfe_post_types`, etc.) — ACF Extended isn't a vendored plugin here.
  Stick to core ACF Pro field types.
- A `clone` field must reference a `field_*`/`group_*` key that actually
  exists in one of the exported groups. A dangling clone target was another
  real bug in the source — it fails silently in wp-admin (empty field) if
  you get this wrong, so it's easy to miss.
- After editing JSON by hand, run
  `ddev wp eval-file bin/sync-acf.php` to import the change into the
  database (equivalent to clicking "Sync available" in wp-admin) so the
  field group shows up in edit screens immediately.
- Prefer flat, obviously-named sub-fields over deeply nested groups. A
  reader should be able to guess a module's sub-field names from its layout
  name and the design, without opening the JSON.

## Step 4 — write the template

Each module template lives at `_parts/modules/{layout_name}.php` and is
included by `ra__render_modules()` (`_parts/module-render.php`) from inside
an active `have_rows('page-builder')` loop — so `get_sub_field()` /
`the_sub_field()` work directly, no extra setup needed.

If a module needs server-side data prep (a `WP_Query`, mapping a radio
index to a CSS class, resolving an ACF `link` field before rendering), add a
`case` for it in `ra__get_module_data()` in the same file and consume the
result via `$data['...']` in the template — keep the template itself a
dumb renderer, not a place to write query logic. See the `display_posts`
case for the pattern.

Use `rb_render__btn($link_field_array, $colour, $size)`
(`_includes/render.php`) for every CTA button rather than hand-rolling
`<a>` markup per module — it's the one place button markup changes if the
design system's button styles change.

## Step 5 — styles

SCSS lives in `_src/assets/styles/`, ITCSS-ordered:
`00-core` (breakpoints/colours/fonts/reset — edit `_colours.scss` first for
a new project's brand palette) → `01-mixins` → `02-layout` →
`03-components` (one file per module family) → `04-client` (wp-admin/login
only) → `05-ui` → `06-tools` (dev-only, gated by flags in
`00-core/_base-options.scss`).

Build with `npm run build` (one-off) or `npm run watch` (during a session),
run from `_src/` — or via `ddev npm --prefix public/content/themes/<theme>/_src run watch`
so it runs inside the DDEV container without needing Node on the host.

## Step 6 — local preview

From the repo root: `bin/setup.sh` (first run) or just `ddev start` +
`ddev launch` (subsequent sessions). It downloads WP core, installs ACF PRO
from `.env`'s `ACF_PRO_KEY`, activates the theme, syncs the JSON field
groups into the DB, and seeds a demo page so there's immediately something
to look at in the browser and in wp-admin. Full detail in the repo root
`README.md`.

Check the actual rendered page in a browser after building each module —
type checking a PHP template doesn't catch a wrong ACF return-format
assumption (e.g. treating an `image` field as an ID when it's configured to
return an array). This is exactly the kind of bug that's invisible until you
look.

## Step 7 — before calling a build done

- [ ] Every module used on the page has a real, on-brand template (no
      `_parts/modules/*.php` placeholder comments left rendering as empty
      `<section>` tags on the live page)
- [ ] `docs/CONVENTIONS.md` naming rules followed for anything new
      (post types, taxonomies, option fields, ACF JSON filenames)
- [ ] `ddev wp eval-file bin/sync-acf.php` run after any ACF JSON edit
- [ ] Checked in a browser — home page and at least one interior page
- [ ] `npm run build` run (not just `watch` left running) so `_dist/` has a
      production build before commit

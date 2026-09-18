# Base theme conventions

Audited from ramarketing's `rawp_base` theme export. This file documents what
was kept, what was fixed, and what was dropped, so the reasoning doesn't get
lost — and so a fresh scaffold built by the `wp-acf-build` skill actually
looks like something a ramarketing dev wrote.

## Kept as-is (these are the real conventions)

- **Folder layout**: `_includes/` (functions.php require targets, one concern
  per file), `_parts/` (template partials + the page-builder module system),
  `_src/` (SCSS/JS source, gulp-built into `_dist/`), `acf-json/` (local JSON
  field groups at theme root, ACF's default autoload location — no filter
  needed).
- **Function naming**: `rb_<file>__<action>()` for most includes
  (`rb_scripts__enqueue_script`, `rb_get__time_to_read`,
  `rb_cptax__reg_pt_articles`). The page-builder renderer uses `ra__` instead
  of `rb_` — that inconsistency exists in the source and is preserved rather
  than "fixed", since renaming it would make the base theme look unlike any
  real ramarketing project.
- **CPT slugs**: `cpt-{name}` (`cpt-articles`, `cpt-team`, `cpt-vacancies`).
- **Taxonomy slugs**: `tax-{name}` (`tax-content-type`, `tax-location`,
  `tax-department`).
- **ACF options field naming**: `global--{name}` on the General Options page,
  `theme--{name}` on the Theme Options sub-page, both gating optional
  features (`theme--map`, `theme--contact-form`, `theme--site-search`).
- **The page-builder pattern**: a single `flexible_content` field named
  `page-builder` on the `page` post type. Each layout name maps 1:1 to a
  template file at `_parts/modules/{layout}.php`, included by
  `ra__render_modules()` in `_parts/module-render.php`. Any server-side data
  prep for a module (building a WP_Query, mapping a radio index to a label)
  happens in `ra__get_module_data()` — the module template itself stays a
  dumb renderer.
- **SCSS structure**: ITCSS-ish — `00-core` (breakpoints, colours, base
  options, fonts, reset, typography) → `01-mixins` → `02-layout` →
  `03-components` → `04-client` (wp-admin/login screen only) → `05-ui` →
  `06-tools` (dev-only helpers, gated by flags in `_base-options.scss`).
- **Custom `content/` directory**: `wp-config.php` redefines
  `WP_CONTENT_DIR`/`WP_CONTENT_URL` to `content` instead of `wp-content`
  (WP Engine deploy convention). `bin/setup.sh` reproduces this.
- **Options pages**: `acf_add_options_page()` for General Options (slug
  `options`) with a Theme Options sub-page (slug `theme-options`).

## Fixed (these were bugs in the source, not conventions)

- **Duplicate ACF field group key.** `group_5e468c69354de.json` and
  `group_5e468c69354ge.json` shared the literal key `group_5e468c69354de`
  but pointed at two different options-page slugs (`options` vs.
  `site-options` — the latter never registered anywhere in `acf.php`, so it
  was dead). Kept only the one wired to the real `options` page.
- **`acfe_*` field attributes** throughout the modules field group are ACF
  Extended settings, but ACF Extended isn't one of the vendored plugins —
  they were inert leftovers from a copy/paste. Stripped.
- **`acfe_post_types` field type** (`display_posts.post_type`) requires ACF
  Extended to render at all; without it ACF shows an unknown-field-type
  error in wp-admin. Replaced with a plain `select` field.
- **Dangling clone field.** The `team` layout cloned `field_5f871f5af5557`,
  a field that isn't defined in any exported field group — broken since
  before this export. Replaced with plain `headline`/`subheading` fields.
- **`cpt-resources`** was referenced in the `display_posts` layout's post
  type choices but never registered as a post type anywhere. Dropped in
  favour of the CPTs that actually exist (`post`, `page`, `cpt-articles`).
- **`_parts/modules/*.php` didn't exist** for 14 of the 15 flexible-content
  layouts (only `contact_form.php` was present) — `ra__render_modules()`
  would hit a missing-file warning on every other layout. All 15 now have a
  starter template.
- **`$ajax` undefined variable** in `_includes/scripts.php` — the
  `get_field('ajax_filter', 'options')` call that should have set it was
  commented out, so the conditional right below it was dead code operating
  on an undefined var. Fixed.
- **Broken reCAPTCHA call** in `_parts/modules/contact_form.php`:
  `(new submissionHandling)->getRecaptchaKeys['site_key']` calls a method
  without `()` before indexing it — invalid PHP. Fixed to
  `->getRecaptchaKeys()['site_key']`.
- **Relative `include_once('_includes/...')` calls** in `functions.php`
  depend on PHP's include path / cwd rather than resolving from the theme
  directory — fragile outside the exact server config it was written for.
  Replaced with `RB_THEME_DIR . '/_includes/...'` throughout.
- **`rb_render__btn()`** was a stub that always returned an empty string.
  Implemented against ACF's `link` field array shape (`url`/`title`/`target`).
- **`wp_title()`** in `header.php` is deprecated since WP 4.4. Removed in
  favour of `add_theme_support('title-tag')`.

## Dropped (project-specific, not part of the base)

- **Brand colours** in `00-core/_colours.scss` (`$red: #DA000F`, a specific
  client's palette) — replaced with a neutral placeholder palette. Swap
  these per project.
- **TGM Plugin Activation** (`class-tgm-plugin-activation.php`,
  `tgm_activation.php`) — a wp-admin nag screen for required plugins. DDEV +
  WP-CLI installs plugins directly, so this has no job to do here.
- **Vendored plugins** (ACF Pro, Yoast, Wordfence, Smush, wps-hide-login,
  classic-editor, a custom `contact-database`/`ra-suite` mu-plugin-style
  setup) were bundled directly in the zip's `content/plugins/`. None of
  that's "base theme" — it's a specific deployed site's dependency tree.
  This repo tracks the theme only; `bin/setup.sh` installs ACF Pro (the one
  plugin the theme actually calls) via WP-CLI using a license key from
  `.env`.
- **gulp-notify desktop notifications** — meaningless in a headless
  container. The modernised `gulpfile.js` (Gulp 3 → Gulp 4, node-sass →
  dart-sass, since the original deps don't install on current Node) logs to
  the console instead.
- **`example.README.md` / `example.wp-config.php`** at the export's root
  were WP Engine deployment instructions (SSH commands, `wp search-replace`
  for a specific staging/prod naming scheme) — that's deploy documentation
  for a specific host, not a base-theme convention. Superseded by
  `bin/setup.sh` for local dev; deploy docs belong in a real project's own
  README when it's actually going to WP Engine.

## Still open

- **`_parts/modules/timeline.php`** has no ACF fields defined yet — the
  original left this layout as a placeholder. Add sub_fields to the
  `timeline` layout in `acf-json/group_page_builder_modules.json` the first
  time a design actually needs one.
- **`cpt-team` / `cpt-vacancies`** are registered in `cptax.php` but
  commented out of their `add_action('init', ...)` calls, matching the
  source. The `team.php` and `vacancies.php` module templates query these
  post types directly — uncomment the registration before using either
  module on a real build.

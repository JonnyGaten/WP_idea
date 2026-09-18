# WP Idea — WordPress + ACF build skill

A Claude Code skill (`.claude/skills/wp-acf-build/SKILL.md`) that turns a
design into a fully wired-up WordPress site: theme templates, ACF fields
(as local JSON), and a live local preview including wp-admin — grounded in
ramarketing's own base theme conventions.

## What's in here

```
public/content/themes/base/   the base theme (WordPress core, plugins and
                               uploads are all fetched by bin/setup.sh, not
                               committed — this and rois/ are the only
                               things this repo tracks under public/)
public/content/themes/rois/   design-evaluation build: a full one-page site
                               forked from base, demonstrating the skill
                               end to end against a real design
bin/                           the local environment contract (DDEV + WP-CLI)
docs/CONVENTIONS.md            what was kept / fixed / dropped from the
                               original theme export, and why
.claude/skills/wp-acf-build/   the skill itself
.ddev/config.yaml              DDEV project config
```

## Local environment contract

Requires [DDEV](https://ddev.readthedocs.io/en/stable/#installation) (which
needs Docker) on the machine actually running this — not inside a sandboxed
remote session without a Docker daemon.

```bash
cp .env.example .env   # fill in WP_ADMIN_PASSWORD, WP_ADMIN_EMAIL, ACF_PRO_KEY
bin/setup.sh
```

`bin/setup.sh` is idempotent — re-run it any time:

1. `ddev start`
2. Downloads WP core (skips `wp-content`, since the theme's `wp-config.php`
   points `WP_CONTENT_DIR` at the already-tracked `content/` folder)
3. Writes `wp-config.php` with the project's custom defines
4. `wp core install`
5. Downloads + activates ACF PRO using `ACF_PRO_KEY` from `.env` (via ACF's
   own update-connect endpoint — never hardcode the key in the repo)
6. Activates the `base` theme
7. Imports the `acf-json/` field groups into the database
   (`bin/sync-acf.php`)
8. Seeds a demo homepage through the page-builder field so there's
   something to look at (`bin/seed.php`)
9. `ddev launch`

Front-end build (SCSS/JS → `_dist/`), per theme:

```bash
ddev npm --prefix public/content/themes/base/_src install
ddev npm --prefix public/content/themes/base/_src run watch
```

## Seeing the ROIS design-evaluation build

`bin/setup.sh` above sets up WordPress with the `base` theme active. To see
the ROIS demo instead (a full one-page site — hero, animated stat counter,
process steps, locations, about, feature cards, careers CTA, news list,
final CTA — built against a design link as the real end-to-end test of this
skill):

```bash
ddev npm --prefix public/content/themes/rois/_src install
ddev npm --prefix public/content/themes/rois/_src run build
ddev wp eval-file bin/seed-rois.php
ddev launch
```

`bin/seed-rois.php` activates the `rois` theme, imports its ACF field
groups, seeds 3 demo articles + the primary/footer nav menus, and builds the
homepage through the `page-builder` field to match the design. Re-running it
updates the same content instead of duplicating it.

## Status

Everything here — the base theme, the ROIS demo theme, ACF field groups, and
the DDEV/WP-CLI scripts — was built and lint-checked (`php -l`, and each
theme's `npm run build` was run standalone to confirm the modernised gulp
pipeline actually compiles) in a sandboxed session **without a Docker daemon
available**, so none of `bin/setup.sh`, `bin/seed.php`, or `bin/seed-rois.php`
have been run end-to-end against a live DDEV project yet. That first real
run — on a machine with Docker — is the next step before treating the skill
as trustworthy: something in the WP-CLI flags, the ACF Pro download, or the
seeded flexible-content data will likely need a fix once it hits a real
WordPress install. Fix forward with Claude Code locally when it does.

See `docs/CONVENTIONS.md` for what was audited out of the original
`rawp_base` export and why.

# WP Idea — WordPress + ACF build skill

A Claude Code skill (`.claude/skills/wp-acf-build/SKILL.md`) that turns a
design into a fully wired-up WordPress site: theme templates, ACF fields
(as local JSON), and a live local preview including wp-admin — grounded in
ramarketing's own base theme conventions.

## What's in here

```
public/content/themes/base/   the base theme (the only thing this repo tracks
                               under public/ — WordPress core, plugins and
                               uploads are all fetched by bin/setup.sh, not
                               committed)
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

Front-end build (SCSS/JS → `_dist/`):

```bash
ddev npm --prefix public/content/themes/base/_src install
ddev npm --prefix public/content/themes/base/_src run watch
```

## Status

The theme scaffold, ACF field groups, and DDEV/WP-CLI scripts were built and
lint-checked (`php -l`, plus the theme's `npm run build` was run standalone
to confirm the modernised gulp pipeline compiles) in a sandboxed session
**without a Docker daemon available**, so `bin/setup.sh` has not been run
end-to-end against a live DDEV project yet. Run it on a machine with Docker
and fix forward with Claude Code if any step needs adjusting — this is the
next thing to do before treating the skill as trustworthy.

See `docs/CONVENTIONS.md` for what was audited out of the original
`rawp_base` export and why.

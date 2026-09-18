#!/usr/bin/env bash
# Local environment contract: spin up -> install ACF -> activate theme -> seed content -> open localhost.
# Safe to re-run — every step checks whether it's already done.
set -euo pipefail
cd "$(dirname "$0")/.."

if ! command -v ddev >/dev/null 2>&1; then
    echo "ddev is not installed. See https://ddev.readthedocs.io/en/stable/#installation" >&2
    exit 1
fi

if [ ! -f .env ]; then
    echo ".env not found. Copy .env.example to .env and fill in real values first." >&2
    exit 1
fi

# shellcheck disable=SC1091
set -a; source .env; set +a

echo "==> Starting DDEV"
ddev start

if [ ! -f public/wp-load.php ]; then
    echo "==> Downloading WordPress core (content dir already tracked in git)"
    ddev wp core download --skip-content --force
fi

if [ ! -f public/wp-config.php ]; then
    echo "==> Writing wp-config.php"
    ddev wp config create \
        --dbname=db --dbuser=db --dbpass=db --dbhost=db \
        --dbprefix="${DB_TABLE_PREFIX:-rb_}" \
        --skip-check \
        --extra-php <<PHP
define('WP_CONTENT_DIR_NAME', 'content');
define('WP_CONTENT_DIR', ABSPATH . WP_CONTENT_DIR_NAME);
define('WP_CONTENT_URL', 'http://' . (\$_SERVER['HTTP_HOST'] ?? parse_url(getenv('PROJECT_URL') ?: 'http://localhost', PHP_URL_HOST)) . '/' . WP_CONTENT_DIR_NAME);
define('ENV', 'local');
define('RECAPT_SITE', getenv('RECAPTCHA_SITE_KEY') ?: '');
define('RECAPT_SECRET', getenv('RECAPTCHA_SECRET_KEY') ?: '');
define('GTM_TAG', getenv('GTM_TAG') ?: false);
PHP
elif ! grep -q "WP_CONTENT_DIR_NAME" public/wp-config.php; then
    # ddev auto-generates a bare wp-config.php on first `ddev start` before this
    # script gets a chance to write its own — patch the custom defines into the
    # marker section ddev's stub already leaves for exactly this purpose.
    echo "==> Patching wp-config.php with custom content-dir defines"
    php -r '
        $path = "public/wp-config.php";
        $contents = file_get_contents($path);
        $marker = "/* Add any custom values between this line and the \"stop editing\" line. */";
        $custom = <<<PHP

define("WP_CONTENT_DIR_NAME", "content");
define("WP_CONTENT_DIR", ABSPATH . WP_CONTENT_DIR_NAME);
define("WP_CONTENT_URL", "http://" . (\$_SERVER["HTTP_HOST"] ?? parse_url(getenv("PROJECT_URL") ?: "http://localhost", PHP_URL_HOST)) . "/" . WP_CONTENT_DIR_NAME);
define("ENV", "local");
define("RECAPT_SITE", getenv("RECAPTCHA_SITE_KEY") ?: "");
define("RECAPT_SECRET", getenv("RECAPTCHA_SECRET_KEY") ?: "");
define("GTM_TAG", getenv("GTM_TAG") ?: false);
PHP;
        $contents = str_replace($marker, $marker . $custom, $contents);
        file_put_contents($path, $contents);
    '
fi

if ! ddev wp core is-installed >/dev/null 2>&1; then
    echo "==> Running WordPress install"
    ddev wp core install \
        --url="${PROJECT_URL:-https://wp-idea.ddev.site}" \
        --title="${PROJECT_TITLE:-WP Idea}" \
        --admin_user="${WP_ADMIN_USER:-admin}" \
        --admin_password="${WP_ADMIN_PASSWORD:?set WP_ADMIN_PASSWORD in .env}" \
        --admin_email="${WP_ADMIN_EMAIL:?set WP_ADMIN_EMAIL in .env}" \
        --skip-email
fi

if ! ddev wp plugin is-installed advanced-custom-fields-pro >/dev/null 2>&1; then
    if [ -n "${ACF_PRO_KEY:-}" ]; then
        echo "==> Downloading ACF PRO"
        ACF_ZIP="/tmp/acf-pro.zip"
        curl -sSL "https://connect.advancedcustomfields.com/index.php?a=download&p=pro&k=${ACF_PRO_KEY}" -o "$ACF_ZIP"
        ddev import-files --source="$ACF_ZIP" 2>/dev/null || true
        ddev wp plugin install "$ACF_ZIP" --activate || echo "!! ACF PRO install failed, check ACF_PRO_KEY in .env"
        ddev wp eval 'if (function_exists("acf_pro_update_license")) { acf_pro_update_license(getenv("ACF_PRO_KEY")); echo "ACF PRO license set.\n"; } else { echo "ACF PRO installed, but license activation needs a manual step under Custom Fields > Updates.\n"; }'
        rm -f "$ACF_ZIP"
    elif ddev wp plugin is-installed advanced-custom-fields >/dev/null 2>&1; then
        : # free ACF already installed from a prior run without a key
    else
        echo "!! ACF_PRO_KEY not set in .env — installing free ACF from wordpress.org instead."
        echo "   The theme needs some build of ACF active just to boot (get_field() etc)."
        echo "   Flexible-content page-builder fields are a PRO-only feature, so seeded"
        echo "   page-builder content won't render until a real key is added and this"
        echo "   script is re-run. Get a key from https://www.advancedcustomfields.com/my-account/"
        ddev wp plugin install advanced-custom-fields --activate
    fi
fi

echo "==> Activating theme"
ddev wp theme activate base

echo "==> Importing local ACF JSON field groups into the database"
ddev wp eval-file bin/sync-acf.php

echo "==> Seeding demo content"
bash bin/seed.sh

echo "==> Done"
ddev launch

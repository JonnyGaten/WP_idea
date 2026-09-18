#!/usr/bin/env bash
set -euo pipefail
cd "$(dirname "$0")/.."
ddev wp eval-file bin/seed.php

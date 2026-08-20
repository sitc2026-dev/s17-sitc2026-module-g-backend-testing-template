#!/usr/bin/env bash
# Download PHPUnit PHAR locally (optional — Docker image already includes it).
set -euo pipefail
cd "$(dirname "$0")"
curl -fsSL -o phpunit.phar https://phar.phpunit.de/phpunit-12.5.12.phar
chmod +x phpunit.phar
echo "OK: ./phpunit.phar"
echo "Run: php phpunit.phar"

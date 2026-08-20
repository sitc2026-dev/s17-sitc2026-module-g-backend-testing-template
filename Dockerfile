FROM php:8.3-cli-bookworm
RUN apt-get update && apt-get install -y --no-install-recommends curl ca-certificates \
    && rm -rf /var/lib/apt/lists/* \
    && curl -fsSL -o /usr/local/bin/phpunit \
      https://phar.phpunit.de/phpunit-12.5.12.phar \
    && chmod +x /usr/local/bin/phpunit
WORKDIR /app
COPY . .
RUN chmod +x run.php
# Skeletons start incomplete — do not fail the image build.
RUN phpunit || true
CMD ["php", "run.php"]

# SwapLoop Billing — PHPUnit (Module G)

Partner billing inspired by Module B. **No Composer. No third-party libraries.** PHP stdlib only for the app. Implement tests under `tests/`.

## Run the app

```bash
php run.php
```

## Run tests

Docker (PHPUnit PHAR baked into the image):

```bash
docker compose up --build          # demo export
docker compose run --rm test       # PHPUnit
```

Local PHPUnit PHAR (optional):

```bash
./install-phpunit.sh
php phpunit.phar
```

## Layout

```
autoload.php   simple App\ autoloader (no Composer)
run.php        CLI entrypoint
src/           domain code
tests/         PHPUnit skeletons
out/           export output (gitignored)
```

App uses `date()` and `file_put_contents()` directly. Concrete `Notifier` (no interface) — mock it in tests.

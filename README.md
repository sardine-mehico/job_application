# Cleaning Company Applications

This project ships with Docker Compose for hosting the webapp with SQLite.

## Hosting With Docker

The Compose stack reads variables from `.env`, so you can change ports, app URL, debug mode, container name, and SQLite path without editing `docker-compose.yml`.

By default the stack pulls the published image from GitHub Container Registry:

```env
APP_IMAGE=ghcr.io/sardine-mehico/job_application:1.0
```

Recommended `.env` values for hosting:

```env
APP_NAME="Cleaning Company Applications"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.example

APP_IMAGE=ghcr.io/sardine-mehico/job_application:1.0
APP_PORT=8088
APP_CONTAINER_NAME=cleaning-company-app

DB_CONNECTION=sqlite
DB_DATABASE=/var/www/html/database/database.sqlite

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database
```

## Start The App

```bash
docker compose up -d --build
```

On startup the container will:

- create the SQLite database file if it does not exist
- run migrations
- run seeders
- start Apache

## Persistent Data

Docker volumes are used for:

- the SQLite database directory
- Laravel `storage`

That means application data survives container rebuilds and restarts.

# Local setup guide (interview / demo machine)

Use this guide after cloning the repository from GitHub. For architecture and tickets, see [README.md](README.md) and [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md).

## What you get after setup

- Product catalog (Fake Store API): featured products, categories, search, product detail
- Product enquiry form with thank-you page
- JSON API under `/api/...`
- Health check at `/up`

| Page / API | URL (with `php artisan serve`) |
|--------------|--------------------------------|
| Home (5 featured) | http://127.0.0.1:8000/ |
| All products | http://127.0.0.1:8000/products |
| Search | http://127.0.0.1:8000/products?q=shirt |
| Category | http://127.0.0.1:8000/products/category/electronics |
| Product detail + enquiry | http://127.0.0.1:8000/products/1 |
| API featured | http://127.0.0.1:8000/api/products/featured |
| API list | http://127.0.0.1:8000/api/products |
| Health | http://127.0.0.1:8000/up |

## Prerequisites

- **PHP 8.2+** (XAMPP: add `c:\xampp\php` to PATH, or run commands with full path to `php.exe`)
- **Composer** — https://getcomposer.org/
- **Node.js 18+** and npm — for frontend assets (`npm run build`)
- **Git**
- **Internet** — Fake Store API, Composer, npm
- **Optional (Profile B):** Redis on `127.0.0.1:6379` (e.g. [Memurai](https://www.memurai.com/) on Windows)
- **Optional:** Docker Desktop — full stack with MySQL + Redis + Horizon (see [Docker (optional)](#docker-optional))

## Clone and install

```powershell
git clone https://github.com/VB79955/ProductCatalogue.git
cd ProductCatalogue
composer install
copy .env.example .env
php artisan key:generate
php artisan migrate
npm install
npm run build
```

If you use XAMPP and `php` is not on PATH:

```powershell
c:\xampp\php\php.exe artisan key:generate
c:\xampp\php\php.exe artisan migrate
```

## Choose a local profile

### Profile A — Quick (no Redis)

Best for an interview laptop **without** Redis installed.

Edit `.env`:

```env
CACHE_STORE=array
QUEUE_CONNECTION=sync
```

Then clear config:

```powershell
php artisan config:clear
```

Enquiry emails, audit, and analytics run **immediately** (sync) — no queue worker needed.

### Profile B — Full (Redis cache + queue)

Matches the project’s Redis cache and async enquiry processing.

Keep in `.env` (defaults from `.env.example`):

```env
CACHE_STORE=redis
QUEUE_CONNECTION=redis
REDIS_CLIENT=predis
REDIS_HOST=127.0.0.1
REDIS_PORT=6379
```

Start Redis first, then:

```powershell
php artisan config:clear
```

**Queue worker** (second terminal) — required for enquiry side effects:

```powershell
php artisan queue:work redis --queue=enquiries,default
```

**Note:** Laravel Horizon does **not** run on Windows PHP (missing `pcntl`). Use `queue:work` locally, or use Docker for Horizon.

## Start the application

**Terminal 1 — web server:**

```powershell
php artisan serve
```

Open **http://127.0.0.1:8000**

**Profile B — Terminal 2:** keep `php artisan queue:work` running (see above).

**Optional — all-in-one dev** (Profile B + live Vite; requires Node):

```powershell
composer dev
```

Runs `serve`, queue listener, logs, and Vite together.

After any `.env` change:

```powershell
php artisan config:clear
```

## Verify (interview demo checklist)

1. **Home** — http://127.0.0.1:8000/ shows **5 featured** product cards.
2. **Detail** — Open http://127.0.0.1:8000/products/1 .
3. **Enquiry** — Submit the form (name, email, phone, message) → thank-you page with a **reference** UUID.
4. **API** — http://127.0.0.1:8000/api/products/featured returns JSON with a `data` array.
5. **Health** — http://127.0.0.1:8000/up returns success.

**Automated tests (optional):**

```powershell
php artisan test
```

## Docker (optional)

For MySQL + Redis + Horizon in containers:

```powershell
copy .env.docker.example .env.docker
```

Set `APP_KEY` in `.env.docker` (run `php artisan key:generate --show` and paste).

```powershell
docker compose --env-file .env.docker up --build -d
```

App: **http://localhost:8080**

More detail: [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md).

## Troubleshooting

| Symptom | Likely fix |
|---------|------------|
| `Vite manifest not found` | Run `npm install` then `npm run build` (or `npm run dev` while developing) |
| `Connection refused` to Redis | Start Redis/Memurai, or switch to **Profile A** (`array` + `sync`) |
| Enquiry saves but no email/audit rows | **Profile B:** start `php artisan queue:work redis --queue=enquiries,default` |
| `No application encryption key` | Run `php artisan key:generate` |
| Migration errors | Ensure `database/database.sqlite` exists or DB settings in `.env` are correct; run `php artisan migrate` |
| Blank styles | Re-run `npm run build` |
| `php` not recognized | Use full path, e.g. `c:\xampp\php\php.exe artisan serve` |

Logs: `storage/logs/laravel.log`

## Pushing to GitHub

Do **not** commit:

- `.env` (secrets and local settings)
- `vendor/` (restore with `composer install`)
- `node_modules/` (restore with `npm install`)

Commit `LOCAL_SETUP.md`, source code, `composer.json`, `package.json`, migrations, etc. Interviewers can follow this file after clone.

## Related docs

- [README.md](README.md) — features, tickets, API reference
- [docs/ARCHITECTURE.md](docs/ARCHITECTURE.md) — scalability, Docker scale, cloud roadmap

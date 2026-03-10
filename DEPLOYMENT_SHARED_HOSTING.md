# Deploy to Shared Hosting

Step-by-step guide to deploy RODTHBAL KCM CMS to shared hosting (cPanel, Plesk, etc.).

---

## Deploy to Shared Hosting – Quick steps

### On your computer

1. **Create the deploy package**
   ```bash
   php deploy.php
   ```
   Or: `composer deploy`. This runs `composer install --no-dev`, `npm run build`, and creates **deploy/Deploy-DD-Mon-YY.zip** (e.g. `deploy/Deploy-10-Mar-26.zip`).  
   To skip build and only create the zip: `php deploy.php --skip-build`.

2. **Upload to the server**
   - Upload the zip from the `deploy/` folder to your hosting (e.g. via cPanel File Manager or FTP).
   - Extract it into your web folder (e.g. `public_html`, `htdocs`, or a subfolder like `public_html/RODTHBAL_KCM_CMS`).

### On the server

3. **Point document root to `public`**
   - In the hosting panel, set the domain’s **Document Root** to the `public` folder inside the extracted project (e.g. `public_html/RODTHBAL_KCM_CMS/public`).  
   - If you cannot change document root, use the project root and keep the root `index.php` and `.htaccess` (see section at the end).

4. **Configure `.env`**
   - Copy `.env.example` to `.env` in the project root on the server.
   - Edit `.env`: set `APP_NAME`, `APP_URL` (e.g. `https://yourdomain.com`), `APP_DEBUG=false`, `APP_ENV=production`, and your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).  
   - Generate key: `php artisan key:generate` (if you have SSH), or copy an `APP_KEY` from another env.

5. **Set permissions**
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```

6. **Run migrations**
   ```bash
   php artisan migrate --force
   ```

7. **Cache config (optional but recommended)**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

8. **Storage link (if the app uses public storage)**
   ```bash
   php artisan storage:link
   ```

9. **Check the site**
   - Open your domain in the browser.  
   - If you see errors, run `php deploy_check.php` on the server (from project root) or open `https://yourdomain.com/deploy_check.php` once, then **delete** that file. Fix any reported issues (e.g. missing `vendor`, wrong permissions).

**Server requirements:** PHP 8.2+ and extensions: BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, PDO_MySQL, Tokenizer, XML.

---

# Laravel on Shared Hosting – Fix HTTP 500

Follow these steps on your shared host if you see 500 errors or “files still missing”.

---

## 0. Find what’s missing (run on server)

If the error says “some files are still missing”, run this on the server from the project root:

```bash
php deploy_check.php
```

Or open in the browser: `https://oseyteychurch.com/deploy_check.php` (then **delete** the file after use).  
*(If your document root is `public/`, the script is not web-accessible; run it via SSH only.)*

The script checks for missing `vendor`, `.env`, and storage/cache folders, creates missing storage dirs when it can, and tells you what to fix.

**To get the exact error:** open `storage/logs/laravel.log` on the server and copy the last error block (the lines with the exception message and “Stack trace”). Paste that in your next message so we can target the exact missing file.

---

## 1. Set document root to `public`

The web server **must** use the `public` folder as the document root, not the project root.

- In your hosting panel (cPanel, Plesk, etc.), find **Document Root** / **Web Root** for the domain.
- Set it to: `public` inside your project folder.  
  Example: if the project is in `public_html`, set document root to `public_html/public` (or the path your host uses, e.g. `home/user/RODTHBAL_KCM_CMS/public`).

If your host does **not** allow changing the document root, use the **root** `index.php` and `.htaccess` in the project root (see end of this file).

---

## 2. Production `.env` on the server

On the server, edit `.env` (or create it from `.env.example`) and set:

```env
APP_NAME="Your Site Name"
APP_ENV=production
APP_KEY=base64:WAZVk4V26PXvOjV3vkSlrNCT4Hh+KUMVpPqeq7NwqyI=
APP_DEBUG=false
APP_URL=https://oseyteychurch.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_hosting_db_name
DB_USERNAME=your_hosting_db_user
DB_PASSWORD=your_hosting_db_password
```

- **APP_DEBUG=false** in production (required to avoid errors and security issues).
- **APP_URL** must be your real domain with `https://` if you use SSL.
- Use the **database name, user, and password** given by your hosting provider (often in “MySQL Databases” or “Databases”).

---

## 3. File permissions

Laravel must be able to write to these folders. On the server (SSH or File Manager), set:

- `storage` → **775** (recursive)
- `bootstrap/cache` → **775** (recursive)

If you use SSH:

```bash
chmod -R 775 storage bootstrap/cache
```

---

## 4. Install dependencies (no dev)

On the server, from the **project root** (where `composer.json` is), run:

```bash
composer install --optimize-autoloader --no-dev
```

If you don’t have SSH, run this **locally** and upload the whole project again (including the `vendor` folder).

---

## 5. Generate key and cache config (if needed)

If you use a new `.env` on the server or the key is missing:

```bash
php artisan key:generate
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 6. Run migrations

Create tables in the hosting database:

```bash
php artisan migrate --force
```

---

## 7. Storage link (if you use `storage:link`)

```bash
php artisan storage:link
```

---

## 8. PHP version

Laravel 12 needs **PHP 8.2 or higher**. In the hosting panel, set the domain or account to use PHP 8.2+.

---

## 9. Required PHP extensions

Ensure these are enabled (usually in “Select PHP Version” or “PHP Extensions”):

- BCMath, Ctype, cURL, DOM, Fileinfo, JSON, Mbstring, OpenSSL, PCRE, PDO, PDO_MySQL, Tokenizer, XML

---

## If you still get 500: enable temporary debug

Only to see the real error:

1. In `.env` on the server set: `APP_DEBUG=true`
2. Reload the site and note the **full error message** and stack trace.
3. Fix the error, then set `APP_DEBUG=false` again.

You can also check: `storage/logs/laravel.log` on the server.

---

## If document root cannot be changed (use project root as web root)

If the host only allows the document root to be the project root (e.g. `public_html` = project root), then:

1. Keep the **root** `index.php` and **root** `.htaccess` that were added to this project.
2. Point the domain’s document root to the folder that contains that root `index.php` (your project root).
3. Still follow steps 2–9 above (`.env`, permissions, `composer install`, migrations, etc.).

The root `index.php` and `.htaccess` will send all requests to `public/index.php` so Laravel runs correctly.

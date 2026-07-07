# WorkNest — Office Equipment Store

Final project by **The Strawhats**. A two-part web application:

- **Buyer part** — registration with email verification, categorized store, session cart, checkout, and a simulated payment page.
- **Seller part** — admin panel to manage users, manage products and prices, and view reports (inventory + audit log of all logged-in user activity).

Built with plain PHP (procedural mysqli, prepared statements), MySQL, and Bootstrap 5. No PHP framework.

## Local setup (XAMPP)

1. Copy this folder into `htdocs/worknest`.
2. Open phpMyAdmin and import `database/worknest.sql` (creates `worknest_db` with sample products).
3. Check `includes/config.php` — the defaults match XAMPP (`root`, empty password, `http://localhost/worknest`).
4. Open `http://localhost/worknest/setup_accounts.php` once to create the admin and test buyer accounts, then delete that file.
5. Log in with the accounts listed in `sample_accounts.txt`.

## Deploying to InfinityFree / AwardSpace

1. Create a MySQL database in the hosting control panel, then import `database/worknest.sql` through their phpMyAdmin. Remove the `CREATE DATABASE` / `USE` lines at the top first if the host only allows their own database name.
2. Upload all files to `htdocs` via the file manager or FTP.
3. Edit `includes/config.php` with the host's DB hostname, username, password, database name, and set `BASE_URL` to your site URL.
4. Visit `setup_accounts.php` once, then delete it.
5. Test the registration email. Free hosts often delay `mail()` or land it in spam — check the spam folder during your demo, and register with a real inbox you control.

## Project structure

```
worknest/
├── index.php            store page (categorized products, add to cart)
├── register.php         registration + sends verification email
├── verify.php           email verification link handler
├── login.php / logout.php
├── cart.php             session cart (add / update / remove)
├── checkout.php         shipping form, creates the order
├── payment.php          simulated payment page (no API)
├── order_success.php    confirmation
├── about.php            company + group members
├── setup_accounts.php   run once, then delete
├── admin/
│   ├── index.php        dashboard
│   ├── users.php        add/list users
│   ├── user_edit.php    edit user, change role, reset password
│   ├── products.php     add/list products
│   ├── product_edit.php edit product, change price/stock
│   └── reports.php      inventory report + audit log
├── includes/            config, helpers, header, footer
├── assets/              css + logo
└── database/worknest.sql
```

## Before submitting

- Replace the member placeholders in `about.php` with your real names.
- Push everything (including `database/worknest.sql`) to your group GitHub repo.
- Take screenshots for the PDF: register → email → verify → login, store, cart, checkout, payment, order success, and each admin page.

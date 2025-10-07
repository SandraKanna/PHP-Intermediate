# PHP Intermediate — Practice Application

This project is the **next level** after *PHP Fundamentals* and *PHP Forms*.  
It combines everything learned so far into a single, modular application — with routing, database persistence, and a cleaner interface.

---

## Overview

This repository serves as a bridge between the **Fundamentals** exercises and a **Laravel-ready** environment.

It includes:
- A simple **router** (`index.php`) that loads pages dynamically.
- A clean **layout system** (`header.php` + `footer.php`).
- A **multi-field form** that stores data into PostgreSQL.
- A **shared CSS stylesheet** for consistent design.
- Environment configuration via **.env** file.
- PHP version pinned at **7.4** for future Laravel compatibility.
---

## Tech Stack

| Layer | Description |
|-------|--------------|
| **PHP** | Version 7.4 (kept intentionally for Laravel 8–9 compatibility). |
| **PostgreSQL** | Database used instead of SQLite (runs as a separate container). |
| **Apache** | Bundled with the PHP container for easy local hosting. |
| **Docker Compose** | Manages the PHP and PostgreSQL containers. |
| **CSS** | Custom stylesheet for improved UI and dark/light mode. |
| **.env file** | Stores environment variables such as DB credentials and host info. |
---

## Project Structure
```
php-intermediate/
├── .env
├── Dockerfile
├── docker-compose.yml
├── Makefile
├── config/
│   ├── php-upload.ini
├── src/
│   ├── index.php
│   ├── helpers.php
│   ├── layout/
│   │   ├── header.php
│   │   ├── footer.php
│   │   └── style.css
│   ├── pages/
│   │   ├── 01-output.php
│   │   ├── 02-variables.php
│   │   ├── 03-constants.php
│   │   ├── 04-strings.php
│   │   ├── 05-arrays.php
│   │   ├── 06-form.php
│   │   └── 06-form.html
```
---

## ⚙️ Setup Instructions

### 1. Clone the repository
```bash
git clone https://github.com/<your-username>/php-intermediate.git
cd php-intermediate
```
---
### 2. Configure environment
Edit config/.env if needed:
```bash
DB_HOST=db
DB_PORT=5432
DB_NAME=appdb
DB_USER=app
DB_PASS=secret
```
---
## 3. Usage
Make sure you have **Docker** and **Docker Compose** installed.  
Then use the provided `Makefile`:

```bash
# build images (if they dont exist yet) and start the containers
make start

# view logs
make logs

# stop all
make stop

# cleanup (remove containers, volumes, local images)
make clean

# Destroy EVERYTHING (all containers/images/volumes, careful!)
make destroy
```

## 4. Database
Data is now stored in PostgreSQL (instead of SQLite).
The database container is defined in docker-compose.yml, and connection credentials are loaded automatically from the environment variables (DB_HOST, DB_NAME, DB_USER, DB_PASS, DB_PORT).

You can inspect the data directly from the Postgres container:

```bash
# Open a shell inside the Postgres container
docker compose exec db bash

# Connect to the database
psql -U app -d appdb

# Once inside the psql prompt:
\dt                       -- list all tables (you should see "form1")
SELECT * FROM form1;      -- view all submitted form entries

#to exit postgres:
\q
```
---

## 5. Open in browser
```
http://localhost:8080

```
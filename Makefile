.PHONY: local dev prod install build up down logs shell composer npm setup-env

# =================================
# Konfiguracja środowisk
# =================================

# Środowisko LOCAL
local: setup-env-local
	docker-compose -f docker-compose.yml up -d

local-no-d:
	docker-compose -f docker-compose.yml up

local-build: setup-env-local
	@if [ ! -f docker-compose.yml ]; then \
		echo "Kopiowanie docker-compose.local.yml do docker-compose.yml"; \
		cp docker-compose.local.yml docker-compose.yml; \
	fi
	docker-compose -f docker-compose.yml up -d --build

setup-env-local:
	@if [ ! -f src/.env ]; then \
		echo "Kopiowanie .env do src/.env..."; \
		cp .env src/.env; \
	fi

# Środowisko DEV
dev: setup-env-dev
	@if [ ! -f docker-compose.yml ]; then \
		echo "Kopiowanie docker-compose.dev.yml do docker-compose.yml"; \
		cp docker-compose.dev.yml docker-compose.yml; \
	fi
	docker-compose -f docker-compose.yml up -d

dev-build: setup-env-dev
	@if [ ! -f docker-compose.yml ]; then \
		echo "Kopiowanie docker-compose.dev.yml do docker-compose.yml"; \
		cp docker-compose.dev.yml docker-compose.yml; \
	fi
	docker-compose -f docker-compose.yml up -d --build

setup-env-dev:
	@if [ ! -f src/.env ]; then \
		echo "Kopiowanie .env.dev do .env..."; \
		cp .env.dev src/.env; \
	fi

# Środowisko PROD
prod: setup-env-prod
	@if [ ! -f docker-compose.yml ]; then \
		echo "Kopiowanie docker-compose.prod.yml do docker-compose.yml"; \
		cp docker-compose.prod.yml docker-compose.yml; \
	fi
	docker-compose -f docker-compose.yml up -d

prod-build: setup-env-prod
	@if [ ! -f docker-compose.yml ]; then \
		echo "Kopiowanie docker-compose.prod.yml do docker-compose.yml"; \
		cp docker-compose.prod.yml docker-compose.yml; \
	fi
	docker-compose -f docker-compose.yml up -d --build

setup-env-prod:
	@if [ ! -f src/.env ]; then \
		echo "Kopiowanie .env.prod do .env..."; \
		cp .env.prod src/.env; \
	fi

# =================================
# Inicjalizacja projektów
# =================================

# Inicjalizacja nowego projektu
init-project:
	@echo "Inicjalizacja nowego projektu Laravel..."
	@if [ ! -f src/.env ]; then \
		echo "Tworzenie pliku środowiskowych z przykładów..."; \
		cp .env.example.local src/.env; \
	fi
	make local-build
	make install
	make breeze-install
	@echo "Projekt gotowy! Aplikacja dostępna pod: http://localhost:8000"

# Kompletna instalacja
install:
	make composer-install
	make npm-install
	make key-generate
	make migrate

# =================================
# Zarządzanie kontenerami
# =================================

# Zatrzymanie kontenerów
down:
	docker-compose down

# Restart kontenerów
restart:
	make down
	make local

# Logi
logs:
	docker-compose logs -f

logs-app:
	docker-compose logs -f app

logs-nginx:
	docker-compose logs -f webserver

# Shell do kontenera PHP
shell:
	docker-compose exec --user www app sh

# =================================
# Polecenia Composer
# =================================

composer-install:
	docker-compose exec app composer install --optimize-autoloader

composer-update:
	docker-compose exec app composer update

composer-require:
	docker-compose exec app composer require $(package)

composer-dump:
	docker-compose exec --user www app composer dump-autoload --optimize

# =================================
# Polecenia NPM/Node
# =================================

npm-install:
	docker-compose exec app npm install

npm-dev:
	docker-compose exec app npm run dev

npm-build:
	docker-compose exec app npm run build

npm-watch:
	docker-compose exec app npm run dev -- --watch

npm-hot:
	docker-compose exec app npm run hot

# =================================
# Polecenia Laravel
# =================================

key-generate:
	docker-compose exec app php artisan key:generate

migrate:
	docker-compose exec app php artisan migrate

migrate-fresh:
	docker-compose exec app php artisan migrate:fresh --seed

migrate-rollback:
	docker-compose exec app php artisan migrate:rollback

seed:
	docker-compose exec app php artisan db:seed

# Cache
cache-clear:
	@echo "🗑️  Czyszczenie cache Laravel..."
	docker-compose exec --user www app php artisan cache:clear
	docker-compose exec --user www app php artisan config:clear
	docker-compose exec --user www app php artisan route:clear
	docker-compose exec --user www app php artisan view:clear

cache-config:
	docker-compose exec app php artisan config:cache

cache-routes:
	docker-compose exec app php artisan route:cache

cache-views:
	docker-compose exec app php artisan view:cache

optimize:
	docker-compose exec app php artisan optimize

# Storage
storage-link:
	docker-compose exec app php artisan storage:link

# =================================
# Laravel Breeze
# =================================

breeze-install:
	docker-compose exec app php artisan breeze:install
	docker-compose exec app php artisan migrate
	docker-compose exec app npm install
	docker-compose exec app npm run dev

# =================================
# Testy
# =================================

test:
	docker-compose exec app php artisan test

test-coverage:
	docker-compose exec app php artisan test --coverage

# =================================
# Narzędzia dewelperskie
# =================================

# Tinker
tinker:
	docker-compose exec app php artisan tinker

# Queue
queue-work:
	docker-compose exec app php artisan queue:work

queue-restart:
	docker-compose exec app php artisan queue:restart

# =================================
# Backup i restore
# =================================

db-backup:
	docker-compose exec db mysqldump -u root -p$(DB_PASSWORD) $(DB_DATABASE) > backup_$(shell date +%Y%m%d_%H%M%S).sql

db-restore:
	docker-compose exec -i db mysql -u root -p$(DB_PASSWORD) $(DB_DATABASE) < $(file)

# =================================
# Pomoc
# =================================

help:
	@echo Dostępne komendy:
	@echo
	@echo Środowiska:
	@echo   init-project	- Inicjalizacja nowego projektu
	@echo   local			- Uruchomienie środowiska lokalnego
	@echo   dev				- Uruchomienie środowiska dev
	@echo   prod			- Uruchomienie środowiska prod
	@echo
	@echo Zarządzanie:
	@echo   down			- Zatrzymanie kontenerów
	@echo   restart			- Restart kontenerów
	@echo   logs			- Podgląd logów
	@echo   shell			- Wejście do kontenera PHP
	@echo
	@echo Laravel:
	@echo   migrate			- Uruchomienie migracji
	@echo   cache-clear		- Czyszczenie cache
	@echo   test        	- Uruchomienie testów
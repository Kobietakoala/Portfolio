``` 
*Gotowe!** Aplikacja działa z pełną funkcjonalnością Breeze (rejestracja, logowanie, dashboard).

## 📁 Struktura projektu
```
project/ \
├── app/ # aplikacja laravel\
├── docker/ │ \
│ └── nginx/ │ \
│ │ └── default.conf # Konfiguracja Nginx \
│ └── php/ \
│ │ └── Dockerfile # PHP 8.3 + Extensions \
├── docker-compose.yml # Konfiguracja bazowa \
├── docker-compose.local.yml # Środowisko LOCAL \
├── docker-compose.dev.yml # Środowisko DEV \
├── docker-compose.prod.yml # Środowisko PROD \
├── .env.example.local # Przykład konfiguracji LOCAL \
├── .env.example.dev # Przykład konfiguracji DEV \
├── .env.example.prod # Przykład konfiguracji PROD \
├── Makefile # Automatyzacja komend \
└── README.md # Ten plik


## 🌍 Środowiska

### 🏠 LOCAL (Development)
- **Cel**: Lokalne programowanie
- **Debugging**: Włączony
- **Email**: MailHog (testowe)
- **Dostęp**: http://localhost:8000
- **Baza**: MySQL z prostymi hasłami

### 🔧 DEV (Staging)
- **Cel**: Testowanie przed produkcją
- **Debugging**: Ograniczony
- **Email**: Prawdziwy SMTP
- **Dostęp**: Twoja domena dev
- **Baza**: MySQL z bezpiecznymi hasłami

### 🚀 PROD (Production)
- **Cel**: Środowisko produkcyjne
- **Debugging**: Wyłączony
- **Email**: Produkcyjny SMTP
- **Storage**: AWS S3
- **SSL**: Wymuszony HTTPS
- **Monitoring**: Sentry, New Relic

## 🛠 Instalacja

# 1. Sklonuj projekt
git clone  && cd
# 2. Skopiuj i dostosuj pliki .env
cp .env.example.local .env.local
# Edytuj .env.local według potrzeb
# 3. Uruchom
make local-build \
make install


## 🎛 Zarządzanie

### Uruchamianie środowisk:
make local # Środowisko lokalne \
make dev # Środowisko dev\
make prod # Środowisko produkcyjne

### Zatrzymywanie:
make down # Zatrzymaj kontenery \
make restart # Restart kontenerów

### Monitoring:
bash make logs # Wszystkie logi \
make logs-app # Logi PHP \
make logs-nginx # Logi Nginx


## 📚 Komendy

### 🐳 Docker & Kontenery
| Komenda | Opis |
|---------|------|
| `make local` | Uruchom środowisko lokalne |
| `make local-build` | Uruchom z przebudową |
| `make dev` | Uruchom środowisko dev |
| `make prod` | Uruchom środowisko prod |
| `make down` | Zatrzymaj kontenery |
| `make restart` | Restart kontenerów |
| `make shell` | Wejdź do kontenera PHP |

### 📋 Logi & Monitoring
| Komenda | Opis |
|---------|------|
| `make logs` | Wszystkie logi |
| `make logs-app` | Logi aplikacji PHP |
| `make logs-nginx` | Logi serwera Nginx |
| `docker-compose ps` | Status kontenerów |

### 🎨 Assets (Tailwind + Alpine.js)
| Komenda | Opis |
|---------|------|
| `make npm-install` | Instaluj dependencies |
| `make npm-dev` | Kompilacja development |
| `make npm-build` | Kompilacja production |
| `make npm-watch` | Watch mode (auto-reload) |
| `make npm-hot` | Hot reload |

### 🐘 PHP & Composer
| Komenda | Opis |
|---------|------|
| `make composer-install` | Instaluj pakiety PHP |
| `make composer-update` | Update pakietów |
| `make composer-require package=nazwa` | Dodaj pakiet |
| `make composer-dump` | Dump autoload |

### 🎯 Laravel
| Komenda | Opis |
|---------|------|
| `make key-generate` | Generuj APP_KEY |
| `make migrate` | Uruchom migracje |
| `make migrate-fresh` | Reset bazy + seed |
| `make migrate-rollback` | Cofnij migracje |
| `make seed` | Uruchom seeders |
| `make tinker` | Laravel Tinker |

### 🗄 Cache & Optymalizacja
| Komenda | Opis |
|---------|------|
| `make cache-clear` | Wyczyść wszystkie cache |
| `make cache-config` | Cache konfiguracji |
| `make cache-routes` | Cache routingu |
| `make cache-views` | Cache widoków |
| `make optimize` | Optymalizuj aplikację |

### 🧪 Testy
| Komenda | Opis |
|---------|------|
| `make test` | Uruchom testy |
| `make test-coverage` | Testy z coverage |

### 🔄 Queue & Jobs
| Komenda | Opis |
|---------|------|
| `make queue-work` | Uruchom worker |
| `make queue-restart` | Restart queue |

### 💾 Backup
| Komenda | Opis |
|---------|------|
| `make db-backup` | Backup bazy danych |
| `make db-restore file=backup.sql` | Restore bazy |

### ❓ Pomoc
| Komenda | Opis |
|---------|------|
| `make help` | Lista wszystkich komend |

## 🌐 Dostęp do aplikacji

Po uruchomieniu `make local`:

| Usługa | URL | Opis |
|--------|-----|------|
| **Aplikacja** | http://localhost:8000 | Główna aplikacja Laravel |
| **MailHog** | http://localhost:8025 | Testowanie emaili (tylko local) |
| **Baza danych** | localhost:3306 | MySQL (user: laravel, pass: secret) |
| **Redis** | localhost:6379 | Cache i sesje |

### 🎯 Endpointy Laravel Breeze:
- `/` - Strona główna
- `/register` - Rejestracja
- `/login` - Logowanie
- `/dashboard` - Panel użytkownika (po zalogowaniu)
- `/profile` - Profil użytkownika
- `/password/reset` - Reset hasła


## 🛡 Bezpieczeństwo

### ⚠️ NIGDY nie commituj:
- `.env*` (oprócz `.env.example*`)
- `storage/` z danymi
- `bootstrap/cache/`
- Plików z hasłami

### ✅ Zalecenia:
- Używaj silnych haseł w prod
- Regularnie zmieniaj klucze API
- Monitoruj logi aplikacji
- Aktualizuj zależności


## 🎮 Technologie

### Backend:
- **Laravel 10** - Framework PHP
- **PHP 8.3** - Najnowsza wersja PHP
- **MySQL 8.0** - Baza danych
- **Redis** - Cache i sesje
- **Laravel Breeze** - Autentykacja

### Frontend:
- **Alpine.js** - Reaktywność JavaScript
- **Tailwind CSS** - Utility-first CSS
- **Vite** - Bundler assets

### DevOps:
- **Docker** - Konteneryzacja
- **Docker Compose** - Orkiestracja
- **Nginx** - Serwer web
- **MailHog** - Testowanie emaili (local)

### Monitoring (prod):
- **Sentry** - Error tracking
- **New Relic** - Performance monitoring

## 📞 Wsparcie

Jeśli masz problemy:

1. **Sprawdź logi**: `make logs`
2. **Sprawdź status**: `docker-compose ps`
3. **Restart**: `make restart`
4. **Pełny reset**: `make down && make local-build`

## 📄 Licencja

Ten projekt jest licencjonowany na zasadach Apache2 License.
# Mini-Trello - Guía de Desarrollo

## Configuración del Proyecto

Este proyecto puede ejecutarse tanto en **local** como con **Docker**. Ambas configuraciones están preparadas y puedes cambiar entre ellas fácilmente.

## Requisitos

### Para desarrollo local:
- PHP 8.1 o superior
- Composer
- Node.js y npm
- SQLite

### Para desarrollo con Docker:
- Docker
- Docker Compose

## Comandos Rápidos

Usamos un `Makefile` para simplificar los comandos más comunes:

```bash
# Ver todos los comandos disponibles
make help

# Configuración inicial (solo la primera vez)
make setup

# Desarrollo local
make local      # Configurar para local
make serve      # Iniciar servidor

# Desarrollo con Docker  
make docker     # Configurar y levantar con Docker
make docker-down # Detener contenedores

# Utilidades
make migrate    # Ejecutar migraciones
make test       # Ejecutar tests
make clean      # Limpiar caches
```

## Instalación Paso a Paso

### 1. Clonar y configurar inicialmente

```bash
# Clonar el repositorio
git clone <tu-repo>
cd mini-trello

# Instalación inicial (automática)
make setup
```

### 2. Elegir tu entorno de desarrollo

#### Opción A: Desarrollo Local

```bash
# Configurar para local
make local

# Iniciar servidor
make serve
# o directamente: php artisan serve
```

La aplicación estará disponible en: http://127.0.0.1:8000

#### Opción B: Desarrollo con Docker

```bash
# Configurar para Docker
make docker
```

La aplicación estará disponible en: http://localhost

### 3. Cambiar entre entornos

Puedes cambiar entre local y Docker en cualquier momento:

```bash
# Cambiar a local
./switch-env.sh local
php artisan serve

# Cambiar a Docker
./switch-env.sh docker
./vendor/bin/sail up -d
```

## Estructura de Configuración

- `.env` - Configuración activa actual
- `.env.local` - Configuración para desarrollo local  
- `.env.docker` - Configuración para Docker
- `switch-env.sh` - Script para cambiar entre configuraciones

## Comandos Útiles

### Laravel Artisan
```bash
# Migraciones
php artisan migrate
php artisan migrate:fresh --seed

# Cache
php artisan cache:clear
php artisan config:clear

# Tests
php artisan test
```

### Con Docker (usando Sail)
```bash
# Comandos Artisan
./vendor/bin/sail artisan migrate

# NPM
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev

# Tests
./vendor/bin/sail test
```

### Compilar Assets
```bash
# Desarrollo
npm run dev

# Producción  
npm run build

# Watch mode
npm run watch
```

## Troubleshooting

### Problema con permisos de SQLite
```bash
# Asegurar permisos correctos
chmod 664 database/database.sqlite
chmod 775 database/
```

### Limpiar todo y empezar de nuevo
```bash
make clean
php artisan migrate:fresh
npm run build
```

### Docker no inicia
Asegúrate de que Docker Desktop esté ejecutándose:
```bash
# Verificar Docker
docker --version
docker-compose --version

# Reconstruir contenedores
make docker-build
```

## Desarrollo

1. **Instalar Livewire**: El siguiente paso es instalar Livewire para la interactividad
2. **Crear modelos**: Task, TaskStatus, etc.
3. **Implementar autenticación**: Laravel Breeze o similar
4. **Crear componentes Livewire**: Para el tablero Kanban
5. **Styling**: TailwindCSS para el diseño

---

¿Problemas? Revisa los logs:
- Local: `storage/logs/laravel.log`
- Docker: `./vendor/bin/sail logs`

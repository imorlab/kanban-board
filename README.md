# 📋 Mini-Trello Kanban Board

> **Proyecto de prueba técnica**: Sistema de gestión de tareas estilo Trello con Laravel + Livewire

[![Laravel](https://img.shields.io/badge/Laravel-9.x-red.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-2.x-purple.svg)](https://laravel-livewire.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-blue.svg)](https://tailwindcss.com)
[![SQLite](https://img.shields.io/badge/Database-SQLite-green.svg)](https://sqlite.org)

## 🚀 Características

- ✅ **Tablero Kanban Interactivo** con drag & drop
- ✅ **Autenticación Completa** (registro, login, perfil)
- ✅ **Gestión de Tareas CRUD** (crear, leer, actualizar, eliminar)
- ✅ **Estados de Tareas**: Pendiente → En Progreso → Completado
- ✅ **Interfaz Responsiva** con TailwindCSS
- ✅ **Tiempo Real** con Livewire 2
- ✅ **Base de Datos SQLite** (fácil configuración)
- ✅ **Configuración Dual** (Local + Docker)

## 📁 Estructura del Proyecto

```
├── app/
│   ├── Http/Livewire/          # Componentes Livewire
│   │   ├── KanbanBoard.php     # Tablero principal
│   │   ├── TaskCard.php        # Tarjetas de tareas
│   │   └── CreateTaskForm.php  # Formulario de creación
│   ├── Models/
│   │   ├── Task.php           # Modelo de tareas
│   │   └── User.php           # Modelo de usuarios
│   └── Enums/
│       └── TaskStatus.php     # Estados de tareas
├── database/
│   ├── migrations/            # Migraciones de BD
│   ├── factories/            # Factories para datos de prueba
│   └── seeders/              # Seeders con datos demo
├── resources/views/
│   ├── livewire/             # Vistas de componentes Livewire
│   └── layouts/              # Layouts de la aplicación
└── docker/                   # Configuración Docker para producción
```

## 🛠️ Tecnologías Utilizadas

- **Backend**: Laravel 9.x + PHP 8.3
- **Frontend**: Livewire 2.x + TailwindCSS + Alpine.js
- **Base de Datos**: SQLite
- **Autenticación**: Laravel Breeze
- **Drag & Drop**: SortableJS
- **Containerización**: Docker + Docker Compose

## ⚡ Inicio Rápido

### Opción 1: Configuración Automática

```bash
# Clonar el repositorio
git clone https://github.com/imorlab/kanban-board.git
cd kanban-board

# Configuración inicial automática
make setup

# Iniciar servidor de desarrollo
make serve
```

### Opción 2: Configuración Manual

```bash
# 1. Instalar dependencias
composer install
npm install

# 2. Configurar entorno
./setup-sqlite.sh
php artisan key:generate

# 3. Base de datos
php artisan migrate
php artisan db:seed

# 4. Assets
npm run build

# 5. Servidor
php artisan serve
```

## 🐳 Docker

### Desarrollo
```bash
make docker      # Configurar y levantar
make docker-down # Detener
```

### Producción
```bash
make prod-build  # Construir imagen optimizada
make prod-up     # Levantar en producción
make prod-logs   # Ver logs
```

## 🎯 Uso de la Aplicación

### 1. **Autenticación**
- Registrar nuevo usuario o usar demo: `demo@kanban.com` / `password`

### 2. **Gestión de Tareas**
- **Crear**: Botón "Nueva Tarea" en el tablero
- **Editar**: Click en icono de editar en la tarjeta
- **Mover**: Drag & drop entre columnas
- **Eliminar**: Click en icono de eliminar (con confirmación)

### 3. **Estados de Tareas**
- 🔘 **Pendiente**: Tareas por hacer
- 🔵 **En Progreso**: Tareas en desarrollo  
- 🟢 **Completado**: Tareas finalizadas

## 📊 Datos de Demostración

El proyecto incluye un seeder con datos de prueba:
- 1 usuario demo: `demo@kanban.com`
- 9 tareas distribuidas en los 3 estados
- Datos faker para títulos y descripciones realistas

```bash
# Regenerar datos demo
php artisan migrate:fresh --seed
```

## 🔧 Comandos Útiles

```bash
# Ver todos los comandos disponibles
make help

# Desarrollo
make serve           # Servidor local
make dev            # Compilar assets (desarrollo)
make build          # Compilar assets (producción)

# Base de datos
make migrate        # Ejecutar migraciones
make migrate-fresh  # Recrear BD con seeders

# Utilidades
make clean          # Limpiar caches
make test           # Ejecutar tests
```

## 🏗️ Arquitectura

### Modelos
- **User**: Usuario con relación hasMany a Task
- **Task**: Tarea con enum TaskStatus y relación belongsTo a User

### Componentes Livewire
- **KanbanBoard**: Tablero principal con gestión de estado
- **TaskCard**: Tarjeta individual con CRUD inline
- **CreateTaskForm**: Formulario modal de creación

### Estados y Transiciones
```
[Pendiente] → [En Progreso] → [Completado]
     ↓              ↓              ↓
  (gray)        (blue)        (green)
```

## 🧪 Testing

```bash
# Ejecutar todos los tests
php artisan test

# Tests específicos
php artisan test --filter=TaskTest
php artisan test --filter=KanbanBoardTest
```

## 📝 Funcionalidades Implementadas

### ✅ Requisitos Básicos
- [x] Sistema de autenticación completo
- [x] CRUD de tareas con título, descripción y estado
- [x] Tablero Kanban con 3 columnas
- [x] Drag & drop funcional
- [x] Actualización asíncrona con Livewire
- [x] Tareas privadas por usuario

### ✅ Características Adicionales
- [x] Interfaz responsiva y moderna
- [x] Validaciones frontend y backend
- [x] Factory y seeders para datos de prueba
- [x] Configuración Docker para producción
- [x] Sistema de comandos con Makefile
- [x] Documentación completa

## 🚀 Próximas Mejoras

- [ ] Sistema de auditoría para administradores
- [ ] Notificaciones toast
- [ ] Tests unitarios y de feature
- [ ] API REST para integraciones
- [ ] Websockets para colaboración en tiempo real
- [ ] Filtros y búsqueda avanzada

## 📄 Licencia

Este proyecto es una prueba técnica y está disponible bajo la licencia MIT.

## 👨‍💻 Desarrollo

Desarrollado como prueba técnica para demostrar habilidades en:
- Laravel + Livewire
- TailwindCSS
- SQLite
- Docker
- Git + GitHub

---

**¿Preguntas o sugerencias?** 
Abre un [issue](https://github.com/imorlab/kanban-board/issues) o envía un PR! 🎯
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

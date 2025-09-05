# 📋 Mini-Trello Kanban Board

> **Proyecto de prueba técnica**: Sistema de gestión de tareas estilo Trello con Laravel + Livewire

[![Laravel](https://img.shields.io/badge/Laravel-9.x-red.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-2.x-purple.svg)](https://laravel-livewire.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-blue.svg)](https://tailwindcss.com)
[![SweetAlert2](https://img.shields.io/badge/SweetAlert2-11.x-orange.svg)](https://sweetalert2.github.io)
[![Spatie ActivityLog](https://img.shields.io/badge/Spatie-ActivityLog-green.svg)](https://spatie.be/docs/laravel-activitylog)
[![SQLite](https://img.shields.io/badge/Database-SQLite-blue.svg)](https://sqlite.org)

## 🚀 Características

- ✅ **Tablero Kanban Interactivo** con drag & drop (SortableJS)
- ✅ **Autenticación Completa** (registro, login, perfil)
- ✅ **Gestión de Tareas CRUD** (crear, leer, actualizar, eliminar)
- ✅ **Estados de Tareas**: Pendiente → En Progreso → Completado
- ✅ **Sistema de Auditoría** completo con Spatie ActivityLog
- ✅ **Panel Administrativo** para visualizar audit trail
- ✅ **Notificaciones Interactivas** con SweetAlert2
- ✅ **Sistema de Traducciones** (Inglés/Español)
- ✅ **Interfaz Responsiva** con TailwindCSS + Alpine.js
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
- **Frontend**: Livewire 2.x + TailwindCSS + Alpine.js + SweetAlert2
- **Base de Datos**: SQLite
- **Autenticación**: Laravel Breeze
- **Auditoría**: Spatie Laravel ActivityLog
- **Drag & Drop**: SortableJS
- **Notificaciones**: SweetAlert2 (integrada via NPM)
- **Traducciones**: Laravel i18n (inglés incluido)
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
- Usuario admin: `admin@kanban.com` / `password` (para acceder al audit log)

### 2. **Gestión de Tareas**
- **Crear**: Botón "Nueva Tarea" en el tablero → Formulario sidebar
- **Editar**: Click en icono de editar en la tarjeta → Edición inline
- **Mover**: Drag & drop entre columnas → Notificación automática
- **Eliminar**: Click en icono de eliminar → Confirmación SweetAlert2

### 3. **Sistema de Auditoría** 🔍
- **Acceso**: Solo usuarios admin pueden ver "Audit Log" en navegación
- **Funcionalidad**: Registra automáticamente todas las acciones CRUD
- **Información**: Usuario, fecha/hora, evento, cambios realizados
- **Búsqueda**: Filtrar actividades por descripción o evento

### 4. **Notificaciones Interactivas**
- 🎉 **Creación de tareas**: Modal de confirmación
- 📝 **Actualización**: Toast discreto en esquina superior
- 🚀 **Movimiento**: Toast con estado destino
- 🗑️ **Eliminación**: Confirmación + notificación de éxito

### 5. **Estados de Tareas**
- 🔘 **Pendiente**: Tareas por hacer
- 🔵 **En Progreso**: Tareas en desarrollo  
- 🟢 **Completado**: Tareas finalizadas

## 📊 Datos de Demostración

El proyecto incluye seeders con datos de prueba:
- **Usuario demo**: `demo@kanban.com` / `password`
- **Usuario admin**: `admin@kanban.com` / `password` (acceso al audit log)
- **9 tareas** distribuidas en los 3 estados
- **Datos faker** para títulos y descripciones realistas
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

## 🎨 Características UX/UI

### Notificaciones SweetAlert2
- **Toast Notifications**: Feedback discreto en esquina superior derecha
- **Confirmaciones Modales**: Diálogos elegantes para acciones destructivas
- **Animaciones Suaves**: Transiciones fluidas entre estados
- **Responsive**: Adaptadas a dispositivos móviles y desktop

### Sistema de Traducciones
- **Archivo de traducciones**: `lang/en/front.php`
- **Textos centralizados**: Todos los strings del frontend organizados
- **Fácil localización**: Base preparada para múltiples idiomas
- **Consistencia**: Terminología unificada en toda la aplicación

### Interacciones Avanzadas
- **Drag & Drop**: SortableJS con animaciones suaves
- **Feedback Visual**: Estados hover, focus y loading
- **Formularios Reactivos**: Validación en tiempo real con Livewire
- **Sidebar Deslizante**: Formulario de creación con overlay y animaciones

## 🔍 Sistema de Auditoría

### Características
- **Paquete**: Spatie Laravel ActivityLog v4
- **Logging Automático**: Todas las operaciones CRUD en tareas
- **Información Registrada**: Usuario, fecha/hora, evento, cambios
- **Acceso Restringido**: Solo usuarios administradores

### Funcionalidades
- **Vista Paginada**: Lista completa de actividades con paginación
- **Búsqueda Avanzada**: Filtrar por descripción o tipo de evento
- **Detalles de Cambios**: Ver valores anteriores y nuevos
- **Timestamps Precisos**: Fecha y hora exacta de cada acción

### Eventos Registrados
- **Created**: Creación de nuevas tareas
- **Updated**: Modificación de título, descripción o estado
- **Deleted**: Eliminación de tareas

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
- [x] **Sistema de auditoría** con Spatie ActivityLog
- [x] **Panel administrativo** para visualizar audit trail

### ✅ Características Adicionales
- [x] Interfaz responsiva y moderna
- [x] Notificaciones SweetAlert2 para todas las operaciones CRUD
- [x] Sistema de traducciones (archivo `lang/en/front.php`)
- [x] Confirmaciones de eliminación interactivas
- [x] Toast notifications para feedback inmediato
- [x] Usuario administrador con permisos especiales
- [x] Logging automático de todas las acciones CRUD
- [x] Validaciones frontend y backend
- [x] Factory y seeders para datos de prueba
- [x] Configuración Docker para producción
- [x] Sistema de comandos con Makefile
- [x] Documentación completa

## 🚀 Próximas Mejoras

- [ ] Tests unitarios y de feature completos
- [ ] API REST para integraciones
- [ ] Websockets para colaboración en tiempo real
- [ ] Filtros y búsqueda avanzada en el tablero
- [ ] Sistema de etiquetas/categorías
- [ ] Fechas de vencimiento
- [ ] Múltiples tableros por usuario

## 📄 Licencia

Este proyecto es una prueba técnica y está disponible bajo la licencia MIT.

## � Dependencias Frontend

### Principales
```json
{
  "dependencies": {
    "alpinejs": "^3.x",
    "sweetalert2": "^11.x",
    "sortablejs": "^1.15.x"
  },
  "devDependencies": {
    "@tailwindcss/forms": "^0.5.x",
    "tailwindcss": "^3.x",
    "vite": "^4.x"
  }
}
```

### Scripts Disponibles
```bash
npm run dev      # Desarrollo con watch
npm run build    # Compilación optimizada
npm run preview  # Preview del build
```

## �👨‍💻 Desarrollo

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

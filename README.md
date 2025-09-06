# 📋 Kanban Board

> **Proyecto**: Sistema de gestión de tareas estilo Trello con Laravel + Livewire

[![Laravel](https://img.shields.io/badge/Laravel-9.x-red.svg)](https://laravel.com)
[![Livewire](https://img.shields.io/badge/Livewire-2.x-purple.svg)](https://laravel-livewire.com)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3.x-blue.svg)](https://tailwindcss.com)
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

### 1. Instalación Inicial

```bash
# Clonar el repositorio
git clone https://github.com/imorlab/kanban-board.git
cd kanban-board

# Instalar dependencias
composer install && npm install

# Configuración automática (crea archivos .env necesarios)
./docker-helper.sh setup
```

### 2. Elegir Entorno de Desarrollo

#### 🏠 **Desarrollo Local**
```bash
./docker-helper.sh local
php artisan serve
```
👉 Disponible en: http://127.0.0.1:8000

#### 🐳 **Desarrollo con Docker** (Recomendado)
```bash
./docker-helper.sh docker  
```
👉 Disponible en: http://localhost:8080

### 3. 🔄 Cambiar Entre Entornos

```bash
# Ver configuración actual
./docker-helper.sh config

# Cambiar a local (detiene Docker automáticamente)
./docker-helper.sh local

# Cambiar a Docker (inicia contenedores automáticamente)  
./docker-helper.sh docker
```

## 🛠️ Gestión de Configuraciones

### ¿Por qué Configuraciones Separadas?

La aplicación **requiere rutas diferentes** según el entorno:

| Configuración | 🏠 Local | 🐳 Docker |
|---------------|----------|-----------|
| **Base de datos** | `/ruta/completa/database.sqlite` | `/var/www/html/database/database.sqlite` |
| **Redis** | `127.0.0.1:6379` | `redis:6379` |
| **URL** | `http://127.0.0.1:8000` | `http://localhost:8080` |

### Archivos de Configuración

- `.env` → **Configuración activa** (se cambia automáticamente)
- `.env.local.example` → Template para desarrollo local  
- `.env.docker.example` → Template para Docker
- `docker-helper.sh` → Script para gestión automática de entornos

### Comandos Disponibles

```bash
# 🔄 Gestión de entornos
./docker-helper.sh local      # Cambiar a configuración LOCAL
./docker-helper.sh docker     # Cambiar a configuración DOCKER  
./docker-helper.sh config     # Ver configuración actual

# 🐳 Docker
./docker-helper.sh start      # Iniciar contenedores
./docker-helper.sh stop       # Detener contenedores
./docker-helper.sh status     # Estado de contenedores
./docker-helper.sh logs       # Ver logs

# 🔧 Utilidades  
./docker-helper.sh setup      # Configuración inicial
./docker-helper.sh migrate    # Ejecutar migraciones
./docker-helper.sh help       # Ver todos los comandos
```

## 🔧 Comandos Útiles Adicionales

### Laravel Artisan (Local)
```bash
php artisan migrate           # Ejecutar migraciones
php artisan migrate:fresh --seed  # Recrear BD con datos demo
php artisan cache:clear       # Limpiar caché
php artisan config:clear      # Limpiar config cache
php artisan test             # Ejecutar tests
```

### Laravel Sail (Docker)
```bash
./vendor/bin/sail artisan migrate    # Migraciones
./vendor/bin/sail artisan tinker     # Consola interactiva
./vendor/bin/sail npm run dev        # Assets desarrollo
./vendor/bin/sail test              # Tests
```

### Compilación de Assets
```bash
npm run dev      # Desarrollo con watch
npm run build    # Compilación optimizada para producción
```

## ⚠️ Troubleshooting

### 🔄 Problemas de Configuración

**Error: Database not found**
```bash
# 1. Verificar configuración actual
./docker-helper.sh config

# 2. Cambiar al entorno correcto
./docker-helper.sh local   # o docker

# 3. Si persiste, limpiar caché
php artisan config:clear   # Local
# o
./vendor/bin/sail artisan config:clear  # Docker
```

**Error: Port already in use**
```bash
# Para Docker (puerto 8080 ocupado)
./docker-helper.sh stop
docker ps  # Verificar que no hay contenedores corriendo

# Para local (puerto 8000 ocupado)  
php artisan serve --port=8001
```

### 🐳 Problemas con Docker

**Contenedores no inician**
```bash
# Verificar Docker Desktop
docker --version

# Reiniciar completamente
./docker-helper.sh stop
./vendor/bin/sail down
./vendor/bin/sail up -d
```

**Permisos de archivos SQLite**
```bash
chmod 664 database/database.sqlite
chmod 775 database/
```

### 🔧 Reset Completo

Si nada funciona, reset completo:
```bash
# Detener todo
./docker-helper.sh stop

# Limpiar archivos y caché
rm .env
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

# Configurar de nuevo
./docker-helper.sh setup
./docker-helper.sh docker  # o local
```
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

### Configuración de Tests
- **Base de datos en memoria**: SQLite `:memory:` para tests rápidos
- **Factory y Seeders**: Datos de prueba consistentes
- **RefreshDatabase**: Base de datos limpia en cada test

### Suite de Tests Completa

#### Tests Unitarios (`tests/Unit/`)
**TaskTest** - Modelo Task
- ✅ Creación de tareas con validaciones
- ✅ Relaciones con usuarios (belongsTo)  
- ✅ Cast de enum TaskStatus
- ✅ Scopes: `ofStatus()`, `forUser()`, `ordered()`
- ✅ Logging automático con Spatie ActivityLog
- ✅ Verificación de audit trail en creación/actualización

#### Tests de Feature (`tests/Feature/`)

**CreateTaskFormTest** - Componente de creación
- ✅ Renderizado del formulario
- ✅ Creación exitosa de tareas
- ✅ Validaciones de campos requeridos
- ✅ Reset de formulario después de crear
- ✅ Eventos Livewire correctos

**KanbanBoardTest** - Tablero principal
- ✅ Renderizado con columnas correctas
- ✅ Tareas mostradas en columnas apropiadas
- ✅ Segregación de tareas por usuario
- ✅ Manejo de eventos de componentes

**TaskCardTest** - Tarjetas de tareas
- ✅ Renderizado de información de tarea
- ✅ Edición inline completa
- ✅ Validación en edición
- ✅ Cancelar edición
- ✅ Confirmación de eliminación
- ✅ Protección contra edición de tareas ajenas

**AuditLogTest** - Sistema de auditoría
- ✅ Acceso restringido a admins únicamente
- ✅ Renderizado del componente
- ✅ Mostrar actividades registradas
- ✅ Búsqueda por descripción y propiedades
- ✅ Paginación de resultados
- ✅ Estados vacíos apropiados

### Ejecutar Tests

```bash
# Todos los tests
php artisan test

# Test específico por clase
php artisan test tests/Unit/TaskTest.php
php artisan test tests/Feature/KanbanBoardTest.php

# Test específico por método
php artisan test --filter=it_can_create_a_task

# Tests con coverage (si tienes xdebug)
php artisan test --coverage

# Tests en paralelo (más rápido)
php artisan test --parallel
```

### Estructura de Testing

```
tests/
├── Unit/
│   └── TaskTest.php           # Tests del modelo
├── Feature/
│   ├── CreateTaskFormTest.php # Formulario de creación
│   ├── KanbanBoardTest.php    # Tablero principal
│   ├── TaskCardTest.php       # Tarjetas de tareas
│   └── AuditLogTest.php       # Sistema de auditoría
└── TestCase.php               # Base para todos los tests
```

### Datos de Prueba
- **UserFactory**: Usuarios con/sin permisos admin
- **TaskFactory**: Tareas con estados aleatorios
- **Relaciones**: Tareas asociadas a usuarios específicos
- **ActivityLog**: Verificación automática de audit trail

### Cobertura de Tests
Los tests cubren:
- 🔄 **CRUD completo**: Crear, leer, actualizar, eliminar
- 🔒 **Autorización**: Usuarios solo pueden ver/editar sus tareas
- 👑 **Roles**: Funcionalidad admin para audit log
- 📝 **Validaciones**: Frontend y backend
- 🎯 **Business Logic**: Scopes, relaciones, eventos
- 📊 **Audit Trail**: Logging automático de actividades

```bash
# Ejecutar tests específicos por funcionalidad
php artisan test --group=task-management
php artisan test --group=audit-system
php artisan test --group=user-permissions
```

## 📝 Funcionalidades Implementadas

### ✅ Requisitos Funcionales
- [x] **Autenticación de Usuarios** completa (registro, login, perfil)
- [x] **Sistema de tareas privadas** - cada usuario solo ve sus tareas
- [x] **CRUD de tareas** con título, descripción y estado
- [x] **Tablero Kanban interactivo** con 3 columnas (Pendiente, En Progreso, Completado)
- [x] **Drag & drop funcional** - mover tareas entre columnas con actualización asíncrona
- [x] **Sistema de auditoría** completo para registrar acciones del usuario
- [x] **Panel administrativo** - audit trail visible solo para usuarios admin

### ✅ Requisitos Técnicos
- [x] **Backend**: Laravel 9.x
- [x] **Frontend**: Livewire 2.x para toda la interactividad
- [x] **Base de datos**: SQLite (archivo incluido en `database/`)
- [x] **Estilos**: TailwindCSS + Alpine.js para interfaz limpia y responsiva

### ✅ Puntos Extra Implementados
- [x] **Testing completo** - Tests unitarios y feature para funcionalidades críticas
- [x] **Validación robusta** - Frontend (Livewire) y backend con mensajes claros
- [x] **Notificaciones interactivas** - SweetAlert2 para feedback inmediato
- [x] **Componentes bien estructurados** - Livewire components reutilizables y organizados
- [x] **Calidad del código** - PSR-12, strong types, código claro y comentado
- [x] **Historial Git limpio** - Commits atómicos y descriptivos
- [x] **Docker para producción** - docker-compose.yml optimizado con Nginx + PHP-FPM
- [x] **Sistema de traducciones** - Archivo `lang/en/front.php` centralizado
- [x] **Factory y seeders** - Datos de prueba con usuario demo y admin
- [x] **Configuración dual** - Local + Docker con scripts de cambio automático

### 🚀 Mejoras Adicionales Implementadas
- [x] **Interfaz moderna** - Diseño responsivo con animaciones suaves
- [x] **Toast notifications** - Feedback discreto para acciones exitosas
- [x] **Confirmaciones elegantes** - Diálogos SweetAlert2 para acciones destructivas
- [x] **Edición inline** - Editar tareas directamente en las tarjetas
- [x] **Búsqueda en audit log** - Filtrar actividades por descripción o evento
- [x] **Paginación** - Lista de actividades con navegación eficiente
- [x] **Sistema de comandos** - Makefile con comandos útiles para desarrollo
- [x] **Documentación completa** - README detallado con ejemplos y troubleshooting

### 🎯 Funcionalidades Avanzadas Futuras
- [ ] **API REST** para integraciones móviles
- [ ] **Websockets** para colaboración en tiempo real
- [ ] **Filtros avanzados** en el tablero
- [ ] **Sistema de etiquetas** y categorías
- [ ] **Fechas de vencimiento** con recordatorios
- [ ] **Múltiples tableros** por usuario
- [ ] **Colaboración** entre usuarios
- [ ] **Exportar datos** a PDF/Excel

## 📄 Licencia

Este proyecto está disponible bajo la licencia MIT.

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

Desarrollado para demostrar habilidades en:
- Laravel + Livewire
- TailwindCSS
- SQLite
- Docker
- Git + GitHub

---

**¿Preguntas o sugerencias?** 
Abre un [issue](https://github.com/imorlab/kanban-board/issues) o envía un PR! 🎯

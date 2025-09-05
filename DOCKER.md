# 🐳 Docker Setup - Kanban Board

Este proyecto incluye dos configuraciones de Docker para diferentes propósitos:

## 📋 Configuraciones Disponibles

### 1. **Laravel Sail** (Desarrollo)
- ✅ Configuración simple y rápida
- ✅ Ideal para desarrollo local
- ✅ Incluye Redis y herramientas de desarrollo
- ✅ Hot reload automático

### 2. **Docker Compose Personalizado** (Producción)
- ✅ Optimizado para producción
- ✅ Nginx + PHP-FPM
- ✅ Multi-stage build
- ✅ Caché optimizado

## 🚀 Inicio Rápido

### Opción 1: Laravel Sail (Recomendado para desarrollo)

```bash
# 1. Crear alias
alias sail='./vendor/bin/sail'

# 2. Iniciar contenedores
sail up -d

# 3. Configurar aplicación (primera vez)
sail artisan key:generate
sail artisan migrate

# 4. Acceder a la aplicación
# http://localhost
```

### Opción 2: Script Helper (Más fácil)

```bash
# Ver comandos disponibles
./docker-helper.sh help

# Iniciar desarrollo
./docker-helper.sh start

# Configurar entorno (primera vez)
./docker-helper.sh setup

# Ver estado
./docker-helper.sh status

# Detener contenedores
./docker-helper.sh stop
```

### Opción 3: Docker Compose Personalizado

```bash
# Desarrollo
docker-compose -f docker-compose.prod.yml up --build

# Producción (background)
docker-compose -f docker-compose.prod.yml up -d --build
```

## 📊 Servicios Incluidos

| Servicio | Puerto | Descripción |
|----------|--------|-------------|
| **App** | 80 | Aplicación Laravel |
| **Redis** | 6379 | Cache y sesiones |
| **Nginx** | 80/443 | Servidor web (solo en prod) |

## 🔧 Comandos Útiles

### Laravel Sail
```bash
# Comandos Laravel
sail artisan migrate
sail artisan tinker
sail artisan queue:work

# Acceder al contenedor
sail shell

# Ver logs
sail logs -f

# Ejecutar tests
sail test
```

### Docker Compose Personalizado
```bash
# Ver logs
docker-compose -f docker-compose.prod.yml logs -f

# Ejecutar comandos en el contenedor
docker-compose -f docker-compose.prod.yml exec app php artisan migrate

# Reconstruir imágenes
docker-compose -f docker-compose.prod.yml build --no-cache
```

## 🛠️ Troubleshooting

### Puerto ya en uso
```bash
# Cambiar puerto en .env
APP_PORT=8080

# O detener servicios locales
sudo service apache2 stop
sudo service nginx stop
```

### Permisos de archivos
```bash
# Arreglar permisos de storage
sail exec app chmod -R 775 storage bootstrap/cache
sail exec app chown -R www-data:www-data storage bootstrap/cache
```

### Limpiar Docker
```bash
# Limpiar contenedores e imágenes no utilizadas
docker system prune -af

# Remover volúmenes
docker volume prune
```

## 📝 Variables de Entorno

Principales variables para Docker en `.env`:

```env
# Puertos
APP_PORT=80
VITE_PORT=5173
FORWARD_REDIS_PORT=6379

# Docker
WWWGROUP=1000
WWWUSER=1000
SAIL_XDEBUG_MODE=develop,debug
```

## 🎯 Mejores Prácticas

1. **Desarrollo**: Usa Laravel Sail o el script helper
2. **Testing**: Usa SQLite en memoria (ya configurado)
3. **Producción**: Usa docker-compose.prod.yml
4. **Debugging**: Activa Xdebug solo cuando sea necesario
5. **Performance**: Usa volúmenes para node_modules y vendor

## 📚 Recursos Adicionales

- [Laravel Sail Documentation](https://laravel.com/docs/sail)
- [Docker Compose Reference](https://docs.docker.com/compose/)
- [PHP-FPM Configuration](https://www.php.net/manual/en/install.fpm.php)

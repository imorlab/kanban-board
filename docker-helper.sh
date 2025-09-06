#!/bin/bash

# Docker Helper Script para Kanban Board
# Facilita el uso de Docker en el proyecto

set -e

# Colores
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# Banner
echo -e "${BLUE}🐳 Docker Helper - Kanban Board${NC}"
echo "=================================="

# Funciones
start_sail() {
    echo -e "${GREEN}🚀 Iniciando Laravel Sail...${NC}"

    # Configurar automáticamente para Docker
    if [ -f .env.docker.example ] && [ ! -f .env.docker ]; then
        cp .env.docker.example .env.docker
        echo "✅ Archivo .env.docker creado desde template"
    fi

    if [ -f .env.docker ]; then
        cp .env.docker .env
        echo "✅ Configuración Docker aplicada"

        # Generar APP_KEY si no existe
        if ! grep -q "APP_KEY=base64:" .env; then
            php artisan key:generate
            echo "✅ APP_KEY generada"
        fi
    fi

    ./vendor/bin/sail up -d
    echo -e "${GREEN}✅ Aplicación disponible en http://localhost${NC}"
}

stop_sail() {
    echo -e "${YELLOW}⏹️  Deteniendo Laravel Sail...${NC}"
    ./vendor/bin/sail down
    echo -e "${GREEN}✅ Contenedores detenidos${NC}"
}

start_production() {
    echo -e "${GREEN}🏭 Iniciando Docker Producción...${NC}"
    docker-compose -f docker-compose.prod.yml up -d --build
    echo -e "${GREEN}✅ Aplicación disponible en http://localhost${NC}"
}

stop_production() {
    echo -e "${YELLOW}⏹️  Deteniendo Docker Producción...${NC}"
    docker-compose -f docker-compose.prod.yml down
    echo -e "${GREEN}✅ Contenedores detenidos${NC}"
}

show_status() {
    echo -e "${BLUE}📊 Estado de los contenedores:${NC}"
    docker ps --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
}

show_logs() {
    if [ "$2" == "prod" ]; then
        docker-compose -f docker-compose.prod.yml logs -f
    else
        ./vendor/bin/sail logs -f
    fi
}

setup_environment() {
    echo -e "${GREEN}🔧 Configurando entorno...${NC}"

    # Crear archivos .env desde templates si no existen
    if [ ! -f .env.local ] && [ -f .env.local.example ]; then
        cp .env.local.example .env.local
        # Actualizar ruta de base de datos con la ruta real
        sed -i.bak "s|/absolute/path/to/your/project|$(pwd)|g" .env.local
        rm .env.local.bak
        echo "✅ Archivo .env.local creado desde template"
    fi

    if [ ! -f .env.docker ] && [ -f .env.docker.example ]; then
        cp .env.docker.example .env.docker
        echo "✅ Archivo .env.docker creado desde template"
    fi

    # Copiar .env si no existe (usar local por defecto)
    if [ ! -f .env ]; then
        if [ -f .env.local ]; then
            cp .env.local .env
        else
            cp .env.example .env
        fi
        echo "✅ Archivo .env creado"
    fi

    # Generar APP_KEY si no existe
    if ! grep -q "APP_KEY=base64:" .env; then
        php artisan key:generate
        echo "✅ APP_KEY generada"
    fi

    # Verificar si los contenedores están corriendo
    if [ "$2" == "prod" ]; then
        # Para producción
        if ! docker-compose -f docker-compose.prod.yml ps | grep -q "Up"; then
            echo "⚠️  Iniciando contenedores de producción..."
            docker-compose -f docker-compose.prod.yml up -d --build
            sleep 10
        fi
        docker-compose -f docker-compose.prod.yml exec app php artisan key:generate
    else
        # Para desarrollo con Sail
        if ! ./vendor/bin/sail ps 2>/dev/null | grep -q "Up"; then
            echo "⚠️  Iniciando contenedores de desarrollo..."
            ./vendor/bin/sail up -d
            sleep 15
        fi
        ./vendor/bin/sail artisan key:generate
    fi

    echo -e "${GREEN}✅ Entorno configurado${NC}"
}

migrate_database() {
    echo -e "${GREEN}🗄️  Ejecutando migraciones...${NC}"

    if [ "$2" == "prod" ]; then
        # Verificar contenedores de producción
        if ! docker-compose -f docker-compose.prod.yml ps | grep -q "Up"; then
            echo "⚠️  Los contenedores no están corriendo. Use: ./docker-helper.sh start prod"
            exit 1
        fi
        docker-compose -f docker-compose.prod.yml exec app php artisan migrate --force
    else
        # Verificar contenedores de desarrollo
        if ! ./vendor/bin/sail ps 2>/dev/null | grep -q "Up"; then
            echo "⚠️  Los contenedores no están corriendo. Use: ./docker-helper.sh start"
            exit 1
        fi
        ./vendor/bin/sail artisan migrate
    fi

    echo -e "${GREEN}✅ Migraciones completadas${NC}"
}

show_help() {
    echo -e "${BLUE}📖 Comandos disponibles:${NC}"
    echo ""
    echo -e "${GREEN}Desarrollo (Laravel Sail):${NC}"
    echo "  ./docker-helper.sh start      - Iniciar contenedores"
    echo "  ./docker-helper.sh stop       - Detener contenedores"
    echo "  ./docker-helper.sh logs       - Ver logs"
    echo ""
    echo -e "${GREEN}Producción:${NC}"
    echo "  ./docker-helper.sh start prod - Iniciar contenedores de producción"
    echo "  ./docker-helper.sh stop prod  - Detener contenedores de producción"
    echo "  ./docker-helper.sh logs prod  - Ver logs de producción"
    echo ""
    echo -e "${GREEN}Utilidades:${NC}"
    echo "  ./docker-helper.sh status     - Estado de contenedores"
    echo "  ./docker-helper.sh setup      - Configurar entorno"
    echo "  ./docker-helper.sh migrate    - Ejecutar migraciones"
    echo "  ./docker-helper.sh help       - Mostrar esta ayuda"
}

# Main
case "$1" in
    "start")
        if [ "$2" == "prod" ]; then
            start_production
        else
            start_sail
        fi
        ;;
    "stop")
        if [ "$2" == "prod" ]; then
            stop_production
        else
            stop_sail
        fi
        ;;
    "status")
        show_status
        ;;
    "logs")
        show_logs $@
        ;;
    "setup")
        setup_environment $@
        ;;
    "migrate")
        migrate_database $@
        ;;
    "help"|"--help"|"-h")
        show_help
        ;;
    *)
        echo -e "${RED}❌ Comando no reconocido: $1${NC}"
        echo ""
        show_help
        exit 1
        ;;
esac

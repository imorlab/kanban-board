#!/bin/bash

# Script para alternar entre configuraciones local y Docker

case "$1" in
    "local")
        echo "Configurando para desarrollo local..."
        if [ -f .env.local ]; then
            cp .env.local .env
            echo "✓ Configuración local activada"
            echo "Ejecuta: php artisan serve"
        else
            echo "❌ Archivo .env.local no encontrado"
            exit 1
        fi
        ;;
    "docker")
        echo "Configurando para desarrollo con Docker..."
        if [ -f .env.docker ]; then
            cp .env.docker .env
            echo "✓ Configuración Docker activada"
            echo "Ejecuta: ./vendor/bin/sail up -d"
        else
            echo "❌ Archivo .env.docker no encontrado"
            exit 1
        fi
        ;;
    *)
        echo "Uso: $0 {local|docker}"
        echo ""
        echo "local  - Configura el proyecto para desarrollo local"
        echo "docker - Configura el proyecto para desarrollo con Docker"
        exit 1
        ;;
esac

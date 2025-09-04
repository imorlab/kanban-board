.PHONY: help install setup local docker docker-down docker-build clean test

# Variables
SAIL = ./vendor/bin/sail

# Colores para los mensajes
GREEN = \033[0;32m
YELLOW = \033[1;33m
RED = \033[0;31m
NC = \033[0m # No Color

help: ## Mostrar esta ayuda
	@echo "$(GREEN)Mini-Trello - Comandos disponibles:$(NC)"
	@echo ""
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  $(YELLOW)%-15s$(NC) %s\n", $$1, $$2}' $(MAKEFILE_LIST)
	@echo ""

install: ## Instalar dependencias
	@echo "$(GREEN)Instalando dependencias...$(NC)"
	composer install
	npm install

setup: install ## Configuración inicial del proyecto
	@echo "$(GREEN)Configurando el proyecto...$(NC)"
	./setup-sqlite.sh
	php artisan key:generate
	php artisan migrate
	npm run build

local: ## Configurar para desarrollo local
	@echo "$(GREEN)Configurando para desarrollo local...$(NC)"
	./switch-env.sh local
	@echo "$(YELLOW)Ahora puedes ejecutar: php artisan serve$(NC)"

docker: ## Configurar y levantar con Docker
	@echo "$(GREEN)Configurando para desarrollo con Docker...$(NC)"
	./switch-env.sh docker
	$(SAIL) up -d
	@echo "$(YELLOW)Aplicación disponible en: http://localhost$(NC)"

docker-down: ## Detener los contenedores Docker
	@echo "$(RED)Deteniendo contenedores...$(NC)"
	$(SAIL) down

docker-build: ## Reconstruir los contenedores Docker
	@echo "$(GREEN)Reconstruyendo contenedores...$(NC)"
	$(SAIL) build --no-cache
	$(SAIL) up -d

serve: ## Iniciar servidor de desarrollo local
	@echo "$(GREEN)Iniciando servidor local...$(NC)"
	php artisan serve

migrate: ## Ejecutar migraciones
	@echo "$(GREEN)Ejecutando migraciones...$(NC)"
	php artisan migrate

migrate-fresh: ## Recrear base de datos
	@echo "$(RED)Recreando base de datos...$(NC)"
	php artisan migrate:fresh --seed

test: ## Ejecutar tests
	@echo "$(GREEN)Ejecutando tests...$(NC)"
	php artisan test

clean: ## Limpiar caches
	@echo "$(GREEN)Limpiando caches...$(NC)"
	php artisan cache:clear
	php artisan config:clear
	php artisan route:clear
	php artisan view:clear

dev: ## Compilar assets en modo desarrollo
	@echo "$(GREEN)Compilando assets...$(NC)"
	npm run dev

build: ## Compilar assets para producción
	@echo "$(GREEN)Compilando assets para producción...$(NC)"
	npm run build

# === COMANDOS DE PRODUCCIÓN ===

prod-build: ## Construir imagen de producción
	@echo "$(GREEN)Construyendo imagen de producción...$(NC)"
	docker-compose -f docker-compose.prod.yml build --no-cache

prod-up: ## Levantar en producción
	@echo "$(GREEN)Levantando en producción...$(NC)"
	docker-compose -f docker-compose.prod.yml up -d

prod-down: ## Detener producción
	@echo "$(RED)Deteniendo producción...$(NC)"
	docker-compose -f docker-compose.prod.yml down

prod-logs: ## Ver logs de producción
	@echo "$(GREEN)Mostrando logs de producción...$(NC)"
	docker-compose -f docker-compose.prod.yml logs -f

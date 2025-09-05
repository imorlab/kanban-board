# Prueba Técnica para Desarrollador Laravel & Livewire en jtsec

¡Hola! Te damos la bienvenida y agradecemos tu interés en formar parte de nuestro equipo.

Esta prueba técnica ha sido diseñada para evaluar tus habilidades y conocimientos en el desarrollo de aplicaciones web modernas con Laravel y Livewire. El objetivo es que puedas demostrarnos tu forma de trabajar, tu atención al detalle y tu capacidad para crear soluciones funcionales y de alta calidad.

---

## El Desafío: Mini-Trello - Gestor de Tareas Interactivo

El reto consiste en desarrollar un pequeño gestor de tareas al estilo "Kanban Board" (como Trello o Jira). La aplicación permitirá a los usuarios gestionar sus tareas a través de un tablero visual e interactivo. La clave del desafío es que toda la interactividad del frontend debe ser manejada con Livewire.

### Requisitos Funcionales

1.  **Autenticación de Usuarios:**
    *   La aplicación debe tener un sistema de registro e inicio de sesión.
    *   Las tareas de cada usuario deben ser privadas y solo visibles por él mismo.

2.  **Gestión de Tareas (CRUD):**
    *   Un usuario autenticado debe poder crear, leer, actualizar y eliminar sus propias tareas.
    *   Cada tarea debe tener, como mínimo, un `título`, una `descripción` y un `estado`.

3.  **Tablero Kanban Interactivo:**
    *   La vista principal después de iniciar sesión será un tablero Kanban con tres columnas: **"Pendiente"**, **"En Progreso"** y **"Completado"**.
    *   Las tareas del usuario se mostrarán en la columna correspondiente a su estado.
    *   **Funcionalidad clave:** El usuario debe poder arrastrar y soltar (`drag and drop`) una tarea de una columna a otra.
    *   Al mover una tarea, su estado debe actualizarse en la base de datos de forma asíncrona (sin recargar la página), utilizando Livewire.

4.  **Auditoría:**
    *   La aplicación debe tener una auditoría de tipo "audit trail" para registrar las acciones del usuario.
    *   La auditoria solo debe de ser posible verla para un usuario administrativo (admin).

### Requisitos Técnicos

*   **Backend:** Laravel 9.
*   **Frontend:** Toda la lógica interactiva debe ser implementada con Livewire 2 (tienes que instalar la dependencia de Livewire en el proyecto).
*   **Base de Datos:** Utilizar **SQLite**. Esto simplifica la configuración para que puedas enfocarte en el código. El archivo de la base de datos debe estar incluido en el directorio `database/`.
*   **Estilos:** Eres libre de usar el framework CSS que prefieras (TailwindCSS es recomendado por su buena integración con Livewire), o incluso CSS puro. Lo importante es que la interfaz sea limpia, usable y estéticamente agradable.

---

### Puntos Extra (Opcionales pero muy valorados)

Estos puntos nos permitirán ver tu potencial y tu dominio de buenas prácticas:

*   **Testing:** Añadir pruebas (unitarias o de feature) para las funcionalidades críticas. El uso de Pest o PHPUnit es bienvenido.
*   **Validación de Formularios:** Implementar validaciones robustas tanto en el frontend (con Livewire) como en el backend.
*   **Notificaciones:** Mostrar notificaciones al usuario tras realizar acciones (ej. "¡Tarea creada con éxito!").
*   **Diseño de Componentes:** Estructurar la aplicación en componentes de Livewire reutilizables y bien organizados.
*   **Calidad del Código:** Seguir los estándares de codificación de Laravel (PSR-12), uso de `strong types` de PHP, y código claro y bien comentado (en inglés).
*   **Historial de Git:** Realizar commits atómicos y descriptivos que cuenten la historia del desarrollo.
*   **Contenerización para Producción:** Crear un archivo `docker-compose.yml` optimizado para un entorno de producción (utilizando Nginx, PHP-FPM, etc.).

---

### Cómo Instalar y Ejecutar el Proyecto

Este proyecto está configurado para funcionar con **Laravel Sail**, el entorno de desarrollo por defecto de Laravel basado en Docker. No necesitas tener PHP o Composer instalados en tu máquina local, solo [Docker](https://www.docker.com/get-started).

1.  **Clona el repositorio y navega al directorio.**

2.  **Prepara el entorno:**
    Ejecuta el script de configuración para SQLite (o copia el archivo de entorno manualmente):
    ```bash
    ./setup-sqlite.sh
    ```
    O alternativamente:
    ```bash
    cp .env.example .env
    ```

3.  **Levanta los contenedores con Sail:**
    La primera vez que ejecutes este comando, Sail construirá las imágenes de tu aplicación. Esto puede tardar varios minutos.
    ```bash
    ./vendor/bin/sail up -d
    ```

4.  **Genera la clave de la aplicación y ejecuta las migraciones:**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ./vendor/bin/sail artisan migrate
    ```
    *Nota: Como usamos SQLite, la migración creará el archivo `database/database.sqlite` dentro del contenedor.*

5.  **Instala las dependencias de NPM y compila los assets:**
    ```bash
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run dev
    ```

¡Y listo! La aplicación estará disponible en `http://localhost`.

---

### Instrucciones de Entrega

1.  Crea un repositorio público en tu cuenta de GitHub o GitLab.
2.  Realiza tu desarrollo en el repositorio, usando un historial de commits claro.
3.  Cuando hayas finalizado, envía el enlace de tu repositorio a la persona de contacto que te envió esta prueba.

### Plazo

Tienes un plazo de **5 días** a partir de la recepción de esta prueba para enviarnos tu solución.

---

¡Mucha suerte! Estamos muy interesados en ver tu trabajo. Si tienes alguna pregunta, no dudes en contactarnos.

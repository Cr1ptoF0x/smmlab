# SMMlab en Cloudflare Containers

SMMlab es una aplicación PHP/Laravel con MySQL. No se despliega como un sitio estático de Cloudflare Pages. Este repositorio usa Cloudflare Workers + Containers para ejecutar Apache/PHP; MySQL y los archivos de usuario deben vivir en servicios persistentes.

## Arquitectura

- Cloudflare Worker en src/index.js recibe HTTP y enruta al contenedor.
- Cloudflare Container construye Dockerfile, PHP 8.3 + Apache y el código en Files/.
- Laravel se ejecuta desde Files/core; Apache publica únicamente Files/public.
- MySQL debe ser una base externa accesible desde Cloudflare Containers.
- Los uploads deben ir a almacenamiento persistente compatible con S3, por ejemplo R2. El sistema de archivos local del contenedor no debe ser el único respaldo de archivos.

## Configurar despliegue continuo

1. En Cloudflare, habilita Containers en la cuenta que usará SMMlab y crea un API token restringido a esa cuenta con permisos para editar Workers.
2. En GitHub, abre Settings → Secrets and variables → Actions y agrega:
   - CLOUDFLARE_ACCOUNT_ID
   - CLOUDFLARE_API_TOKEN
3. Haz push a master. El workflow .github/workflows/deploy-cloudflare.yml instalará dependencias Node y ejecutará wrangler deploy.
4. Espera a que Cloudflare termine de crear la primera instancia y revisa Workers & Pages → smmlab → Logs.

Nunca pongas el API token de Cloudflare en archivos del repositorio. El workflow lo lee desde GitHub Actions Secrets.

## Variables/secretos del Worker

Desde la carpeta del proyecto, carga cada secreto de forma interactiva con:

    npx wrangler secret put APP_KEY
    npx wrangler secret put APP_URL
    npx wrangler secret put DB_HOST
    npx wrangler secret put DB_DATABASE
    npx wrangler secret put DB_USERNAME
    npx wrangler secret put DB_PASSWORD

Usa estos valores:

- APP_KEY: clave Laravel segura, con prefijo base64: (genera con php artisan key:generate --show en un entorno PHP).
- APP_URL: URL pública del Worker o tu dominio.
- DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD: credenciales de la base MySQL externa.
- APP_ENV=production, APP_DEBUG=false, APP_NAME=FollowBooster Store, SESSION_DRIVER=database, CACHE_STORE=database, QUEUE_CONNECTION=database y FILESYSTEM_DISK=s3 pueden añadirse en wrangler.jsonc bajo vars. No guardes credenciales dentro de vars.

Los secretos de Worker no son los mismos que los secretos de GitHub Actions: GitHub autentica el despliegue y Cloudflare entrega la configuración runtime al Worker/contenedor.

## Base de datos

Cloudflare no hospeda una instancia MySQL compatible como servicio Workers. Crea/usa MySQL gestionado externo, permite conexiones entrantes desde Cloudflare Containers según las reglas del proveedor y carga el esquema/backup de tu instancia actual antes de abrir la tienda. No uses SQLite ni un MySQL dentro de un contenedor efímero para producción.

El repositorio no contiene un backup de la base real. Antes de hacer el cambio de DNS, exporta la base actual, importa el respaldo en MySQL gestionado y verifica login de administrador, login de cliente, pedidos, saldo y callbacks de pago.

## Archivos subidos

Los archivos locales de un Container pueden desaparecer al reconstruirse o cambiar de instancia. Configura un bucket R2/S3 persistente y adapta la configuración S3 de Laravel con sus variables de endpoint, bucket y credenciales. Verifica dónde escribe SMMlab las imágenes y archivos; establecer FILESYSTEM_DISK=s3 no cambia rutas personalizadas que escriban directamente en disco local.

## Desarrollo local

1. Copia .env.example a .env y genera valores locales únicos.
2. Ejecuta docker compose up --build.
3. Abre http://localhost:8000/install/; MySQL se expone en 127.0.0.1:3307 desde el host y el servicio se llama db desde la app.
4. phpMyAdmin queda en http://localhost:8080.

Los datos locales viven en el volumen Docker smmlab-db-data. No borres ese volumen si quieres conservar la base de desarrollo.

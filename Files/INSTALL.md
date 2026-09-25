# Guía de Instalación en HestiaCP (Ubuntu 22.04 + Nginx + PHP 8.3)

Esta guía te ayudará a desplegar tu proyecto SMMLab en un servidor de producción utilizando Hestia Control Panel.

## 1. Preparación en HestiaCP
1. Inicia sesión en tu panel de HestiaCP.
2. Ve a la sección **WEB** y añade un nuevo dominio (ej. `tupanel.com`).
3. Al crear el dominio, asegúrate de activar la casilla de **Soporte SSL/TLS** y **Let's Encrypt**.
4. En las opciones avanzadas del dominio web, selecciona la versión de PHP **8.3** (si no la tienes, instálala desde la configuración del servidor de Hestia).

## 2. Subir Archivos
Dado que la estructura del proyecto tiene los archivos públicos directamente en la carpeta principal (y el código interno en la carpeta `core/`):
1. Ve al **File Manager** (Administrador de Archivos) en HestiaCP.
2. Navega a `web/tupanel.com/public_html/`.
3. Borra el archivo `index.html` por defecto que crea HestiaCP.
4. Sube el archivo `smmlab-production.zip` que acabamos de generar.
5. Descomprime el archivo ZIP. **Asegúrate de que los archivos (como `index.php`, `server.php` y la carpeta `core`) queden directamente dentro de `public_html/`** y no dentro de otra subcarpeta.

## 3. Permisos de Carpetas (Muy Importante)
Laravel necesita permisos de escritura en las carpetas de caché y almacenamiento.
Desde la terminal SSH de tu servidor Ubuntu (o desde el File Manager de Hestia), aplica los siguientes permisos:
```bash
cd /home/tu_usuario/web/tupanel.com/public_html/core
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

## 4. Base de Datos
1. En HestiaCP, ve a la sección **DB** (Bases de Datos).
2. Haz clic en **Añadir Base de Datos**. Crea una base de datos, un usuario y genera una contraseña segura. Guarda estos datos.
3. Abre phpMyAdmin desde HestiaCP e importa el archivo de tu base de datos SQL (`database.sql` si lo tienes a la mano).

## 5. Configurar el archivo .env
1. En el File Manager de HestiaCP, ve a `public_html/core/`.
2. Renombra el archivo `.env.example` a `.env` (si es que no tienes un `.env` generado).
3. Edita el archivo `.env` y configura los siguientes valores:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://tupanel.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tu_base_de_datos
   DB_USERNAME=tu_usuario_de_db
   DB_PASSWORD=tu_contraseña_de_db
   ```
4. Guarda los cambios.

## 6. Generar APP_KEY (Si partiste del .env.example)
Si renombraste `.env.example` y el campo `APP_KEY` está vacío, deberás generar uno. Conéctate por SSH a tu servidor y ejecuta:
```bash
cd /home/tu_usuario/web/tupanel.com/public_html/core
php artisan key:generate
php artisan optimize:clear
```

¡Listo! Tu panel debería estar funcionando perfectamente en tu dominio.

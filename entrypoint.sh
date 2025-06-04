#!/bin/sh

# Esperar a que la base de datos esté lista
echo "Esperando a que la base de datos esté disponible..."
until pg_isready -h "$DB_HOST" -p "$DB_PORT" -U "$DB_USERNAME"; do
  sleep 2
done

echo "Base de datos disponible. Ejecutando comandos de Laravel..."

# Generar la clave de la aplicación (solo si no existe APP_KEY)
if [ -z "$APP_KEY" ]; then
  php artisan key:generate
fi

# Ejecutar migraciones y seeders
php artisan migrate --force
php artisan db:seed --force

# Cachear configuración y rutas
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Iniciar servidor Laravel
exec php artisan serve --host=0.0.0.0 --port=8000

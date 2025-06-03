FROM php:8.2-fpm

# Instalar dependencias del sistema necesarias para extensiones PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    unzip \
    zip \
    nginx

# Limpiar caché de paquetes
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP requeridas por Laravel y PostgreSQL
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath intl gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Crear archivo .env a partir del ejemplo
RUN cp .env.example .env

# Instalar dependencias PHP con Composer
RUN composer install --optimize-autoloader --no-dev

# Generar clave de la aplicación
RUN php artisan key:generate

# Cachear configuración, rutas y vistas
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Asignar permisos a Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer el puerto 8000
EXPOSE 8000

# Iniciar servidor Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

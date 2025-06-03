FROM php:8.2-fpm

# Instalar dependencias del sistema
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

# Instalar Node.js y npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Limpiar caché
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath intl gd zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Crear archivo .env si no existe
RUN cp .env.example .env || true

# Instalar dependencias PHP
RUN composer install --optimize-autoloader --no-dev

# Instalar dependencias JS y compilar assets con Vite
RUN npm install && npm run build

# Generar clave de la aplicación
RUN php artisan key:generate

# Cachear configuración, rutas y vistas
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# Permisos
RUN chown -R www-data:www-data storage bootstrap/cache

# Exponer puerto 8000
EXPOSE 8000

# Iniciar servidor
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

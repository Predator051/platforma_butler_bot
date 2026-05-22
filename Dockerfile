# Используем официальный PHP образ с Apache
FROM php:8.2-apache

# 1. Устанавливаем системные зависимости и PHP-расширения
# zip и unzip критически важны для Composer, git нужен для загрузки некоторых пакетов
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Включаем модуль Apache rewrite (очень полезно для красивых URL в PHP)
RUN a2enmod rewrite

# 3. Копируем Composer из официального Docker-образа
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Разрешаем Composer работать под пользователем root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Устанавливаем рабочую директорию
WORKDIR /var/www/html

# 4. Сначала копируем ТОЛЬКО файлы зависимостей
# Это нужно для кэширования: Docker не будет заново качать вендоры, если вы просто поменяли код
COPY composer.json composer.lock* ./

# Устанавливаем зависимости (без dev-пакетов и с оптимизацией автозагрузки)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# 5. Копируем оставшийся код проекта
COPY . .

# Окончательно генерируем автозагрузчик уже с учетом наших классов
RUN composer dump-autoload --optimize

# 6. Выставляем правильные права на файлы для Apache (пользователь www-data)
RUN chown -R www-data:www-data /var/www/html

# Открываем порт 80
EXPOSE 80

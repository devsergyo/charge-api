FROM php:8.4-fpm-alpine

# Instalar dependências do sistema
RUN apk add --no-cache \
    git \
    curl \
    postgresql-dev \
    oniguruma-dev \
    zip \
    unzip

# Instalar extensões PHP necessárias para Laravel API
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    bcmath \
    opcache

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . .


# Expor porta 9000 para PHP-FPM
EXPOSE 9000

# Comando padrão
CMD ["php-fpm"] 
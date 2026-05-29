# ─── Stage 1: Imagem final ───────────────────────────────────────────────────
FROM php:8.2-apache

# Instala dependências do sistema e extensões PHP
RUN apt-get update && apt-get install -y \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instala Node.js 20 LTS e dependências npm
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Habilita mod_rewrite
RUN a2enmod rewrite

# VirtualHost próprio
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Configurações de PHP/OPcache
COPY docker/php.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www/html

# Copia o código-fonte
COPY . .

# Instala dependências do npm
RUN npm install

# Garante que os diretórios necessários existam com permissões corretas.
RUN mkdir -p assets \
    && chmod -R 755 assets

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 80

# ENTRYPOINT roda o script de inicialização
# CMD é passado como argumento para o entrypoint e pode ser sobrescrito
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["apache2-foreground"]
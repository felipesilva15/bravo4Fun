# Baixa a imagem oficial do server Apache
FROM php:8.2.0-apache

# Define o diretório de trabalho no contêiner
WORKDIR /var/www/html

# Copia os arquivos do diretório atual para a pasta /var/www/html
COPY . /var/www/html

# Instala a extensão pdo_mysql
RUN docker-php-ext-install pdo_mysql

# Instala o Node.js
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get install -y nodejs

# Executa o comando npm install para instalar as dependências do Node.js
RUN npm install

# Copia o arquivo env de exemplo
COPY config.env.example.php config.env.php

# Define as variáveis de ambiente no Dockerfile
ARG DB_HOST
ARG DB_DATABASE
ARG DB_USER
ARG DB_PASSWORD

# Substitui as variáveis no arquivo .env pelas variáveis de ambiente
RUN sed -i "s#DB_HOST#${DB_HOST}#" config.env.php \
    && sed -i "s#DB_DATABASE#${DB_DATABASE}#" config.env.php \
    && sed -i "s#DB_USER#${DB_USER}#" config.env.php \
    && sed -i "s#DB_PASSWORD#${DB_PASSWORD}#" config.env.php

# Expõe a porta 80 para acessar o servidor web
EXPOSE 80

# Executa o comando de inicialização do apache após a execução do contêiner
CMD ["apache2-foreground"]
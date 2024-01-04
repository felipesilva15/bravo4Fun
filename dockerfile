# Baixa a imagem oficial do server Apache
FROM php:8.2.0-apache

# Copia os arquivos do diretório atual para a pasta /var/www/html
COPY . /var/www/html

# Expõe a porta 80 para acessar o servidor web
EXPOSE 80

# Executa o comando de inicialização do apache após a execução do contêiner
CMD ["apache2-foreground"]
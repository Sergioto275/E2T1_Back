FROM php:apache

# MySQLi eta mysql bezeroa instalatu
RUN docker-php-ext-install mysqli && \
    apt-get update && \ 
    apt-get install -y default-mysql-client

COPY apache2.conf /etc/apache2/

# 80 eta 443 atakak erakutsi
EXPOSE 80
EXPOSE 443

# Kontenedorea martxan jarri
CMD ["apache2ctl", "-D", "FOREGROUND"]

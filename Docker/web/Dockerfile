FROM php:apache

# MySQLi eta mysql bezeroa instalatu
RUN docker-php-ext-install mysqli && \
    apt-get update && \ 
    apt-get install -y default-mysql-client

COPY apache2.conf /etc/apache2/
COPY talde1.conf /etc/apache2/sites-available/

RUN a2ensite talde1.conf && \
    openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/www.talde1.edu.key -out /etc/ssl/certs/www.talde1.edu.crt -subj "/C=ES/ST=Bizkaia/L=Santurtzi/O=IronChip/OU=SanJorge/CN=SanJorge/emailAddress=ironchip@gmail.com" && \
    a2enmod ssl && \
    a2enmod rewrite && \
    service apache2 restart

# 80 eta 443 atakak erakutsi
EXPOSE 80
EXPOSE 443

# Kontenedorea martxan jarri
CMD ["apache2ctl", "-D", "FOREGROUND"]

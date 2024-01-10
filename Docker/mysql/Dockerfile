FROM mysql:8.2

# .sql scriptak /docker-entrypoint-initdb.d direktorioan kopiatzen dugu
COPY 01WAG2_Erronka_2_BD_script.sql /docker-entrypoint-initdb.d/
# FROGA INSERT GUZTIAK EGIN HEMEN

EXPOSE 3306
# CMD ["mysqld", "--daemonize=0"]
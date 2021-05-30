ARG MYSQL_VERSION=""
FROM mysql:${MYSQL_VERSION:-latest}

ADD dump.sql /docker-entrypoint-initdb.d

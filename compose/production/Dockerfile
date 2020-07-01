FROM node:12
LABEL mantainer "hacklab/ <contato@hacklab.com.br>"
ARG target='prod'

COPY themes /var/www/themes

WORKDIR /var/www/themes/inventores

RUN npm install

RUN chown -R www-data: /var/www/themes

RUN su www-data -s /bin/bash -c 'npm run prod' && rm -rf node_modules;

WORKDIR /var/www/html

FROM hacklab/wordpress:v5.3.2-php7.3

LABEL mantainer "hacklab/ <contato@hacklab.com.br>"

ARG composer='--no-dev'
USER www-data

COPY --from=0 /var/www/themes /var/www/themes

# Insert our data and dependencies
COPY compose/entrypoint-extra /docker-entrypoint-extra
COPY compose/production/wordpress/php/extra.ini /usr/local/etc/php/conf.d/extra.ini
COPY compose/production/wordpress/wp-config.d/ /var/www/html/wp-config.d

COPY wp-content /var/www/html/wp-content
COPY plugins /var/www/plugins
COPY mu-plugins /var/www/mu-plugins


# Fix file permissions
USER root
RUN chown -R www-data: wp-content

RUN a2enmod headers remoteip          \
    && {                              \
        date;                         \
        printf "%-45s %-45s %s";      \
    } > /var/www/html/versioninfo.txt
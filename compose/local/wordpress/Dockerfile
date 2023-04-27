FROM hacklab/wordpress:6.1.1-php7.4

LABEL mantainer "hacklab/ <contato@hacklab.com.br>"

USER www-data

# Insert our data and dependencies
COPY ["compose/entrypoint-extra", "/docker-entrypoint-extra"]

# Fix file permissions
USER root

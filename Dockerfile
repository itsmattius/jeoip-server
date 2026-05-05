FROM ghcr.io/dnj/laravel-alpine:8.1-mysql-nginx

COPY --chown=www-data . /var/www/
RUN composer install --no-dev --prefer-dist --optimize-autoloader && \
	rm -f .env && \
	composer clear-cache

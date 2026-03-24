# ─────────────────────────────────────────
# Imagen base: PHP 8.2 con Apache integrado
# ─────────────────────────────────────────
FROM php:8.2-apache

# Instalar extensión mysqli (necesaria para tu config.php)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Habilitar mod_rewrite de Apache (útil para rutas limpias)
RUN a2enmod rewrite

# Configurar Apache para permitir .htaccess en /var/www/html
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# El código fuente se monta como volumen (ver docker-compose.yml)
# No se copia aquí para facilitar el desarrollo en caliente

EXPOSE 80

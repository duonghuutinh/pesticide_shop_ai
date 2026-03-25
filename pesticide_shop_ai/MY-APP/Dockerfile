# Sử dụng PHP 7.4 (hoặc 8.1 tùy thuộc vào server cũ của bạn) kèm Apache
FROM php:7.4-apache

# Cài đặt các extension kết nối database cơ bản
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Bật mod_rewrite của Apache (cần thiết cho CodeIgniter)
RUN a2enmod rewrite

# Cấu hình AllowOverride All để cho phép .htaccess 
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

# Cấu hình VirtualHost linh hoạt nhận port
RUN echo '<VirtualHost *:${PORT}>\n\
    DocumentRoot /var/www/html\n\
    <Directory /var/www/html>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Copy toàn bộ code CodeIgniter vào container
COPY . /var/www/html/

# Phân quyền cho www-data để có thể ghi log, cache, uploads
RUN chown -R www-data:www-data /var/www/html/

# Khởi tạo entrypoint thay thế cổng lắng nghe mặc định của Apache (80) sang cổng của Render cung cấp ($PORT)
RUN echo '#!/bin/bash\n\
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf\n\
apache2-foreground' > /usr/local/bin/start.sh \
    && chmod +x /usr/local/bin/start.sh

# Chạy Apache
CMD ["/usr/local/bin/start.sh"]

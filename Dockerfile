# 1. اختيار صورة PHP مع Apache (يمكنك تغيير الإصدار مثل 8.2 أو 8.3 حسب نسختك)
FROM php:8.2-apache

# 2. تثبيت الحزم والمتطلبات الأساسية للنظام
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# تنظيف الملفات المؤقتة لتصغير حجم الصورة
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. تثبيت إضافات PHP الضرورية لعمل لارافيل
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. تثبيت أداة إدارة الحزم Composer داخل الحاوية
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. تحديد مجلد العمل داخل الحاوية
WORKDIR /var/www/html

# 6. توجيه Apache إلى مجلد public الخاص بـ Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 7. تفعيل خاصية الـ rewrite لتعمل مسارات لارافيل (Routes) بشكل صحيح
RUN a2enmod rewrite

# 8. نسخ ملفات المشروع إلى داخل الحاوية
COPY . .

# 9. منح الصلاحيات اللازمة لمجلدات التخزين و الكاش في لارافيل
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

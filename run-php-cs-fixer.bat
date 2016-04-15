@echo off
title php-cs-fixer
echo Running php-cs-fixer on specified folders

php C:\Juha\php\php-cs-fixer.phar fix api/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix classes/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/forms/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/admin.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/bio.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/guestbook.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/news.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/photos-live.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/photos-misc.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/photos-promo.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/photos-studio.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/photos.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/releases.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/shop.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/shows.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix templates/videos.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix tests/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix constants.php --level=symfony

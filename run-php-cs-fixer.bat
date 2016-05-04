@echo off
title php-cs-fixer
echo Running php-cs-fixer on specified folders

php C:\Juha\php\php-cs-fixer.phar fix api/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix classes/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix tests/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix constants.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/*/forms/ --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/*/edit/ --level=symfony

php C:\Juha\php\php-cs-fixer.phar fix apps/admin/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/bio/admin/add-member.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/guestbook/admin/add-comment.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/news/admin/add-news.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/photos/admin/add-photos.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/releases/admin/add-release.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/shop/admin/add-shopitem.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/shows/admin/add-show.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/videos/admin/add-video.php --level=symfony

php C:\Juha\php\php-cs-fixer.phar fix apps/guestbook/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/news/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/photos/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/profile/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/releases/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/shop/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/shows/index.php --level=symfony
php C:\Juha\php\php-cs-fixer.phar fix apps/videos/index.php --level=symfony

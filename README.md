# Vortech website 2016
Restful Vortech website with jQuery, Bootstrap and PHP API. Will replace the existing site sometime this year.

## New features
* User login  
* User comments  
* Database-driven model  
* Responsive design  

## Setup
1. Install/use your favourite LAMP/WAMP stack
2. Make sure you have these in /etc/php5/apache2/php.ini: 
  * extension=mysqli.so
  * extension=pdo_mysql.so
3. And in /etc/apache2/apache2.conf:
  * ServerName localhost
  * User vagrant
  * Group vagrant
  * ```<Directory /vagrant/v>  
        Options Indexes FollowSymLinks MultiViews  
        AllowOverride All  
        Order allow,deny  
        allow from all  
        Require all granted  
    </Directory>```
4. In /etc/apache2/ports.conf:
  * Listen 5656
5. In /etc/apache2/sites-enabled/000-default.conf:
  * <VirtualHost *:5656>
  * DocumentRoot /vagrant/v
6. Import the "create_db.sql" file to your database
7. Set your localhost document_root to the project root
8. Launch localhost in your browser of choice

## Todo
* ~~Database access refactoring (OOP)~~  
* ~~Database query refactoring/simplification~~  
* Admin panel and add/edit features across the page  
* User authentication  
* Account creation  
* Commenting system  
* UI design 

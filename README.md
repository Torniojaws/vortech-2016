# Vortech website 2016
Restful Vortech website with jQuery, Bootstrap and PHP API. Will replace the existing site sometime this year.

## New features
* User login  
* User comments  
* Database-driven model  
* Responsive design  

## Setup for Vagrant
1. Install VirtualBox and Vagrant
2. Run "vagrant init ubuntu/trusty64" in the dir you cloned the project to, eg. E:\web\project\
3. Then "vagrant up"
4. When the box is running, connect to it with SSH (eg. PuTTY) with username "vagrant" and pass "vagrant"
5. Then cd to "/vagrant" and you'll see the project files there
6. Then run the following:

   `sudo apt-get install apache2`  
   `sudo apt-get install mariadb-server`  
   `sudo apt-get install php5`  

7. Then configure some details
8. Give the command `echo "ServerName localhost" | sudo tee /etc/apache2/conf-available/servername.conf`
9. Then edit `/etc/apache2/apache2.conf` and add this to the listing with `<Directory>` to enable pretty urls eg. localhost/news

   ```
     <Directory /vagrant/>  
         Options Indexes FollowSymLinks MultiViews  
         AllowOverride All  
         Order allow,deny  
         allow from all  
         Require all granted  
     </Directory>  
   ```

10. Then add the site with `cd /etc/apache2/sites-available` and `sudo cp 000-default.conf vortech.conf`
11. Edit the config next `sudo vim vortech.conf` and modify to:  

   `ServerName localhost`
   `DocumentRoot /vagrant/`

12. And finally, give the command `sudo a2ensite vortech.conf` to enable the site
13. Then enable rewrites with `sudo a2enmod rewrite && sudo service apache2 restart`
14. Now, install the mysql module to php5 to enable PDO use: `sudo apt-get install php5-mysql`
14. Add this line to `/etc/php5/apache2/php.ini` under the extensions part:

  `extension=pdo_mysql.so`

15. Then install GD for resizing thumbnails in the Photos section:  
    `sudo apt-get install php5-gd && sudo service apache2 restart`
16. Now run `mysql -u root`
17. Then import the "create_db.sql" file to your database with `source setup/create_db.sql;`
18. Now open the site with you browser from `http://localhost:5656`
 * Note that if your Vagrant redirects port 5656 to 80 in guest, change the definition in `constants.php` first

## Tests
* You can run tests with PHPUnit in the root dir with `phpunit tests`. It works the best when used within Vagrant. Sometimes Windows cannot access all the database features

## Todo
* ~~Database access refactoring (OOP)~~  
* ~~Database query refactoring/simplification~~  
* ~~Admin panel and add/edit features across the page~~  
* ~~User authentication~~  
* ~~Account creation~~  
* Admin can ban users
* Commenting system  
* UI design

## Lessons learned
* You cannot parametrize the DB column in PDO prepared statement.  

  ```
  // This is not allowed  
  $sql = 'UPDATE table SET :column = :value';  
  $params = array('column' => $column, 'value' => $value);  
  ```

  Use a switch or if..else instead:  

  ```
  switch ($column) {  
      case 'id':  
          $sql_example = 'UPDATE table SET id = :value';  
          break;  
      case 'username':  
          $sql_example = 'UPDATE table SET username = :value';  
          break;
  }  
  $query['params'] = array('value' => $value);
  ```

* You cannot use the same parameter name twice in a PDO prepared statement.

  ```
  // This is not allowed  
  $sql = 'UPDATE table SET username = :username WHERE username = :username';  
  $query['params'] = array('username' => $username);  
  ```

  Just rename them in the array:
    `$query['params'] = array('username' => $username, 'user' => $username)`
* You cannot use GET parameters when checking file_exists().

  ```
  file_exists('path/to/file.php'); // true
  file_exists('path/to/file.php?page=2'); // false
  ```

  Send them separately instead:  

  ```
  if(file_exists('path/to/file.php')) {
      $_GET['page'] = 2;
  }
  ```
* When updating a value that is also used for identifying a DB row, you should also send the old value in a hidden field (for example).
Otherwise it won't find the row because the value has (obviously) changed.

  ```
  // This does not work  
  $sql = 'UPDATE table SET username = :new_username WHERE username = :username';  
  $query['params'] = array('new_username' => $username, 'username' => $username);  
  ```

  instead, use a separate value:

    ```
    $sql = 'UPDATE table SET username = :new_username WHERE username = :old_username';  
    $query['params'] = array('new_username' => $new_username, 'old_username' => $old_username);  
    ```

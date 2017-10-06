![image](https://travis-ci.org/ilabafrica/iBLIS.svg?branch=master)

BLIS
=====

BLIS is a port of the Basic Laboratory Information System ([BLIS](https://github.com/C4G/BLIS)) to the Laravel PHP Framework by [@iLabAfrica](http://www.ilabafrica.ac.ke/).
BLIS was originally developed by C4G. 

You can test and view the application [here](http://blis.ilabafrica.ac.ke:8080/).

Requirements (Linux)
------------
1. Supported database. Currently only [MySQL](http://dev.mysql.com/downloads/mysql) has been tested. Laravel also supports PostgreSQL, SQLite and SQL Server.
2. [PHP >= 5.4](http://php.net).
3. [Composer](https://getcomposer.org) - Dependency manager for PHP.
4. [git](https://git-scm.com/) - Git is a free and open source distributed version control system

Installation
-----------
##### DOCKER
The easiest way to install is using docker, follow instruction [here](https://github.com/ilabafrica/iblis-contrib-docker) to install via docker. 

##### FROM SOURCE (Linux)

1. Install the above mentioned requirements.
2. Extract this git repository to a local folder by running the following shell command.
    <blockquote>git clone git@github.com:APHLK/BLIS.git </blockquote>
    This will create a folder called `BLIS`. Henceforth we'll refer to this folder as `<APP_HOME>`.
3. Change your directory to `<APP_HOME>`. Update **composer** then run it in order to install the application dependencies. You may need root permissions to update `composer`. Run the following commands on the Linux terminal.
    <blockquote>
      composer self-update<br />
      composer install
    </blockquote>
4. Update the application configuration files to suit your local settings:
  - Set the "Application URL" in `<APP_HOME>/app/config/app.php`
  - Create a database and set the database connection details in `<APP_HOME>/app/config/database.php`
  - The organization name in `<APP_HOME>/app/config/kblis.php`

5. Run the migrations to create the required database tables.
    <blockquote>php artisan migrate</blockquote>
6. Load the basic seed data
    <blockquote> php artisan db:seed </blockquote>
   If #5 or #6 above fails, you may need to run the following command then repeat the above two commands again.
    <blockquote> composer dumpautoload </blockquote>
7. If you are running the application on a webserver eg. apache, ensure that the webserver has write permissions to the `<APP_HOME>/app/storage` folder.
   The web-root should be the `<APP_HOME>/public` folder.

   See below a sample apache *namedhost* virtualhost configuration file.
   ````
   <VirtualHost *:80>
        ServerName blis

        ServerAdmin blisadmin@myorganization.me
        DocumentRoot /var/www/BLIS/public

        <Directory /var/www/BLIS/public>
                Options Indexes MultiViews FollowSymLinks
                AllowOverride All
                Require all granted
        </Directory>

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

    </VirtualHost>
    ````
   
 8. The default login credentials are '*administrator*' '*password*'.

Troubleshooting
----------------
1. Routing failures: Ensure that you enable mod_rewrite, `sudo a2enmod rewrite` if you are using apache. Perform the analogous action if using another web server.

Road Map
---------

#|Feature|Release Date
-|-|-
1.| Create a core API availing all functionality| June 2018
2.| HTML/CSC/Javascript front end | June 2018
3.| Use [Mirth](https://www.mirth.com/) for instrument interfaces | June 2018
4.| Update documentation| Continuous

Collaboration
--------------
We welcome all forms of collaboration: coding, testing, documentation (writing/proof reading), feature/enhancement suggestions, ... Please review our contribution guidelines on the [wiki page](https://github.com/APHLK/BLIS/wiki).

1. Review the [issue list](https://github.com/APHLK/BLIS/issues) for an issue you wish to resolve or create a new issue for a bug or enhancement.
2. Create a branch
3. Resolve the issue
4. Send us a pull request

![image](https://travis-ci.org/ilabafrica/iBLIS.svg?branch=master)

kBLIS
=====

kBLIS is a port of the Basic Laboratory Information System (<a href="https://github.com/C4G/BLIS">BLIS</a>) to the Laravel PHP Framework by iLabAfrica.
BLIS was originally developed by C4G. 

Requirements
------------
1. Supported database. Currently only <a href='http://dev.mysql.com/downloads/mysql/'>MySQL</a> has been tested. Laravel also supports PostgreSQL, SQLite and SQL Server.
2. <a href='http://php.net/'>PHP</a> (>= 5.4).
3. <a href='https://getcomposer.org/'>Composer</a> - Dependency manager for PHP.

Quick Start
-----------
1. Install the above mentioned requirements.
2. Extract this git repository to a local folder
    <blockquote>git clone git@github.com:ilabafrica/iBLIS.git </blockquote>
3. Change directory to the root folder of the application. Update **composer** then run it in order to install the application dependencies. You may need root permissions to update composer.
    <blockquote>
      composer self-update<br />
      composer install
    </blockquote>
4. Update the application configuration files to suit your local settings:
  - Set the "Application URL" in `/app/config/app.php`
  - Set the database connection details in `/app/config/database.php`
  - The organization name in `/app/config/kblis.php`

5. Run the migrations to create the required database tables.
    <blockquote>php artisan migrate</blockquote>
6. Load the basic seed data
    <blockquote> php artisan db:seed </blockquote>
   If #5 or #6 above fails, you may need to run the following command then repeat the two commands again.
    <blockquote> composer dumpautoload </blockquote>
7. If you are running the application on a webserver eg. apache, ensure that the webserver has write permissions to the /app/storage folder.
   Ideally the web-root should be the /public folder.
   The default login credentials are '*administrator*' '*password*'.

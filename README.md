kBLIS
=====

kBLIS is a port of the Basic Laboratory Information System (<a href="https://github.com/C4G/BLIS">BLIS</a>) to the Laravel PHP Framework by iLabAfrica.
BLIS was originally developed by C4G. 

Quick Start
-----------
1. Ensure you have Laravel already setup
2. Extract the git repository to a local folder
3. Update the application configuration files to suit your local settings:
  <ul>
    <li>Set the "Application URL" in /app/config/app.php</li>
    <li>Set the database connection details in /app/config/database.php</li>
    <li>The organization name in /app/config/kblis.conf</li>
</ul>
4. Run the migrations to create the required database tables.
    <blockquote>php artisan migrate</blockquote>
5. Load the basic seed data
    <blockquote> php artisan db:seed </blockquote>
   The default login is 'administrator' 'password'.

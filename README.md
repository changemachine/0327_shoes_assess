
# Shoe Stores for Epicodus
## by James Nielson
#### Date: March 27, 2015

A program to add and view local shoe stores and the brands of shoes they carry.  Or conversely, add or select a brand and see who carries it.


    ##Technologies Used
    - PHP
    - PHPUNIT
    - SILEX
    - TWIG
    - POSTGRES
    - PSQL
    - Composer


    ##Use and Editing
    To use the app, download the source code and run it in on your php server.
    [PHP Installation] (http://php.net/manual/en/install.general.php)
    [PostGres Installation](https://www.learnhowtoprogram.com/lessons/postgres-with-php-weekend-homework)
    *If you are copying any of the code to your own directories, you may need to install Composer in your root directory.*

    ###DATABASE GENERATION
    ##### shoes[stores[id, 'name'], brands[id, 'brand'], shoes_stores[id, store_id, brand_id]]<br />

    To create the database from the included sql file, open a command-line window to the project root and start psql. Then create the database 'shoes' and /c into it. Now import the sql data with the \i command and the name of the sql file.

    ```sql
    CREATE DATABASE shoes;
    \c shoes;
    \i shoes.sql;
    ```

    Alternatively, create the working and test databases using the following series of commands: <br/>

    ```sql
    CREATE DATABASE shoes;
    \c shoes;
    CREATE TABLE stores (id serial PRIMARY KEY, name varchar);
    CREATE TABLE brands (id serial PRIMARY KEY, brand varchar);
    CREATE TABLE stores_brands (id serial PRIMARY KEY, store_id int, brand_id int);
    CREATE DATABASE shoes_test WITH TEMPLATE shoes;
    \c shoes_test;
    ```


    #### Copyright © 2015, James Nielson
    #### License: [MIT](https://github.com/twbs/bootstrap/blob/master/LICENSE")

    #### No guarantees, no promises.  Don't use it for evil.


# Library Catlog for Epicodus
## by James Nielson
#### Date: March 27, 2015


A program to list out local shoe stores and the brands of shoes they carry.

When viewing by store, list out all of the brands at that store, and allow user to add a brand to that store.

<!-- A "getBrandsByStore" method, using a join statement.

When viewing a single brand, a getStores method for that brand.
addStore method for brands. Use a join statement.
-->


## DATABASE GENERATION
#### shoes[stores[id, 'name'], brands[id, 'brand'], shoes_stores[id, store_id, brand_id]]
    CREATE DATABASE shoes;
    \c shoes;
    CREATE TABLE stores (id serial PRIMARY KEY, name varchar);
    CREATE TABLE brands (id serial PRIMARY KEY, brand varchar);
    CREATE TABLE stores_brands (id serial PRIMARY KEY, store_id int, brand_id int);
    CREATE DATABASE shoes_test WITH TEMPLATE shoes;
    \c shoes_test;

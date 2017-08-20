<?php

/**
 * Configuration for: Database Connection
 *
 * For more information about constants please @see http://php.net/manual/en/function.define.php
 * If you want to know why we use "define" instead of "const" @see http://stackoverflow.com/q/2447791/1114320
 *
 * DB_HOST: database host, usually it's "127.0.0.1" or "localhost", some servers also need port info
 * DB_NAME: name of the database. please note: database and database table are not the same thing
 * DB_USER: user for your database. the user needs to have rights for SELECT, UPDATE, DELETE and INSERT.
 * DB_PASS: the password of the above user
 */

//Local Config
/*
define("DB_HOST", "localhost");
define("DB_NAME", "agenda");
define("DB_USER", "root");
define("DB_PASS", "");
*/

//AWS Config
define("DB_HOST", "tnr-agenda.cnkwtaxccbcp.us-west-2.rds.amazonaws.com");
define("DB_PORT", "3306");
define("DB_NAME", "tnr_agenda");
define("DB_USER", "tnrdb");
define("DB_PASS", "cloudufc2016");

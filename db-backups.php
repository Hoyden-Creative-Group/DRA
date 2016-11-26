<?php

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
  define('ABSPATH', dirname(__FILE__) . '/');


// pull in environment variables
require_once(ABSPATH . 'env.php');

$datestamp = date("Y-m-d");
$dbhost   = 'localhost';
$dbuser   = DB_USER;
$dbpass   = DB_PASSWORD;
$dbname   = DB_NAME;
$dir      = DB_BACKUP_DIR;

$filename = $dir . "backup-$datestamp.sql.gz";

$command = "mysqldump -u $dbuser --password=$dbpass $dbname | gzip > $filename";
$result = passthru($command);

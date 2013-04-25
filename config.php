<?php

ini_set('display_errors', 1); // TODO: remove me on production

// datadabase connection settings
$conf['db']['host'] = 'localhost';
$conf['db']['user'] = 'root';
$conf['db']['pass'] = '1234';
$conf['db']['dbname'] = 'test';
$conf['db']['debug'] = false;

// global app settings
$conf['appNamespace'] = 'AdSerf'; // we need this to avoid putting controllers/models classes into global namespace or adding extra directories into autoloading

return $conf;
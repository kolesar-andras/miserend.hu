#!/usr/bin/env php
<?php

use Illuminate\Database\Capsule\Manager as DB;

require 'vendor/autoload.php';
include_once('functions.php');
include_once('config.php');

dbconnect();
$result = DB::table('information_schema.tables')
        ->where('table_type', "=", 'BASE TABLE')
        ->where('table_schema', '=', $config['connection']['database'])
        ->count();
if ($result) {
	$output = sprintf("Database '%s' is not empty.\n",
		$config['connection']['database']
	);
} else {
    $command = sprintf('MYSQL_PWD=%s mysql -h %s -u %s %s < %s 2>&1',
		escapeshellarg($config['connection']['password']),
		escapeshellarg($config['connection']['host']),
		escapeshellarg($config['connection']['user']),
		escapeshellarg($config['connection']['database']),
		'mysql_sample.sql'
	);
    $output = shell_exec($command);
}
fwrite(STDERR, $output);

if (!is_dir('fajlok')) {
	mkdir('fajlok');
	mkdir('fajlok/templomok');
    mkdir('fajlok/igenaptar');
	mkdir('fajlok/staticmaps');
}
if (!is_dir('kepek')) {
	mkdir('kepek');
	mkdir('kepek/templomok');
}

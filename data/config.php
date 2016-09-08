<?php

use Docs\Config;

$default = [
    'nginx_sendFile' => 'off',
    'app_name' => 'docs',
    'phpfpm_www_maxmemory' => '16M', 
];

$socketDir = '/var/run/php-fpm';

$centos = [
    'nginx_log_directory' => '/var/log/nginx',
    'nginx_root_directory' => '/usr/share/nginx',
    'nginx_conf_directory' => '/etc/nginx',
    'nginx_run_directory' => '/var/run',
    'nginx_user' => 'nginx',
    'nginx_sendFile' => 'off',

    'docs_root_directory' => dirname(__DIR__),

    'phpfpm_maxmemory' => '16M',
    'phpfpm_user' => 'docs',
    'phpfpm_group' => 'www-data',
    'phpfpm_socket_directory' => $socketDir,
    'phpfpm_conf_directory' => '/etc/php-fpm.d',
    'phpfpm_pid_directory' => '/var/run/php-fpm',

    'phpfpm_fullsocketpath' => $socketDir."/php-fpm-docs-".basename(dirname(__DIR__)).".sock",

    'php_conf_directory' => '/etc/php',
    'php_log_directory' => '/var/log/php',
    'php_errorlog_directory' => '/var/log/php',
    'php_session_directory' => '/var/lib/php/session',

    'ssl_directory' => '/temp/ssl',
    
    'MYSQL_PORT' => 3306,
    'MYSQL_USERNAME' => 'intahwebz',
    'MYSQL_PASSWORD' => 'pass123',
    'MYSQL_ROOT_PASSWORD' => 'pass123',
    'MYSQL_SERVER' => null,
    'MYSQL_SOCKET_CONNECTION' => '/var/lib/mysql/mysql.sock',
    'SESSION_NAME' => 'irsession',
];





$centos_guest = $centos;
//this doesn't work in vagrant on virtualBox
$centos_guest['nginx_sendFile'] = 'off'; 


$dev = [
    Config::LIBRATO_STATSSOURCENAME => 'docs.test',    
    Config::JIG_COMPILE_CHECK => \Jig\Jig::COMPILE_ALWAYS,
    Config::SCRIPT_PACKING => false
];

$live = [
    Config::LIBRATO_STATSSOURCENAME => 'docs.com',
    Config::JIG_COMPILE_CHECK => \Jig\Jig::COMPILE_CHECK_EXISTS,
    Config::SCRIPT_PACKING => true
];


$perf = [
    Config::JIG_COMPILE_CHECK => \Jig\Jig::COMPILE_CHECK_EXISTS,
];


<?php
session_start();

define('BASEPATH', __DIR__ . '/');
define('APPPATH', BASEPATH . '/application/');

require_once(BASEPATH . 'system/config.php');
require_once(BASEPATH . 'system/routing.php');
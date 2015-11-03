<?php

define('PATH_TO_ROOT', '..');

require_once PATH_TO_ROOT . '/kernel/init.php';

$url_controller_mappers = array(
	
	new UrlControllerMapper('WikiEIController')
);

DispatchManager::dispatch($url_controller_mappers);


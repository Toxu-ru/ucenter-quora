<?php

$aws_plugin = array(
	'title' => 'External for Anwsion',	// Назв. подключение
	'version' => 20130107,	// Номер версии
	'description' => 'Anwsion',	// Описание
	'requirements' => '20120706',	// Build
	
	'contents' => array(
		// Контроллер (setup)
		'setups' => array(
			
		),
	
		// Action
		'actions' => array(
		
		),
		
		// Model,  $this->model('name') 
		'model' => array(
			'class_name' => 'aws_offical_external_class',	// Model name,  _class
			'include' => 'aws_offical_external.php',	// Введение
		),
	),
);

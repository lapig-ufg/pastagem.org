<?php

	define( '_JEXEC', 1 );
	define('JPATH_BASE', dirname(__FILE__));
	define( 'DS', DIRECTORY_SEPARATOR );

	require_once (JPATH_BASE . DS . 'includes' . DS . 'defines.php');
	require_once (JPATH_BASE . DS . 'includes' . DS . 'framework.php');

	//$siteName = 'Laboratório de Processamento de Imagens e Geoprocessamento';
	$mainframe = JFactory::getApplication('site');
	$mainframe->initialise();

	$user =& JFactory::getUser();

	//echo var_dump($user);
	echo 		'{' 
			.	'"name":"' . $user->name . '",'
			.	'"email":"' . $user->email . '"'
			.	'}';

?>

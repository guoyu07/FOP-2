<?php

function dump($var) {
	echo '<pre>';
	var_dump($var);
	echo '</pre>';
}

include_once('../FOP.php');

$config = array();
$config['templatesRoot'] = dirname(__FILE__).'/templates/';
$config['fopConfXMLRoot'] = dirname(__FILE__).'/fop.conf';
$config['debug'] = true;


$FOP = new FOP($config);
$version = $FOP->getVersion();
$is_installed = $FOP->isInstalled();
$configuration = $FOP->getConfiguration();

//var_dump($version);
//var_dump($is_installed);
//var_dump($configuration);

$FOP
	->setData('var', 'hello world')
	->setTemplateName('example.xsl')
	->renderAndFlush('report')
;
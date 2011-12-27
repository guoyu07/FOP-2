<?php

require_once 'PHPUnit/Autoload.php';
require_once 'FOP.php';

/**
 * Tests for FOP
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.1.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.1.0
 */


class FOPTest extends PHPUnit_Framework_TestCase {

	private static $_FOP;

	public static function setUpBeforeClass() {
		$config = array();
		$config['templatesRoot'] = realpath(dirname(__FILE__).'/../').'/examples/templates/';
		self::$_FOP = new FOP($config);
	}

	public function testIsInstalled() {
		$this->assertTrue(self::$_FOP->isInstalled());
	}

	public function testGetVersion() {
		$version = self::$_FOP->getVersion();
	}

	public function testRender() {
		$file_path = self::$_FOP
			->setData('var', 'hello world')
			->setTemplateName('example.xsl')
			->render('report')
		;
		$this->assertTrue(file_exists($file_path));
	}

}
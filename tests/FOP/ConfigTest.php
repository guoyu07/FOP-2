<?php

require_once 'PHPUnit/Autoload.php';
require_once 'FOP.php';

/**
 * Tests for FOP_Config
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.1.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.1.0
 */

class FOP_ConfigTest extends PHPUnit_Framework_TestCase {

	private $_Config;

	public function setUp() {
		$config = array();
		$config['templatesRoot'] = '/templates/';
		$config['libraryRoot'] = '/path/to/library/';
		$config['debug'] = true;

		$this->_Config = FOP_Config::getInstance();
		$this->_Config->init($config);
	}

	public function testGet() {
		$this->assertTrue($this->_Config->debug);
		$this->assertEquals('downloaded', $this->_Config->downFilename);
	}

	/**
	 * @depends testGet
	 */
	public function testSet() {
		$this->_Config->debug = false;
		$this->assertFalse($this->_Config->debug);
		$this->_Config->templatesRoot = '/path/to/templates/';
		$this->assertEquals('/path/to/templates/', $this->_Config->templatesRoot);
	}

	/**
	 * @depends testGet
	 */
	public function testToArray() {
		$expected = array(
			'libraryRoot'=>'/path/to/library/',
			'templatesRoot'=>'/templates/',
			'tmpRoot'=>'/tmp/',
			'fopConfXMLRoot'=>'',
			'pathToFOP'=>'',
			'downFilename'=>'downloaded',
			'debug'=>true
		);
		$this->assertEquals($expected, $this->_Config->toArray());
	}

	public function tearDown() {}

}
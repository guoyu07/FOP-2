<?php

require_once 'PHPUnit/Autoload.php';
require_once 'FOP.php';

/**
 * Tests for FOP_XML
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.1.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.1.0
 */

class FOP_XMLTest extends PHPUnit_Framework_TestCase {

	/**
	 * @expectedException FOP_Exception
	 */
	public function testSetData() {
		$XML = new FOP_XML();
		$XML->setData('35', 'value');
	}

	public function testSave() {
		$XML = new FOP_XML();
		$XML->setData('var', 'value');
		$filePath = $XML->save();
		$this->assertTrue(file_exists($filePath));
	}

}
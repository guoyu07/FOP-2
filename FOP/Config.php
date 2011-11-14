<?php

/**
 * FOP
 *
 * Copyright (c) 2011, Sasha Bereka <tender.post@gmail.com>.
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 *
 *   * Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 *
 *   * Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 *
 *   * Neither the name of Sasha Bereka nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package   FOP
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @since     File available since Release 1.0.0
 */

/**
 * FOP_Config contains default config values
 * default config values should not be changed
 * use FOP::__construct($config) parameter to change default config values
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.0.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.0.0
 */

class FOP_Config {

    public $libraryRoot;
    /**
     * path to xsl templates
     * @var string
     */
	public $templatesRoot = '';
    /**
     * path to temporary generated pdf files
     * @var string
     */
	public $tmpRoot = '/tmp/';
	/**
	 *path to additional xml config file
	 *specifies location for custom fonts
	 * @var string
	 */
	public $fopConfXMLRoot = '';
    /**
     * path to fop application
     * @var string
     */
	public $pathToFOP = '';
    /**
     * default name of generated pdf file
     * @var string
     */
	public $downFilename = 'downloaded';
	public $debug = false;

    protected static $_instance;

    protected function __construct() {
        $this->libraryRoot = realpath(dirname(__FILE__).'/../').'/';
    }

	protected function __clone() {}

	public static function getInstance() {
		if (!self::$_instance instanceof self) {
			self::$_instance = new self;
		}
		return self::$_instance;
	}

	public function __set($name, $value) {
		if (!isset($this->$name)) {
			throw new FOP_Exception('FOP config property "'.$name.'" doesn\'t exist', 1003);
		}		
		$this->$name = $value;
	}

	public function init($config = array()) {
		if (!is_array($config) or !count($config)) {
			return;
		}
		foreach ($config as $name=>$value) {
			$this->$name = $value;
		}
	}

	public function toArray() {
		return get_object_vars(self::$_instance);
	}

}
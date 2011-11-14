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
 * FOP_XSL is used for getting and checking FOP input xsl file
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.0.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.0.0
 */

class FOP_XSL {

    protected $_folder;
    protected $_filename;

    public function __construct() {
        $this->_initFolder();
    }    

    /**
     * @return string
     */
    public function getFolder() {
        return $this->_folder;
    }

    /**
     * @param string $filename
     */
    public function setFilename($filename) {
        $this->_filename = $filename;
    }

    /**
     * @return string
     */
    public function getFilename() {
        return $this->_filename;
    }

    private function _initFolder() {
        $Config = FOP_Config::getInstance();
        $this->_folder = $Config->templatesRoot;
	    if (!is_dir($this->_folder)) {
			throw new FOP_Exception('Can\'t find pdf templates directory "'.$this->_folder.'"', 1005);
	    }
    }

    /**
     * Return file path to xsl template
     * @return string
     */
    public function getFilePath() {
        return $this->getFolder().$this->getFilename();
    }
	
	public function isValid() {
		if (is_file($this->getFilePath())) {
			return true;
		}
		return false;
	}

}
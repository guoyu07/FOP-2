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
 * FOP_XML is used for creating FOP input xml file
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.0.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.0.0
 */

class FOP_XML {

    protected $_output;
	protected $_folder;
	protected $_filename;

    function __construct() {
        $this->_initFolder();
        $this->_initFilename();
		$this->_output = new DOMDocument("1.0", "ISO-8859-1");
		$rootNode = $this->_output->createElement("document");
		$this->_output->appendChild($rootNode);
        $this->setData('templatesRoot', FOP_Config::getInstance()->templatesRoot);
	}

    /**
     * @param string $tag
     * @param mixed $data
     */
    public function __set($tag, $data) {
		$this->setData($tag, $data);
	}

	/**
	 * Stores data for pdf  template
     * @param string $tag
     * @param mixed $data
     */
    public function setData($tag, $data, $escaping = true) {
	    if (is_object($data)) {
			$this->_assignArray($this->_output->firstChild, $tag, (array) $data, $escaping);
	    } elseif (is_array($data)) {
			$this->_assignArray($this->_output->firstChild, $tag, $data, $escaping);
		} else {
			$this->_assignVar($this->_output->firstChild, $tag, $data, $escaping);
		}
	}

	/**
	 * get filepath of generated xml data file
     * @return string
     */
    public function getFilePath() {
        return $this->getFolder().$this->getFilename();
    }

    public function getFolder() {
        return $this->_folder;
    }

    public function getFilename() {
        return $this->_filename;
    }

	/**
	 * saves stored data into xml file and returns xml file path
	 * @throws FOP_Exception
	 * @return string
	 */
    public function save() {
	    if (!is_writable($this->_folder) and !chmod($this->_folder, 0777)) {
		    throw new FOP_Exception('Directory "'.$this->_folder.'" for storing xml data file is not writable', 1006);
	    }
        $this->_output->save($this->getFilePath());
	    if (!is_file($this->getFilePath())) {
            throw new FOP_Exception('Can\'t find xml data file: "'.$this->getFilePath().'"', 1007);
        }
	    return $this->getFilePath();
	}

	private function _assignVar($parentElement, $tagName, $data, $escaping) {
		$this->_checkTagName($tagName);
		if (is_numeric($data) or !$escaping) {
			$node = $this->_output->createElement($tagName, $data);
		} else {
			$CDATA = $this->_output->createCDATASection($data);
			$node = $this->_output->createElement($tagName);
			$node->appendChild($CDATA);
		}
		$parentElement->appendChild($node);
	}

	private function _assignArray($parentElement, $tagName, $data, $escaping) {
		$this->_checkTagName($tagName);
		$node = $this->_output->createElement($tagName);
		foreach ($data as $index => $value) {
			$tagName = (is_numeric($index))?  'item' : $index;
			if (is_array($value) or is_object($value)) {
				$this->_assignArray($node, $tagName, $value, $escaping);
			} else {
				$this->_assignVar($node, $tagName, $value, $escaping);
			}
		}
		$parentElement->appendChild($node);
	}

	private function _checkTagName($tagName) {
		if (preg_match("/(?:^(?:(?:xml)|(?:[^a-z])))|(?:[<>&'\"\s])/i",$tagName)) {
			throw new FOP_Exception('Variable name "'.$tagName.'" is invalid', 1004);
		}
	}

	/**
	 * in case if directory for storing xml data doesn't exist, attempts to create it
	 * @throws FOP_Exception
	 * @return void
	 */
    private function _initFolder() {
        $this->_folder = FOP_Config::getInstance()->tmpRoot;
	    if (!is_dir($this->_folder) and !mkdir($this->_folder, 0777, true)) {
			throw new FOP_Exception('Directory "'.$this->_folder.'" for storing xml data file doesn\'t exist and can\'t be created', 1005);
	    }
    }

    private function _initFilename() {
        $this->_filename = 'fop_'.str_replace('.', '', microtime('true')).'.xml';
    }

}
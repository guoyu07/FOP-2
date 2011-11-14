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

$current_dir = dirname(__FILE__).'/';
include_once($current_dir . 'FOP/Config.php');
include_once($current_dir . 'FOP/XML.php');
include_once($current_dir . 'FOP/XSL.php');
include_once($current_dir . 'FOP/Exception.php');

/**
 * FOP is php wrapper for Apache FOP application
 * Generates pdf files using xsl template
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.0.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.0.0
 */

class FOP {

    private $_xml;
    private $_xsl;

    public function __construct($config = array()) {
		$this->_initConfig($config);
        $this->_initXML();
        $this->_initXSL();
    }

	private function _initConfig($config = array()) {
		$Config = FOP_Config::getInstance();
		$Config->init($config);
	}

    private function _initXML() {
        $this->_xml = new FOP_XML();
    }

    private function _initXSL() {
        $this->_xsl = new FOP_XSL();
    }

	/**
	 * Checks if Apache FOP application is installed on server
	 * @return bool
	 */
	public function isInstalled() {
		try {
			$this->getVersion();
		} catch(FOP_Exception $e) {
			return false;
		}
		return true;
	}

	/**
	 * Returns Apache FOP application version
	 * @throws FOP_Exception
	 * @return   string
	 */
	public function getVersion() {
		$cmd = 'fop -v 2>&1';
		exec($cmd, $output);
		if (!count($output)) {
			throw new FOP_Exception('command output is empty', 1001);
		}
		foreach ($output as $line) {
			if (preg_match('~FOP Version ([\d\.]+)~', $line, $matches)) {
				return $matches[1];
			}
		}
		throw new FOP_Exception('can\'t get Apache FOP version', 1002);
	}

	/**
	 * Returns configuration parameters
	 * @return  array
	 */
	public function getConfiguration() {
		$Config =  FOP_Config::getInstance();
		return $Config->toArray();
	}

    /**
     * Stores data for pdf template
     * @param string $var
     * @param mixed $value
     * @return FOP
     */
    public function setData($var, $value, $escaping = true) {
        $this->_xml->setData($var, $value, $escaping);
        return $this;
    }

    /**
     * Set xsl template name to use when generating pdf
     * @param string $templateName
     * @return FOP
     */
    public function setTemplateName($template_name) {
        $this->_xsl->setFilename($template_name);
        return $this;
    }

    /**
     * Returns path to rendered pdf file
     * @throws FOP_Exception
     * @return string
     */
    public function render() {
        $Config = FOP_Config::getInstance();
        $pdf_file_path = $Config->tmpRoot.$this->_renderTmpPDFFilename();
        if (!$this->_xsl->isValid()) {
            throw new FOP_Exception('Can\'t find xsl template file: "'.$this->_xsl->getFilePath().'"', 1008);
        }
        $xml_file_path = $this->_xml->save();
        if ($Config->fopConfXMLRoot and is_file($Config->fopConfXMLRoot)) {
	        $conf = '-c '.$Config->fopConfXMLRoot;
        }
        $bash = $Config->pathToFOP.'fop '.$conf.' -xml '.$xml_file_path.' -xsl '.$this->_xsl->getFilePath().' -pdf '.$pdf_file_path.' 2>&1';
        exec($bash, $output);
        unlink($xml_file_path);
	    if (!file_exists($pdf_file_path)) {
			$this->_processOutput($output);
        }
        return $pdf_file_path;
    }

    private function _processOutput($output) {
	    if (!count($output)) {
		    return;
	    }
	    $output_error = "";
		if (FOP_Config::getInstance()->debug) {
			$write_error = false;
			foreach ($output as $line) {
				if (strpos($line, 'Fatal Error') !== false) {
					$write_error = true;
				}
				if (strpos($line, 'SEVERE: Exception') !== false) {
					$write_error = false;
				}
				if ($write_error) {
					$output_error .= $line." \n";
				}
			}
		}
		$exception_message = 'Rendering pdf error';
		if ($output_error) {
			$exception_message .= ":\n".$output_error;
		}
		throw new FOP_Exception($exception_message, 1009);
    }

    /**
     * Render and flush pdf file
     * @throws FOP_Exception
     * @param string $filename
     */
    public function renderAndFlush($filename = '') {
        if (empty($filename)) {
            $filename = FOP_Config::getInstance()->downFilename;
        }
        $this->flush($this->render(), $filename);
    }

	/**
	 * Flush pdf file
	 * @param string  $pdfFilePath
	 * @param string  $filename
	 * @return void
	 */
	public function flush($pdfFilePath, $filename) {
		header("Content-type:application/pdf");
        header("Content-Disposition:attachment;filename=$filename.pdf");
        readfile($pdfFilePath);
        die();
	}

    private function _renderTmpPDFFilename() {
        return 'fop_'.str_replace('.', '', microtime('true')).'.pdf';
    }

}
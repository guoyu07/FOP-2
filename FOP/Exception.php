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
 * Exception codes:
 * 1001 - Command output is empty
 * 1002 - Can't get Apache FOP version
 * 1003 - FOP config property doesn't exist
 * 1004 - Variable name for pdf template is invalid
 * 1005 - Directory for storing xml data file doesn't exist and can't be created
 * 1006 - Directory for storing xml data file is not writable
 * 1007 - Can't find xml data file
 * 1008 - Can't find xsl template file
 * 1009 - Rendering pdf error
 *
 * @author    Sasha Bereka <tender.post@gmail.com>
 * @copyright 2011 Sasha Bereka <tender.post@gmail.com>
 * @license   http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version   Release: 1.0.0
 * @link      http://github.com/sashabereka/FOP/tree
 * @since     Class available since Release 1.0.0
 */

class FOP_Exception extends Exception {}
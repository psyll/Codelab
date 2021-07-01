<?php
/*
	CODELAB
	© Jaroslaw Szulc <jarek@psyll.com>
	© Psyll.com <info@psyll.com>
	This file is part of the Codelab package.
    Distributed under the PPCL license (http://psyll.com/license/ppcl)
*/
if (session_status() === PHP_SESSION_NONE):
    session_start();
endif;
echo '<pre>';
echo '</pre>';
if (!isset($_SESSION[clPackages['session']['config']['sessionName']])):
    $_SESSION[clPackages['session']['config']['sessionName']] = array();
endif;

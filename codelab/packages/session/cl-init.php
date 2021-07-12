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
if (!isset($_SESSION[CL_PACKAGES['session']['config']['sessionName']])):
    $_SESSION[CL_PACKAGES['session']['config']['sessionName']] = array();
endif;

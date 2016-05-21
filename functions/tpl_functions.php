<?php
function tpl_show($tpl_file,$layout='default')
{
	global $PageVars;
	$tpl_file=TPL_PATH.DS.'tpl'.DS.$tpl_file.'.html';
	require TPL_PATH.DS.'layout'.DS.$layout.'.html';
	exit;
}
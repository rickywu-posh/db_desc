<?php
session_start();
define('DS',DIRECTORY_SEPARATOR);
define('APP_PATH',dirname(__FILE__));
define('TPL_PATH',dirname(__FILE__).DS.'tpl');
define('RESOURCE_PATH',TPL_PATH.DS.'resource');
define('URL_BASE','http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/');
define('URL_RESOURCE_BASE','http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/tpl/resource/');

require APP_PATH.DS.'functions'.DS.'db_functions.php';
require APP_PATH.DS.'functions'.DS.'tpl_functions.php';


if(isset($_GET['logout']))
{
	logout();
}

if(($conn=db_connect())==false)
{
	login();
}

$dbs=dbs($conn);

$cur_db=!empty($_GET['db'])?trim($_GET['db']):$dbs[0];
$tables=db_tables($cur_db,$conn);
if($tables)
{
	$show_html='';
	set_character_set($conn);
	foreach($tables as $table)
	{
		$show_html.=show_table_desc($table,$cur_db,$conn);
	}
}else{
	$show_html='No Tables.';
}

$PageVars['dbs']=$dbs;
$PageVars['tables']=$tables;
$PageVars['cur_db']=$cur_db;
$PageVars['show_html']=$show_html;
tpl_show('show');

<?php
function db_connect()
{
	if(isset($_POST['dologin']))
	{
		$_SESSION['db_config']['host']=trim($_POST['host']);
		$_SESSION['db_config']['username']=trim($_POST['username']);
		$_SESSION['db_config']['password']=trim($_POST['password']);
	}
	if($_SESSION['db_config'])
	{
		$conn=mysqli_connect($_SESSION['db_config']['host'],$_SESSION['db_config']['username'],$_SESSION['db_config']['password']);
		if(!$conn)
		{
			$_SESSION['db_config']=null;
		}
	}
	return $conn;
}
function login()
{
	tpl_show('login');
}
function logout()
{
	$_SESSION['db_config']=null;
	login();
}
function set_character_set($conn,$cset='utf8')
{
	mysqli_query($conn,"set names $cset");
	mysqli_query($conn,"set character_set_client=$cset"); 
    mysqli_query($conn,"set character_set_results=$cset"); 
}
function dbs($conn)
{
	$dbs_result=mysqli_query($conn,'show databases') or die("List dbs failed");
	$dbs=array();
	while(($db_row=mysqli_fetch_array($dbs_result))!=false)
	{
		$dbs[]=$db_row[0];
	}
	return $dbs;
}
function db_tables($cur_db,$conn)
{
	mysqli_select_db($conn , $cur_db);
	$result=mysqli_query($conn,'show tables') or die("List tables of database $cur_db failed!");
	$tables=array();
	while ($row = mysqli_fetch_row($result)) {
		$tables[]=$row[0];
	}
	return $tables;
}
function show_table_desc($table,$db,$conn)
{
	$result = mysqli_query($conn,"SHOW FULL FIELDS FROM `$table`");
	$show_html='';
	if($result)
	{
		
		$show_html.='<div class="table_top" id="'.$table.'"> </div>';
		$show_html.='<div class="table_name">'.$table.'</div>';
		$show_html.='<table border="1" class="table">';
		$show_html.='<thead>';
		$show_html.='<tr><th>Field</th><th>Type</th><th>Collation</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th><th>Comment</th></tr></thead><tbody>';
		while($row=mysqli_fetch_array($result))
		{
			$show_html.='<tr>';
			$show_html.='<td>';
			$show_html.=$row['Field'];
			$show_html.='</td>';
			$show_html.='<td>';
			$show_html.=$row['Type'];
			$show_html.='</td>';
			$show_html.='<td>';
			$show_html.=$row['Collation'];
			$show_html.='</td>';
			$show_html.='<td>';
			$show_html.=$row['Null'];
			$show_html.='</td>';
			$show_html.='<td>';
			$show_html.=$row['Key'];
			$show_html.='</td>';
			$show_html.='<td>';
			$show_html.=$row['Default'];
			$show_html.='</td>';
			$show_html.='<td>';
			$show_html.=$row['Extra'];
			$show_html.='</td>';
			$show_html.='<td>';
			$show_html.=$row['Comment'];
			$show_html.='</td>';
			$show_html.='</tr>';			
		}
		$show_html.='</tbody></table>';
	}
	return $show_html;
}
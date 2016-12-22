<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Learning & Exam System</title>
<link href="themes/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
<link href="Scripts/jtable/themes/metro/blue/jtable.css" rel="stylesheet" type="text/css" />
	
<script src="scripts/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="scripts/jquery-ui-1.8.16.custom.min.js" type="text/javascript"></script>
<script src="scripts/jtable/jquery.jtable.js" type="text/javascript"></script>
<style type="text/css">
	body{
		padding:0px;
		margin:0px;	
	}
	
	input {-webkit-appearance: none; box-shadow: none !important; outline:none}
	-webkit-autofill { color: #fff !important; }

	
	.menu_td{ padding:0; margin:0;}
	#menu{
		height:100%;
		width:100%;
		padding:0;
		margin-top:5px;	
	}
	.menu_item{
		width:100%;
		float:left;
		padding:5px 0px 5px 10px;
		font-family:arial;
		font-size:13px;
		width:95%;	
	}
	.menu_item:hover{
		background-color:#E0E0E0;	
	}
	.menu_item a{ display:block; text-decoration:none; color:black;}
	.active{background-color:#CCCCCC; font-weight:bold }
	input,select{width:230px; height:25px; font-size:15px; border:1px solid #BABABA}
	input:hover{border:1px solid #5C5C5C}
	
	.uiForm { border:1px solid #008A17; display:inline-block; }
	.uiForm .row { margin:1px; padding:5px; }
	.uiForm .row .left, .uiForm .row .middle, .uiForm .row .right { float:left; }
	.uiForm .row .left { width:150px; font-family:Verdana; font-size:12px; font-weight:bold }
	.uiForm .row .middle { width:20px; }
	.clear { clear:both; }
	
</style>

</head>
<body>
<table width="100%" border="0" cellspacing="0" height="650">
	<tr>
    	<td colspan="3" height="50" bgcolor="#008A17"><h3 style = 'color:white; font-family:verdana'>Online Exam System</h3></td>
    </tr>
    
    <tr>
        <td width="180" bgcolor="#F3F3F3" valign="top" class="menu_td">
        	<?php
        		include_once("templates/nav.php");
        	?>
        </td>
        <td colspan="2" valign="top">
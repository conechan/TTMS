<?php

	if(isset($title))
	{
		$page_title = $title . ' - '; 
	}
	else
	{
		$title = '';
		$page_title = '';
	}
	
	if(!isset($section))
	{
		$section = 'welcome';
	}
	
	$sections = array(
		'welcome' => array(
			'name' => 'Welcome',
			'url' => 'welcome'
		),
		'CDragon' => array(
			'name' => 'CDragon',
			'url' => 'servers/find/CDragon'
		),
		'CATT' => array(
			'name' => 'CATT',
			'url' => 'servers/find/CATT'
		),
		'CMUST' => array(
			'name' => 'CMUST',
			'url' => 'servers/find/CMUST'
		),
		'VSOS' => array(
			'name' => 'VSOS',
			'url' => 'servers/find/VSOS',
		),
		'admin' => array(
			'name' => 'Admin',
			'url' => 'admin'
		)
	);
	
	$user = $this->session->userdata('user_name');
	
	if( ! isset($message))
	{
		$message = $this->session->flashdata('message');
	}

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?= $page_title ?>Test Tool Maintenace System</title>
	<link type="text/css" rel="stylesheet" href="<?= str_replace('ttms/', 'web/ttms/', site_url('css/style.css')) ?>" />
    <script src="<?= str_replace('ttms/', 'web/ttms/', site_url('js/jquery.js')) ?>" type="text/javascript"></script>
    <script src="<?= str_replace('ttms/', 'web/ttms/', site_url('js/jquery.blockUI.js')) ?>" type="text/javascript"></script>
    <script src="<?= str_replace('ttms/', 'web/ttms/', site_url('js/action.ajax.js')) ?>" type="text/javascript"></script>
</head>
<body>
<!--
-->
<!-- Header -->
<div class="header">
	<h1 title="Test Tool Maintenance System">Test Tool Maintenance System</h1>
	<div class="nav">
		<ul>
<?			foreach($sections as $key => $s):
				$sel = ($section == $key) ? ' selected' : ''; ?>
			<li class="<?= $key . $sel ?>"><a href="<?= site_url($s['url']) ?>"><?= $s['name'] ?></a></li>
<?			endforeach; ?>

		</ul>
	</div>
	<div class="username">Welcome, <?= htmlspecialchars($user) ?></div>
</div>
<!-- End Header -->

<? if( ! empty($title)): ?>
<!-- Page Title -->
<h2><?= $title ?></h2>
<? endif; ?>

<!-- Page Content -->
<div class="content">

<? if( ! empty($message)): ?>
<!-- Form Result Message --> 
<div id="page_message"><?= htmlspecialchars($message) ?></div>
<? endif; ?>

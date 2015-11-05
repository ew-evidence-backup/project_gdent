<?php
/*
	Template Name: Download
*/

if(isset($_GET['id']))
	header('Location: ' . ShareFile::get_download_url($_GET['id']));
else
	echo 'Error';

die();
?>
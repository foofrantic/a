<?php
$uri_path = trim($_SERVER['REQUEST_URI'], '/');
// Split up the remaining URI into an array, using '/' as delimiter.
$uri_parts = explode('/', $uri_path);
$url = $_SERVER['REQUEST_URI'];
$class_title = strtolower(str_replace(' ','_',$node->title));
//============================================================
// LOAD  TEMPLATES
//============================================================
// Callback the delete guestbook function
if($uri_parts['1']=='delete' && $uri_parts['0']=='guestbook') {
	$recipient = guestbook_recipient($uri_parts['2']);
	if($user->uid != $recipient && !in_array('Administrator',$user->roles)) {
		drupal_set_message('You are not allowed to edit this comment.');
		header("location:/alerts");
	} else {
		delete_guestbook($uri_parts['2']);
		header("location:/alerts");
    }
}
switch ($uri_parts['0']) {
	case 'admin':
		$uid = $uri_parts['1'];
		include 'page-default.tpl.php';
	return;
	case 'taxonomy':
		include 'page-default.tpl.php';
	return;
	case 'register':
		drupal_goto('user/register');
	return;
	case 'alerts':
		include 'page-alerts.tpl.php';
	return;
	case 'comment':
		include 'page-comments.tpl.php';
	return;
	case 'publisher-review':
		include 'page-review.tpl.php';
	return;
}
// Returns the user listing page instead of user profile page
if ($uri_parts['0'] == 'admin' && $uri_parts['1']=='user' && $uri_parts['2']=='user') { 
	$uid = $uri_parts['1'];
	include 'page-default.tpl.php'; 
	return; }
//Loads the profile page
if ($node->nid=='190') { 
	include 'page-guestbook-edit.tpl.php'; 
	return; }
// Checks if a font size has been requested in the url and starts a session
if($_GET['font']) {
	$_SESSION['font'] = $_GET['font'];
}
// Defaults all pages with Edit in the url to page-default template
if (strpos($url,'edit')==TRUE || strpos($url,'delete')==TRUE) {
    include 'page-default.tpl.php'; 
    return; }
//Loads the Words page
if ($node->type=='word') {
	include 'page-words.tpl.php'; 
	return; }
//Loads the Front page
if ($node->type=='front') {
	include 'page-front.tpl.php'; 
	return; }
//Loads the publications page
if ($uri_parts['0'] == 'publications') {
	include 'page-publications.tpl.php'; 
	return; }
if ($node->type == 'release' || $node->type == 'book_published') {
	include 'page-release.tpl.php'; 
	return; }
if ($uri_parts['0']=='blog' || $uri_parts['0']=='blogs' || $uri_parts['0'] == 'archive') {
	include 'page-blog.tpl.php'; 
	return; }
if ($node->type == 'blog') {
	include 'page-blog-view.tpl.php'; 
	return; }
if (strpos($url,'search')==TRUE ) {
	include 'page-search.tpl.php'; 
	return; }
//if none of the above applies, load the page-default.tpl.php 
include 'page-default.tpl.php'; 
    return;

//===============================================================
//***END***
//===============================================================
?>
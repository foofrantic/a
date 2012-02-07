<?php
/*
	==============================
	Author: Jay Boodhun
	Date: 05 Nov 2008
	
	This function changes the tabs that
	are displayed by Drupal to custom images.
	
	The images displayed are stored in the themes images folder 
	in the tabs directory.
	
	This function is being used in template.php in the theme to 
	override the theme_menu_local_tasks() [line 1438] function in the menu.inc file 
	in the includes folder.
	==============================
*/
function tabs_menu($primary) {
	//Converts the string into an array
	$tabs = strip_tags($primary);
	$tabs = preg_split('%[\n,]+%', $tabs);
	
	// Replaces all words with images named after the text
	for($i=0;$i<count($tabs);$i++) {
		$tab = strtolower(str_replace(' ','_',$tabs[$i]));
		$primary = str_replace($tabs[$i],
		'<center><img src="'.base_path() . path_to_theme().'/images/tabs/'.$tab.'.gif" 
		alt=""/></center>'.$tabs[$i].'',$primary);
	} 
	return $primary;
}	
function secondary_tabs_menu($secondary) {
	return $secondary;
}	

?>
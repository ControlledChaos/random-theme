<?php
/*
Plugin Name: Random Theme on Signup
Plugin URI: http://premium.wpmudev.org/project/random-theme-on-signup
Description: Activates a random theme for new blog signups
Version: 1.0
Author: Aaron Edwards (Incsub)
Author URI: http://uglyrobot.com
WDP ID: 137

Copyright 2009-2010 Incsub (http://incsub.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

//------------------------------------------------------------------------//
//---Hook-----------------------------------------------------------------//
//------------------------------------------------------------------------//

add_action('wpmu_new_blog', 'random_theme_switch_theme', 1, 1);

//------------------------------------------------------------------------//
//---Functions------------------------------------------------------------//
//------------------------------------------------------------------------//

function random_theme_switch_theme($blog_ID) {
  //get allowed themes
  $themes = get_themes();
  $allowed_themes = apply_filters("allowed_themes", get_site_allowed_themes() );
  
  //pick a random one
  $new_theme = array_rand($allowed_themes);
  
  //we have to go through all this to handle child themes, otherwise it will throw errors
  foreach( (array) $themes as $key => $theme ) {
		$stylesheet = wp_specialchars($theme['Stylesheet']);
		$template = wp_specialchars($theme['Template']);
		if ($new_theme == $stylesheet || $new_theme == $template) {
      $new_stylesheet = $stylesheet;
      $new_template = $template;
		}
	}
  
  //activate it
  switch_to_blog( $blog_ID );
	switch_theme( $new_template, $new_stylesheet );
	restore_current_blog();
}


//------------------------------------------------------------------------//
//---Output Functions-----------------------------------------------------//
//------------------------------------------------------------------------//



//------------------------------------------------------------------------//
//---Page Output Functions------------------------------------------------//
//------------------------------------------------------------------------//

?>

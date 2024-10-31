<?php
/*
	Copyright 2010 Fredrik Poller. All rights reserved.

	Redistribution and use in source and binary forms, with or without modification, are
	permitted provided that the following conditions are met:

	  1. Redistributions of source code must retain the above copyright notice, this list of
	  conditions and the following disclaimer.

	  2. Redistributions in binary form must reproduce the above copyright notice, this list
	  of conditions and the following disclaimer in the documentation and/or other materials
	  provided with the distribution.

	THIS SOFTWARE IS PROVIDED BY FREDRIK POLLER ``AS IS'' AND ANY EXPRESS OR IMPLIED
	WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
	FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL <COPYRIGHT HOLDER> OR
	CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
	CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
	SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
	ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
	NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
	ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

	The views and conclusions contained in the software and documentation are those of the
	authors and should not be interpreted as representing official policies, either expressed
	or implied, of Fredrik Poller.
*/

/*
	Plugin Name: Resize tag cloud
	Plugin URI: http://poller.se/code/wordpress-plugins/#resize-tag-cloud
	Description: Allows for resizing of the tag cloud font sizes from within the admin panel.
	Version: 0.3
	Author: Fredrik Poller
	Author URI: http://poller.se/
	License: Simplified BSD License
*/

	// This function adds a menu item
	function plrrtc_admin_menu() {
		add_theme_page('Resize tag cloud', 'Resize tag cloud', 'manage_options', 'plr-resize-tag-cloud', 'plrrtc_admin_page');
	}

	// Tell wordpress to use our menu item function
	add_action('admin_menu', 'plrrtc_admin_menu');

	// This functions is the admin page itself
	function plrrtc_admin_page() {
		// Start wrap div
		echo '<div class="wrap">' . "\n"; 

		// Fancy title
		echo '<div id="icon-themes" class="icon32"><br /></div>' . "\n";
		echo '<h2>Resize tag cloud</h2>' . "\n"; 

		// Updated badge. Since this for some reason only works by itself on the options page, not the theme page.
		if($_GET['updated'])
			echo '<div id="message" class="updated fade"><p><strong>Settings saved.</strong></p></div>' . "\n";

		// Description
		echo 'Enter the sizes for the tag cloud below in points.<br /><br />' . "\n\n";

		// Get current options if they exists, otherwise set default
		$plrrtc_smallest_size = get_option('plrrtc_smallest_size');
		$plrrtc_largest_size  = get_option('plrrtc_largest_size');

		if(!$plrrtc_smallest_size)
			$plrrtc_smallest_size = 8;

		if(!$plrrtc_largest_size)
			$plrrtc_largest_size = 22;

		// Start form
		echo '<form method="post" action="options.php">' . "\n";

		// Magic wordpress function, adds hidden inputs to help redirect the user back to the right page after submit
		wp_nonce_field('update-options');

		// Start table
		echo '<table class="form-table">' . "\n";

		// Our two settings (smallest and largest)
		echo '<tr valign="top">' . "\n";
		echo '<th scope="row">Smallest size</th>' . "\n";
		echo '<td><input type="text" name="plrrtc_smallest_size" value="' . $plrrtc_smallest_size . '" size="3" /> pt</td>' . "\n";
		echo '<td><span class="description">Default is 8 pt</span></td>' . "\n";
		echo '</tr>' . "\n";

		echo '<tr valign="top">' . "\n";
		echo '<th scope="row">Largest size</th>' . "\n";
		echo '<td><input type="text" name="plrrtc_largest_size" value="' . $plrrtc_largest_size . '" size="3" /> pt</td>' . "\n";
		echo '<td><span class="description">Default is 22 pt</span></td>' . "\n";
		echo '</tr>' . "\n";

		// End table
		echo '</table><br />' . "\n";

		// Magic hidden inputs to make wordpress update our options
		echo '<input type="hidden" name="action" value="update" />' . "\n";
		echo '<input type="hidden" name="page_options" value="plrrtc_smallest_size,plrrtc_largest_size" />' . "\n";

		// Submit button
		echo '<input type="submit" name="plrrtc_submit" class="button-primary" value="Save Changes" />' . "\n";

		// End form
		echo '</form>' . "\n";

		// End wrap div
		echo '</div>' . "\n";
	}

	// This filter function does the actual work
	function plrrtc_filter_args($args = array()) {
		// Get current options
		$plrrtc_smallest_size = get_option('plrrtc_smallest_size');
		$plrrtc_largest_size  = get_option('plrrtc_largest_size');

		// If option exist, replace value in $args
		if($plrrtc_smallest_size)
			$args['smallest'] = $plrrtc_smallest_size;

		if($plrrtc_largest_size)
			$args['largest'] = $plrrtc_largest_size;

		return $args;
	}

	// Tell wordpress to use our filter function
	add_filter('widget_tag_cloud_args', 'plrrtc_filter_args', 20);
?>

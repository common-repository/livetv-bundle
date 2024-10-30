<?php 
/*
Plugin Name: liveTV Team - 2 - Display lives
Plugin URI: http://kwark.allwebtuts.net
Description: liveTV Team - Display all livestreams in a page - Require 0 + 1 + 3 activated - Activate this part if you need to display loop of thumbnails with two modes: normal view and large view.
Author: Laurent (KwarK) Bertrand
Version: 1.1
Author URI: http://kwark.allwebtuts.net
*/

/*  
	Copyright 2012  Laurent (KwarK) Bertrand  (email : kwark@allwebtuts.net)
	
	Please consider a small donation for my work. Behind each code, there is a geek who has to eat.
	This is not because we're geeks that each geek can go without food lol. We are human not a machine lol
	Thank you for my futur bundle...pizza-cola lol. Bundle vs bundle, it's a good deal, no ? 
	Small pizza donation @ http://kwark.allwebtuts.net
	
	You can not remove comments such as my informations.

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

$plugurl = '' . WP_PLUGIN_URL . '';

//Main jquery
wp_register_script('livetv-beautiful-effect', $plugurl . '/livetv-bundle/js/frontend.js', array('jquery'));
wp_register_script('livetv-beautiful-qtip',  $plugurl . '/livetv-bundle/js/jquery.qtip-1.0.0-rc3.min.js', array('jquery'));
wp_register_script('livetv-color-picker',  $plugurl . '/livetv-bundle/js/jscolor.js');

//Selector options from administration for slider
wp_register_script('livetv-effect-top-left',  $plugurl . '/livetv-bundle/js/switcher-top-left.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-top', $plugurl . '/livetv-bundle/js/switcher-top.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-top-right', $plugurl . '/livetv-bundle/js/switcher-top-right.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-bottom-right', $plugurl . '/livetv-bundle/js/switcher-bottom-right.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-bottom', $plugurl . '/livetv-bundle/js/switcher-bottom.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-bottom-left', $plugurl . '/livetv-bundle/js/switcher-bottom-left.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-slide-left', $plugurl . '/livetv-bundle/js/switcher-slide-left.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-slide-right', $plugurl . '/livetv-bundle/js/switcher-slide-right.js', array('livetv-beautiful-effect'));
wp_register_script('livetv-effect-draggable', $plugurl . '/livetv-bundle/js/switcher-draggable.js', array('jquery-ui-core', 'jquery-ui-draggable'));

//Qtip bubble dialog
wp_register_script('livetv-effect-qtype', $plugurl . '/livetv-bundle/js/jquery.qtip.min.js', array('jquery'));
wp_register_script('livetv-qtip-light', $plugurl . '/livetv-bundle/js/livetv-qtip-light.js', array('livetv-effect-qtype'));
wp_register_script('livetv-qtip-grey', $plugurl . '/livetv-bundle/js/livetv-qtip-grey.js', array('livetv-effect-qtype'));
wp_register_script('livetv-qtip-dark', $plugurl . '/livetv-bundle/js/livetv-qtip-dark.js', array('livetv-effect-qtype'));


//register hook css's wordpress
wp_register_style('livetv-page', $plugurl . '/livetv-bundle/css/page-livetreams.css');
wp_register_style('livetv-hook', $plugurl . '/livetv-bundle/css/page-livetreams-hook.css');
wp_register_style('livetv-3col', $plugurl . '/livetv-bundle/css/page-livetreams-3col.css');
wp_register_style('livetv-light', $plugurl . '/livetv-bundle/css/light.css');
wp_register_style('livetv-dark', $plugurl . '/livetv-bundle/css/dark.css');
wp_register_style('livetv-widget-off', $plugurl . '/livetv-bundle/css/widget-off.css');
wp_register_style('livetv-transparent', $plugurl . '/livetv-bundle/css/transparent.css');
wp_register_style('livetv-qtype', $plugurl . '/livetv-bundle/css/jquery.qtip.min.css');

	//Load qtip in admin and frontend
	wp_enqueue_style('livetv-qtype');

	//Enqueue the good qtip script for bubble in admin and frontend
	$qtip = get_option('livetv_qtip');
	
	switch ($qtip):
		
			case 'dark':
				wp_enqueue_script('livetv-qtip-dark');
			break;
				
			case 'light':
				wp_enqueue_script('livetv-qtip-light');
			break;
			
			case 'grey':
				wp_enqueue_script('livetv-qtip-grey');
			break;	
	
	endswitch;


if(!is_admin())
{	
	//General css livestream
	wp_enqueue_style('livetv-page');
	
	//stylish the frontend with css
	$general_color = get_option('livetv_color');
	if($general_color == 'dark'){wp_enqueue_style('livetv-dark');}
	if($general_color == 'light'){wp_enqueue_style('livetv-light');}
	if($general_color == 'transparent'){wp_enqueue_style('livetv-transparent');}
	$option3col = get_option('livetv_3col');
	if($option3col == 'on'){wp_enqueue_style('livetv-3col');}
	$widget_offline = get_option('livetv_view_offline'); 
	if($widget_offline == 'widget_off'){wp_enqueue_style('livetv-widget-off');}
	
	//Enqueue the good effect for slider
	$effect = get_option('livetv_effect');
	
	switch ($effect):
			
			case 'bottom':
				wp_enqueue_script('livetv-effect-bottom');
			break;
			
			case 'top':
				wp_enqueue_script('livetv-effect-top');
			break;
			
			case 'slide_left':
				wp_enqueue_script('livetv-effect-slide-left');
			break;
			
			case 'slide_right':
				wp_enqueue_script('livetv-effect-slide-right');
			break;
			
			case 'bottom_left':
				wp_enqueue_script('livetv-effect-bottom-left');
			break;
			
			case 'bottom_right':
				wp_enqueue_script('livetv-effect-bottom-right');
			break;
			
			case 'top_left':
				wp_enqueue_script('livetv-effect-top-left');
			break;
			
			case 'top_right':
				wp_enqueue_script('livetv-effect-top-right');
			break;

			default:
				wp_enqueue_script('livetv-effect-bottom');
			break;
			
	endswitch;
	
	include( $livetv_plugin_path . 'page-frontend/page-livetreams.php' );
}
if(is_admin())
{
	wp_enqueue_script('livetv-color-picker');
	// Registers some default option on activation hook
	function livetv_livestream_page_add_defaut_settings() {
		
		global $wpdb, $current_user;
		
		$settings = array(
			'livetv_defaut_role_wordpress' => 'off', //...
			'livetv_activate_creation_role' => 'off',
			'livetv_h3' => 'img',
			'livetv_view_offline' => 'on',
			'livetv_effect' => 'bottom',
			'livetv_cache' => '3',
			'livetv_irc' => 'sitename_userName',
			'livetv_qtip' => 'dark',
			'livetv_3col' => 'off',
			'livetv_types_order' => 'own3d_twitch',
			'livetv_disable_normal' => 'off',
			'livetv_span_color' => 'BDAD93',
			'livetv_irc_own3d' => 'quakenet',
			'livetv_irc_justin' => 'quakenet',
			'livetv_irc_twitch' => 'quakenet'
		);
	
		foreach ($settings as $key => $value) {
			update_option( $key, $value );
		}
		
		// If the plugin has not yet been used one time
		$livetv_easy_install_status = get_option('livetv_easy_install');
		if ( $livetv_easy_install_status !== '1' )
		{
			//if administrator have changed its id in db...
			get_currentuserinfo();
			 
			// Setup Default page with shortcode
			$post = array(
				 'post_title' => 'Livestream',
				 'post_content' => '[LivesOnline]',
				 'post_status' => 'publish',
				 'post_type' => 'page',
				 'post_author' => $current_user->ID
			);
			// Insert page
			wp_insert_post( $post , $wp_error );
				
			// Once done for the page with shortcode
			update_option( 'livetv_easy_install', '1' );
		}
	}
	register_activation_hook(__FILE__, 'livetv_livestream_page_add_defaut_settings');
	
	
	
	// Remove all settings and special roles for this plugin on uninstall hook
	function livetv_livestream_page_delete_defaut_settings()
	{
		global $wpdb, $blog_id, $current_user;
		
		$settings = array(
			'livetv_defaut_role_wordpress',
			'livetv_activate_creation_role',
			'livetv_h3',
			'livetv_view_offline',
			'livetv_effect',
			'livetv_cache',
			'livetv_irc',
			'livetv_qtip',
			'livetv_3col',
			'livetv_types_order',
			'livetv_disable_normal',
			'livetv_span_color',
			'livetv_irc_own3d',
			'livetv_irc_justin',
			'livetv_irc_twitch'
		);
	
		foreach ($settings as $v) {
			delete_option( ''.$v.'' );
		}
		
		$editable_roles = get_roles();
		/*var_dump($editable_roles);*/
	
		foreach($editable_roles as $key => $value)
		{
		
			$temp = preg_match("#^live_#", $key);
		
			if($temp)
			{
				$lastusers = array(
					'blog_id' => $blog_id,
					'role' => ''.$key.'',
					'search' => ID
				);
					
				$blogusers = get_users(''.$lastusers.'' );
				
				foreach($blogusers as $specialroleusers => $specialuser)
				{
					$id = $specialuser->ID;
					
					// get user objet by user ID
					$bloguser = new WP_User( $id );
					
					$bloguser->remove_role( ''.$value.'' );
								
					//Filter current admin to make sure...
					if($current_user->ID != $id)
					{
						$bloguser->set_role( 'subscriber' );
					}
				}
			//Now remove this WP role...
			$roles = new WP_Roles();
			$result = $roles->remove_role(''.$key.'');
			}
		}	
	}
	register_uninstall_hook(__FILE__, 'livetv_livestream_page_delete_defaut_settings');
	
//Now construct admin page
include( $livetv_plugin_path . 'page-admin/page-admin-livetreams.php' );
}
?>
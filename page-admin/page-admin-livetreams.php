<?php
/*  
	Copyright 2012  Laurent (KwarK) Bertrand  (email : kwark@allwebtuts.net)
	
	Please consider a small donation for my work. Behind each code, there is a geek who has to eat.
	This is not because we're geeks that each geek can go without food lol. We are human not a machine lol
	Thank you for my futur bundle...pizza-cola lol. Bundle vs bundle, it's a good deal, no ? 
	Small pizza donation @ http://kwark.allwebtuts.net
	
	You can not remove this comments such as my informations.

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
// disallow direct access to file
if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
	wp_die(__('Sorry, but you cannot access this page directly.', 'livetv'));
}


// only necessary when the plugin part "livestream_page" is active
function livetv_general_options_livestream_page()
{
	add_submenu_page('plugin-livetv-fork.php', 'General lives page', __('General livetream', 'livetv'), 'manage_options', 'page-admin/page-admin-livetreams.php', 'livetv_do_admin_page_level_livestream_page');
}
add_action( 'livetv_add_submenu_page', 'livetv_general_options_livestream_page'); //plugin api


// Do admin options page General livestream for livestream page (plugin level 2)
function livetv_do_admin_page_level_livestream_page()
{
		
    if(isset($_POST['submitted']) && $_POST['submitted'] == "yes")
	{
		$livetv_activate_creation_role = stripslashes($_POST['livetv_activate_creation_role']);
		update_option("livetv_activate_creation_role", $livetv_activate_creation_role);
		
		$livetv_defaut_role_wordpress = stripslashes($_POST['livetv_defaut_role_wordpress']);
		update_option("livetv_defaut_role_wordpress", $livetv_defaut_role_wordpress);

		$livetv_users_role_selected = stripslashes($_POST['livetv_users_role_selected']);
		update_option("livetv_users_role_selected", $livetv_users_role_selected);
		
		$livetv_h3 = stripslashes($_POST['livetv_h3']);
		update_option("livetv_h3", $livetv_h3);
		
		$livetv_view_offline = stripslashes($_POST['livetv_view_offline']);
		update_option("livetv_view_offline", $livetv_view_offline);
		
		$livetv_effect = stripslashes($_POST['livetv_effect']);
		update_option("livetv_effect", $livetv_effect);
		
		$livetv_cache = stripslashes($_POST['livetv_cache']);
		update_option("livetv_cache", $livetv_cache);
		
		$livetv_irc = stripslashes($_POST['livetv_irc']);
		update_option("livetv_irc", $livetv_irc);
		
		$livetv_twitter = stripslashes($_POST['livetv_twitter']);
		update_option("livetv_twitter", $livetv_twitter);
		
		$livetv_facebook = stripslashes($_POST['livetv_facebook']);
		update_option("livetv_facebook", $livetv_facebook);
		
		$livetv_qtip = stripslashes($_POST['livetv_qtip']);
		update_option("livetv_qtip", $livetv_qtip);
		
		$livetv_3col = stripslashes($_POST['livetv_3col']);
		update_option("livetv_3col", $livetv_3col);
		
		$livetv_types_order = stripslashes($_POST['livetv_types_order']);
		update_option("livetv_types_order", $livetv_types_order);
		
		$livetv_disable_normal = stripslashes($_POST['livetv_disable_normal']);
		update_option("livetv_disable_normal", $livetv_disable_normal);
		
		$livetv_span_color = stripslashes($_POST['livetv_span_color']);
		update_option("livetv_span_color", $livetv_span_color);
		
		$livetv_irc_own3d = stripslashes($_POST['livetv_irc_own3d']);
		update_option("livetv_irc_own3d", $livetv_irc_own3d);
		
		$livetv_irc_twitch = stripslashes($_POST['livetv_irc_twitch']);
		update_option("livetv_irc_twitch", $livetv_irc_twitch);
		
		$livetv_irc_justin = stripslashes($_POST['livetv_irc_justin']);
		update_option("livetv_irc_justin", $livetv_irc_justin);
		
		if(!empty($_POST['livetv_new_role_to_add']))
		{
			$livetv_new_role_to_add = stripslashes($_POST['livetv_new_role_to_add']);
			$livetv_new_role_to_add_data = preg_replace('# #', '_', strtolower(stripslashes($_POST['livetv_new_role_to_add'])));
			$livetv_new_role_based_on = stripslashes($_POST['livetv_new_role_based_on']);
		
			if($livetv_new_role_based_on == "subscriber"){
				$live_tv_capabilities = array(
					'read' => true, // True allows that capability
					'level_0' => true
				);
			}
			
			if($livetv_new_role_based_on == "contributor"){
				$live_tv_capabilities = array(
					'read' => true,
					'delete_posts' => true,
					'edit_posts' => true,
					'level_1' => true,
					'level_0' => true
				);
			}
			
			if($livetv_new_role_based_on == "author"){
				$live_tv_capabilities = array(
					'read' => true,
					'delete_posts' => true,
					'edit_posts' => true,
					'edit_published_posts' => true,	
					'upload_files' => true,
					'publish_posts' => true,	
					'delete_published_posts' => true,
					'level_2' => true,
					'level_1' => true,
					'level_0' => true
				);
			}
			
			if($livetv_new_role_based_on == "editor"){
				$live_tv_capabilities = array(
					'read' => true,
					'delete_posts' => true,
					'edit_posts' => true,
					'edit_published_posts' => true,	
					'upload_files' => true,
					'publish_posts' => true,	
					'delete_published_posts' => true,
					'read_private_pages' => true,
					'edit_private_pages' => true,				
					'delete_private_pages' => true,
					'read_private_posts' => true,
					'edit_private_posts' => true,
					'delete_private_posts' => true,
					'delete_published_pages' => true,
					'delete_pages' => true,
					'publish_pages' => true,
					'edit_published_pages' => true,
					'edit_others_pages' => true,
					'edit_pages' => true,
					'edit_others_posts' => true,
					'manage_links' => true,
					'manage_categories' => true,
					'moderate_comments' => true,
					'level_7' => true,
					'level_6' => true,
					'level_5' => true,
					'level_4' => true,
					'level_3' => true,
					'level_2' => true,
					'level_1' => true,
					'level_0' => true
				);
			}
			
			if(!preg_match("#^live_#", $livetv_new_role_to_add_data))
			{
				$livetv_new_role_to_add_data = 'live_' . $livetv_new_role_to_add_data; //Cheating for list of new roles and futur traitment
			}
			$roles = new WP_Roles();
			$result = $roles->add_role(''.$livetv_new_role_to_add_data.'', ''.$livetv_new_role_to_add.'', $live_tv_capabilities); 
			
			if (null !== $result)
			{
				$info = __('Yay!  New role', 'livetv');
				$info .= ' '.$livetv_new_role_to_add.' ';
				$info .= __('for your team created! Based on defaut capabilities of', 'livetv');
				$info .= ' ' . $livetv_new_role_based_on.'.';
				$class = 'success';
			}
			
			else
			{
				$info = __('Oh... the', 'livetv');
				$info .= ' '.$livetv_new_role_to_add.' ';
				$info .= __('role for your team already exists.', 'livetv');
				$class = 'info';
			}
		}
		
		if(!empty($_POST['livetv_new_role_to_delete']))
		{
			$livetv_new_role_to_delete = stripslashes($_POST['livetv_new_role_to_delete']);
			
			//Before remove role...
			//get all users in this role...
			global $blog_id, $current_user;
			
			$lastusers = array(
				'blog_id' => $blog_id,
				'role' => ''.$livetv_new_role_to_delete.'',
				'search' => ID
 			);
				
			$blogusers = get_users(''.$lastusers.'' );
			
			/*var_dump($blogusers);*/
			
            //filter current admin
			wp_get_current_user();
			
			$editable_roles = get_roles();
			/*var_dump($editable_roles);*/

			//Update role of these users...
			foreach($blogusers as $key => $value)
			{
				$id = $value->ID;
				// get user objet by user ID
				$bloguser = new WP_User( $id );
				
				foreach($editable_roles as $k => $v)
				{
					$temp = preg_match("#".$livetv_new_role_to_delete."#", $k);
					
					if($temp == true)
					{
						$bloguser->remove_role( ''.$v.'' );
						
						//Filter current admin on localhost until tests...
						if($current_user->ID != $id)
						{
							$bloguser->set_role( 'subscriber' );
						}
					}
				}
			}
				
			//Now remove this WP role...
			$roles = new WP_Roles();
			$result = $roles->remove_role(''.$livetv_new_role_to_delete.'');
			
			
			if (null == $result)
			{
				$info = __('The role with the id ', 'livetv');
				$info .= ' '.$livetv_new_role_to_delete.' ';
				$info .= __('successful deleted!', 'livetv');
				$class = 'success';
			} 
			
			else 
			{
				$info = __('Oh... the role', 'livetv');
				$info .= ' '.$livetv_new_role_to_delete.' ';
				$info .= __('already erased or not exists actually.', 'livetv');
				$class = 'error';
			}
		}
		
		if(!$info)
		{
			echo "<div id=\"message\" class=\"updated fade\"><p><strong>";
			echo _e('Your settings have been saved.', 'livetv');
			echo "</strong></p></div>";
		}
		
		else
		{
			echo '<div id="message" class="updated fade '.$class.'"><p><strong>'.$info.'</strong></p></div>';
		}
	}


// Lest go for the html part of admin page for livestream_page
?>

<div class="wrap livetv-admin">
  <div id="icon-upload" class="icon32"><br>
  </div>
  <h2>
    <?php _e('liveTV Team - General configuration page livestream', 'livetv') ?>
  </h2>
  <form method="post" action="" class="livetv_admin">
    <p class="submit">
      <input type="submit" name="options_submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
    </p>
    <?php
		
	$editable_roles = get_roles();
	/*var_dump($editable_roles);*/

	foreach($editable_roles as $key => $value){
		$temp = preg_match("#^live_#", $key);
	}
	if($temp == true){

		?>
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Option to delete one of these new roles', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Delete one ?', 'livetv'); ?>
          </label></td>
        <td class="livetv-admin-td"><select name="livetv_new_role_to_delete" id="livetv_new_role_to_delete" onchange="if(this.options[this.selectedIndex].value== ''){return;}else(confirm('<?php _e('Really want to delete this role ? Turn Off if not !', 'livetv'); ?>'));">
            <option value=""><?php echo 'Off' ?></option>
            <?php 
		foreach ($editable_roles as $key => $value)
		{ 
			if(preg_match("#^live_#", $key)) //cheating to list, dont change this
			{ ?>
            <option value="<?php echo ''.$key.'' ?>"><?php echo ''.$value.'' ?></option>
            <?php 
			}
		 } ?>
          </select>
          <span class="livetv_help" title="<?php _e('Select one and clic on registration button to delete the current selected role', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('These current roles have access to streaming creation from her profil field', 'livetv'); ?></th>
        <?php
			    
		foreach ($editable_roles as $key => $value)
		{ 
			if(preg_match("#^live_#", $key)) //cheating to list, dont change this
			{ ?>
      <tr valign="top">
        <td scope="row"><label>&nbsp;</label></td>
        <td><input type="text" style="width:125px;" maxlength="55" disabled="disabled" name="<?php echo $value; ?>" value="<?php echo $value; ?>" id="<?php echo $key; ?>" />
          <span class="livetv_help" title="<?php _e('This role have access to streamings live creation', 'livetv'); ?>"></span> <br /></td>
      </tr>
      <?php 
			}
		}
		if(!$temp) { ?>
      <tr valign="top">
        <td scope="row"><label>&nbsp;</label></td>
        <td class="livetv-admin-td"><?php _e('No current role actually', 'livetv'); ?></td>
      </tr>
      <?php } ?>
    </table>
    <?php } ?>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Defaut title h3 for thumbnails list', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Display title or image for h3 ?', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_h3'); ?>
        <td class="livetv-admin-td"><select name="livetv_h3" id="livetv_h3">
            <option <?php if($temp == 'img'){echo 'selected="selected"';} ?> value="img">Image</option>
            <option <?php if($temp == 'txt'){echo 'selected="selected"';} ?> value="txt">Texte</option>
            <option <?php if($temp == 'off'){echo 'selected="selected"';} ?> value="off">No</option>
          </select>
          <span class="livetv_help" title="<?php _e('Choose a default value for displaying h3 on livestream page', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Option to display the livestreams offline', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('View lives offline ?', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_view_offline'); ?>
        <td class="livetv-admin-td"><select name="livetv_view_offline" id="livetv_view_offline">
            <option <?php if($temp == 'on'){echo 'selected="selected"';} ?> value="on">On</option>
            <option <?php if($temp == 'off'){echo 'selected="selected"';} ?> value="off">Off</option>
            <option <?php if($temp == 'widget_off'){echo 'selected="selected"';} ?> value="widget_off">Only off on widget</option>
          </select>
          <span class="livetv_help" title="<?php _e('Choose - on - to view all livestreams offline on the livestream page (a macaroon appears for each status). To view the changes more rapidely, visit your page livestream to regenerate the cache system.', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Special beautiful effects', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Choose a slide effect', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_effect'); ?>
        <td class="livetv-admin-td"><select name="livetv_effect" id="livetv_effect">
            <option <?php if($temp == 'top_left'){echo 'selected="selected"';} ?> value="top_left">top-left</option>
            <option <?php if($temp == 'top'){echo 'selected="selected"';} ?> value="top">top</option>
            <option <?php if($temp == 'top_right'){echo 'selected="selected"';} ?> value="top_right">top-right</option>
            <option <?php if($temp == 'slide_right'){echo 'selected="selected"';} ?> value="slide_right">slide-right</option>
            <option <?php if($temp == 'bottom_right'){echo 'selected="selected"';} ?> value="bottom_right">bottom-right</option>
            <option <?php if($temp == 'bottom'){echo 'selected="selected"';} ?> value="bottom">bottom</option>
            <option <?php if($temp == 'bottom_left'){echo 'selected="selected"';} ?> value="bottom_left">bottom-left</option>
            <option <?php if($temp == 'slide_left'){echo 'selected="selected"';} ?> value="slide_left">slide-left</option>
          </select>
          <span class="livetv_help" title="<?php _e('Choose the default slide effect for some elements like switch infos and chatIRC.', 'livetv'); ?>"></span> <br /></td>
      </tr>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Choose a bubble dialog effect', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_qtip'); ?>
        <td class="livetv-admin-td"><select name="livetv_qtip" id="livetv_qtip">
            <option <?php if($temp == 'light'){echo 'selected="selected"';} ?> value="light">
            <?php _e('White', 'livetv'); ?>
            </option>
            <option <?php if($temp == 'grey'){echo 'selected="selected"';} ?> value="grey">
            <?php _e('Grey', 'livetv'); ?>
            </option>
            <option <?php if($temp == 'dark'){echo 'selected="selected"';} ?> value="dark">
            <?php _e('Black', 'livetv'); ?>
            </option>
          </select>
          <span class="livetv_help" title="<?php _e('Choose the default bubble Tips effect for some elements like livestream page and help in administration', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Special cache time', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Choose a cache time', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_cache'); ?>
        <td class="livetv-admin-td"><select name="livetv_cache" id="livetv_cache">
        <option <?php if($temp == '0'){echo 'selected="selected"';} ?> value="0">Off</option>
            <?php for($i = 1; $i <= 10; $i++){ ?>
            <option <?php if($temp == ''.$i.''){echo 'selected="selected"';} ?> value="<?php echo ''.$i.''; ?>"><?php echo ''.$i.''; ?></option>
            <?php } ?>
          </select>
          <span class="livetv_help" title="<?php _e('Cache is expressed in minutes before expiration', 'livetv'); ?> <?php _e('Consider Off as temporary Off. Choose Off only when you make a setting change to see the result more rapidly. After changes, choose a cache time.', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Special options chat irc', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Make all chat irc based on', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_irc'); ?>
        <td class="livetv-admin-td"><select name="livetv_irc" id="livetv_irc">
            <option <?php if($temp == 'sitename'){echo 'selected="selected"';} ?> value="sitename">#sitename</option>
            <option <?php if($temp == 'userName'){echo 'selected="selected"';} ?> value="userName">#user</option>
            <option <?php if($temp == 'channelName'){echo 'selected="selected"';} ?> value="channelName">#liveID</option>
            <option <?php if($temp == 'sitename_userName'){echo 'selected="selected"';} ?> value="sitename_userName">#sitename.user</option>
            <option <?php if($temp == 'sitename_channelName'){echo 'selected="selected"';} ?> value="sitename_channelName">#sitename.liveID</option>
            <option <?php if($temp == 'sitename_userName_channelName'){echo 'selected="selected"';} ?> value="sitename_userName_channelName">#sitename.user.liveID</option>
            <option <?php if($temp == 'sitename_channelName_userName'){echo 'selected="selected"';} ?> value="sitename_channelName_userName">#sitename.liveID.user</option>
          </select>
          <span class="livetv_help" title="<?php _e('This option change the #channel format of the chat IRC under the current livestream e.g. if you use #sitename only one channel irc exist for all irc channel on your site and all members and visitors speak under this irc channel. If you use #sitename.user only one channel irc exist for all livestreams shared by this user. If you use a parameter with #chanID each livestream has its personal irc channel', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
        <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Special options quakenet replacement', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Replace quakenet by original chat for all your own3d.tv', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_irc_own3d'); ?>
        <td class="livetv-admin-td"><select name="livetv_irc_own3d" id="livetv_irc_own3d">
            <option <?php if($temp == 'quakenet'){echo 'selected="selected"';} ?> value="quakenet">Off</option>
            <option <?php if($temp == 'own3d'){echo 'selected="selected"';} ?> value="own3d">On</option>
          </select>
          <span class="livetv_help" title="<?php _e('This option work if that\'s possible like original chat from own3d/twitch/justin', 'livetv'); ?>"></span> <br /></td>
      </tr>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Replace quakenet by original chat for all your twitch.tv', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_irc_twitch'); ?>
        <td class="livetv-admin-td"><select name="livetv_irc_twitch" id="livetv_irc_twitch">
         	<option <?php if($temp == 'quakenet'){echo 'selected="selected"';} ?> value="quakenet">Off</option>
            <option <?php if($temp == 'twitch'){echo 'selected="selected"';} ?> value="twitch">On</option>
          </select>
          <span class="livetv_help" title="<?php _e('This option work if that\'s possible like original chat from own3d/twitch/justin', 'livetv'); ?>"></span> <br /></td>
      </tr>
       <tr valign="top">
        <td scope="row"><label>
            <?php _e('Replace quakenet by original chat for all your justin.tv', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_irc_justin'); ?>
        <td class="livetv-admin-td"><select name="livetv_irc_justin" id="livetv_irc_justin">
            <option <?php if($temp == 'quakenet'){echo 'selected="selected"';} ?> value="quakenet">Off</option>
            <option <?php if($temp == 'justin'){echo 'selected="selected"';} ?> value="justin">On</option>
          </select>
          <span class="livetv_help" title="<?php _e('This option work if that\'s possible like original chat from own3d/twitch/justin', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Option 3 columns', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Display thumbnails on 3 colums ?', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_3col'); ?>
        <td class="livetv-admin-td"><select name="livetv_3col" id="livetv_3col">
            <option <?php if($temp == 'on'){echo 'selected="selected"';} ?> value="on">General On</option>
            <option <?php if($temp == 'off'){echo 'selected="selected"';} ?> value="off">General Off</option>
            <option <?php if($temp == 'on_large_view'){echo 'selected="selected"';} ?> value="on_large_view">On only on large view</option>
          </select>
          <span class="livetv_help" title="<?php _e('Maybe you have a largest theme to display thumbnails on 3 columns ?', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
        <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Option for some page template', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Disable button normal view ?', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_disable_normal'); ?>
        <td class="livetv-admin-td"><select name="livetv_disable_normal" id="livetv_disable_normal">
            <option <?php if($temp == 'off'){echo 'selected="selected"';} ?> value="off">Off</option>
            <option <?php if($temp == 'on'){echo 'selected="selected"';} ?> value="on">On</option>
          </select>
          <span class="livetv_help" title="<?php _e('Maybe you have a page template without sidebar and you desire to disable normal view button to made not a css bug ?', 'livetv'); ?> <?php _e('Info: Please be patient to view the result with the cache system.', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
     <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Change color for thumbnails text informations', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Change color', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_span_color'); ?>
        <td class="livetv-admin-td"><input class="color" id="livetv_span_color" name="livetv_span_color" value="<?php echo ''.$temp.''; ?>" />
          <span class="livetv_help" title="<?php _e('Maybe your theme and this plugin dont have a good result for color on text @ the right side of thumbnails. Change the color value for the text on right side of thumbnails', 'livetv'); ?> <?php _e('Info: Please be patient to view the result with the cache system.', 'livetv'); ?>"></span><br /></td>
      </tr>
    </table>
    <br />
          <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Change order of livestream types on page and widget', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Livestream display order', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_types_order'); ?>
        <td class="livetv-admin-td"><select name="livetv_types_order" id="livetv_types_order">
            <option <?php if($temp == 'own3d'){echo 'selected="selected"';} ?> value="own3d">own3d only</option>
            <option <?php if($temp == 'twitch'){echo 'selected="selected"';} ?> value="twitch">twitch only</option>
            <option <?php if($temp == 'justin'){echo 'selected="selected"';} ?> value="justin">justin only</option>
            <option <?php if($temp == 'own3d_twitch' || $temp == ''){echo 'selected="selected"';} ?> value="own3d_twitch">own3d twitch</option>
            <option <?php if($temp == 'twitch_own3d'){echo 'selected="selected"';} ?> value="twitch_own3d">twitch own3d</option>
            <option <?php if($temp == 'own3d_justin'){echo 'selected="selected"';} ?> value="own3d_justin">own3d justin</option>
            <option <?php if($temp == 'justin_own3d'){echo 'selected="selected"';} ?> value="justin_own3d">justin own3d</option>
            <option <?php if($temp == 'twitch_justin'){echo 'selected="selected"';} ?> value="twitch_justin">twitch justin</option>
            <option <?php if($temp == 'justin_twitch'){echo 'selected="selected"';} ?> value="justin_twitch">justin twitch</option>
            <option <?php if($temp == 'own3d_twitch_justin'){echo 'selected="selected"';} ?> value="own3d_twitch_justin">own3d twitch justin</option>
            <option <?php if($temp == 'own3d_justin_twitch'){echo 'selected="selected"';} ?> value="own3d_justin_twitch">own3d justin twitch</option>
            <option <?php if($temp == 'twitch_own3d_justin'){echo 'selected="selected"';} ?> value="twitch_own3d_justin">twitch own3d justin</option>
            <option <?php if($temp == 'twitch_justin_own3d'){echo 'selected="selected"';} ?> value="twitch_justin_own3d">twitch justin own3d</option>
            <option <?php if($temp == 'justin_own3d_twitch'){echo 'selected="selected"';} ?> value="justin_own3d_twitch">justin own3d twitch</option>
            <option <?php if($temp == 'justin_twitch_own3d'){echo 'selected="selected"';} ?> value="justin_twitch_own3d">justin twitch own3d</option>
          </select>
          <span class="livetv_help" title="<?php _e('Choose the livestream type to display and the order to display', 'livetv'); ?> <?php _e('Info: Please be patient to view the result with the cache system.', 'livetv'); ?>"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('General social media link', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><?php _e('Define your link to Facebook', 'livetv'); ?></td>
        <?php $general_join_facebook = get_option('livetv_facebook'); $general_join_twitter = get_option('livetv_twitter'); ?>
        <td class="livetv-admin-td"><input type="text" style="width:125px;" maxlength="150" name="livetv_facebook" value="<?php echo $general_join_facebook; ?>" id="livetv_facebook" />
          <span class="livetv_help" title="<?php _e('Choose your entire link to go to your social media page', 'livetv'); ?> Facebook"></span> <br /></td>
      </tr>
      <tr valign="top">
        <td scope="row"><?php _e('Define your link to Twitter', 'livetv'); ?></td>
        <td class="livetv-admin-td"><input type="text" style="width:125px;" maxlength="150" name="livetv_twitter" value="<?php echo $general_join_twitter; ?>" id="livetv_twitter" />
          <span class="livetv_help" title="<?php _e('Choose your entire link to go to your social media page', 'livetv'); ?> Twitter"></span> <br /></td>
      </tr>
    </table>
    <br />
    <table class="widefat options" style="width: 650px">
      <th colspan="2" class="dashboard-widget-title"><?php _e('Who has access to livestreams creation from his profile field ?', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Make this on new roles', 'livetv'); ?>
          </label></td>
        <?php $temp = get_option('livetv_activate_creation_role'); ?>
        <td class="livetv-admin-td"><input type="radio" name="livetv_activate_creation_role" id="livetv_activate_creation_role" value="on" <?php if($temp == 'on'){echo 'checked="checked"';} ?> />
          <?php _e('On', 'livetv'); ?>
          <span class="livetv_help" title="<?php _e('Create some special roles of your choice', 'livetv'); ?>"></span> <br />
          <input type="radio" name="livetv_activate_creation_role" id="livetv_activate_creation_role" value="off" <?php if($temp == 'off'){echo 'checked="checked"';} ?> />
          <?php _e('Off', 'livetv'); ?>
          <span class="livetv_help" title="<?php _e('Continue with wordpress default roles only', 'livetv'); ?>"></span> <br /></td>
      </tr>
      <?php if($temp == 'on'){ ?>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Add a new role', 'livetv'); ?>
          </label></td>
        <td class="livetv-admin-td"><input type="text"  style="width:125px;" maxlength="55" name="livetv_new_role_to_add" id="livetv_new_role_to_add" value="" />
          <select name="livetv_new_role_based_on" id="livetv_new_role_based_on">
            <option value="subscriber">
            <?php _e('Members', 'livetv'); ?>
            </option>
            <option value="contributor">
            <?php _e('Contributors', 'livetv'); ?>
            </option>
            <option value="author">
            <?php _e('Authors', 'livetv'); ?>
            </option>
            <option value="editor">
            <?php _e('Editors', 'livetv'); ?>
            </option>
          </select>
          <span class="livetv_help" title="<?php _e('Choose default capabilities based on a default wordpress roles for your new role before updating. Info: editor is not the original version. No capabilities delete on other posts/pages. No capabilities for html script. All the rest is the same.', 'livetv'); ?>"></span> <br /></td>
      </tr>
      <?php } ?>
    </table>
    <?php if($temp == 'off'){ ?>
    <br />
    <?php $temp = get_option('livetv_defaut_role_wordpress'); ?>
    <table class="widefat options" style="width: 650px">
        <th colspan="2" class="dashboard-widget-title"><?php _e('Do this on default wordpress roles then...', 'livetv'); ?></th>
      <tr valign="top">
        <td scope="row"><label>
            <?php _e('Defaut wordpress roles', 'livetv'); ?>
          </label></td>
        <td class="livetv-admin-td"><select name="livetv_defaut_role_wordpress" id="livetv_defaut_role_wordpress">
            <option value="off" <?php if($temp == 'off'){echo 'selected="selected"';} ?>>Off</option>
            <option <?php if($temp == 'contributor'){echo 'selected="selected"';} ?> value="contributor">Contributors</option>
            <option <?php if($temp == 'author'){echo 'selected="selected"';} ?> value="author">Authors</option>
            <option <?php if($temp == 'administrator'){echo 'selected="selected"';} ?> value="administrator">Administrator(s)</option>
          </select>
          <span class="livetv_help" title="<?php _e('Choose the default role who have access to create livestreams from their profil field (administrator have already access)', 'livetv'); ?>"></span> <br /></td>
      </tr>
      <?php } ?>
    </table>
    <p class="submit">
      <input name="submitted" type="hidden" value="yes" />
      <input type="submit" name="options_submit" class="button-primary" value="<?php _e( 'Save Changes' ) ?>" />
    </p>
  </form>
</div>
<?php
}
//End admin page


//Now hook to create extra profil fields
add_action( 'edit_user_profile', 'livetv_show_extra_profile_fields' ); 
//When the current on the current profil has capabilties to edit -> display
add_action( 'edit_user_profile_update', 'livetv_save_extra_profile_fields' ); 
//When the current on the current profil has capabilties to edit -> update

add_action( 'show_user_profile', 'livetv_show_extra_profile_fields' ); 
//When the current on the current profil has capabilties to show -> display
add_action( 'personal_options_update', 'livetv_save_extra_profile_fields' ); 
//When the current on the current profil is the current and edit -> update

if(!is_admin)
{
//Frontend plugins compatibility
add_action('profile_personal_options', 'livetv_show_extra_profile_fields');
//When the current on the current profil is the current and show -> display
}

//Now construct new profil fields access, based on option of the plugin (default wordpress roles or new roles)
function livetv_show_extra_profile_fields( $user ) 
{
	$userID = $user->ID;

	$access = get_option('livetv_activate_creation_role');
	
	//If based on new roles 
	if($access == 'on')
	{
		$editable_roles = get_roles();
		
		foreach ($editable_roles as $key => $value)
		{ 
			$temp = preg_match("#^live_#", $key);
			
			if($temp == true)
			{
				if (current_user_can(''.$key.''))
				{
					$live_profil = '1';
				}
				else
				{
					$live_profil = '0';
				}
			}
		}
	}
	
	//If based on wordpress role	
	if($access == 'off')
	{
		$defautRole = get_option('livetv_defaut_role_wordpress');
	
		if (current_user_can(''.$defautRole.''))
		{
			$live_profil = '1';
		}
		else
		{
			$live_profil = '0';
		}
	}
	
	//Administrator have already access to all profils
	if (current_user_can('administrator'))
	{
		$live_profil = '1';
	}
	
	//Result to displaying profil fields
	if($live_profil == '1'){if(is_admin()){$tableclass = 'widefat options';}else{$tableclass = 'form-table';} ?>
	<table class="<?php echo $tableclass; ?>" style="width: 600px">
	  <h3>
		<?php _e('LiveTV general configuration'); ?>
	  </h3>
	  
		<th colspan="2" class="dashboard-widget-title"><?php _e('Add your channels', 'livetv'); ?></th>
      <?php 
	  	$types = explode('_', get_option('livetv_types_order'));
	  	foreach($types as $key => $type)
		{ ?>
	  <tr valign="top">
		<td scope="row"><label>
			<?php _e('add one for', 'livetv'); echo ' '. $type; ?>
		  </label></td>
		<td class="livetv-admin-td"><input type="text" style="width:125px;" maxlength="55" name="live_<?php echo $type; ?>" id="live_<?php echo $type; ?>" class="regular-text" />
		  <span class="livetv_help" title="<?php _e('Complete this input with the channelName or channelID to add one', 'livetv'); ?><?php echo ' ' . $type. '.tv '; ?><?php _e('or leave empty to do nothing', 'livetv'); ?>"></span><br /></td>
	  </tr>
	<?php } ?>
	</table>
    <?php 
	foreach($types as $key => $type)
			{
				$countlive = get_user_meta($userID, 'count_live_'.$type.'', true); 
				if($countlive) { ?>
	<br />
	<table class="widefat options" style="width: 600px">
	  
		<th colspan="2" class="dashboard-widget-title"><?php _e('Your active channels for ', 'livetv'); echo $type; ?>
		  <span class="mini-<?php echo $type; ?>"></span></th>
	  <tr valign="top">
		<td scope="row"><label><?php _e('Delete one ?', 'livetv') ?></label></td>
		<td class="livetv-admin-td"><select name="delete_one_<?php echo ''.$type.'' ?>" id="delete_one_<?php echo ''.$type.'' ?>">
			<option value=""><?php echo 'off' ?></option>
			<?php for($i = 1; $i <= $countlive; $i ++)
					{ 
						$live = get_user_meta($userID, 'live_'.$userID.'_'.$type.'_'.$i.'', true);
						if($live)
						{
						?>
			<option value="<?php echo 'live_'.$userID.'_'.$type.'_'.$i.''; ?>"><?php echo $live; ?></option>
			<?php }} ?>
		  </select>
		  <span class="livetv_help" title="<?php _e('Select delete and clic on registration button to delete this current channel', 'livetv'); ?>"></span><br /></td>
	  </tr>
	  <?php
				for($i = 1; $i <= $countlive; $i ++)
				{
					$live = get_user_meta($userID, 'live_'.$userID.'_'.$type.'_'.$i.'', true);
					if($live)
					{
						/*var_dump($filter_live);*/
						// $matches = $userid, $type AND $liveid in $type. ?>
	  <tr valign="top">
		<td scope="row"><label><?php echo 'ID&nbsp;' ?>
			<input type="text" style="width:50px;" maxlength="55" disabled="disabled" value="<?php echo $i; ?>" />
		  </label></td>
		<td class="livetv-admin-td"><input type="text" style="width:125px;" maxlength="55" disabled="disabled" name="<?php echo $live; ?>" value="<?php echo $live; ?>" id="<?php echo 'live_'.$userID.'_'.$type.'_'.$i.'' ?>" />
		  <span class="livetv_help" title="<?php _e('This liveTV appears on our site', 'livetv'); ?>"></span></td>
	  </tr>
	  <?php }} ?>
	</table>
<?php }}}}

//Profil field update function
function livetv_save_extra_profile_fields( $user_id )
{
	if ( current_user_can( 'edit_user', $user_id ) )
	{

		if(isset($_POST['delete_one_own3d']) && !empty($_POST['delete_one_own3d']))
		{
			$temp = stripslashes($_POST['delete_one_own3d']);
			
			if($temp)
			{
				delete_user_meta( $user_id, ''.$temp.'');
			}
		}
		
		if(isset($_POST['delete_one_justin']) && !empty($_POST['delete_one_justin']))
		{
			$temp = stripslashes($_POST['delete_one_justin']);
			
			if($temp)
			{
				delete_user_meta( $user_id, ''.$temp.'');
			}
		}
		
		if(isset($_POST['delete_one_twitch']) && !empty($_POST['delete_one_twitch']))
		{
			$temp = stripslashes($_POST['delete_one_twitch']);
			
			if($temp)
			{
				delete_user_meta( $user_id, ''.$temp.'');
			}
		}
		
		if(isset($_POST['live_own3d']) && $_POST['live_own3d'] != '')
		{
			
			$countlive = get_user_meta($user_id, 'count_live_own3d', true);
			
			if(!$countlive){
				$countlive = '0';
			}
	
			$count = $countlive + '1';
			
			update_user_meta( $user_id, 'count_live_own3d', ''.$count.'');
			update_user_meta( $user_id, 'live_'.$user_id.'_own3d_'.$count.'', $_POST['live_own3d'] );
		}
		
		if(isset($_POST['live_justin']) && $_POST['live_justin'] != '')
		{
				
			$countlive = get_user_meta($user_id, 'count_live_justin', true);
			
			if(!$countlive){
				$countlive = '0';
			}
			
			$count = $countlive + '1';
			
			update_user_meta( $user_id, 'count_live_justin', ''.$count.'');
			update_user_meta( $user_id, 'live_'.$user_id.'_justin_'.$count.'', $_POST['live_justin'] );
		}
		
		if(isset($_POST['live_twitch']) && $_POST['live_twitch'] != '')
		{
				
			$countlive = get_user_meta($user_id, 'count_live_twitch', true);
			
			if(!$countlive){
				$countlive = '0';
			}
			
			$count = $countlive + '1';
			
			update_user_meta( $user_id, 'count_live_twitch', ''.$count.'');
			update_user_meta( $user_id, 'live_'.$user_id.'_twitch_'.$count.'', $_POST['live_twitch'] );
		}
	}
}
?>
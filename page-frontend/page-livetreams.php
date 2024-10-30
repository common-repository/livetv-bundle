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

// Make shortcode to display livestreams list
add_shortcode( 'LivesOnline', 'livetv_add_livestreams_shorcode' );

function livetv_add_livestreams_shorcode()
{
	global $livetv_plugin_url;
	
	//General admin options First
	$visibility = get_option('livetv_visibility');
	$message = get_option('livetv_message');
	$general_width = get_option('livetv_width');
	$general_height = get_option('livetv_height');
	$registration = get_option('livetv_registration');
	$titleh3 = get_option('livetv_h3');
	$general_color = get_option('livetv_color');
	$general_option3col = get_option('livetv_3col');
	$livetv_view_offline = get_option('livetv_view_offline');
	$livetv_current_url = get_permalink();
	$temp = preg_match('#\?#', $livetv_current_url);
	if($temp){$livetv_current_url .= '&';}else{$livetv_current_url .= '?';}
	if($livetv_view_offline == 'widget_off'){$live_offline_class = 'hide-on-page'; }
	

	if(isset($_REQUEST['liveview']) && $_REQUEST['liveview'] != '' && isset($_REQUEST['mode']) && $_REQUEST['mode'] != '')
	{
		if ($visibility == "members only" && is_user_logged_in() || $visibility == "public")
		{
			//General script livestream - single view
			wp_enqueue_script('livetv-beautiful-effect');
			wp_enqueue_script('livetv-effect-draggable');
			
			//e.g. live_4_own3d_4 = live_$userID(WP)_$type_$ChanID(profilUser)
			$viewmode = $_REQUEST['mode'];
			$channelKey = $_REQUEST['liveview'];
			$temp = explode('_', $channelKey);
				
			$userID = $temp[1];
			$channelType = $temp[2];
			
			if($channelType == 'justin' && $general_color == 'light'){$switchimage = '-black';} //Cheat for image twitch. Bad result for white on white
				
			$channelName = get_user_meta($userID, ''.$channelKey.'', true);
				
			$userData = get_userdata($userID);
				
			/*var_dump($userData);*/
			$userName = $userData->display_name;
			
			//#chan IRC format data
			$livetv_irc_format = get_option('livetv_irc');	
			
			$sitename = preg_replace(array('# #','#%20#', '#-#'), array('','',''), strtolower(get_bloginfo('name')));
			
			$username = preg_replace(array('# #','#%20#', '#-#'), array('','',''), $userName);
			
			switch ($livetv_irc_format):
				
					case 'sitename':
						$livetv_irc = ''.$sitename.'';
					break;
					
					case 'sitename_channelName':
						$livetv_irc = ''.$sitename.'.'.$channelName.'';
					break;
						
					case 'sitename_userName':
						$livetv_irc = ''.$sitename.'.'.$username.'';
					break;
					
					case 'channelName':
						$livetv_irc = ''.$channelName.'';
					break;	
					
					case 'userName':
						$livetv_irc = ''.$username.'';
					break;
					
					case 'sitename_userName_channelName':
						$livetv_irc = ''.$sitename.'.'.$username.'.'.$channelName.'';
					break;
					
					case 'sitename_channelName_userName':
						$livetv_irc = ''.$sitename.'.'.$channelName.'.'.$username.'';
					break;
					
					default:
						$livetv_irc = ''.$channelName.'';
					break;
					
			endswitch;
				
			if($viewmode == 'normal' || $viewmode == 'full')
			{
				if($viewmode == 'full')
				{
					wp_enqueue_style('livetv-hook');
					
					if($general_option3col == 'on_large_view')
					{
						wp_enqueue_style('livetv-3col');
					}
					
					$modeView = 'Large';
					$classView = 'full';
					$widthView = '100%';
					$heightView = '590'; //Fetch to the reason
					$widthIRC = '100%';
					$heightIRC = '250';
					
				}
				
				if($viewmode == 'normal')
				{
					$modeView = 'Medium';
					$classView = 'full'; //Full because is the same with css with 100% value to fit to the container, but for futur...
					$widthView = $general_width;
					$heightView = $general_height;
					$heightIRC = '250';
					$widthIRC = $widthView - 6; //Due to border
				}
				
				//Top H2	
				echo '<div id="'.$classView.'-view-content" class="'.$classView.'-view-content">';
	
				if($titleh3 == 'txt')
				{
					echo '<h2 class="livetv">'.$modeView.' view '.$channelType.' - Channel '.$channelName.' by '.$userName.'</h2>';
				}
				if($titleh3 == 'img')
				{
					echo '<h2 class="livetv-h2"><img class="bubble" src="'.$livetv_plugin_url.'images/thumblist-title-'.$channelType.''.$switchimage.'.png" title="'.$channelType.' channel '.$modeView.' mode. Channel '.$channelName.' by '.$userName.'" /></h2>';
				}
				
				//Do current livestream
				echo do_shortcode('[livestream type="'.$channelType.'" channel="'.$channelName.'" width="'.$widthView.'" height="'.$heightView.'"]');
					
				echo '</div>';
				
				//Content slider	
				echo '<div id="'.$classView.'-view-switcher" class="'.$classView.'-view-switcher">';
				
				
				
				////First slide (IRC)
				echo '<div id="'.$classView.'-view-irc"><h4 class="livetv-nxt">';
				
				if($titleh3 == 'img')
				{
					$infoimg = __('Switch to share zone ?', 'livetv');
					$temp = '<img class="bubble" src="'.$livetv_plugin_url.'images/qnet.png" title="'.$infoimg.'" />';
				}
				if($titleh3 == 'txt')
				{
					$temp = 'IRC '.$userName.'';
				}
				echo ''.$temp.'';
				echo '</h4>';
				
				//do current IRC chan
				$chat_type = get_option('livetv_irc_' . $channelType);
				if($chat_type == 'quakenet')
				{
					echo do_shortcode('[liveTVChat type="quakenet" channel="'.$livetv_irc.'" width="'.$widthIRC.'" height="'.$heightIRC.'"]');
				}
				else
				{
					echo do_shortcode('[liveTVChat type="'.$chat_type.'" channel="'.$channelName.'" width="'.$widthIRC.'" height="'.$heightIRC.'"]');
				}
				
				echo '</div>';
				
				
				
				////Second slider (share + latest news)
				echo '<div id="'.$classView.'-view-irc">';
	
				echo '<ul id="container-sub-live">';
				
				echo '<h4 class="livetv-nxt">'; //h4 because h3 is the do_shortcode
				
				if($titleh3 == 'img')
				{
					$infoimg = __('Return to chat IRC ?', 'livetv');
					$temp = '<img class="bubble" src="'.$livetv_plugin_url.'images/info.png" title="'.$infoimg.'" />';
				}
				if($titleh3 == 'txt')
				{
					$temp = __('Share live', 'livetv');
				}
				echo ''.$temp.'';
				
				echo '</h4>';
				
				echo '<li id="livetv-recent-posts" class="livetv-widget-container">';
				
				echo '<h5 class="widget-title">Share '.$userName.'</h5>';
				
				echo '<ul>';
				
				echo '<div class="facebook-share-button"><iframe
	src="http://www.facebook.com/plugins/like.php?href='.get_permalink($post->ID).'&layout=button_count&show_faces=false&width=85&action=like&colorscheme=light&height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:85px; height:21px;" allowTransparency="true"></iframe></div><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript"
	src="http://platform.twitter.com/widgets.js"></script>';
				echo '<div class="gplusone"><script src="http://apis.google.com/js/plusone.js" type="text/javascript"></script><g:plusone size="medium"></g:plusone></div><a class="msn-share-button" href="#" onclick="javascript:window.open(\'http://profile.live.com/badge?url='.get_permalink($post->ID).'/\', \'Windows Live\', \'width=550, height=450, top=230, right=450, left=450\'); return false;" title="Messenger live share">Messenger</a><br />';
				
				//General social pages
				$general_join_facebook = get_option('livetv_facebook');
				$general_join_twitter = get_option('livetv_twitter');
				
				echo '<br /><div style="text-align:center;"><br />';
				if($general_join_facebook)
					{
						$txtfacebook = __('Join us on Facebook', 'livetv');
						echo '<h4 class="share-social"><a href="'.esc_url($general_join_facebook, array('http', 'https')).'"><img class="bubble" src="' . $livetv_plugin_url . 'images/facebook.png" title="'.$txtfacebook.'" /></a></h4>';
					}
				if($general_join_twitter)
					{
						$txttwitter = __('Join us on Twitter', 'livetv');
						echo '<h4 class="share-social"><a href="'.esc_url($general_join_twitter, array('http', 'https')).'"><img class="bubble" src="' . $livetv_plugin_url . 'images/twitter.png" title="'.$txttwitter.'" /></a></h4>';
					}
				echo '</div>';
				
				echo '</ul>';
				
				echo '</li>';
				
	
				
				//Last news
				echo '<li id="livetv-recent-posts" class="livetv-widget-container">';
				
				echo '<h5 class="widget-title">'; _e('Latest news', 'livetv'); echo '</h5>';
				
				echo '<ul>';
				
				$args = array( 'numberposts' => '9', 'post_status' => 'publish');
				$posts = get_posts( $args );
				
				foreach ($posts as $posted) 
				{
					echo '<li class="news-single"><a href="' . get_permalink( $posted->ID ) . '" title="' . esc_attr( $posted->post_title ) . '">';
					$title = esc_attr( $posted->post_title,'', false); echo substr($title, 0, 35);
					echo '&hellip;</a></li>';
				}
				echo '</ul>';
				
				echo '</li>';
				
				echo '</ul>';
				
				echo '</div>';
					
	
				echo '</div><br />';//End div content full/medium view format
			}
		}
		else
		{
			echo '<div class="livetv-info"><a href="'.esc_url($registration, array('http', 'https')).'">'.esc_html($message).'</a></div>';
		}
	}
	
	//Now loop of thumbnails
		
	global $blog_id, $livetv_plugin_path;
	/*	global $userdata, $blog_id;
	$userdata = get_userdata( $userdata->ID );*/
		
	$editable_roles = get_roles();
	/*var_dump($editable_roles);*/
	/*$types = array();
	$types = array('own3d', 'twitch', 'justin');*/
	$types = explode('_', get_option('livetv_types_order'));
	$button = get_option('livetv_disable_normal');
	/*var_dump($types);*/
	$livetv_activate_creation_role = get_option('livetv_activate_creation_role');	
	$livestreamusers = array();
	$livestreamusersID = array();
	
	foreach($editable_roles as $keyRole => $valueRole)
	{
		if($livetv_activate_creation_role == 'on')
		{
			$temp = preg_match("#^live_#", $keyRole) || preg_match("#^administrator#", $keyRole);
		}
		if($livetv_activate_creation_role == 'off')
		{
			$temp = !preg_match("#^live_#", $keyRole) && !preg_match("#^subscriber#", $keyRole);
		}
		
		if($temp)
		{
			$args = array(
			'role' => $keyRole
			);
			$team = get_users( $args );
			
			if($team)
			{
				foreach($team as $key => $value){
					$livestreamusersID[] = $value->ID . ',' . $value->display_name;
				}
				$livestreamers = array_merge($livestreamusers, $livestreamusersID);
			}
			/*echo $valueRole . '<br /><br />';*/
			/*var_dump($livestreamers);*/
			/*echo '<br /><br />';
			$role = get_role( ''.$keyRole.'' );
			var_dump($role);*/
		}
	}
					
	/*var_dump($livestreamers);*/
		
	//Start cache
	$cachetime = get_option('livetv_cache');
	$livetv_span_color = get_option('livetv_span_color');
	$livetv_span_color = '#'.$livetv_span_color;
	
	$cache = $livetv_plugin_path . 'cache/temp_'.$blog_id.'_live.html';
		
	$expire = time() - ($cachetime * 60); //-60; // valable X minutes

	if(file_exists($cache) && filemtime($cache) > $expire)
	{
		readfile($cache);
	}
	else
	{
	ob_start(); //start buffer
			
	/*echo '<br /><br />User: ' . $userID;
	echo '<br />';*/
			
		foreach($types as $keyType => $valueType)
		{
			switch($valueType):
						
				case 'own3d': //own3d.tv
						
						echo '<div id="minithumb-own3d-content">';
							
						if($titleh3 == 'txt')
						{
							echo '<h3>';
							_e('Own3d channels', 'livetv');
							echo '</h3>';
						}
						if($titleh3 == 'img')
						{
							echo '<h3><img class="bubble" src="'.$livetv_plugin_url.'images/thumblist-title-own3d.png" title="';
							_e('own3d channels', 'livetv');
							echo '" /></h3>';
						}
						$count = 0;
						foreach($livestreamers as $keyID => $user)
						{
							$livetvuser = explode(',', $user);
							$userID = $livetvuser[0];
							$userName = $livetvuser[1];
								
							$countlive = get_user_meta(''.$userID.'', 'count_live_own3d', true);
								
							if($countlive)
							{	
								for($i = 1; $i <= $countlive; $i ++)
								{
									$channelName = get_user_meta(''.$userID.'', 'live_'.$userID.'_'.$valueType.'_'.$i.'', true);
										
									if($channelName)
									{
										$live_now = false;
										$own3d = 'http://api.own3d.tv/liveCheck.php?live_id=' . $channelName .'';
										$xml = simplexml_load_file($own3d);
										$is_live = $xml->xpath('/own3dReply/liveEvent/isLive');
										$live_viewers = $xml->xpath('/own3dReply/liveEvent/liveViewers');
										$live_duration = $xml->xpath('/own3dReply/liveEvent/liveDuration');
										$live_stamp = $live_duration[0];
										$live_now = $is_live[0];
										$live_until = (time() - $live_stamp);
											
											
										if($live_now == 'true')
										{ 
										$count = $count + 1; 
										?><span class="minithumb-own3d" style="opacity:1"><span class="minithumb-own3d-splash"><img class="bubble" src="<?php echo ''.$livetv_plugin_url.'images/mini-own3d.png' ?>" alt="mask" title="<?php _e('Online since', 'livetv'); ?> <?php echo '' . date('d-m-Y H:i', $live_until) . ''; ?>" /></span><span class="minithumb-own3d-thumb"><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_own3d_'.$i.'&mode=normal' ?>"><img class="bubble" src="http://img.hw.own3d.tv/live/live_tn_<?php echo ''.$channelName.'' ?>_.jpg" title="<?php _e('Channel by', 'livetv');?> <?php echo ''.$userName.''; ?> <?php  _e('from own3d', 'livetv'); ?>" alt="own3d thumbnail" /></a></span><span class="minithumb-own3d-info" style="color:<?php echo ''.$livetv_span_color.''; ?>"><span class="w-viewers"><?php _e('Viewers:', 'livetv'); ?> <?php echo $live_viewers[0]; ?></span><span class="w-user"><?php _e('user:', 'livetv'); ?> <?php echo $userName; ?></span><span class="w-channel"><?php _e('channel:', 'livetv'); ?> <?php echo $channelName; ?></span><span class="w-view"><?php _e('View:', 'livetv'); ?> <?php if($button == 'off'){ ?><a class="bubble button" href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_own3d_'.$i.'&mode=normal' ?>" title="<?php _e('Swtich to normal view', 'livetv'); ?>"><?php _e('Normal', 'livetv'); ?></a><?php } ?> <a class="bubble button" href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_own3d_'.$i.'&mode=full' ?>" title="<?php _e('Swtich to Large view', 'livetv'); ?>"><?php _e('Large', 'livetv'); ?></a></span><span class="w-live"><?php _e('Live!', 'livetv'); ?> <?php echo '' . date('d-m-Y H:i', $live_until) . ''; ?></span></span></span><?php }
										
										if($livetv_view_offline == 'on' && $live_now == 'false' || $livetv_view_offline == 'widget_off' && $live_now == 'false')
										{
										?><span class="minithumb-own3d offline"><span class="minithumb-own3d-splash"><img src="<?php echo ''.$livetv_plugin_url.'images/offline.png' ?>" alt="mask" class="bubble" title="own3d channel offline" /></span><span class="minithumb-own3d-thumb"><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_own3d_'.$i.'&mode=normal' ?>"><img src="http://img.hw.own3d.tv/live/live_tn_<?php echo ''.$channelName.'' ?>_.jpg" class="bubble" title="<?php _e('Channel by', 'livetv'); ?> <?php echo ''.$userName.'' ?> from own3d" alt="own3d thumbnail" /></a></span><span class="minithumb-own3d-info" style="color:<?php echo ''.$livetv_span_color.''; ?>"><span class="w-off-viewers"><?php _e('Last:', 'livetv'); ?> <?php echo $live_viewers[0]; ?> <?php _e('viewers', 'livetv'); ?></span><span class="w-off-user"><?php _e('user:', 'livetv'); ?> <?php echo $userName; ?></span><span class="w-off-channel"><?php _e('channel:', 'livetv'); ?> <?php echo $channelName; ?></span><span class="w-off-view"><?php _e('View:', 'livetv'); ?> <?php if($button == 'off'){ ?><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_own3d_'.$i.'&mode=normal' ?>" class="bubble button" title="<?php _e('Swtich to normal view', 'livetv'); ?>"><?php _e('Normal', 'livetv'); ?></a><?php } ?> <a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_own3d_'.$i.'&mode=full' ?>" class="bubble button" title="<?php _e('Swtich to Large view', 'livetv'); ?>"><?php _e('Large', 'livetv'); ?></a></span><span class="w-off-live"><?php _e('Live: Offline', 'livetv'); ?></span></span></span><?php }
									}
								}
							}
						}
						if($count == 0)
						{
							if($livetv_view_offline == 'off' || $livetv_view_offline == 'widget_off')
							{
								echo '<p class="'.$live_offline_class.'">';
								_e('Currently no live stream online', 'livetv');
								echo '</p>';
							}
						}
						echo '</div>';
												
				break;
				
				
				case 'twitch': //twitch.tv
					
						echo '<div id="minithumb-twitch-content">';
							
						if($titleh3 == 'txt')
						{
							echo '<h3>';
							_e('Twitch channels', 'livetv');
							echo '</h3>';
						}
						if($titleh3 == 'img')
						{
							echo '<h3><img src="'.$livetv_plugin_url.'images/thumblist-title-twitch.png" class="bubble" title="';
							_e('twitch channels', 'livetv');
							echo '" /></h3>';
						}
						$count = 0;
						foreach($livestreamers as $keyID => $user)
						{
						
							$livetvuser = explode(',', $user);
							$userID = $livetvuser[0];
							$userName = $livetvuser[1];
									
							$countlive = get_user_meta(''.$userID.'', 'count_live_twitch', true);
								
							if($countlive)
							{	
								for($i = 1; $i <= $countlive; $i ++)
								{
									$channelName = get_user_meta(''.$userID.'', 'live_'.$userID.'_twitch_'.$i.'', true);
										
									if($channelName)
									{
										$live_now = 'false';
										$base_url = 'http://api.justin.tv/api/stream/list.json?channel=' . $channelName .'';
										$json_file = file_get_contents($base_url, 0, null, null);
										$json_array = json_decode($json_file, true);
											
										/*var_dump($json_array);*/
																
										if($json_array[0]['name'] == 'live_user_'.$channelName.'')
										{
											$live_now = 'true';
										}
										$live_title = $json_array[0]['channel']['title'];
										$live_status = $json_array[0]['channel']['status'];
										$live_game = $json_array[0]['meta_game'];
										$live_thumb = $json_array[0]['channel']['screen_cap_url_medium'];
										$live_count = $json_array[0]['channel_count'];
										$live_until = strtotime($json_array[0]['up_time']);
											
										if($live_now == 'true')
										{ 
										$count = $count + 1;
										/*var_dump($is_live);
										var_dump($live_viewers);
										var_dump($live_duration);*/
										?><span class="minithumb-twitch" style="opacity:1"><span class="minithumb-twitch-splash"><img src="<?php echo ''.$livetv_plugin_url.'images/mini-twitch.png' ?>" alt="mask" class="bubble" title="<?php _e('Online since', 'livetv'); ?> <?php echo '' . date('d-m-Y H:i', $live_until) . '' ?> <?php if($live_game){_e('on game', 'livetv'); echo ' '.$live_game.'';} ?>" /></span><span class="minithumb-twitch-thumb"><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_twitch_'.$i.'&mode=normal' ?>"><img src="<?php echo $live_thumb; ?>" class="bubble" title="<?php echo $live_game . ' | ' . $live_title . ' | ' . $live_status; ?>" alt="twitch thumbnail" /></a></span><span class="minithumb-twitch-info" style="color:<?php echo ''.$livetv_span_color.''; ?>"><span class="w-viewers"><?php _e('Viewers:', 'livetv'); ?> <?php echo $live_count; ?></span><span class="w-user"><?php _e('user:', 'livetv'); ?> <?php echo $userName; ?></span><span class="w-channel"><?php _e('channel:', 'livetv'); ?> <?php echo $channelName; ?></span><span class="w-view"><?php _e('View:', 'livetv'); ?> <?php if($button == 'off'){ ?><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_twitch_'.$i.'&mode=normal' ?>" class="bubble button" title="<?php _e('Swtich to normal view', 'livetv'); ?>"><?php _e('Normal', 'livetv'); ?></a><?php } ?> <a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_twitch_'.$i.'&mode=full' ?>" class="bubble button" title="<?php _e('Swtich to Large view', 'livetv'); ?>"><?php _e('Large', 'livetv'); ?></a></span><span class="w-live"><?php _e('Live!', 'livetv'); ?> <?php echo '' . date('d-m-Y H:i', $live_until) . ''; ?></span></span></span><?php }
										
										if($livetv_view_offline == 'on' && $live_now == 'false' || $livetv_view_offline == 'widget_off' && $live_now == 'false')
										{
										?><span class="minithumb-twitch offline"><span class="minithumb-twitch-splash"><img src="<?php echo ''.$livetv_plugin_url.'images/offline.png' ?>" alt="mask" class="bubble" title="<?php _e('twitch channel offline', 'livetv'); ?>" /></span><span class="minithumb-twitch-thumb"><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_twitch_'.$i.'&mode=normal' ?>"><img src="<?php echo ''.$livetv_plugin_url.'images/thumblist-mask-offline.png' ?>" class="bubble" title="<?php _e('Channel by', 'livetv'); ?> <?php echo ''.$userName.'' ?> <?php _e('from twitch', 'livetv'); ?>" alt="twitch thumbnail" /></a></span><span class="minithumb-twitch-info" style="color:<?php echo ''.$livetv_span_color.''; ?>"><span class="w-off-viewers"><?php _e('Viewers: offline', 'livetv'); ?></span><span class="w-off-user"><?php _e('user:', 'livetv'); ?> <?php echo $userName; ?></span><span class="w-off-channel"><?php _e('channel:', 'livetv'); ?> <?php echo $channelName; ?></span><span class="w-off-view"><?php _e('View:', 'livetv'); ?> <?php if($button == 'off'){ ?><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_twitch_'.$i.'&mode=normal' ?>" class="bubble button" title="<?php _e('Swtich to normal view', 'livetv'); ?>"><?php _e('Normal', 'livetv'); ?></a><?php } ?> <a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_twitch_'.$i.'&mode=full' ?>" class="bubble button" title="<?php _e('Swtich to Large view', 'livetv'); ?>"><?php _e('Large', 'livetv'); ?></a></span><span class="w-off-live"><?php _e('Live: Offline', 'livetv'); ?></span></span></span><?php }
									}
								}
							}
						}
						if($count == 0)
						{
							if($livetv_view_offline == 'off' || $livetv_view_offline == 'widget_off')
							{
								echo '<p class="'.$live_offline_class.'">';
								_e('Currently no live stream online', 'livetv');
								echo '</p>';
							}
						}
						echo '</div>';
												
				break;
										
											
				case 'justin': //justin.tv
					
						echo '<div id="minithumb-justin-content">';
							
						if($titleh3 == 'txt')
						{
							echo '<h3>';
							_e('Justin channels', 'livetv');
							echo '</h3>';
						}
						if($titleh3 == 'img')
						{
							$gencolor = get_option('livetv_color');
							if($gencolor == 'light'){$justinlight = '-black';}
							echo '<h3><img src="'.$livetv_plugin_url.'images/thumblist-title-justin'.$justinlight.'.png" class="bubble" title="';
							_e('justin channels', 'livetv');
							echo '" /></h3>';
						}
						$count = 0;
						foreach($livestreamers as $keyID => $user)
						{
							$livetvuser = explode(',', $user);
							$userID = $livetvuser[0];
							$userName = $livetvuser[1];
							
							$countlive = get_user_meta(''.$userID.'', 'count_live_justin', true);
								
							if($countlive)
							{	
								for($i = 1; $i <= $countlive; $i ++)
								{
									$channelName = get_user_meta(''.$userID.'', 'live_'.$userID.'_justin_'.$i.'', true);
										
									if($channelName)
									{	
										$live_now = 'false';
										$base_url = 'http://api.justin.tv/api/stream/list.json?channel=' . $channelName .'';
										$json_file = file_get_contents($base_url, 0, null, null);
										$json_array = json_decode($json_file, true);
											
										/*var_dump($json_array);*/
																
										if($json_array[0]['name'] == 'live_user_'.$channelName.'')
										{
											$live_now = 'true';
										}
										$live_title = $json_array[0]['channel']['title'];
										$live_status = $json_array[0]['channel']['status'];
										$live_game = $json_array[0]['meta_game'];
										$live_thumb = $json_array[0]['channel']['screen_cap_url_medium'];
										$live_count = $json_array[0]['channel_count'];
										$live_until = strtotime($json_array[0]['up_time']);
											
										if($live_now == 'true')
										{ 
										$count = $count + 1;
		/*								var_dump($is_live);
										var_dump($live_viewers);
										var_dump($live_duration);*/
										?><span class="minithumb-justin" style="opacity:1"><span class="minithumb-justin-splash"><img src="<?php echo ''.$livetv_plugin_url.'images/mini-justin.png' ?>" alt="mask" class="bubble" title="<?php _e('Online since', 'livetv'); ?> <?php echo '' . date('d-m-Y H:i', $live_until) . ''; ?> <?php if($live_game){_e('on game', 'livetv'); echo ' '.$live_game.'';} ?>" /></span><span class="minithumb-justin-thumb"><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_justin_'.$i.'&mode=normal' ?>"><img src="<?php echo $live_thumb; ?>" class="bubble" title="<?php echo $live_game . ' | ' . $live_title . ' | ' . $live_status; ?>" alt="justin thumbnail" /></a></span><span class="minithumb-justin-info" style="color:<?php echo ''.$livetv_span_color.''; ?>"><span class="w-viewers"><?php _e('Viewers:', 'livetv'); ?> <?php echo $live_count; ?></span><span class="w-user"><?php _e('user:', 'livetv'); ?> <?php echo $userName; ?></span><span class="w-channel"><?php _e('channel:', 'livetv'); ?> <?php echo $channelName; ?></span><span class="w-view"><?php _e('View:', 'livetv'); ?> <?php if($button == 'off'){ ?><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_justin_'.$i.'&mode=normal' ?>" class="bubble button" title="<?php _e('Swtich to normal view', 'livetv'); ?>"><?php _e('Normal', 'livetv'); ?></a><?php } ?> <a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_justin_'.$i.'&mode=full' ?>" class="bubble button" title="<?php _e('Swtich to Large view', 'livetv'); ?>"><?php _e('Large', 'livetv'); ?></a></span><span class="w-live"><?php _e('Live!', 'livetv'); ?> <?php echo '' . date('d-m-Y H:i', $live_until) . ''; ?></span></span></span><?php }
											
										if($livetv_view_offline == 'on' && $live_now == 'false' || $livetv_view_offline == 'widget_off' && $live_now == 'false')
										{ 
										?><span class="minithumb-justin offline"><span class="minithumb-justin-splash"><img src="<?php echo ''.$livetv_plugin_url.'images/offline.png' ?>" alt="mask" class="bubble" title="<?php _e('justin channel offline', 'livetv'); ?>" /></span><span class="minithumb-justin-thumb"><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_justin_'.$i.'&mode=normal' ?>"><img src="<?php echo ''.$livetv_plugin_url.'images/thumblist-mask-offline.png' ?>" class="bubble" title="<?php _e('Channel by', 'livetv'); ?> <?php echo ''.$userName.'' ?> <?php _e('from justin', 'livetv'); ?>" alt="justin thumbnail" /></a></span><span class="minithumb-justin-info" style="color:<?php echo ''.$livetv_span_color.''; ?>"><span class="w-off-viewers"><?php _e('Viewers: offline', 'livetv'); ?></span><span class="w-off-user"><?php _e('user:', 'livetv'); ?> <?php echo $userName; ?></span><span class="w-off-channel"><?php _e('channel:', 'livetv'); ?> <?php echo $channelName; ?></span><span class="w-off-view"><?php _e('View:', 'livetv'); ?> <?php if($button == 'off'){ ?><a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_justin_'.$i.'&mode=normal' ?>" class="bubble button" title="<?php _e('Swtich to normal view', 'livetv'); ?>"><?php _e('Normal', 'livetv'); ?></a><?php } ?> <a href="<?php echo $livetv_current_url . 'liveview=live_'.$userID.'_justin_'.$i.'&mode=full' ?>" class="bubble button" title="<?php _e('Swtich to Large view', 'livetv'); ?>"><?php _e('Large', 'livetv'); ?></a></span><span class="w-off-live"><?php _e('Live: Offline', 'livetv'); ?></span></span></span><?php }
									}
								}
							}
						}
						if($count == 0)
						{
							if($livetv_view_offline == 'off' || $livetv_view_offline == 'widget_off')
							{
								echo '<p class="'.$live_offline_class.'">';
								_e('Currently no live stream online', 'livetv');
								echo '</p>';
							}
						}
						echo '</div>';
												
				break;
												
									
				default:
									
					$live_now = false;
					
				break;
											
			endswitch;

		}
	//Clean buffer and ending file
	$page = ob_get_contents();
	ob_end_clean();
	
	file_put_contents($cache, $page);
	echo ''.$page.'';
	}
}
?>
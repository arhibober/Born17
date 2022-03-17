<?php
/* 
This file is part of HeatMap Theme AdAptive
See license.txt (distributed with this file) for details of
license, contributors, copyright notices, credits and trademarks.
*/

$heatmapthemead_options = heatmapthemead_get_theme_options();

// get the theme layout global which can override the options setting
global $heatmapthemead_options_override;

// okay if the global theme layout is set then use that
if ( isset ( $heatmapthemead_options_override['theme_layout'] ) ) $current_theme_layout  = $heatmapthemead_options_override['theme_layout'];
else {
	// Otherwise change the layout of the theme based on the options.
	$current_theme_layout = $heatmapthemead_options['theme_layout'];
	$current_theme_layout = apply_filters('heatmapthemead_render_layout_options', $current_theme_layout );
}

print '<!DOCTYPE html>' . HMTA_NL;

// get the theme name and version
$heatmapthemead_this_theme = wp_get_theme();


// output html comment containing theme credits
print '<!-- '; bloginfo('name'); print ' uses '. esc_attr($heatmapthemead_this_theme->Name) . ' v' . esc_attr($heatmapthemead_this_theme->Version) . ' by heatmaptheme.com -->' . HMTA_NL;

print '<!-- render.php -->';
print '<html '; language_attributes(); print '>' . HMTA_NL;

print '<!-- Beginning of <head> -->' . HMTA_NL;
print '<head>'. HMTA_NL;
global $user_ID;
if ($user_ID == 0)
	echo "<style>
		#menu-item-1691:hover #menu-item-3165
		{
			display: none !important;
		}
	<style>";
global $wpdb;
$sqlstr = "select group_id from wp_users where id=".$user_ID;
$groups = $wpdb->get_results ($sqlstr, ARRAY_A);
switch ($groups [0]["group_id"])
{
	case 2:
		echo "<style>
			#menu-item-1691:hover #menu-item-3022
			{
				display: block !important;
			}
		</style>";
		break;
	case 3:
		echo "<style>
			#menu-item-1691:hover #menu-item-3042
			{
				display: block !important;
			}
		</style>";	
		break;
	case 4:
		echo "<style>
			#menu-item-1691:hover #menu-item-3041
			{
				display: block !important;
			}
		</style>";
		break;		
	case 5:
		echo "<style>
			#menu-item-1691:hover #menu-item-3040
			{
				display: block !important;
			}
		</style>";
		break;
	case 6:
		echo "<style>
			#menu-item-1691:hover #menu-item-3039
			{
				display: block !important;
			}
		</style>";
		break;
}
switch ($user_ID)
{
	case 65:
		echo "<style>
			#menu-item-1691:hover #menu-item-3916
			{
				display: block !important;
			}
		</style>";	
case 52:
		echo "<style>
			#menu-item-1691:hover #menu-item-3042
			{
				display: block !important;
			}
		</style>";	
		break;
	case 53:
		echo "<style>
			#menu-item-1691:hover #menu-item-3041
			{
				display: block !important;
			}
		</style>";
		break;
	case 60:
		echo "<style>
			#menu-item-1691:hover #menu-item-3661
			{
				display: block !important;
			}
		</style>";
		break;
	case 63:
		echo "<style>
			#menu-item-1691:hover #menu-item-3832
			{
				display: block !important;
			}
		</style>";
		break;
	case 64: 
		echo "<style>
			#menu-item-1691:hover #menu-item-3899
			{
				display: block !important;
			}
		</style>";
		case 67: 
		echo "<style>
			#menu-item-1691:hover #menu-item-3915
			{
				display: block !important;
			}
		</style>";
		break;
		case 69: 
		echo "<style>
			#menu-item-1691:hover #menu-item-4117
			{
				display: block !important;
			}
		</style>";
case 68: 
		echo "<style>
			#menu-item-1691:hover #menu-item-3917
			{
				display: block !important;
			}
		</style>";
		break;
	case 1:	case 57: case 61:
		echo "<style>
			#menu-item-1691:hover #menu-item-3042, #menu-item-1691:hover #menu-item-3041, #menu-item-1691:hover #menu-item-3040, #menu-item-1691:hover #menu-item-3039, #menu-item-1691:hover #menu-item-3194, #menu-item-1691:hover #menu-item-3661, #menu-item-1691:hover #menu-item-3832, #menu-item-1691:hover #menu-item-3899, #menu-item-1691:hover #menu-item-3913, #menu-item-1691:hover #menu-item-3917, #menu-item-1691:hover #menu-item-3915
			{
				display: block !important;
			}
		</style>";
		break;
	case 0:
		echo "<style>
			#menu-item-544, #menu-item-545
			{
				display: none !important;
			}
		</style>";
		break;
	case 48:
		echo "<style>
			#wpadminbar
			{
				display: none !important;
			}
		</style>";
		break;
}
	if (($groups [0]["group_id"] != 1) && (($user_ID != 1) && ($user_ID != 57)))
		echo "<style>
			#menu-item-2204
			{
				display: none !important;
			}
	</style>";


print '<!-- heatmapthemead_pre_wp_head hook -->' . HMTA_NL;
do_action('heatmapthemead_pre_wp_head');
print '<!-- end of heatmapthemead_pre_wp_head hook -->' . HMTA_NL;

print '<!-- wp_head()-->';
wp_head(); 
print '<!-- End of wp_head() -->' . HMTA_NL;

print '<!-- heatmapthemead_post_wp_head hook -->' . HMTA_NL;
do_action('heatmapthemead_post_wp_head');
print '<!-- end of heatmapthemead_post_wp_head hook -->' . HMTA_NL;
print '<!--[if lt IE10]><style type="text/css">#heatmapthemead-footer-container{width: 1258px;margin:0 auto;bottom:10px;}#heatmapthemead-header{width: 1258px;margin: 0 auto;}#heatmapthemead-main{width: 1258px;margin:0 auto; }#heatmapthemead-primary-sidebar{position:absolute;right:950px;}</style><![endif]-->'. HMTA_NL;
print '</head>' . HMTA_NL;
print '<!-- End of <head> -->' . HMTA_NL;

// the additional heatmap responsive classes are filter into body_class() using heatmapthemead_body_class()
print '<body '; body_class(); print '>' . HMTA_NL;

print  '<!-- heatmapthemead_start_body hook -->' . HMTA_NL;;
do_action('heatmapthemead_start_body_hook');
print '<!-- end of heatmapthemead_start_body hook -->' . HMTA_NL;

do_action('heatmapthemead_pre_header_hook');

print '<!-- The Header Bars -->' . HMTA_NL;


print '<div id="heatmapthemead-header-wipe">' . HMTA_NL;
	print '<div id="heatmapthemead-header">' . HMTA_NL;
		print '<div id="heatmapthemead-header-container">' . HMTA_NL;
			do_action('heatmapthemead_header_hook');		
		print '</div> <!-- id="heatmapthemead-header-container" -->' . HMTA_NL;
	print '</div> <!-- id="heatmapthemead-header" -->' . HMTA_NL;
print '</div> <!-- id="heatmapthemead-header-wipe" -->' . HMTA_NL;

do_action('heatmapthemead_post_header_hook');

print '<!-- The main part of the page (with content and sidebars) -->' . HMTA_NL;

print '<div id="heatmapthemead-main-wipe">' . HMTA_NL;

	print '<div id="heatmapthemead-main">' . HMTA_NL;
		do_action('heatmapthemead_main_top_hook');
  		print '<div id="heatmapthemead-content">' . HMTA_NL;
    		print '<div id="heatmapthemead-the-content" class="site-content">' . HMTA_NL;
				print '<div id="heatmapthemead-the-content-container" role="main">' . HMTA_NL;
					do_action('heatmapthemead_the_content_hook');
				print '</div> <!-- id="heatmapthemead-the-content-container" --> ' . HMTA_NL;
			print'</div> <!-- id="heatmapthemead-the-content" --> ' . HMTA_NL;
  		print '</div> <!-- id="heatmapthemead-content" --> ' . HMTA_NL;
		
		// if only the Content is specified then ignore the sidebars
		if ($current_theme_layout!='content')
		{
				
			if (($current_theme_layout=='primary-sidebar-content') || ($current_theme_layout=='both-sidebars')) {
				
				// if this is a two column setup using only the content and multi then miss this div out		

				print '<!-- primary sidebar -->' . HMTA_NL; 
				print '<div id="heatmapthemead-primary-sidebar">' . HMTA_NL;
					print '<div id="heatmapthemead-primary-sidebar-container" role="complementary">' . HMTA_NL; 
						do_action('heatmapthemead_primary_hook');		
					print '</div> <!-- id="heatmapthemead-primary-sidebar-container" -->' . HMTA_NL; 
				print'</div> <!-- id="heatmapthemead-primary-sidebar" -->' . HMTA_NL;  
			}
			
			// if this is a two column setup using only the content and single then miss this div out
			if (($current_theme_layout=='content-secondary-sidebar') || ($current_theme_layout=='both-sidebars')) {

				print '<!-- secondary sidebar -->' . HMTA_NL; 
				print '<div id="heatmapthemead-secondary-sidebar">' . HMTA_NL;
					print '<div id="heatmapthemead-secondary-sidebar-container" role="complementary">' . HMTA_NL;
						do_action('heatmapthemead_secondary_hook');
					print '</div> <!-- id="heatmapthemead-secondary-sidebar-container" -->' .HMTA_NL;
				print'</div> <!-- id="heatmapthemead-secondary-sidebar" -->' .HMTA_NL;
			}
		}
		do_action('heatmapthemead_main_bottom_hook');
	print '</div> <!-- id="heatmapthemead-main" -->' . HMTA_NL;

print '</div> <!-- id="heatmapthemead-main-wipe" -->' . HMTA_NL; 

print '<!-- Footer -->' . HMTA_NL; 


do_action('heatmapthemead_pre_footer_hook');

print '<div id="heatmapthemead-footer-wipe">' . HMTA_NL; 
	print '<div id="heatmapthemead-footer">' . HMTA_NL;
		print '<div id="heatmapthemead-footer-container" role="complementary">' . HMTA_NL; 
			do_action('heatmapthemead_footer_hook'); 
		print '</div> <!-- id="heatmapthemead-footer-container" -->' . HMTA_NL; 
	print '</div> <!-- id="heatmapthemead-footer" -->' . HMTA_NL; 
print '</div> <!-- id="heatmapthemead-footer-wipe" -->' . HMTA_NL; 

do_action('heatmapthemead_post_footer_hook');

print '<!-- wp_footer() -->' . HMTA_NL; 	
wp_footer();
print '<!-- End of wp_footer() -->' . HMTA_NL;

print '<!-- Number of Queries:'; print (get_num_queries()); print '   Seconds: '; timer_stop(1); echo '-->'; echo HMTA_NL; 
	
print '<!-- heatmapthemead_end_body hook -->' . HMTA_NL; 
do_action('heatmapthemead_end_body_hook');
print '<!-- end of heatmapthemead_end_body hook -->' . HMTA_NL; 
	
print '</body>' . HMTA_NL; 

print '</html>' . HMTA_NL;

print '<!-- End of render.php -->' . HMTA_NL;
?>
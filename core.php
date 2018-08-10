<?php
/*
Plugin Name: core Functions Plugin for mistyffiction.com
Description: Site specific code changes for mistyffiction.com
*/
/* Start Adding Functions Below this Line */

function remove_more_jump_link($link) { 
	$offset = strpos($link, '#more-');
	if ($offset) {
		$end = strpos($link, '"',$offset);
	}
	if ($end) {
		$link = substr_replace($link, '', $offset, $end-$offset);
	}
	return $link;
}

add_filter('the_content_more_link', 'remove_more_jump_link');

//add_filter('ptrn/post_content','my_excerpt_adding_function');

function my_excerpt_adding_function($content) {

	global $post;

	add_filter('ptrn/bypass_filtering','toggle_patreon_filtering');

	$content_arr = get_extended ( $post->post_content );
	$excerpt = $content_arr['main'];
	
	remove_filter('ptrn/bypass_filtering','toggle_patreon_filtering');
	
	// Format the excerpt in any way you want after this point
	
	return $excerpt.$content;
}

function toggle_patreon_filtering($filter) {
	
	if(!$filter) {
		return true;		
	}	
	return false;
}

function restrict_access_if_logged_out(){
	global $post;
	if (is_single() && !is_user_logged_in()){
        $current_post_categories = wp_get_post_categories($post->ID);
        if (in_array(get_cat_id('NSFW'),$current_post_categories)) {
    		// More tag
    		$content_parts = get_extended( $post->post_content );
		    if( ! empty( $content_parts['extended'] ) ) {
				$preview = $content_parts['main'];
		    }
			$message = "Hey there!<br />While this story is free to read, it is a work of adult fiction " .
				"and I need you to provide some level of identification to read it. So, please, " .
				"either sign in below or [<a href=\"/register\">register for an account</a>]. Thanks for your understanding!" .
				"- Misty F" . do_shortcode('[wppb-login]');
		    // Return the preview
    		return wpautop( $preview ) . wpautop( $message );
		} else {
			return $post->post_content;	
		}
	} else {
		return $post->post_content;	
	}
}
	
add_filter( 'the_content', 'restrict_access_if_logged_out', 3 );

/* Stop Adding Functions Below this Line */
?>

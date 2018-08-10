<?php
/*
Plugin Name: Formatting Functions Plugin for mistyffiction.com
Description: Site specific code changes for mistyffiction.com
*/
/* Start Adding Functions Below this Line */
function story_div_shortcode( $atts, $content = null ) {
	$post = get_page_by_title($atts[0], OBJECT, 'post');
	$post_id = $post->ID;
	$class_arr = get_post_class( 'story', ${post_id} );
	$classes = "class=\"".implode(" ",$class_arr)."\"";
	$first_bit = "<div id=\"post-${post_id}\" ${classes}";
	$link = get_permalink($post->ID);
	$content_arr = get_extended( $post->post_content );
	$content_lines = explode("\r", $content_arr['main']);
	$setting = get_post_meta($post_id,'setting_name',true);
	$synop = get_post_meta($post_id,'preview_text',true);
	$third_bit = "<br /><i>" . $setting . "</i><br /><strong>Synopsis :</strong>" . $synop . "[<a href=\"" . $link . "\">Read the revised verion here</a>] " . "</div>";
	return $first_bit ."><strong>" . $atts[0] . "</strong>" . $content . $third_bit;
}
add_shortcode( 'story_div', 'story_div_shortcode' );

function test_things( $atts, $content = null ) {
	$post = get_page_by_title($atts[0], OBJECT, 'post');
	$post_id = $post->ID;
	$class_arr = get_post_class( 'story', ${post_id} );
	$classes = "class=\"".implode(" ",$class_arr)."\"";
	$first_bit = "<div id=\"post-${post_id}\" ${classes}";
	$link = get_permalink($post->ID);
	$content_arr = get_extended( $post->post_content );
	$content_lines = explode("\r", $content_arr['main']);
	$setting = array_shift($content_lines);
	$synop = implode("<br />", $content_lines);
	$third_bit = "[<a href=\"" . $link . "\"> Read Here</a>]<br />" . $setting . "<br /><br />Synopsis :<br />" . $synop . "</div>";
	return $first_bit .">" . $atts[0] . $content . $third_bit;
}

add_shortcode( 'test_echo', 'test_things');

function show_story_footer ($atts, $content = null) {
	return '<a href="http://blog.mistyffiction.com/ask">Send Me Comments</a> about this story or post below what you thought!';
}
	
add_shortcode ('story_footer', 'show_story_footer');

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

function wpse_wpautop_nobr( $content ) {
    return wpautop( $content, false );
}

add_filter( 'the_content', 'wpse_wpautop_nobr' );
add_filter( 'the_excerpt', 'wpse_wpautop_nobr' );

function custom_excerpt ( $post ) {
		$content = wp_trim_words( get_post_meta($post->ID, 'preview_text', true), '50', " Read More of " . esc_html( get_the_title() ) );
		$content = '<span class="setting-name"><i>' . get_post_meta($post->ID, 'setting_name', true) . "</i><hr />" . $content . '</span>';
		return '<a href="' . esc_url( get_permalink() ) . '" tabindex="-1" rel="bookmark"><span class="preview-text">' . $content . '</span></a>';
}

/* Stop Adding Functions Below this Line */
?>

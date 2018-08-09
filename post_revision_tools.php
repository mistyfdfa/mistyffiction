/*
Plugin Name: Post Revision Tools
Plugin URI: http://mistyffiction.com
Description: Tools to access post revisions
Author: Misty F
Version: 1.0
Author URI: https://github.com/mistyfdfa/
*/

<?php
  function get_named_revision () {
    $custom_field_keys = get_post_custom_keys();
    foreach ( $custom_field_keys as $key => $value ) {
      if ( $key == "named_revision_id" )
        if ( ! is_null( $value ))
          return $value;
   }
  }

  function link_to_named_revision () {
      $rev_id = get_named_revision();
      $rev = wp_get_post_revision( $post );
      return get_permalink( $rev );
  }

add_shortcode( 'rev', 'link_to_named_revision');
?>

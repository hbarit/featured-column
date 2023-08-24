<?php

/**
 * Adding Featured Posts column in the admin
 *
 */

add_filter( 'manage_post_posts_columns', 'fx_filter_posts_columns' );
function fx_filter_posts_columns( $columns ) {
  $columns['featured_post'] = __( 'Featured' );  
  return $columns;
}


add_action( 'manage_post_posts_custom_column', 'fx_post_column', 10, 2);
function fx_post_column( $column, $post_id ) {  
    switch($column){
        case 'featured_post':       
            if( get_post_meta($post_id, 'post_featured')[0] == 1 ){
                echo '<span class="dashicons dashicons-star-filled" style="padding-left: 20px; color: #F6BB06"></span>';
            }          
        break;
    }    
}


?>
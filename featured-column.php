<?php

/**
 * Adding Featured Product Posts Metabox
 *
 */


function product_add_featured_meta_box() {
    add_meta_box(
        'featured_meta_box',
        'Featured',
        'render_featured_meta_box',
        'product',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'product_add_featured_meta_box');

function render_featured_meta_box($post) {
    $value = get_post_meta($post->ID, '_is_featured', true);
    wp_nonce_field('save_featured_meta_box', 'featured_meta_box_nonce');
    ?>
    <label>
        <input type="checkbox" name="is_featured" value="1" <?php checked($value, '1'); ?> />
        Mark as Featured
    </label>
    <?php
}

function save_featured_meta_box($post_id) {
    if (!isset($_POST['featured_meta_box_nonce']) || !wp_verify_nonce($_POST['featured_meta_box_nonce'], 'save_featured_meta_box')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $is_featured = isset($_POST['is_featured']) ? '1' : '0';
    update_post_meta($post_id, '_is_featured', $is_featured);
}
add_action('save_post', 'save_featured_meta_box');




/**
 * Adding Featured Posts column in the admin
 *
 */

 add_filter( 'manage_product_posts_columns', 'fx_filter_posts_columns' );
 function fx_filter_posts_columns( $columns ) {
   $columns['featured_post'] = __( 'Featured' );  
   return $columns;
 }
 
 
 add_action( 'manage_product_posts_custom_column', 'fx_post_column', 10, 2);
 function fx_post_column( $column, $post_id ) {  
     switch($column){
         case 'featured_post':       
             if( get_post_meta($post_id, '_is_featured')[0] == 1 ){
                 echo '<span class="dashicons dashicons-star-filled" style="padding-left: 20px; color: #F6BB06"></span>';
             }          
         break;
     }    
 }
 


?>

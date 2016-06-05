<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.iazami.ir/
 * @since      1.0.0
 *
 * @package    Picowall
 * @subpackage Picowall/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Picowall
 * @subpackage Picowall/admin
 * @author     mohammad azami <iazami@outlook.com>
 */
class Picowall_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	* Meta Box setup function
	*/

	public function picowall_metabox_setup(){

		/* Add meta box on the 'add_meta_boxes' hook. */
		add_action('add_meta_boxes', array($this, 'picowall_add_metabox') );

		/* Save post meta on the 'save_post' hook. */

		add_action('save_post', array($this, 'picowall_save_metabox'), 10, 2);
	}

/**
* Creating meta box
*/

public function picowall_add_metabox(){

	add_meta_box(
		'picowall_metabox', // ID
		esc_html__('Photo Resizer', $this->plugin_name), // Title
		array($this, 'picowall_metabox_callback'), // Callback Function
		'post',  // Admin page (or post type)
		'advanced', // Context
		'default' // Priority
);

}

/**
* Save and Update Fields.
*/

public function picowall_save_metabox($post_id, $post){

	/* Verify the nonce before proceeding. */
	if( !isset( $_POST['picowall_metabox_nonce'] ) || !wp_verify_nonce( $_POST['picowall_metabox_nonce'], basename(__FILE__) ) )
	return $post_id;

	/* Get post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has premission to edit the post. */
	if( !current_user_can( $post_type->cap->edit_post, $post_id ) )
	return $post_id;

	/* Get the posted data */
	$new_meta_value = ( isset( $_POST['picowall-photo-url'] ) ? $_POST['picowall-photo-url'] : '' );

	$meta_key = 'picowall_photo_url';

	/* Get the meta value */
	$meta_value = get_post_meta($post_id, $meta_key, true);

	/* If a new meta value was added and there was no previous value, add it. */
  if ( $new_meta_value && '' == $meta_value )
    add_post_meta( $post_id, $meta_key, $new_meta_value, true );

  /* If the new meta value does not match the old value, update it. */
  elseif ( $new_meta_value && $new_meta_value != $meta_value )
    update_post_meta( $post_id, $meta_key, $new_meta_value );

  /* If there is no new meta value but an old value exists, delete it. */
  elseif ( '' == $new_meta_value && $meta_value )
    delete_post_meta( $post_id, $meta_key, $meta_value );

}

/**
* Meta Box html view
*/

public function picowall_metabox_callback($object, $box){

	wp_nonce_field( basename(__FILE__), 'picowall_metabox_nonce');

	include_once( dirname(__FILE__) . '/partials/picowall-metabox-view.php' );

}

}

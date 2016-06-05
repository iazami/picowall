<?php
/**
 *
 * @package    Picowall
 * @subpackage Picowall/public
 * @author     mohammad azami <iazami@outlook.com>
 */
class Picowall_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/* Register role */

	public function picowall_rewrite_rules(){
		add_rewrite_rule(
		'download/?([^/]*)',
		'index.php?pagename=index.php?pagename=download&picowall_file_name=$matches[1]',
		'top'
		);
	}

	/* Get the query vars */

	function picowall_query_vars($vars) {
	  $vars[] = 'picowall_file_name';
	  return $vars;
	 }

	 /* Create a public face for resizing result */

	public function picowall_rewrite_display(){

		$download_page = get_query_var('pagename');
		$file_name = get_query_var('picowall_file_name');

		$query = array(
			'width',
			'height',
			'download_id',
			'option'
		);

	  if ('download' == $download_page && '' != $file_name){

			foreach ($query as $value) {

				if(isset($_GET[$value]) && is_numeric($_GET[$value])){
					$setting[] = sanitize_text_field($_GET[$value]);
				}
				elseif (isset($_GET[$value]) && is_string($_GET[$value])) {
					$setting[] = sanitize_text_field($_GET[$value]);
				}
				else {
					header("HTTP/1.0 404 Not Found");
					echo "<h1>Not Found.</h1>";
					exit();
				}
			}

			$image = get_post_meta( $setting[2], 'picowall_photo_url', true );

			if($image == ''){
				header("HTTP/1.0 404 Not Found");
				echo "<h1>Not Found.</h1>";
				exit();
			}

			$resizer = new Picowall_Resize($image);
			$image = $resizer->displayImage($setting[0], $setting[1], $setting[3]);

			$this->picowall_output_view($image,$file_name,$setting[0],$setting[1]);

			exit();
		}
	}

	public function picowall_output_view($source,$name,$width, $height){

		$extension = strtolower(strrchr($name, '.'));

		switch($extension){
			case '.jpg':
			case '.jpeg':
				$content_type = 'image/jpeg';
				break;
			case '.gif':
				$content_type = 'image/gif';
				break;
			case '.png':
				$content_type = 'image/png';
				break;
		}

		//$name = preg_replace('/[0-9]+/', '', $name); /* strip the actual size in file name */
		$name = basename($name, $extension);
		$name = $name.'-'.$width.'-'.$height.$extension; /* add the new width and height to file name */

		include_once( dirname(__FILE__) . '/partials/picowall-output-view.php' );

	}

	/* public function and shortcodes */

	public function picowall_functions_loader(){
		include_once( dirname(__FILE__) . '/picowall-public-functions.php' );
	}

}

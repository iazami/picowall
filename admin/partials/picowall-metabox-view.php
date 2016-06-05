<?php
/**
* meta box view
*
* @package Picowall
* @subpackage Picowall/admin/partials
*/
?>

<div class="wrap">
  <div id="col-container">
    <div class="col-wrap picowall-metabox">
      <div class="inside">
        <fieldset>
          <label for="picowall-photo-url">
            <b><?php _e( "Please enter the url of your image:", $this->plugin_name ); ?></b>
          </label>
          <input type="text" name="picowall-photo-url" id="picowall-photo-url" value="<?php echo esc_attr( get_post_meta( $object->ID, 'picowall_photo_url', true ) ); ?>" size="50" />
        </fieldset>
      </div>
    </div>
  </div>
</div>

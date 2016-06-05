<?php
/**
* Public functions
*
* @package    Picowall
* @subpackage Picowall/public
* @author     mohammad azami <iazami@outlook.com>
*/

/* this function will return an array of links */

function picowall($size_setting, $global_option = 'auto', $id = null){
  global $post;
  if($global_option == '')
    $global_option = 'auto';
  $download_id = (isset($id) && is_numeric($id) ? $id : $post->ID);
  $download_link = get_site_url()."/download/".basename( get_post_meta($download_id, 'picowall_photo_url', true));

  $pos = strpos($size_setting, '|'); /*is there more than one setting block ? */

  if($pos == false){

    /*no there is only one setting block eg: width,height,option */

    $setting = explode(',' ,$size_setting);

    if(count($setting) == 3){
      $url = $download_link.'?&width='.$setting[0].'&height='.$setting[1].'&option='.$setting[2].'&download_id='.$download_id;
      $links[] = array(
        'size' => $setting[0].'×'.$setting[1],
        'url'  => $url
      );
    }elseif (count($setting) == 2 ) {
      $url = $download_link.'?&width='.$setting[0].'&height='.$setting[1].'&option='.$global_option.'&download_id='.$download_id;
      $links[] = array(
        'size' => $setting[0].'×'.$setting[1],
        'url'  => $url
      );
    }
  }
  else{

    /* yes there is more eg: wdith1,height1,option1|wdith2,height2,option2 ... |widh(n),height(n),option(n) */

    $setting_block = explode('|', $size_setting);

    foreach ($setting_block as $cell) {

      $setting = explode(',' ,$cell);

      if(count($setting) == 3){
        $url = $download_link.'?&width='.$setting[0].'&height='.$setting[1].'&option='.$setting[2].'&download_id='.$download_id;
        $links[] = array(
          'size' => $setting[0].'×'.$setting[1],
          'url'  => $url
        );
      }
      elseif (count($setting) == 2 ) {
        $url = $download_link.'?&width='.$setting[0].'&height='.$setting[1].'&option='.$global_option.'&download_id='.$download_id;
        $links[] = array(
          'size' => $setting[0].'×'.$setting[1],
          'url'  => $url
        );
      }
    }
  }

  return $links;

}

/*This function will print the result of above function */

function picowall_generate_links($size_setting, $global_option = 'auto', $sep='', $id = null){

  $links = picowall($size_setting, $global_option, $id);
  $c = count($links);
  $i = 0;
  $html = '';
    while(true){
          if($c == 0 || $i >= $c){
            break;
          }
          $html = $html . '<a href="'.$links[$i]['url'].'" title="download image '.$links[$i]['size'].'" target="_blank">'.$links[$i]['size'].'</a>&nbsp;'.$sep.'&nbsp;';
          $i++;
    }
    $x = strlen($sep);
    $html = substr_replace($html, '', (-$x + -6));
    echo $html;
}

/* same above */

function picowall_shortcode_links($size_setting, $global_option = 'auto', $sep='', $id = null){

  $links = picowall($size_setting, $global_option, $id);
  $c = count($links);
  $i = 0;
  $html = '';
    while(true){
          if($c == 0 || $i >= $c){
            break;
          }
          $html = $html . '<a href="'.$links[$i]['url'].'" title="download image '.$links[$i]['size'].'" target="_blank">'.$links[$i]['size'].'</a>&nbsp;'.$sep.'&nbsp;';
          $i++;
    }
    $x = strlen($sep);
    $html = substr_replace($html, '', (-$x + -6));
    return $html;
}

/* generate shortcode */

function picowall_generate_shortcode($atts){
  extract(
    shortcode_atts(
      array(
        'size' => '',
        'option' => '',
        'sep' => ''
      ),$atts)
    );
    return picowall_shortcode_links($size,$option,$sep);
}

add_shortcode('picowall', 'picowall_generate_shortcode');

?>

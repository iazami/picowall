<?php
/**
*
* A class definition in order to resize images
*
* @since      1.0.0
* @package    Picowall
* @subpackage Picowall/includes
* @author     mohammad azami <iazami@outlook.com>
*/

class Picowall_Resize{

  private $image;
  private $width;
  private $height;
  private $imageResized;
  private $extension;

  public function __construct($fileName){
    /* Open up the file */
    $this->image = $this->openImage($fileName);

    /* Get width and height */
    $this->width  = imagesx($this->image);
    $this->height = imagesy($this->image);
  }

  private function openImage($file){
    /* Get extension */
    $this->extension = strtolower(strrchr($file, '.'));

    switch($this->extension){
      case '.jpg':
      case '.jpeg':
        $img = @imagecreatefromjpeg($file);
        break;
      case '.gif':
        $img = @imagecreatefromgif($file);
        break;
      case '.png':
        $img = @imagecreatefrompng($file);
        break;
        default:
        $img = false;
          break;
    }
    return $img;
  }

  public function resizeImage($newWidth, $newHeight, $option="auto"){

    /* Get optimal width and height - based on $option */
    $optionArray = $this->getDimensions($newWidth, $newHeight, strtolower($option));

    $optimalWidth  = $optionArray['optimalWidth'];
    $optimalHeight = $optionArray['optimalHeight'];

    /* Resample - create image canvas of x, y size */
    $this->imageResized = imagecreatetruecolor($optimalWidth, $optimalHeight);
    imagecopyresampled($this->imageResized, $this->image, 0, 0, 0, 0, $optimalWidth, $optimalHeight, $this->width, $this->height);

    /* if option is 'crop', then crop too */
    if ($option == 'crop') {
        $this->crop($optimalWidth, $optimalHeight, $newWidth, $newHeight);
    }
  }

 private function getDimensions($newWidth, $newHeight, $option){
    switch ($option)
     {
         case 'exact':
             $optimalWidth = $newWidth;
             $optimalHeight= $newHeight;
             break;
         case 'portrait':
             $optimalWidth = $this->getSizeByFixedHeight($newHeight);
             $optimalHeight= $newHeight;
             break;
         case 'landscape':
             $optimalWidth = $newWidth;
             $optimalHeight= $this->getSizeByFixedWidth($newWidth);
             break;
         case 'auto':
             $optionArray = $this->getSizeByAuto($newWidth, $newHeight);
             $optimalWidth = $optionArray['optimalWidth'];
             $optimalHeight = $optionArray['optimalHeight'];
             break;
         case 'crop':
             $optionArray = $this->getOptimalCrop($newWidth, $newHeight);
             $optimalWidth = $optionArray['optimalWidth'];
             $optimalHeight = $optionArray['optimalHeight'];
             break;
     }
     return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
  }

 private function getSizeByFixedHeight($newHeight){
   $ratio = $this->width / $this->height;
   $newWidth = $newHeight * $ratio;
   return $newWidth;
 }

 private function getSizeByFixedWidth($newWidth){
   $ratio = $this->height / $this->width;
   $newHeight = $newWidth * $ratio;
   return $newHeight;
 }

 private function getSizeByAuto($newWidth, $newHeight){
  if ($this->height < $this->width)
  /* Image to be resized is wider (landscape) */
  {
      $optimalWidth = $newWidth;
      $optimalHeight= $this->getSizeByFixedWidth($newWidth);
  }
  elseif ($this->height > $this->width)
  /* Image to be resized is taller (portrait) */
  {
      $optimalWidth = $this->getSizeByFixedHeight($newHeight);
      $optimalHeight= $newHeight;
  }
  else
  /* Image to be resizerd is a square */
  {
      if ($newHeight < $newWidth) {
          $optimalWidth = $newWidth;
          $optimalHeight= $this->getSizeByFixedWidth($newWidth);
      } else if ($newHeight > $newWidth) {
          $optimalWidth = $this->getSizeByFixedHeight($newHeight);
          $optimalHeight= $newHeight;
      } else {
          /* Sqaure being resized to a square */
          $optimalWidth = $newWidth;
          $optimalHeight= $newHeight;
      }
  }

  return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
}

 private function getOptimalCrop($newWidth, $newHeight){

     $heightRatio = $this->height / $newHeight;
     $widthRatio  = $this->width /  $newWidth;

     if ($heightRatio < $widthRatio) {
         $optimalRatio = $heightRatio;
     } else {
         $optimalRatio = $widthRatio;
     }

     $optimalHeight = $this->height / $optimalRatio;
     $optimalWidth  = $this->width  / $optimalRatio;

     return array('optimalWidth' => $optimalWidth, 'optimalHeight' => $optimalHeight);
}

 private function crop($optimalWidth, $optimalHeight, $newWidth, $newHeight){
    /* Find center - this will be used for the crop */
  $cropStartX = ( $optimalWidth / 2) - ( $newWidth /2 );
  $cropStartY = ( $optimalHeight/ 2) - ( $newHeight/2 );

  $crop = $this->imageResized;
  //imagedestroy($this->imageResized);

  /*  Now crop from center to exact requested size */
  $this->imageResized = imagecreatetruecolor($newWidth , $newHeight);
  imagecopyresampled($this->imageResized, $crop , 0, 0, $cropStartX, $cropStartY, $newWidth, $newHeight , $newWidth, $newHeight);
}

public function displayImage($width, $height, $option='auto'){

  $this->resizeImage($width, $height, strtolower($option));

  switch($this->extension){

    case '.jpg':
    case '.jpeg':
      ob_start();
      imagejpeg($this->imageResized, null, 100);
      $data = ob_get_contents();
      ob_end_clean();
      $photo = '<img id="img" src="data:image/jpeg;base64,' . base64_encode($data) . '" />';
      break;

    case '.gif':
      ob_start();
      imagegif($this->imageResized, null);
      $data = ob_get_contents();
      ob_end_clean();
      $photo = '<img id="img" src="data:image/gif;base64,' . base64_encode($data) . '" />';
      break;

    case '.png':
      /* Scale quality from 0-100 to 0-9 */
      $scaleQuality = round((100/100) * 9);

      /* Invert quality setting as 0 is best, not 9*/
      $invertScaleQuality = 9 - $scaleQuality;
      ob_start();
      imagepng($this->imageResized, null, $invertScaleQuality);
      $data = ob_get_contents();
      ob_end_clean();
      $photo = '<img id="img" src="data:image/png;base64,' . base64_encode($data) . '" />';
    break;
  }

  imagedestroy($this->imageResized);

  return $photo;

}

}

 ?>

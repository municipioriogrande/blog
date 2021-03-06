<?php
	/** Insta resize
	*
	*
	* @license	MIT
	* @copyright Copyright (C) musacivak,  All rights reserved.
	* @link https://github.com/
	* @author Musa Cıvak musacivak50@gmail.com
	*/

	namespace MSC\Instaresize;

	/**
	* Instagram resizer
	*/
	class Resize
	{
	protected $sizes;
        protected $images;
        protected $width;
        protected $height;
        protected $newWidth;
        protected $newHeight;
        protected $x;
        protected $y;
		public function check($photo = null)
		{
            try {
                //Get image size
                if($photo == null){
                    throw new \Exception("Error: You did not specify image.");
                    exit;
                }

                $this->sizes = @getimagesize($photo);
                $this->width = $this->sizes['0'];
                $this->height = $this->sizes['1'];

                //Check image extension

                switch ($this->sizes['mime']) {
                    case 'image/jpeg'   :
                        $this->images = @imagecreatefromjpeg($photo);
                        break;
                    case 'image/png'    :
                        $this->images = @imagecreatefrompng($photo);
                        break;
                    case 'image/gif'    :
                        $this->images = @imagecreatefromgif($photo);
                        break;
                    default :
                        throw new \Exception('Error: Unidentified image extension.');
                        exit;
                }

                //IMAGE PROCESS

                if($this->width <= 320 && $this->height <= 320){
                    $this->newHeight = round((320 / $this->width) * $this->height);
                    $this->newWidth = round(($this->newHeight / $this->height) * $this->width);

                    $im = imagecreatetruecolor(320, 320);
                    $wb = imagecolorallocate($im, 255, 255, 255);
                    imagefill($im,0,0,$wb);


                    $this->x = (320 - $this->newHeight) / 2;
                    $this->y = (320 - $this->newWidth) / 2;

                    imagecopyresized($im, $this->images, $this->x, $this->y, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
                }
                elseif ($this->width >= $this->height && $this->width >= 1080) {
                    $this->newHeight = round((1080 / $this->width) * $this->height);
                    $this->newWidth = round(($this->newHeight / $this->height) * $this->width);

                    if ($this->height < 575) {
                        $this->newHeight = 575;
                    } elseif ($this->height > 1080) {
                        $this->newHeight = 1080;
                    }

                    $im = imagecreatetruecolor(1080, 1080);
                    $wb = imagecolorallocate($im, 255, 255, 255);
                    imagefill($im, 0, 0, $wb);

                    if (1080 > $this->newHeight) {
                        $this->y = (1080 - $this->newHeight) / 2;
                    } else {
                        $this->y = ($this->newHeight - 1080) / 2;
                    }

                    if (1080 > $this->newWidth) {
                        $this->x = (1080 - $this->newWidth) / 2;
                    } else {
                        $this->x = ($this->newWidth - 1080) / 2;
                    }

                    imagecopyresized($im, $this->images, $this->x, $this->y, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
                }
                elseif ($this->width >= $this->height && $this->width < 1080) {
                    $this->newHeight = round((640 / $this->width) * $this->height);
                    $this->newWidth = round(($this->newHeight / $this->height) * $this->width);

                    $im = imagecreatetruecolor(640, $this->newHeight);
                    $wb = imagecolorallocate($im, 255, 255, 255);
                    imagefill($im, 0, 0, $wb);

                    if (640 > $this->newWidth) {
                        $this->x = (640 - $this->newWidth) / 2;
                    } else {
                        $this->x = ($this->newWidth - 640) / 2;
                    }

                    imagecopyresized($im, $this->images, $this->x, $this->y, 0, 0, $this->newWidth, $this->newHeight, $this->width, $this->height);
                }
                elseif ($this->height >= $this->width && $this->height > 1100) {
                    $this->newHeight = round((1080 / $this->width) * $this->height);
                    $this->newWidth = round((1349 / $this->height) * $this->width);

                    $im = imagecreatetruecolor(1080, 1349);
                    $wb = imagecolorallocate($im, 255, 255, 255);
                    imagefill($im, 0, 0, $wb);

                    if (1379 > $this->newHeight) {
                        $this->y = (1379 - $this->newHeight) / 2;
                    }
                    else {
                        $this->y = ($this->newHeight - 1379) / 2;
                    }
                    if (1080 > $this->newWidth) {
                        $this->x = (1080 - $this->newWidth) / 2;
                    } else {
                        $this->x = ($this->newWidth - 1080) / 2;
                    }


                    imagecopyresized($im, $this->images, $this->x, 0, 0, 0, $this->newWidth, 1349, $this->width, $this->height);
                }
                elseif ($this->height > $this->width && $this->height <= 1100) {
                    $this->newHeight = round((640 / $this->width) * $this->height);
                    $this->newWidth = round((799 / $this->height) * $this->width);

                    $im = imagecreatetruecolor(640, 799);
                    $wb = imagecolorallocate($im, 255, 255, 255);
                    imagefill($im, 0, 0, $wb);

                    if (799 > $this->newHeight) {
                        $this->y = (799 - $this->newHeight) / 2;
                    }
                    else {
                        $this->y = ($this->newHeight - 799) / 2;
                    }
                    if (640 > $this->newWidth) {
                        $this->x = (640 - $this->newWidth) / 2;
                    } else {
                        $this->x = ($this->newWidth - 640) / 2;
                    }

                

                    imagecopyresized($im, $this->images, $this->x, 0, 0, 0, $this->newWidth, 799, $this->width, $this->height);
                }
                $uniqID = uniqid();
                $path = plugin_dir_path(__FILE__)."resized_img/".$uniqID.".jpg";
                imagejpeg($im, $path, 100);
                return $path;
            }catch (\Exception $e) {
                return $e->getMessage();
            }
		}
	}

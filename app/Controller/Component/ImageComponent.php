<?php
    class ImageComponent extends Component {
        /*
        * @var array
        * @access private
        * 
        * array with allowed mime types
        */

        ///$this->Image->width(150);
        //$this->Image->width(75);  
        private $allowed_mime_types = array(
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif'
        );

        /*
        * @var array
        * @access private
        * 
        * array with allowed file extensions
        */
        private $allowed_extensions = array(
        'jpg',
        'jpeg',
        'png',
        'gif'
        );

        /*
        * @var string
        * @access private
        * 
        * save paths for thumbnail and upload image
        */
        private $save_paths = array(
        'upload' => '',
        'thumb' => ''
        );

        /*
        * @var string
        * @access private
        * 
        * path to file
        */
        private $file_path = null;

        /*
        * @var int
        * @access public
        * 
        * thumbnail width
        */
        public $width = 100;

        /*
        * @var int
        * @access public
        * 
        * thumbnail height
        */
        public $height = 100;

        /*
        * @var mixed
        * @access private
        * 
        * zoom crop
        */
        private $zoom_crop = 0;

        /*
        * @var pointer
        * @access private
        * 
        * object pointer for controller
        */
        private $controller = null;

        /*
        * @var array
        * @access public
        * 
        * array with error messages
        */
        private $errorMsg = array();

        /*
        * @access public
        * @param object pointer &$controller
        * 
        * init component with controller pointer
        */
        public function startup(Controller $controller) {
            $this->controller = &$controller;
        }

        public function set_path($upload_path, $m="big") {    
            
            if(!empty($upload_path) AND is_writable($upload_path) AND $m=="big")
            {
                $this->save_paths = array('upload' => $upload_path);
                return true;
            }
            elseif(!empty($upload_path) AND is_writable($upload_path) AND $m=="thumb")
            {
                $this->save_paths = array('thumb' => $upload_path);                
                return true;
            }
            else 
            {
                return false;
            }
        }
        /*
        * @access public
        * @param string $upload_path
        * @param string $thumb_path
        * 
        * set paths for upload and thumb
        */
        public function set_paths($upload_path, $thumb_path) {    
            
            if(!empty($upload_path) AND is_writable($upload_path) AND !empty($thumb_path) AND is_writable($thumb_path))
            {
                $this->save_paths = array(
                'upload' => $upload_path,
                'thumb' => $thumb_path 
                );                
                return true;
            }
            else 
            {
                return false;
            }

        }

        /*
        * @access public
        * @param mixed $zoom_crop
        * @return boulean success
        * 
        * set zoom crop for ThumbPHP
        */
        public function set_zoom_crop($zoom_crop) {
            if(empty($zoom_crop) OR $zoom_crop === '') return false;

            /*
            * allowed zoom crop parameter
            * from actual readme.txt
            */
            static $allowed_zoom_crop_param = array(
            'T',
            'B',
            'L',
            'R',
            'TL',
            'TR',
            'BL',
            'BR'
            );

            if($zoom_crop === 1 OR $zoom_crop === 'C') $this->zoom_crop = 1;
            elseif(extension_loaded('magickwand')
            AND in_array($zoom_crop, $allowed_zoom_crop_param)) $this->zoom_crop = $zoom_crop;
            else return false;

            return true;
        }

        /*
        * @access public
        * @param string $field
        * @return mixed destintion or false
        * 
        * upload image from $this->controller->data array and return success
        * writes upload path into file_path of component
        */
        public function upload_image($field,$filename='') {
            if(empty($field) OR $field === '') return false;

            // get Model and field
            $exploded = explode('.', $field);
            if(count($exploded) !== 2) return false;

            list($model, $value) = $exploded;


            // Image data had been send?
            if(array_key_exists($model, $this->controller->data)
            AND array_key_exists($value, $this->controller->data[$model])
            AND is_array($this->controller->data[$model][$value])) {

                // get pointer for lighter code
                //$file = &$this->controller->data[$model][$value];
                $file = $this->controller->data[$model][$value];

                //print_r($file);

                // does php get any upload errors?
                if(array_key_exists('error', $file) AND $file['error'] === 0) {
                    /*
                    * is the size OK?
                    * (bigger then 0 and smaller then 'upload_max_filesize' in php.ini
                    */

                    $serversize = str_replace("M","",ini_get('upload_max_filesize')); 
                    if($file['size'] === 0
                    OR (string)(ceil((int)$file['size']/1000000)) > $serversize) 
                    return  false;
                    // mimetype ok?
                    elseif(!in_array($file['type'], $this->allowed_mime_types)) 
                    return false;
                    else {
                        // get extension
                        $exploded = explode('.', $file['name']);
                        $extension = end($exploded);

                        // extension allowed?
                        if(in_array(strtolower($extension), $this->allowed_extensions)) {
                            // generate extension
                            if($filename!="")
                            {
                                $destination = $this->save_paths['upload'] .$filename; //. '.' . $extension;
                            }
                            else
                            {
                                $destination = $this->save_paths['upload'] .md5(microtime()) . '.' . $extension;
                            }

                            // move file from temp to upload directory
                            move_uploaded_file($file['tmp_name'], $destination);

                            // all OK?
                            if(file_exists($destination)) {
                                // write destination to internal file_path variable and return success
                                //$this->file_path = $destination;
                                $destArr = explode("/",$destination);
                                $destinationfile = $destArr[count($destArr)-1];
                                return $destinationfile;
                            }
                            else
                            {
                                return '';
                            }
                        }
                        return false;
                    }
                } else return false;
            }
            return false;
        }

        /*
        * @access public
        * @return mixed thumb destination or false
        * 
        * wrapper function for $this->thumb()
        * uses $this->file_name from upload function as parameter
        */
        public function thumb_uploaded_file() {
            // run thumb generation method with internal filepath variable
            //return $this->thumb($this->file_path);
        }

        /*
        * @access public
        * @param string $file
        * @return mixed thumb destination or false
        * 
        * generates an thumbnail from source
        * write the result to a file
        */
        public function thumb($file,$targetpath,$width,$height,$crop=0) {
            if(empty($file)
            OR !file_exists($file)) return false;

            /*
            * load phpThumb from vendors directory
            * and get a new instance
            */
            App::import('Vendor', 'phpThumb', array(
            'file' => 'phpThumb' . DS . 'phpthumb.class.php'
            ));
            $phpThumb = new phpThumb();
            
            $this->zoom_crop=$crop;
            
            /*echo "file".$file;
            echo "<br>target".$targetpath;
            echo "<br>width".$width;
            echo "<br>height".$height;*/
            
            // configure phpThumb for it's thumbnail generation
            $phpThumb->setSourceFilename($file);
            $phpThumb->setParameter('w', $width); //$this->width
            $phpThumb->setParameter('h', $height);//$this->height
           
            $phpThumb->setParameter('zc', $this->zoom_crop);

            /*
            * generate thumbnail
            * and render to file
            */
            $pathinfo = pathinfo($file);
           
            //$destination = $this->save_paths['thumb'] .md5($pathinfo['filename'] . $this->width . $this->height . $this->zoom_crop) .'.' . $pathinfo['extension'];
            $destination = $targetpath .$pathinfo['filename'] .'.' . $pathinfo['extension'];

//echo "<br>dest".$destination;

            /*
            * if their is an older version of the thumbnail
            * (same source, width, height, zoom-crop),
            * then delete
            */
            if(file_exists($destination))
            {
                //echo "under unlink";
                //unlink($destination);
            }

            if($phpThumb->generateThumbnail()
            AND $phpThumb->RenderToFile($destination))
            return $destination;
            // something goes wrong
            return false;
        }
        
        /**
        * Sanitizes a filename replacing whitespace with dashes
        *
        * Removes special characters that are illegal in filenames on certain
        * operating systems and special characters requiring special escaping
        * to manipulate at the command line. Replaces spaces and consecutive
        * dashes with a single dash. Trim period, dash and underscore from beginning
        * and end of filename.
        *
        * @param string $filename The filename to be sanitized
        * @return string The sanitized filename
        */
        public function sanitize_file_name( $filename ) {
            $filename_raw = $filename;
            $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}", chr(0));
            $filename = str_replace($special_chars, '', $filename);
            $filename = preg_replace('/[\s-]+/', '-', $filename);
            $filename = trim($filename, '.-_');
            $filename = strtolower($filename);

            return $filename;
        }

        public function findSharp($orig, $final) // function from Ryan Rud (http://adryrun.com)
        {
            $final    = $final * (750.0 / $orig);
            $a        = 52;
            $b        = -0.27810650887573124;
            $c        = .00047337278106508946;

            $result = $a + $b * $final + $c * $final * $final;

            return max(round($result), 0);
        } // findSharp()

        public function createThumbs( $sourcePath, $targetPath, $sourceFileName, $targetFileName, $thumbWidth, $thumbHeight, $mode )
        {

            // Determine the quality of the output image
            $quality    = DEFAULT_QUALITY;           

            // Get the size and MIME type of the requested image
            $size    = GetImageSize($sourcePath . $sourceFileName);
            $mime    = $size['mime'];

            // Set up the appropriate image handling functions based on the original image's mime type
            switch ($size['mime'])
            {
                case 'image/gif':
                    // We will be converting GIFs to PNGs to avoid transparency issues when resizing GIFs
                    // This is maybe not the ideal solution, but IE6 can suck it
                    $creationFunction    = 'ImageCreateFromGif';
                    $outputFunction        = 'ImagePng';
                    $mime                = 'image/png'; // We need to convert GIFs to PNGs
                    $doSharpen            = FALSE;
                    $quality            = round(10 - ($quality / 10)); // We are converting the GIF to a PNG and PNG needs a compression level of 0 (no compression) through 9
                    $extension          = ".png";
                    break;

                case 'image/x-png':
                case 'image/png':
                    $creationFunction    = 'ImageCreateFromPng';
                    $outputFunction        = 'ImagePng';
                    $doSharpen            = FALSE;
                    $quality            = round(10 - ($quality / 10)); // PNG needs a compression level of 0 (no compression) through 9
                    $extension          = ".png";
                    break;

                default:
                    $creationFunction    = 'ImageCreateFromJpeg';
                    $outputFunction         = 'ImageJpeg';
                    $doSharpen            = TRUE;
                    $extension          = ".jpg";
                    break;
            }

            //echo "<br>Creating thumbnail for {$sourcePath}{$sourceFileName} at {$targetPath}{$targetFileName}{$extension} <br />";



            // load SOURCE image and get image size
            $img    = $creationFunction($sourcePath . $sourceFileName);
            $width   = $size['0'];
            $height  = $size['1'];

            $maxWidth   = $thumbWidth;
            $maxHeight  = $thumbHeight;

            if($mode == "crop")
            {
                // Ratio cropping
                $offsetX    = 0;
                $offsetY    = 0;
                $cropratio = "1:1";
                if (isset($cropratio))
                {
                    $cropRatio        = explode(':', (string) $cropratio);
                    if (count($cropRatio) == 2)
                    {
                        $ratioComputed        = $width / $height;
                        $cropRatioComputed    = (float) $cropRatio[0] / (float) $cropRatio[1];

                        if ($ratioComputed < $cropRatioComputed)
                        { // Image is too tall so we will crop the top and bottom
                            $origHeight    = $height;
                            $height        = $width / $cropRatioComputed;
                            $offsetY    = ($origHeight - $height) / 2;
                        }
                        else if ($ratioComputed > $cropRatioComputed)
                        { // Image is too wide so we will crop off the left and right sides
                            $origWidth    = $width;
                            $width        = $height * $cropRatioComputed;
                            $offsetX    = ($origWidth - $width) / 2;
                        }
                    }
                }                   
            }else {
                // Ratio cropping
                $offsetX    = 0;
                $offsetY    = 0;
            } 

            // Setting up the ratios needed for resizing. We will compare these below to determine how to
            // resize the image (based on height or based on width)

            $xRatio        = $maxWidth / $width;
            $yRatio        = $maxHeight / $height;

            if ($xRatio * $height < $maxHeight)
            { // Resize the image based on width
                $tnHeight    = ceil($xRatio * $height);
                $tnWidth    = $maxWidth;
            }
            else // Resize the image based on height
            {
                $tnWidth    = ceil($yRatio * $width);
                $tnHeight    = $maxHeight;
            }


            if($mode == "dynamic"){
                $tnWidth    = $maxWidth;
                $tnHeight = floor( $height * ( $maxWidth / $width ) );
            }


            // create a new temporary image
            $tmp_img = imagecreatetruecolor( $tnWidth, $tnHeight );

            // copy and resize old image into new image
            imagecopyresized( $tmp_img, $img, 0, 0, $offsetX, $offsetY, $tnWidth, $tnHeight, $width, $height );

            if ($doSharpen)
            {
                // Sharpen the image based on two things:
                //    (1) the difference between the original size and the final size
                //    (2) the final size
                $sharpness    = $this->findSharp($width, $tnWidth);

                $sharpenMatrix    = array(
                    array(-1, -2, -1),
                    array(-2, $sharpness + 12, -2),
                    array(-1, -2, -1)
                );
                $divisor        = $sharpness;
                $offset            = 0;
                imageconvolution($tmp_img, $sharpenMatrix, $divisor, $offset);
            }

            // save thumbnail into a file
            $outputFunction( $tmp_img, "{$targetPath}{$targetFileName}{$extension}" );

            return $extension;
        }
    }
?>
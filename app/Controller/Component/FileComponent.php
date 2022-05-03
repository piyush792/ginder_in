<?php
  class FileComponent extends Component {
    /*
     * @var array
     * @access private
     * 
     * array with allowed mime types
     */
     
    ///$this->Image->width(150);
    //$this->Image->width(75);  
    private $allowed_mime_types = array(
        'application/msword',
        'application/octet-stream',
        'application/vnd.ms-powerpoint',
        'application/pdf',
        'binary/octet-stream',
        'text/plain',
        'application/vnd.ms-excel',
        'application/zip',
        'text/html'
    );
    
    /*
     * @var array
     * @access private
     * 
     * array with allowed file extensions
     */
    private $allowed_extensions = array(
        'doc',
        'docx',
        'ppt',
        'pdf',
        'pps',
        'ppt',
        'txt',
        'xls',
        'zip',
        'htm',
        'html'
    );
    
    /*
     * @var string
     * @access private
     * 
     * save paths for document
     */
    private $save_paths = array(
        'upload' => ''
    );
    
    /*
     * @var string
     * @access private
     * 
     * path to file
     */
    private $file_path = null;
    
    private $file_name = null;
    
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
    public function startup(&$controller) {
        $this->controller = &$controller;
    }
    
    /*
     * @access public
     * @param string $upload_path
     * @param string $thumb_path
     * 
     * set paths for upload and thumb
     */
    public function set_paths($upload_path,$filename) {        
            
        if(!empty($upload_path) AND is_writable($upload_path))
        {
                $this->save_paths = array(
                    'upload' => $upload_path,
                );
                $this->file_name = $filename;
                return true;
        }
        else 
        {
         return false;   
        }
    }
    
    /*
     * @access public
     * @param string $field
     * @return mixed destintion or false
     * 
     * upload image from $this->controller->data array and return success
     * writes upload path into file_path of component
     */
    public function upload_file($field) {
        if(empty($field) OR $field === '') return false;
        
        // get Model and field
       $exploded = explode('.', $field);
        
        if(count($exploded) !== 2) return false;
        
        list($model, $value) = $exploded;
        
        // Image data had been send?
        if(array_key_exists($model, $this->controller->data) AND array_key_exists($value, $this->controller->data[$model])
            AND is_array($this->controller->data[$model][$value])) {
                // get pointer for lighter code
                //$file = &$this->controller->data[$model][$value];
                $file = $this->controller->data[$model][$value];                                
                // does php get any upload errors?
                if(array_key_exists('error', $file) AND $file['error'] === 0) {
                    /*
                     * is the size OK?
                     * (bigger then 0 and smaller then 'upload_max_filesize' in php.ini
                     */
                    $serversize = str_replace("M","",ini_get('upload_max_filesize')); 
                    if($file['size'] === 0
                        OR (string)(ceil((int)$file['size']/1000000)) > $serversize){
                            return  false;
                    // mimetype ok?
                    }
                    elseif(!in_array($file['type'], $this->allowed_mime_types)) {
                        return false;
                    }
                    else {
                        // get extension
                        $exploded = explode('.', $file['name']);
                        $extension = end($exploded);
                        // extension allowed?
                        
                        if(in_array($extension, $this->allowed_extensions)) {
                            // generate extension
                            $destination = $this->save_paths['upload'] . 
                                $this->file_name . '.' . $extension;
                            
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
}
?>
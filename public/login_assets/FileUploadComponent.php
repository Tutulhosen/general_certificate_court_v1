<?php

namespace Cake\Controller\Component;

use Cake\Controller\Component;

class FileUploadComponent extends Component {

    var $pathToImage;
    var $folder;
    var $filename;
    var $img;
    var $width;
    var $height;
    var $error;

    public function saveAs($fileData, $folder, $type = 'file') {
        //die("asda");
        //$filename = "";
//	die($folder);
        if (!empty($fileData["tmp_name"])) {
            $this->folder = $folder;
            $this->filename = $this->generateUniqueFilename($fileData["name"], $this->folder);
            move_uploaded_file($fileData['tmp_name'], $this->folder . $this->filename) or die('can\'t upload');
            $this->pathToImage = $this->folder . $this->filename;
            

            

            if ($type == 'file') {
                if ($fileData["type"] == 'image/jpeg' || $fileData["type"] == 'image/png' || $fileData["type"] == 'image/gif') {
                    
                    $this->setWidthHeight();
                    $this->createThumbnail();
                    //@unlink($this->folder . '/' . $this->filename);
                }
            } else if ($type == 'profile_pic') {
                //die('asaa');
                $this->createThumbnailProfilePic();
                @unlink($this->folder . '/' . $this->filename);
            }
            if ($this->error)
                return false;
        }
        return $this->filename;
    }

    public function fileCopy($source = "", $dest = "", $main_file_name = "") {

        if (!empty($main_file_name)) {
            $copied_filename = $this->generateUniqueFilename($main_file_name, $dest);
            @copy($source . $main_file_name, $dest . $copied_filename);
        }
        return $copied_filename;
    }

    private function generateUniqueFilename($fileName, $path = '') {
        $path = empty($path) ? WWW_ROOT . "/img/upload/" : $path;
        $no = 1;
        $newFileName = $fileName;
        while (file_exists("$path/" . $newFileName)) {
            $no++;
            $newFileName = substr_replace($fileName, "_$no.", strrpos($fileName, "."), 1);
        }
        return $newFileName;
    }

    public function file_delete($file_path, $fileName) {

        if (@unlink($file_path . $fileName)) {
            return true;
        } else {
            return false;
        }
    }

    public function file_downlaod($fileName) {
        /* header("Pragma: public"); // required
          header("Expires: 0");
          header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
          header("Cache-Control: private",false); */
        /* header("Content-Type: application/octet-stream");
          header("Content-Transfer-Encoding: Binary");
          header("Content-length: ".filesize($fileName));
          header("Content-disposition: attachment; filename=\"".basename($fileName)."\"");
          readfile("$fileName");

          header("Content-Type: application/force-download");
          header("Content-Type: application/octet-stream");
          header("Content-Type: application/download");
          header("Content-Description: File Transfer");
          header("Content-Length: " . filesize($fileName));
          flush(); // this doesn't really matter.
          $fp = fopen($fileName, "r");
          while (!feof($fp))
          {
          echo fread($fp, 65536);
          flush(); // this is essential for large downloads
          }
          fclose($fp); */

        $path_parts = pathinfo($fileName);

        $mm_type = "application/octet-stream";

        header("Cache-Control: public, must-revalidate");
        header("Pragma: hack");
        header("Content-Type: " . $mm_type);
        header("Content-Length: " . (string) (filesize($fileName)));
        header('Content-Disposition: attachment; filename="' . $path_parts['basename'] . '"');
        header("Content-Transfer-Encoding: binary\n");

        readfile($fileName);
    }

    private function setWidthHeight() {
        //die($this->pathToImage.'aa');
        if (is_file($this->pathToImage)) {
            //die('bb');
            $info = pathinfo($this->pathToImage);

            $extension = strtolower($info['extension']);
            //die($extension);
            if (in_array($extension, array('jpg', 'jpeg', 'png', 'gif'))) {

                switch ($extension) {
                    case 'jpg':
                        $this->img = imagecreatefromjpeg("{$this->pathToImage}");
                        break;
                    case 'jpeg':
                        $this->img = imagecreatefromjpeg("{$this->pathToImage}");
                        break;
                    case 'png':
                        $this->img = imagecreatefrompng("{$this->pathToImage}");
                        break;
                    case 'gif':
                        $this->img = imagecreatefromgif("{$this->pathToImage}");
                        break;
                    default:
                        $this->img = imagecreatefromjpeg("{$this->pathToImage}");
                }
                // load image and get image size

                $this->width = imagesx($this->img);
                $this->height = imagesy($this->img);
            } else {
                $this->error = 'Failed|Not an accepted image type (JPG, PNG, GIF).';
            }
        } else {
            $this->error = 'Failed|Image file does not exist.';
        }
    }

    private function createThumbnail() {
        //$result = 'Failed';
        //$pathToImage = $folder . $filename;
        // calculate thumbnail size
        //die($this->width);
        if ($this->width / 240 > $this->height / 160) {
            $new_width = 240;
            $new_height = floor($this->height * ( $new_width / $this->width ));
        } else {
            $new_height = 160;
            $new_width = floor($this->width * ( $new_height / $this->height ));
        }
        //$new_height = 160;
        // create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $pathToImage = $this->folder . 'thumb_' . $this->filename;
        // save thumbnail into a file
        imagejpeg($tmp_img, "{$pathToImage}", 100);
        //$result = $pathToImage;
        // calculate medium thumbnail size
        if ($this->width / 556 > $this->height / 370) {
            $new_width = 556;
            $new_height = floor($this->height * ( $new_width / $this->width ));
        } else {
            $new_height = 370;
            $new_width = floor($this->width * ( $new_height / $this->height ));
        }
        //$new_height = 374;
        // create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $pathToImage = $this->folder . 'medium_' . $this->filename;
        // save thumbnail into a file
        imagejpeg($tmp_img, "{$pathToImage}", 100);

        // calculate small thumbnail size
        if ($this->width / 41 > $this->height / 30) {
            $new_width = 41;
            $new_height = floor($this->height * ( $new_width / $this->width ));
        } else {
            $new_height = 30;
            $new_width = floor($this->width * ( $new_height / $this->height ));
        }
        //$new_height = 30;
        // create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $pathToImage = $this->folder . 'small_thumb_' . $this->filename;
        // save thumbnail into a file
        imagejpeg($tmp_img, "{$pathToImage}", 100);
        //$result = $pathToImage;
        //return $result;
    }

    private function createThumbnailProfilePic() {
        //$result = 'Failed';
        //$pathToImage = $folder . $filename;
        // calculate thumbnail size
        //die($this->width);
        if ($this->width / 45 > $this->height / 41) {
            $new_width = 45;
            $new_height = floor($this->height * ( $new_width / $this->width ));
        } else {
            $new_height = 41;
            $new_width = floor($this->width * ( $new_height / $this->height ));
        }
        //$new_height = 160;
        // create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $pathToImage = $this->folder . 'thumb_' . $this->filename;
        // save thumbnail into a file
        imagejpeg($tmp_img, "{$pathToImage}", 100);
        //$result = $pathToImage;
        // calculate medium thumbnail size
        if ($this->width / 53 > $this->height / 45) {
            $new_width = 53;
            $new_height = floor($this->height * ( $new_width / $this->width ));
        } else {
            $new_height = 45;
            $new_width = floor($this->width * ( $new_height / $this->height ));
        }
        //$new_height = 374;
        // create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $pathToImage = $this->folder . 'medium_' . $this->filename;
        // save thumbnail into a file
        imagejpeg($tmp_img, "{$pathToImage}", 100);

        // calculate small thumbnail size
        if ($this->width / 150 > $this->height / 150) {
            $new_width = 150;
            $new_height = floor($this->height * ( $new_width / $this->width ));
        } else {
            $new_height = 150;
            $new_width = floor($this->width * ( $new_height / $this->height ));
        }
        //$new_height = 30;
        // create a new temporary image
        $tmp_img = imagecreatetruecolor($new_width, $new_height);

        // copy and resize old image into new image
        imagecopyresampled($tmp_img, $this->img, 0, 0, 0, 0, $new_width, $new_height, $this->width, $this->height);
        $pathToImage = $this->folder . 'small_thumb_' . $this->filename;
        // save thumbnail into a file
        imagejpeg($tmp_img, "{$pathToImage}", 100);
        //$result = $pathToImage;
        //return $result;
    }

}

?>
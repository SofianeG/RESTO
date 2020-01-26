<?php

class FileHelper
    {
    //extension de l'image .jpg, .jpeg  strrpos() derniere position de du points
          public function getExtention(string $originalName)
          {
              $lastDotPosition = strrpos($originalName,'.');
              $ext = substr($originalName,$lastDotPosition);

              return $ext;
          }

          public function hasValidUploadedFile($name)
          {
            return isset($_FILES[$name])
                    && $_FILES[$name]["error"] == UPLOAD_ERR_OK
                    && $_FILES[$name]["size"]>0;
          }

          public function getUploadPath(string $subfolder ="")
          {
            $path = Router::getInstance()->getWwwPath(true)."/uploads/";
            if ($subfolder)
            {
                $path .="$subfolder/";
            }
            return $path;
          }

          public function saveUploadedFile(string $name,string $baseName, string $folder)
          {
                $originalName = $_FILES[$name]['name'];
                $newName = $baseName.$this->getExtention($originalName);
                $newFullName = $this->getUploadPath($folder).$newName;
                move_uploaded_file($_FILES[$name]["tmp_name"],$newFullName);

                return $newName;
          }

    //supprimer le fichier
          public function removeImage($fileName, $folder)
          {
            $fullFileName = $this->getUploadPath($folder).$fileName;

            if (file_exists($fullFileName))
            {
                unlink($fullFileName);
            }
          }
    }
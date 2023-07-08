<?php

namespace App\Trait;

use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\File;
trait ImageTrait
{
    public $D_S = DIRECTORY_SEPARATOR;
    function path_post_image(){
       return public_path('Upload'.$this->D_S.'Images'.$this->D_S.'PostImages');
    }
    function saveImage($photo,$folder){
        //$file=$photo->getClientOriginalName();
        $fileExtintion=$photo->clientExtension();
        $fileName=date('YmdHis').rand(1,99).'.'.$fileExtintion;
        $path=$folder;
        $photo->move($path,$fileName);
        return $fileName;
    }

    function deleteImage($photo,$folder){
        $path=$folder.$this->D_S.$photo;
        File::delete($path);
    }

}

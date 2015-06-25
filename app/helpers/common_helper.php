<?php

class Common_helper {

/**
 * Build table header with sorting links.
 *
 * @param  array  $table_fields
 * @return text (html)
 */
    public static function sorting_table_fields($table_fields) {

		$sort = Input::get('sort');
    	$order = Input::get('order');
    	$page = Input::get('page');
        $field = Input::get('field');
        $search = Input::get('search');

    	$order_class = $order=='desc'?'glyphicon glyphicon-chevron-up right5':'glyphicon glyphicon-chevron-down right5';    	
    	$order = $order=='desc'?'asc':'desc';
        if(!empty($page)){
            $order = $page?$order.'&page='.$page:$order;
        } 
        if(!empty($field)&&!empty($search)){
            $order = $order.'&field='.$field.'&search='.$search;
        }    	

    	$result = '';
    	foreach ($table_fields as $key => $val) {
    		$order_icon = $key==$sort?'<span class="'.$order_class.'"></span>':'';
    		$result.= '<th>'.$order_icon.'<a href="'.Request::url().'?sort='.$key.'&order='.$order.'">'.$key.'</a></th>';
    	}
    	return $result;
    }

/**
 * Get input by field data
 *
 * @param  int  $type
 * @return text (html)
 */
    public static function getInput($field){
        switch ($field->input_type) {
            case '1':
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label><input type="text" class="form-control" alias="'.$field->alias.'"></div>';
                break;
            case '2':
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label><textarea class="form-control" alias="'.$field->alias.'"></textarea></div>';
                break;
            case '3':
                    $selectData = array();
                    if(!empty($field->external_db)){
                        $externalData = json_decode($field->external_db); 
                        $table = ucfirst($externalData->table);
                        $selectData = $table::lists($externalData->fieldGet,$externalData->field);
                    }
                    if(!empty($field->external_config)){
                       $selectData = Config::get($field->external_config); 
                    }
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label>'.Form::select($field->alias, $selectData,'',array('class'=>'form-control')).'</div>';
                break;
            case '4':
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label><input type="checkbox" alias="'.$field->alias.'"></div>';
                break;
            case '5':
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label><input type="radio" alias="'.$field->alias.'"></div>';
                break;
            case '6':
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label><input type="file" alias="'.$field->alias.'"></div>';
                break;
            case '7':
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label><input type="file" alias="'.$field->alias.'"></div>';
                break;
            case '8':
                    return '<div class="form-group"><label for="'.$field->alias.'">'.$field->alias.'</label><input type="date" class="form-control" alias="'.$field->alias.'"></div>';
                break;                                                                                
            
        }
    }

/**
 * Save upploaded file
 *
 * @param  obj $files, string $type
 * @return array
 */
    public static function fileUpload($file,$folder,$name='',$maxFilesize='3000',$extensions='jpg,jpeg,bmp,png,gif') {
        if(!empty($file)){
            $validator = Validator::make(
                array(
                    'attachment' => $file,
                    'extension'  => \Str::lower($file->getClientOriginalExtension()),
                ),
                array(
                    'attachment' => 'required|max:'.$maxFilesize,
                    'extension'  => 'required|in:'.$extensions,
                )
            ); 

            if($validator->fails()){
                return array('errors'=>$validator->messages());
            }
            $destinationPath = 'uploads/'.$folder.'/';
            if(!is_dir($destinationPath)){
                File::makeDirectory($destinationPath , 0775, true);
            }
            if(!empty($name)){
                $filename = $name.'.'.$file->getClientOriginalExtension();
            } else {
                $filename = $file->getClientOriginalName();
            }
            $uploadSuccess = $file->move($destinationPath, $filename);
            if($uploadSuccess) {
                 $fileUploaded = $destinationPath.$filename;
            }else{
                $fileUploadErrors = $filename;
            }
        }     
        if(isset($fileUploadErrors)){
            return array('errors'=>'File upload error');
        }
        return array('name'=>$filename, 'path'=>$fileUploaded);
    }

    /**
     * Create image thumb
     * @param  array  $image
     * @param  int  $width
     * @param  int  $height
     * @param  bool  $crop
     * @return string
    */
    public static function getThumb($source_path,$save_path,$thumbWidth,$thumbHeight){
        /*
        * Crop-to-fit PHP-GD
        * http://salman-w.blogspot.com/2009/04/crop-to-fit-image-using-aspphp.html
        *
        * Resize and center crop an arbitrary size image to fixed width and height
        * e.g. convert a large portrait/landscape image to a small square thumbnail
        */

        // list($width, $height) = getimagesize($source_path);

        // if ($width > $height) {
            $desired_image_width = $thumbWidth;
            $desired_image_height = $thumbHeight;
        // } else {
        //     $desired_image_width = $thumbHeight;
        //     $desired_image_height = $thumbWidth;
        // }

        /*
         * Add file validation code here
         */

        list($source_width, $source_height, $source_type) = getimagesize($source_path);

        switch ($source_type) {
            case IMAGETYPE_GIF:
                $source_gdim = imagecreatefromgif($source_path);
                break;
            case IMAGETYPE_JPEG:
                $source_gdim = imagecreatefromjpeg($source_path);
                break;
            case IMAGETYPE_PNG:
                $source_gdim = imagecreatefrompng($source_path);
                break;
        }

        $source_aspect_ratio = $source_width / $source_height;
        $desired_aspect_ratio = $desired_image_width / $desired_image_height;

        if ($source_aspect_ratio > $desired_aspect_ratio) {
            /*
             * Triggered when source image is wider
             */
            $temp_height = $desired_image_height;
            $temp_width = ( int ) ($desired_image_height * $source_aspect_ratio);
        } else {
            /*
             * Triggered otherwise (i.e. source image is similar or taller)
             */
            $temp_width = $desired_image_width;
            $temp_height = ( int ) ($desired_image_width / $source_aspect_ratio);
        }

        /*
         * Resize the image into a temporary GD image
         */

        $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
        imagecopyresampled(
            $temp_gdim,
            $source_gdim,
            0, 0,
            0, 0,
            $temp_width, $temp_height,
            $source_width, $source_height
        );

        /*
         * Copy cropped region from temporary image into the desired GD image
         */

        $x0 = ($temp_width - $desired_image_width) / 2;
        $y0 = ($temp_height - $desired_image_height) / 2;
        $desired_gdim = imagecreatetruecolor($desired_image_width, $desired_image_height);
        imagecopy(
            $desired_gdim,
            $temp_gdim,
            0, 0,
            $x0, $y0,
            $desired_image_width, $desired_image_height
        );

        /*
         * Render the image
         * Alternatively, you can save the image in file-system or database
         */

        return imagejpeg($desired_gdim,$save_path);
    }

    /**
     * 
     * @param  int $userId, string $type
     * @return string
     */
    public static function getUserAvatar($userId) {
        $user = User::select('users.socimage','user_info.avatar')
                    ->join('user_info','user_info.user_id','=','users.id')
                    ->where('users.id',$userId)
                    ->first();
        if(!empty($user->avatar) ){
            $avatar = '/'.$user->avatar;
        } elseif(!empty($user->socimage)) {
            $avatar = $user->socimage;
        } else {
            $avatar = '/assets/img/user_icon.png';
        }
        return $avatar;
    }

    public static function translateDate($date){
        $monthes = array(
            1 => 'Января', 
            2 => 'Февраля', 
            3 => 'Марта', 
            4 => 'Апреля',
            5 => 'Мая', 
            6 => 'Июня', 
            7 => 'Июля', 
            8 => 'Августа',
            9 => 'Сентября', 
            10 => 'Октября', 
            11 => 'Ноября', 
            12 => 'Декабря'
        );
        $result = date('j',$date).' '.$monthes[(date('n',$date))].' '.date('Y',$date);
        return $result;
    }

    public static function generateAlias($text){
        if(!empty($text)){
            $text = mb_strtolower($text);
            $transl = array(
                'а'=> 'a', 'б'=> 'b', 'в'=> 'v', 'г'=> 'g', 'д'=> 'd', 'е'=> 'e', 'ё'=> 'e', 'ж'=> 'zh', 
                'з'=> 'z', 'и'=> 'i', 'й'=> 'j', 'к'=> 'k', 'л'=> 'l', 'м'=> 'm', 'н'=> 'n', ' '=>'_',
                'о'=> 'o', 'п'=> 'p', 'р'=> 'r', 'с'=> 's', 'т'=> 't', 'у'=> 'u', 'ф'=> 'f', 'х'=> 'h',
                'ц'=> 'c', 'ч'=> 'ch', 'ш'=> 'sh', 'щ'=> 'sh','ъ'=> '', 'ы'=> 'y', 'ь'=> '', 'э'=> 'e', 'ю'=> 'yu', 'я'=> 'ya',
                'і'=> 'i', 'є'=> 'e',
            );
            $text = strtr($text,$transl);
            $text = preg_replace('~[^-a-z0-9_]+~u', '', $text);
            return $text;
        }
    }

    public static function getPastTime($extDate){
        $startTime = new Datetime($extDate);
        $endTime = new DateTime();   
        $diff = $endTime->diff($startTime);
        $date = new stdClass;
        $date->years = $diff->format('%y');
        $date->months = $diff->format('%m');
        $date->days = $diff->format('%d');

        $res = '';
        if(!empty($date->years)){
            $res.= $date->years; 
            if($date->years == 1){
                $res.= ' год ';
            } elseif($date->years < 5) {
                $res.= ' годa ';
            } else {
                $res.= ' лет ';
            }
        }
        if(!empty($date->months)){
            $res.= $date->months;  
            if($date->months == 1){
                 $res.= ' месяц ';
            } elseif($date->months < 5) {
                 $res.= ' есяца ';
            } else {
                 $res.= ' месяцев ';
            }
        }
        if(!empty($date->days)){
            $res.= $date->days;
            if($date->days == 1){
                $res.= ' день ';
            } elseif($date->days < 5) {
                $res.= ' дня ';
            } else {
                $res.= ' дней ';
            }
        } else {
            $res = 'Сегодня';
        }
        return $res;
    }

}
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
}
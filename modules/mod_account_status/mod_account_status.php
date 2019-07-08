<?php
    // no direct access
    defined('_JEXEC') or die;

    // include the syndicate functions only once
    require_once __DIR__.'/helper.php';
    
    $class_sfx = htmlspecialchars($params->get('class_sfx'));
    $helper = new ModAccountStatusHelper;

    $user = JFactory::getUser();
    $user_info = $fields = $points = array();
    // Get coin name
    $coin = $helper->getCoinName();


// Get user information fields
    $user_fields = $helper->group_by_key(json_decode($params->get('user_info'), true));

    if (count($user_fields)>0){

        foreach($user_fields as $key => $field){
            array_push($fields, $field[1]);

            // If field has alias
            $alias = explode(' AS ', strtoupper($field[1]));

            if(count($alias) > 1){
                $field_name = strtolower($alias[1]);
            }else{
                $fields_name = explode('.', $field[1]);
                $field_name = $fields_name[1];
            }

            $user_info[$field_name] = array('label' => $field[0], 'value' => '');
        }
    }


    // Get user information
    $info = $helper->getUserInfo($user->id, implode(',', $fields));

    foreach($info as $key => $value){
        $user_info[$key]['value'] = $value;
   }



// Get distributor information
    $distributor = $helper->getDistributor($user->id);

    // Get point types
    $points_types = $helper->group_by_key(json_decode($params->get('point_types'), true));

    foreach($points_types as $key => $types){ 
        if(strtolower($types[1]) == 'retroactive' && strtoupper($distributor->name) != 'SANIMEX'){
             
        }else{
            $points[$types[0]] = $helper->getPoints($user->id, $types[1]);
        }
    }

    require(JModuleHelper::getLayoutPath('mod_account_status', $params->get('layout', 'default')));
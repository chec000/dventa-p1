<?php
    // no direct access
    defined('_JEXEC') or die;
    
    class ModAccountStatusHelper{
        
        public static function getCoinName(){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            
            $query->select($db->quoteName('value'))
                ->from($db->quoteName('#__core_configs'))
                ->where($db->quoteName('key').' = '.$db->quote('pmr.coin.name'));
            $db->setQuery($query);
            
            $result = $db->loadResult();

            return $result;
        }
        
        public function group_by_key($array = array()){

            $result = array();
            if($array!=null){
                foreach($array as $sub){
                    foreach($sub as $k => $v){
                        $result[$k][] = $v;
                    }
                }
            }

            return $result;
        }

        public static function getPoints($user_id, $type = ''){
            $total = 0;
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query->select('SUM(amount)')
                ->from($db->quoteName('#__core_user_transactions'))
                ->where($db->quoteName('user_id').' = '.$db->quote($user_id));

            if(!empty($type)){
                $field_type = $db->quote($type);

                if($type == 'order'){
                    $field_type = $field_type.', '.$db->quote('cancellation');
                }

                $query->where($db->quoteName('type').' IN ('.$field_type.')');
            }

            $db->setQuery($query);
            $points = $db->loadResult();

            $total = empty($points) ? 0 : (int) $points;

            if(!empty($type) && $type == 'order'){
                $total = $total * -1;
            }
            
            return $total;
        }

        public static function getUserInfo($user_id, $fields = 'u.username, u.name'){
            $result=null;
            try{
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);


                $query->select(array($fields))
                    ->from($db->quoteName('#__users', 'u'))
                    ->join('LEFT', $db->quoteName('#__core_user_info', 'cui').' ON ('.$db->quoteName('u.id').' = '.$db->quoteName('cui.user_id').')')
                    ->where($db->quoteName('u.id').' = '.$db->quote($user_id));

                $db->setQuery($query);
                $result= $db->loadObject();

            }catch (Exception $e){
            var_dump($e->getMessage());
            die();
                return $result;
            }
            return  $result;

        }

        public static function getDistributor($user_id){
           $result=null;
            try{
                $db = JFactory::getDbo();
                $query = $db->getQuery(true);

                $query->select(array('cd.*'))
                    ->from($db->quoteName('#__core_user_info', 'cui'))
                    ->join('LEFT', $db->quoteName('#__core_distributors', 'cd').' ON ('.$db->quoteName('cui.distributor').' = '.$db->quoteName('cd.id').')')
                    ->where($db->quoteName('cui.user_id').' = '.$db->quote($user_id));
                $db->setQuery($query);
                $result= $db->loadObject();
            }catch (Exception $e){
                var_dump($e->getMessage());
                return null;

            }
            return $result;
        }
    }
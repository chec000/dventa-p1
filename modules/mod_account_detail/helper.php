<?php
// no direct access
defined('_JEXEC') or die;

class ModAccountDetailHelper{


    public function getAllDataUser(){

        try{
            $user = JFactory::getUser();

            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select(array(
                'us.*'
            ));
            $query->from($db->quoteName('#__ws_sales','us'));
            

            $query->where($db->quoteName('us.user_id').' = '.$db->quote($user->id));
            $query->order('us.fecha_pago DESC');
            $db->setQuery($query);
            $data = $db->loadObjectList();
            
            $list=array();
            foreach ($data as $key=>$value){
               array_push($list,$this->getDevolutions($value->id,$value));
            }

              $listComplate=array( );
              $dataComplete= $this->getDataByMount($data);        

         //   echo json_encode($this->separeteData($dataComplete));
          //  die();        

            //echo json_encode($this->separeteData($dataComplete));
            //die();
            return array(
                'data_complate'=>$this->separeteData($dataComplete)
            );


        }catch (Exception $e){

            var_dump($e->getMessage());
            die();
        }

    }


    private function separeteData($list,$listComplate=null){
           $listComplate=array();

            foreach ($list as $key => $value) {
              if (count($listComplate)==0) {
               
               $arrayName = array(
                'year' =>$value['year'],
                 'month'=>$value['month'],
                 'items'=>array($value),
                 'points'=>$value['puntos'],
                 'tickets'=>1
                ); 
                array_push($listComplate,$arrayName);
                
              }else{
                
               foreach ($listComplate as $key => $value2) {

                if (!$this->existYearMonth($listComplate,$value)) {
                 $arrayName = array(
                'year' =>$value['year'],
                 'month'=>$value['month'],
                 'items'=>array($value),
                 'points'=>$value['puntos'],
                 'tickets'=>1
                ); 
                array_push($listComplate,$arrayName);
                 
                    }else{
                         if($this->existItemList($listComplate[$key],$value)){
                            
                            $listComplate[$key]['points']=$listComplate[$key]['points']+$value['puntos'];
                            $listComplate[$key]['tickets']=$listComplate[$key]['tickets']+1;
                            array_push($listComplate[$key]['items'], $value);                        
                            
                         }   


                    }
   
                   
                 }             
 
              }            
              }
            return $listComplate;
    
    }

    private  function  getDevolutions($salesId,$item){
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select(array(
            'sum(d.monto_puntos_sencillos) AS mdev_puntos_sencillos',
            'sum(d.monto_puntos_dobles)  AS mdev_puntos_dobles',
            'sum(d.monto_puntos_triples) AS mdev_puntos_triples',
            'sum(d.monto_puntos_cuadruples) AS mdev_puntos_cuadruples',
            'sum(d.puntos_sencillos) AS dev_puntos_sencillos',
            'sum(d.puntos_dobles) AS dev_puntos_dobles',
            'sum(d.puntos_triples) AS dev_puntos_triples',
            'sum(d.puntos_cuadruples) AS dev_puntos_cuadruples',

        ));
        $query->from($db->quoteName('#__ws_devolutions','d'));
        $query->where($db->quoteName('d.sales_id').' = '.$db->quote($salesId));
        $db->setQuery($query);
            $data = $db->loadObject();
            $item->mdev_puntos_sencillos=($data->mdev_puntos_sencillos!=null)?$data->mdev_puntos_sencillos:0;
            $item->mdev_puntos_dobles=($data->mdev_puntos_dobles!=null)?$data->mdev_puntos_dobles:0;
            $item->mdev_puntos_triples=($data->mdev_puntos_triples!=null)?$data->mdev_puntos_triples:0;
            $item->mdev_puntos_cuadruples=($data->mdev_puntos_cuadruples!=null)?$data->mdev_puntos_cuadruples:0;
            $item->dev_puntos_sencillos=($data->dev_puntos_sencillos!=null)?$data->dev_puntos_sencillos:0;
            $item->dev_puntos_dobles=($data->dev_puntos_dobles!=null)?$data->dev_puntos_dobles:0;
            $item->dev_puntos_triples=($data->dev_puntos_triples!=null)?$data->dev_puntos_triples:0;
            $item->dev_puntos_cuadruples=($data->dev_puntos_cuadruples!=null)?$data->dev_puntos_cuadruples:0;
            return $item;
    }


 

 
    public function  getDataByMount($data){
            
        $data_month= array();

        foreach ($data as $key=>$value){

            $fecha = date($value->fecha_pago);
            $fechaComoEntero = strtotime($fecha);
            $anio = date("Y", $fechaComoEntero);
            
            $month=date("m", $fechaComoEntero);
            switch ($month){
                case '01':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '02';
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '03':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '04':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);


                    break;
                case '05':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '06':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '07':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '08':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '09':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0);
                    break;
                case '10':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '11':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;
                case '12':
                    $data_month=  $this->addItems($data_month,$value,$anio,$month,0,$value->documento_id);
                    break;

            }
        }

        return $data_month;
    }



    private function addItems($list,$data_origin,$anio,$month,$type,$document_id){

        if(count($list)>0){


            foreach ($list as $key=>$value){


                if($value['year']==$anio&&$value['month']==$month&&!$this->existTicket($list,$document_id)){

                    $arr=array(
                        'year'=>$anio,
                        'month'=>$month,
                        'ticket'=>$document_id,
                        'fecha_pago'=>date("d-m-Y", strtotime($value['fecha_pago'])),
                        'fecha_compra'=>date("d-m-Y", strtotime($value['fecha_compra'])),
                        'monto'=>$this->sumaPuntos("monto",$data_origin),
                        'puntos'=>$this->sumaPuntos("puntos",$data_origin),
                    );

                  //  var_dump($value);
                   // die();
                  //  $number = 1123.4;
                    //setlocale(LC_MONETARY, 'en_US.UTF-8');
                  // $nu= $this->formatMoney($number, true);
                   
                    //var_dump($this->money_format('%.2n', $number));
                   // die();

                    array_push($list,$arr);

                }else{
                   $list=$this->addRow($list,$key,$data_origin,$anio,$month,0);
                }
            }

        }else{

            $list= $this->addRow($list,$key=null,$data_origin,$anio,$month,1);
        }


        return $list;

    }

private function existTicket($list,$ticket){

    foreach ($list as $key=>$value){
        if($value['ticket']==$ticket){
            return true;
        }
    }
    return false;
}

private function existItemList($list,$item){    
    
    foreach ($list['items'] as $key=>$value){        
    
        if($item['year']==$value['year']&&$item['month']==$value['month']){
            return true;
         }
       }
      

    return false;
}
private function existYearMonth($list,$item){    
    
    foreach ($list as $key => $va) {
    foreach ($va['items'] as $key=>$value){        
    
        if($item['year']==$value['year']&&$item['month']==$value['month']){
            return true;
         }
       }
    }  

    return false;
}


    private function existMounth($list,$mount,$year){

        foreach ($list as $key=>$value){
            if ($year==$value['year']) {
                # code...
            if($value['month']==$mount){
                return true;
            }
            }

        }
        return false;
    }



    private function addRow($list,$key=null,$value,$anio,$month,$type){
        $result=0; $extra=0;$order=0;$devolution=0;

        if ($type==0){

                foreach ($list as $key=>$i){
                $exist=  $this->existMounth($list,$month,$anio);

                if (!$exist){
                    //agregar un row con mes dferente e igual año
                    $arr=array(
                        'year'=>$anio,
                        'month'=>$month,
                        'ticket'=>$value->documento_id,
                        'fecha_pago'=>date("d-m-Y", strtotime($value->fecha_pago)),
                        'fecha_compra'=>date("d-m-Y", strtotime($value->fecha_compra)),
                        'monto'=>$this->sumaPuntos("monto",$value),
                        'puntos'=>$this->sumaPuntos("puntos",$value),
                    );
                    array_push($list,$arr);
                }
            }
        }else{
            $arr=array(
                'year'=>$anio,
                'month'=>$month,
                'ticket'=>$value->documento_id,
                'fecha_pago'=>date("d-m-Y", strtotime($value->fecha_pago)),
                'fecha_compra'=>date("d-m-Y", strtotime($value->fecha_compra)),
                'monto'=>$this->sumaPuntos("monto",$value),
                'puntos'=>$this->sumaPuntos("puntos",$value),
            );
            //var_dump($arr);
            //die();
            array_push($list,$arr);
        }

        return $list;
    }

    private  function  sumaPuntos($type,$value){
            
        $object=(gettype($value)=="object")?true:false;
       if($object){
        

           if($type=="monto"){
               $total=$value->monto_puntos_sencillos+
                   $value->monto_puntos_dobles
                   +$value->monto_puntos_triples
                   +$value->monto_puntos_cuadruples;
               $dev=$value->mdev_puntos_sencillos
                   +$value->mdev_puntos_dobles
                   +$value->mdev_puntos_triples
                   +$value->mdev_puntos_cuadruples;
               $resultado=$total-$dev;

               $resultado= $this->formatMoney($resultado, true);
               
           }else{
               $total=$value->puntos_sencillos
                   +$value->puntos_dobles
                   +$value->puntos_triples
                   +$value->puntos_cuadruples;
               $dev=$value->dev_puntos_sencillos
                   +$value->dev_puntos_dobles
                   +$value->dev_puntos_triples
                   +$value->dev_puntos_cuadruples;
               $resultado=$total-$dev;

           }

        }else{
           $resultado=0;

            }
        return $resultado;

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
    public  function getUserTransaction($user_id){
        $result=null;
        try{
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query->select(array('cd.*'))
                ->from($db->quoteName('#__core_user_info', 'cui'))
                ->join('LEFT', $db->quoteName('#__core_user_transactions', 'cd').' ON ('.$db->quoteName('cui.distributor').' = '.$db->quoteName('cd.id').')')
                ->where($db->quoteName('cui.user_id').' = '.$db->quote($user_id));
            $db->setQuery($query);
            $result= $db->loadObject();
        }catch (Exception $e){
            var_dump($e->getMessage());
            return null;

        }
        return $result;
    }


 
function formatMoney($number, $fractional=false) { 
    if ($fractional) { 
        $number = sprintf('%.2f', $number); 
    } 
    while (true) { 
        $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number); 
        if ($replaced != $number) { 
            $number = $replaced; 
        } else { 
            break; 
        } 
    } 
    return $number; 
}  
}
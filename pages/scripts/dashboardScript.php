<?php

include '../common/connection.php';

function get_departmentList(){
   global $con;
   $res_Array=array();
   $retrive="SELECT dname from department";
   $result=mysqli_query($con,$retrive) or die(mysqli_error($con));
   while($row=mysqli_fetch_row($result)){
         array_push($res_Array,$row[0]);
   }
      return $res_Array;
}


class Regulation{
    private $Rname;
    private $Batch;
   function __construct($val)
   {
      $this->Rname=$val;
      $this->Batch=array();
   }
   public function retrive_courseOutcomes($branch) {
         global $con;
         $catweight=$seeweight=$targetAttainment=$directw=$indirectw=$level1w=$level2w=$level3w=$directpow=$indirectpow=$target="";
        foreach($this->Batch as $k => $batch){
            // for($i=1;$i<=8;$i++){
               $batch_name=$batch->get_batchName();
               $select_query="select catw,seew,codaw,coidaw,level1,level2,level3,podaw,poidaw,pota,cota from academicyear ac, batchweightage b where ac.aid=b.aid and ayname='$batch_name' and branch='$branch'";
               $res=mysqli_query($con,$select_query) or die(mysqli_error($con));
               if(mysqli_num_rows($res)>0){
                   $row=mysqli_fetch_row($res);
                   $catweight=$row[0];
                   $seeweight=$row[1];
                   $directw=$row[2];
                   $indirectw=$row[3];
                   $level1w=$row[4];
                   $level2w=$row[5];
                   $level3w=$row[6];
                   $directpow=$row[7];
                   $indirectpow=$row[8];
                   $target=$row[9];
                   $targetAttainment=$row[10];
               //   print_r("$catweight,$seeweight,$directw,$indirectw,$level1w,$level2w,$level3w,$directpow,$indirectpow,$target,$targetAttainment <br>");
               $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$this->Rname."&academicYear=".$batch->get_batchName()."&branch=".$branch."&semesterNo=1&catw=".$catweight."&seew=".$seeweight."&targetA=".$targetAttainment."&directCO=".$directw."&indirectCO=".$indirectw."&level1=".$level1w."&level2=".$level2w."&level3=".$level3w."&directw=".$directpow."&indirectw=".$indirectpow."&target=".$target."&endpoint=DASHBOARD";
               $data=file_get_contents($url);
               $decode_Data=json_decode($data,true);
               // print_r($batch->get_batchName());
               // print_r($decode_Data);
               if(isset($decode_Data['error'])){

               }else{

                  foreach($decode_Data['courseoutcomes'] as $k => $courses){
                        $batch->update_TotalCos(($batch->get_TotalCos()+$courses['noofCos']));
                           $attainedValue=0;
                        foreach($courses['result'] as $co=>$val){
                           if($val==="YES"){
                              $attainedValue+=1;
                           }
                        }
                        $batch->update_attainedCos(($batch->get_attainedCos()+$attainedValue));
                  }

                  if(array_key_exists("poerror",$decode_Data)){
                     $batch->update_levels($decode_Data['poerror']);
                  }
                  else{
                     $batch->update_TotalPos(($batch->get_TotalPos()+12));
                     $batch->update_TotalPsos(($batch->get_TotalPsos()+2));
                     $pocount=0;
                     $psocount=0;
                     for($i=1;$i<=14;$i++){
                           $tem="PO".$i;
                           if($i==13){
                              $tem="PSO1";
                              if($decode_Data['programOutcomes']['attained'][$tem]=="YES"){
                                 $psocount++;
                              }
                           }
                           else if($i==14){
                              $tem="PSO2";
                              if($decode_Data['programOutcomes']['attained'][$tem]=="YES"){
                                 $psocount++;
                              }
                           }

                           if($decode_Data['programOutcomes']['attained'][$tem]=="YES"){
                              $pocount++;
                           }

                     }

                     $batch->update_attainedPos(($batch->get_attainedPos()+$pocount));
                     $batch->update_attainedPsos(($batch->get_attainedPsos()+$psocount));
                     $batch->update_levels($decode_Data['programOutcomes']['overall']);

                  }

               }
            }
        }
   } 
   public function add_batch($batch){
      array_push($this->Batch,$batch);
   }
   public function get_Batch(){
      return $this->Batch;
   }
   public function get_regulationName(){
     return $this->Rname;
   }
}
class Batch{
    private $Bname;
    private $TotalCos;
    private $attainedCos;
    private $TotalPos;
    private $attainedPos;
    private $TotalPsos;
    private $attainedPsos;
    private $polevels;

   function __construct($val){
      $this->polevels=array();
      $this->Bname=$val;
      $this->TotalCos=0;
      $this->attainedCos=0;
      $this->TotalPos=0;
      $this->attainedPos=0;
      $this->TotalPsos=0;
      $this->attainedPsos=0;

   }
   public function get_overallPos(){
      return $this->polevels;
   }
   public function update_levels($val){
      // foreach($val as $k=>$v){
      //    $this->polevels[$k]=$v;
      // }
      $this->polevels=$val;
   }
   public function get_batchName(){
      return $this->Bname;
   }
   public function update_TotalCos($val){
       $this->TotalCos=$val;
   }
   public function get_TotalCos(){
      return $this->TotalCos;
   }
   public function get_attainedCos(){
      return $this->attainedCos;
   }
   public function update_attainedCos($val){
      $this->attainedCos=$val;
   }
   public function update_TotalPos($val){
      $this->TotalPos=$val;
  }
  public function get_TotalPos(){
     return $this->TotalPos;
  }
  public function get_attainedPos(){
      return $this->attainedPos;
   }
   public function update_attainedPos($val){
      $this->attainedPos=$val;
   }
  public function update_TotalPsos($val){
    $this->TotalPsos=$val;
  }
  public function get_TotalPsos(){
    return $this->TotalPsos;
  }
  public function get_attainedPsos(){
   return $this->attainedPsos;
   }
   public function update_attainedPsos($val){
      $this->attainedPsos=$val;
   }

}

class Main{

  private $branch;
  private $regulation;
  private $ciew;
  private $seew;
  private $codaw;
  private $coidaw;
  private $level1;
  private $level2;
  private $level3;
  private $podaw;
  private $poidaw;
  private $pota;
  private $cota;
  private $TotalOCos;
  private $attainedOCos;
  private $TotalOPos;
  private $attainedOPos;
  private $TotalOPsos;
  private $attainedOPsos;

   
  function __construct($branch)
  {
     global $con;
     $this->branch=$branch;
     $this->regulation=array();
     $this->TotalOCos=0;
     $this->attainedOCos=0;
     $this->TotalOPos=0;
     $this->attainedOPos=0;
     $this->TotalOPsos=0;
     $this->attainedOPsos=0;
   $url = 'http://localhost/templete/pages/scripts/regulationScript.php';

   $ch = curl_init($url);
   
   $data="type=3";
   curl_setopt($ch,CURLOPT_POST,true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $data );
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   
   $result = curl_exec($ch);
   
   curl_close($ch);
   $result=json_decode($result,true);
   if(array_key_exists('msg',$result)){
      $result=$result['msg'];
      foreach($result as $reg=>$batchs){
         $regulation=new Regulation($reg);
         array_push($this->regulation,$regulation);
         foreach($batchs as $k=>$batch){
            $regulation->add_batch(new Batch($batch));
         }
      }
   
      // print_r($this->regulation);
      // $select_query="select catw,seew,codaw,coidaw,level1,level2,level3,podaw,poidaw,pota,cota from batchweightage where branch='$branch'";
      //       $res=mysqli_query($con,$select_query) or die(mysqli_error($con));
      //       if(mysqli_num_rows($res)>0){
      //           $row=mysqli_fetch_row($res);
      //           $this->ciew=$row[0];
      //           $this->seew=$row[1];
      //           $this->codaw=$row[2];
      //           $this->coidaw=$row[3];
      //           $this->level1=$row[4];
      //           $this->level2=$row[5];
      //           $this->level3=$row[6];
      //           $this->podaw=$row[7];
      //           $this->poidaw=$row[8];
      //           $this->pota=$row[9];
      //           $this->cota=$row[10];

                foreach($this->regulation as $k=>$regu){
                      $regu->retrive_courseOutcomes($this->branch);
                }

               //  exit();
            // }
            // else{
            //    $json_Array=array('error=>Weightage Error, Contact Admin');
            //    $result=json_encode($json_Array);
            //     header('Content-Type:application/json');
            //     echo $result;exit();  
            // }
   }
   else{
      $json_Array=array('error=>Regulation Error, Contact Admin');
      $result=json_encode($json_Array);
      header('Content-Type:application/json');
      echo $result;exit();  
   }

  }
  public function get_COs(){
     $json_Array=array();
     $json_Array['Batchwise']=array();
      foreach($this->regulation as $k=>$regu){
          foreach($regu->get_Batch() as $k1=>$batch){
            //  array_push($json_Array['Batchwise'],array($batch->get_batchName()=>array('Total'=>$batch->get_TotalCos(),'Attained'=>$batch->get_attainedCos())));
            
              $json_Array['Batchwise'][$batch->get_batchName()]=array('Total'=>$batch->get_TotalCos(),'Attained'=>$batch->get_attainedCos(),'OverallPO'=>$batch->get_overallPos(),'TotalPO'=>$batch->get_TotalPos(),'AttainedPO'=>$batch->get_attainedPos(),'TotalPSO'=>$batch->get_TotalPsos(),'AttainedPSO'=>$batch->get_attainedPsos());
            //  $json_Array['Batchwise'][$batch->get_batchName()]['Attained']=$batch->get_attainedCos();
             $this->TotalOCos+=$batch->get_TotalCos();
             $this->attainedOCos+=$batch->get_attainedCos();
             $this->TotalOPos+=$batch->get_TotalPos();
             $this->attainedOPos+=$batch->get_attainedPos();
             $this->TotalOPsos+=$batch->get_TotalPsos();
             $this->attainedOPsos+=$batch->get_attainedPsos();
          }
      }
      $json_Array['Total']=$this->TotalOCos;
      $json_Array['attained']=$this->attainedOCos;
      $json_Array['TotalPO']=$this->TotalOPos;
      $json_Array['attainedPO']=$this->attainedOPos;
      $json_Array['TotalPSO']=$this->TotalOPsos;
      $json_Array['attainedPSO']=$this->attainedOPsos;
      return $json_Array;
  }
}


// API URL
// $main=new Main('IT');
// $json_Array=$main->get_COs();
// $result=json_encode($json_Array);
// header('Content-Type:application/json');
//        echo $result;exit(); 


if(isset($_POST) and !empty($_POST)){
   if(isset($_POST['branch']) and !empty($_POST['branch'])){
       $branch=$_POST['branch'];
       if($branch=="GlobalAdmin"){
            $departments=get_departmentList();
            // print_r($departments); exit();
            $json_Array=array();
            foreach($departments as $k=>$v){
               $m=new Main($v);
               $json_Array[$v]=$m->get_COs();
               // print_r($json_Array);
            }
       }
       else{
         $main=new Main($branch);
         $json_Array=$main->get_COs();
       }
       $result=json_encode($json_Array);
       header('Content-Type:application/json');
       echo $result;exit(); 
      //  print_r($main);
   }
}
else{
   $json_Array=array('error=>SomeThing Went Wrong, Contact Admin');
   $result=json_encode($json_Array);
   header('Content-Type:application/json');
   echo $result;exit(); 
}

?>
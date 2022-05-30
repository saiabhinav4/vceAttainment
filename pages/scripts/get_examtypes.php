<?php

include "../common/connection.php";

function formate_input($row_s){
  if(!empty($row_s)){
      return explode(",",$row_s);
  } 
return array();
}
if(isset($_SESSION['fid']) and !empty($_SESSION['fid'])){

}
else{
  header('location:../../index.php');
}

if(isset($_POST) and !empty($_POST)){

  if(isset($_POST['csid']) and !empty($_POST['csid'])){
       $csid=$_POST['csid'];
       $select_query1="SELECT csid,courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,int_par_short,int_par_long,int_proj_short,int_proj_long,ext_th_short,ext_th_long,ext_par_short,ext_par_long,ext_proj_short,ext_proj_long from coursestructure1 where csid=?";
       $stmt=$con->prepare($select_query1);
       $stmt->bind_param("i",$csid);
       $stmt->execute();
       $result=$stmt->get_result();
       $row=$result->fetch_row();
       // $result=mysqli_query($con,$select_query1) or die(mysqli_error($con));
       // $row=mysqli_fetch_array($result);
       $ishaveinternal=$row[3];
       $ishaveexternal=$row[4];
       $ishaveaat=$row[5];
       $type=$row[6];
       $internal=array();


       $internal_s=array();
       $internal_f=array();
       $external_s=array();
       $external_f=array();

       if($type=="theoretical"){

           if($ishaveinternal=="1"){
             $in_th_s=formate_input($row[7]);
             $in_th_l=formate_input($row[8]);

             $internal_s=$in_th_s;
             $internal_f=$in_th_l;

           }
           if($ishaveexternal=="1"){
               $ex_th_s=formate_input($row[13]);
               $ex_th_l=formate_input($row[14]);

               $external_s=$ex_th_s;
               $external_f=$ex_th_l;
           }

       }
       else if($type=="practical"){
           if($ishaveinternal=="1"){
               $in_pa_s=formate_input($row[9]);
               $in_pa_l=formate_input($row[10]);

               $internal_s=$in_pa_s;
               $internal_f=$in_pa_l;

             }
             if($ishaveexternal=="1"){
                 $ex_pa_s=formate_input($row[15]);
                 $ex_pa_l=formate_input($row[16]);

                 $external_s=$ex_pa_s;
                 $external_f=$ex_pa_l;
             }

       }
       else if($type=="both"){
           if($ishaveinternal=="1"){
               $in_th_s=formate_input($row[7]);
               $in_th_l=formate_input($row[8]);
               $in_pa_s=formate_input($row[9]);
               $in_pa_l=formate_input($row[10]);

               $internal_s=array_merge($in_th_s,$in_pa_s);
               $internal_f=array_merge($in_th_l,$in_pa_l);

             }
             if($ishaveexternal=="1"){
               $ex_th_s=formate_input($row[13]);
               $ex_th_l=formate_input($row[14]);
               $ex_pa_s=formate_input($row[15]);
               $ex_pa_l=formate_input($row[16]);

               $external_s=array_merge($ex_th_s,$ex_pa_s);
               $external_f=array_merge($ex_th_l,$ex_pa_l);
           }


       }
       else if($type=="project"){

           if($ishaveinternal=="1"){
               $in_proj_s=formate_input($row[11]);
               $in_proj_l=formate_input($row[12]);

               $internal_s=$in_proj_s;
               $internal_f=$in_proj_l;

             }
             if($ishaveexternal=="1"){
                 $ex_proj_s=formate_input($row[17]);
                 $ex_proj_l=formate_input($row[18]);

                 $external_s=$ex_proj_s;
                 $external_f=$ex_proj_l;
             }

       }


       // print_r($internal_s);
       // print_r($external_f);
       if($ishaveinternal=="1"){
           foreach($internal_s as $key=>$val){
              //  array_push($internal,$val);
               $internal[$internal_f[$key]]=$val;
           }
       }
       if($ishaveaat=="1"){
          //  array_push($internal,"AAT");
           $internal['Alternative Assessment Test']='AAT';
       }
       if($ishaveexternal=="1"){
           foreach($external_s as $key=>$val){
              //  array_push($internal,$val);
               $internal[$external_f[$key]]=$val;
           }
       }
       // print_r($internal);exit();
       $ishaverubric=$row[2];
       
       $result=json_encode($internal);
       header('Content-Type:application/json');
       echo $result; exit();    


  }
  else{
    echo "Something Went Wrong!, Contact Admin!";  
  }

}
else{
  echo "Something Went Wrong!, refresh and try Again";
}






?>
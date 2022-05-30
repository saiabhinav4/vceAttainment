<?php
    include "../common/connection.php";
    $coursetype=$iswttype=null;
    $ishaverubrics=$ishaveinternal=$ishaveexternal=0;
    $internaltheorytypeNo=$internalpracticaltypeNo=$internalprojecttypeNo=$externaltheorytypeNo=$externalpracticaltypeNo=$externalprojecttypeNo=0;
    $internal_s=$external_s=$internal_f=$external_f=null;
    $ishaveaat=0;
    $int_th_s=array();
    $int_th_l=array();
    $ext_th_s=array();
    $ext_th_l=array();

    $int_par_s=array();
    $int_par_l=array();
    $ext_par_s=array();
    $ext_par_l=array();

    $int_Proj_s=array();
    $int_Proj_l=array();
    $ext_Proj_s=array();
    $ext_Proj_l=array();

    // print_r($_POST); exit();
    if(isset($_POST['coursetype']) and !empty($_POST['coursetype'])){
           $coursetype=strtolower($_POST['coursetype']);   
        $select_query="select csid from coursestructure1 where courseType='$coursetype'";
        $result_s=mysqli_query($con,$select_query) or die(mysqli_error($con));
        // if(mysqli_num_rows($result_s)==0){
        if(isset($_POST['iswttype']) and !empty($_POST['iswttype']) ){
            $iswttype=$_POST['iswttype'];
            if($_POST['ishaveinternal']=="on"){
                $ishaveinternal=1;
            }
            if($_POST['ishaveexternal']=="on"){
                $ishaveexternal=1;
            }
            if($_POST['ishaveatt']=="on"){
                $ishaveaat=1;
            }
            if($_POST['ishaverubrics']=="on"){
                $ishaverubrics=1;
            }

            if($iswttype=="theoretical"){

                  if($ishaveinternal){
                      $internaltheorytypeNo=$_POST['internaltheorytypeNo'];
                      for($i=1;$i<=$internaltheorytypeNo;$i++){
                        $ins="in-Ts-".$i;
                        $inl="in-Tl-".$i;
                        array_push($int_th_s,$_POST[$ins]);
                        array_push($int_th_l,$_POST[$inl]);
                    }

                    $int_theory_short=join(",",$int_th_s);
                    $int_theory_long=join(",",$int_th_l);

                  } 
                  if($ishaveexternal){
                      $externaltheorytypeNo=$_POST['externaltheorytypeNo'];
                      for($i=1;$i<=$externaltheorytypeNo;$i++){
                        $exs="ex-Ts-".$i;
                        $exl="ex-Tl-".$i;
                        array_push($ext_th_s,$_POST[$exs]);
                        array_push($ext_th_l,$_POST[$exl]);
                    }
                    
                    $ext_theory_short=join(",",$ext_th_s);
                    $ext_theory_long=join(",",$ext_th_l);
    
                    
                  } 
               
                  if($ishaveinternal && $ishaveexternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,ext_th_short,ext_th_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_theory_short','$int_theory_long','$ext_theory_short','$ext_theory_long')";
                  }
                  else if($ishaveinternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_theory_short','$int_theory_long')";
                  }
                  else if($ishaveexternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,ext_th_short,ext_th_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$ext_theory_short','$ext_theory_long')";
                  }

                if($res=mysqli_query($con,$insert_query) or die(mysqli_error($con))){
                    header('location:../ui-features/mappingfandc.php?sucs=1'); 
                 }   
                 else{
                    header('location:../ui-features/mappingfandc.php?err=swr'); 
                 }




            }else if($iswttype=="practical"){

                if($ishaveinternal){
                    $internalpracticaltypeNo=$_POST['internalpracticaltypeNo'];
                    for($i=1;$i<=$internalpracticaltypeNo;$i++){
                        $ins="in-Ps-".$i;
                        $inl="in-Pl-".$i;
                        array_push($int_par_s,$_POST[$ins]);
                        array_push($int_par_l,$_POST[$inl]);
                    }

                    $int_practical_short=join(",",$int_par_s);
                    $int_practical_long=join(",",$int_par_l);

                }

                if($ishaveexternal){
                    $externalpracticaltypeNo=$_POST['externalpracticaltypeNo'];
                    for($i=1;$i<=$externalpracticaltypeNo;$i++){
                        $exs="ex-Ps-".$i;
                        $exl="ex-Pl-".$i;
                        array_push($ext_par_s,$_POST[$exs]);
                        array_push($ext_par_l,$_POST[$exl]);
                    }

                    $ext_practical_short=join(",",$ext_par_s);
                    $ext_practical_long=join(",",$ext_par_l);

                }

               
                if($ishaveinternal && $ishaveexternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_par_short,int_par_long,ext_par_short,ext_par_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_practical_short','$int_practical_long','$ext_practical_short','$ext_practical_long')";
                }
                else if($ishaveinternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_par_short,int_par_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_practical_short','$int_practical_long')";
                }
                else if($ishaveexternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,ext_par_short,ext_par_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$ext_practical_short','$ext_practical_long')";
                }

                
                if($res=mysqli_query($con,$insert_query) or die(mysqli_error($con))){
                    header('location:../ui-features/mappingfandc.php?sucs=1'); 
                 }   
                 else{
                    header('location:../ui-features/mappingfandc.php?err=swr'); 
                 }


            }
            else if($iswttype=="both"){

                if($ishaveinternal){
                    $internaltheorytypeNo=$_POST['internaltheorytypeNo'];
                    for($i=1;$i<=$internaltheorytypeNo;$i++){
                        $ins="in-Ts-".$i;
                        $inl="in-Tl-".$i;
                        array_push($int_th_s,$_POST[$ins]);
                        array_push($int_th_l,$_POST[$inl]);
                    }
                    $internalpracticaltypeNo=$_POST['internalpracticaltypeNo'];
                    for($i=1;$i<=$internalpracticaltypeNo;$i++){
                        $ins="in-Ps-".$i;
                        $inl="in-Pl-".$i;
                        array_push($int_par_s,$_POST[$ins]);
                        array_push($int_par_l,$_POST[$inl]);
                    }

                    $int_theory_short=join(",",$int_th_s);
                    $int_theory_long=join(",",$int_th_l);

                    $int_practical_short=join(",",$int_par_s);
                    $int_practical_long=join(",",$int_par_l);
                }

                if($ishaveexternal){
                    $externaltheorytypeNo=$_POST['externaltheorytypeNo'];
                    $externalpracticaltypeNo=$_POST['externalpracticaltypeNo'];
                for($i=1;$i<=$externaltheorytypeNo;$i++){
                    $exs="ex-Ts-".$i;
                    $exl="ex-Tl-".$i;
                    array_push($ext_th_s,$_POST[$exs]);
                    array_push($ext_th_l,$_POST[$exl]);
                }
                for($i=1;$i<=$externalpracticaltypeNo;$i++){
                    $exs="ex-Ps-".$i;
                    $exl="ex-Pl-".$i;
                    array_push($ext_par_s,$_POST[$exs]);
                    array_push($ext_par_l,$_POST[$exl]);
                }

                $ext_theory_short=join(",",$ext_th_s);
                $ext_theory_long=join(",",$ext_th_l);

                $ext_practical_short=join(",",$ext_par_s);
                $ext_practical_long=join(",",$ext_par_l);

            }

            if($ishaveinternal && $ishaveexternal){
                $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,ext_th_short,ext_th_long,int_par_short,int_par_long,ext_par_short,ext_par_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_theory_short','$int_theory_long','$ext_theory_short','$ext_theory_long','$int_practical_short','$int_practical_long','$ext_practical_short','$ext_practical_long')";
            }
            else if($ishaveinternal){
                $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,int_par_short,int_par_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_theory_short','$int_theory_long','$int_practical_short','$int_practical_long')";
            }
            else if($ishaveexternal){
                $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,ext_th_short,ext_th_long,ext_par_short,ext_par_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$ext_theory_short','$ext_theory_long','$ext_practical_short','$ext_practical_long')";
            }

             if($res=mysqli_query($con,$insert_query) or die(mysqli_error($con))){
                header('location:../ui-features/mappingfandc.php?sucs=1'); 
             }   
             else{
                header('location:../ui-features/mappingfandc.php?err=swr'); 
             }

            }
            else if($iswttype=="project"){

                if($ishaveinternal){
                    $internalprojecttypeNo=$_POST['internalprojecttypeNo'];
                    for($i=1;$i<=$internalprojecttypeNo;$i++){
                        $ins="in-Projs-".$i;
                        $inl="in-Projl-".$i;
                        array_push($int_Proj_s,$_POST[$ins]);
                        array_push($int_Proj_l,$_POST[$inl]);
                    }
                    $int_Project_short=join(",",$int_Proj_s);
                    $int_Project_long=join(",",$int_Proj_l);

                }
                if($ishaveexternal){
                    $externalprojecttypeNo=$_POST['externalprojecttypeNo'];
                    for($i=1;$i<=$externalprojecttypeNo;$i++){
                        $exs="ex-Projs-".$i;
                        $exl="ex-Projl-".$i;
                        array_push($ext_Proj_s,$_POST[$exs]);
                        array_push($ext_Proj_l,$_POST[$exl]);
                    }
                    $ext_Project_short=join(",",$ext_Proj_s);
                    $ext_Project_long=join(",",$ext_Proj_l);
                }

                if($ishaveinternal && $ishaveexternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_proj_short,int_proj_long,ext_proj_short,ext_proj_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_Project_short','$int_Project_long','$ext_Project_short','$ext_Project_long')";
                }
                else if($ishaveinternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_proj_short,int_proj_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$int_Project_short','$int_Project_long')";
                }
                else if($ishaveexternal){
                    $insert_query="insert into coursestructure1(courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,ext_proj_short,ext_proj_long) values('$coursetype',$ishaverubrics,$ishaveinternal,$ishaveexternal,$ishaveaat,'$iswttype','$ext_Project_short','$ext_Project_long')";
                }

                if($res=mysqli_query($con,$insert_query) or die(mysqli_error($con))){
                    header('location:../ui-features/mappingfandc.php?sucs=1'); 
                 }   
                 else{
                    header('location:../ui-features/mappingfandc.php?err=swr'); 
                 }


            }
        }
        else{
            header('location:../ui-features/mappingfandc.php?err=wtypetemp');
        }
    //    }
    //    else{
    //     header('location:mappingfandc.php?err=alreadyexist'); 
    //    }
    }
    else{
        header('location:../ui-features/mappingfandc.php?err=ctemp');
    }

?>
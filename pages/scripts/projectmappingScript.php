<?php
include '../common/connection.php';
function InsertRubricMapping($rono,$perc,$type){
    global $con;
    $select_query="insert into rubricmapping(rno,percal,type) values($rono,$perc,'$type')";
    $result=mysqli_query($con,$select_query) or die(mysqli_error($con));  
}
function InsertDefaultRubricMapping($cmid,$per,$type){
    global $con;
    $select_query="insert into courserubricsmapping(cmid,per,type) values($cmid,$per,'$type')";
    $result=mysqli_query($con,$select_query) or die(mysqli_error($con));  
}
function GetCmid($coid,$deid){
    global $con;
    $select_query="SELECT cmid from comappingrubrics WHERE coid=$coid and deid=$deid";
    $result=mysqli_query($con,$select_query) or die(mysqli_error($con));
    $row=mysqli_fetch_row($result);
    return $row[0];  
}
$regulation=$academicYear=$branch=$semesterNo=$QPCode=$projectType=$reviewType=$noofrubrics=$coid=$isdefault=null;
$desc=array();
$flage=true;
// print_r($_POST); 
if(isset($_POST)){
    $isdefault=$_POST['isdefault'];
    if(isset($_POST['regulation'])){
          if(isseT($_POST['academicYear'])){
                if(isset($_POST['branch'])){
                    if(isset($_POST['semesterNo'])){
                        if(isset($_POST['QPCode'])){
                            if(isset($_POST['projectType'])){
                                if(isset($_POST['reviewType'])){
                                    if(isset($_POST['noofrubrics']) and ( ($isdefault==0 and !empty($_POST['noofrubrics'])) or $isdefault!=0 )   ){
                                        $regulation=$_POST['regulation'];
                                        $academicYear=$_POST['academicYear'];
                                        $branch=$_POST['branch'];
                                        $semesterNo=$_POST['semesterNo'];
                                        $QPCode=$_POST['QPCode'];
                                        $projectType=$_POST['projectType'];
                                        $reviewType=$_POST['reviewType'];
                                        $noofrubrics=$_POST['noofrubrics'];
                                        $coid=$_POST['coid'];
                                     if($isdefault==0){   
                                        for($i=1;$i<=$noofrubrics;$i++){
                                             $tem="projectType-".$i;
                                             $tem1="R_".$i;
                                             if( isset($_POST[$tem]) and !empty($_POST[$tem])  and isset($_POST[$tem1]) and !empty($_POST[$tem1]) ){

                                             } 
                                             else{
                                                 $flage=false;
                                                 break;
                                             }  
                                        }
                                        if($flage){
                                            for($i=1;$i<=$noofrubrics;$i++){
                                                $tem="projectType-".$i;
                                                $tem1="R_".$i;
                                                $desc[$_POST[$tem]]=$_POST[$tem1];

                                            }   
                                            $select_check="select rid from coursedetails c,rubricdescription d,rubricmapping m where c.coid=d.coid and d.rid=m.rno and regulation='$regulation' and academicYear='$academicYear' and semesterNo=$semesterNo and branch='$branch' and courseType='$projectType' and type='$reviewType'";
                                            $result_check=mysqli_query($con,$select_check) or die(mysqli_error($con)); 
                                            if(mysqli_num_rows($result_check)>0) {
                                                header("location:../ui-features/projectMapping.php?id=$coid&error=alreadyExist");
                                            }   
                                            else {
                                                foreach($desc as $rid=>$per){
                                                    InsertRubricMapping($rid,$per,$reviewType);
                                                }

                                                header("location:../ui-features/projectMapping.php?id=$coid&msg=success");
                                            }                                         
                                        }
                                        else{
                                            header("location:../ui-features/projectMapping.php?id=$coid&error=invalid");
                                        }

                                        }
                                        else if($isdefault!=0){
                                            $deidArray=explode(",",$_POST['deidArray']);
                                            $noofrubrics=count($deidArray);
                                            $cridArray=array();
                                            foreach($deidArray as $k=>$v){
                                                 array_push($cridArray,GetCmid($coid,$v));   
                                            }
                                            for($i=1;$i<=$noofrubrics;$i++){
                                                $tem1="R_".$i;
                                                if( isset($_POST[$tem1]) and !empty($_POST[$tem1]) ){
   
                                                } 
                                                else{
                                                    $flage=false;
                                                    break;
                                                }  
                                           }
                                           if($flage){
                                            for($i=1;$i<=$noofrubrics;$i++){
                                                $tem1="R_".$i;
                                                array_push($desc,$_POST[$tem1]);
                                            }
                                            $select_check="SELECT crid from comappingrubrics c,courserubricsmapping cr WHERE c.cmid=cr.cmid and coid=$coid and type='$reviewType';";
                                            $result_check=mysqli_query($con,$select_check) or die(mysqli_error($con)); 
                                            if(mysqli_num_rows($result_check)>0) {
                                                header("location:../ui-features/projectMapping.php?id=$coid&error=alreadyExist");
                                            }
                                            else {
                                               for($i=0;$i<$noofrubrics;$i++){
                                                InsertDefaultRubricMapping($cridArray[$i],$desc[$i],$reviewType);
                                                }
                                                header("location:../ui-features/projectMapping.php?id=$coid&msg=success");
                                            }      
                                            
                                           }else{
                                            header("location:../ui-features/projectMapping.php?id=$coid&error=invalid");
                                           } 
                                        }   
                                    }
                                    else{
                                        header("location:../ui-features/projectMapping.php?id=$coid&error=noofr");       
                                    }
                                }
                                else{
                                    header("location:../ui-features/projectMapping.php?id=$coid&error=reviewtype");       
                                }
                            }
                            else{
                                header("location:../ui-features/projectMapping.php?id=$coid&error=projType");       
                            }
                        }
                        else{
                            header("location:../ui-features/projectMapping.php?id=$coid&error=Qpcode");       
                        }   
                    }
                    else{
                        header("location:../ui-features/projectMapping.php?id=$coid&error=semesterno");       
                    }
                }
                else{
                    header("location:../ui-features/projectMapping.php?id=$coid&error=branch");
                }
          }
          else{
            header("location:../ui-features/projectMapping.php?id=$coid&error=acadamicyear");       
          }  
    }
    else{
        header("location:../ui-features/projectMapping.php?id=$coid&error=regulation");
    }
}
else{
    header("location:../ui-features/projectMapping.php?id=$coid&error=nopost");
}

?>
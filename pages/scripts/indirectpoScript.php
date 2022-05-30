<?php
include '../common/connection.php';
// print_r($_POST); exit();
$regulation=$academicYear=$branch=$type=$noofQ=$ipno=null;
$flage=True;
if(isset($_POST) and !empty($_POST)){
    if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
        if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
            if(isset($_POST['branch']) and !empty($_POST['branch'])){
                if(isset($_POST['examType']) and !empty($_POST['examType'])){
                    //    if(isset($_POST['noofQ']) and !empty($_POST['noofQ'])){
                               $regulation=$_POST['regulation'];
                               $academicYear=$_POST['academicYear'];
                               $branch=$_POST['branch'];
                               $type=$_POST['examType'];
                            //    $noofQ=$_POST['noofQ'];          
                               $select_check="select p.ipno from indirectpodetails p,pomapping m where p.ipno=m.ipno and regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and type='$type' ";
                               $result_check=mysqli_query($con,$select_check) or die(mysqli_error($con));
                               if(mysqli_num_rows($result_check)==0){
                                   if($type=="co_curricular" or $type=="extra_curricular"){ 
                                    if(isset($_POST['noofQ']) and !empty($_POST['noofQ'])){
                                        $noofQ=$_POST['noofQ'];    
                                       for($i=1;$i<=$noofQ;$i++){
                                              $tem="A_".$i;
                                              $tem_po="A_".$i."_co";
                                              if((isset($_POST[$tem]) and !empty($_POST[$tem])) and (isset($_POST[$tem_po]) and count($_POST[$tem_po])>0) ){

                                              }
                                              else{
                                                  $flage=False;
                                                  break;
                                              }  
                                       } 
                                       if($flage){  
                                            $select_id="select ipno from indirectpodetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch'";
                                            $result=mysqli_query($con,$select_id) or die(mysqli_error($con));
                                            if(mysqli_num_rows($result)>0){
                                                $row=mysqli_fetch_row($result);
                                                $ipno=$row[0];
                                                for($i=1;$i<=$noofQ;$i++){
                                                    $tem="A_".$i;
                                                    $tem_po="A_".$i."_co";
                                                    $per=(double)$_POST[$tem];
                                                    $po="";
                                                    foreach($_POST[$tem_po] as $key=>$val){
                                                        $po=$po.$val.",";
                                                    }
                                                    $insert="insert into pomapping(ipno,type,per,activityno,programoutcomes) values($ipno,'$type',$per,$i,'$po')";
                                                    $result_insert=mysqli_query($con,$insert) or die(mysqli_error($con));
                                                }
                                                header('location:../ui-features/indirectpos.php?msg=inserted');
                                            }
                                            else{
                                                $inset_details="insert into indirectpodetails(regulation,academicYear,branch) values('$regulation','$academicYear','$branch')";
                                                $result_insert=mysqli_query($con,$inset_details) or die(mysqli_error($con));

                                                $select_ipid="select ipno from indirectpodetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch'";
                                                $result_ipid=mysqli_query($con,$select_ipid) or die(mysqli_error($con));
                                                $row=mysqli_fetch_row($result_ipid);
                                                $ipno=$row[0];
                                                for($i=1;$i<=$noofQ;$i++){
                                                    $tem="A_".$i;
                                                    $tem_po="A_".$i."_co";
                                                    $per=(double)$_POST[$tem];
                                                    $po="";
                                                    foreach($_POST[$tem_po] as $key=>$val){
                                                        $po=$po.$val.",";
                                                    }
                                                    $insert="insert into pomapping(ipno,type,per,activityno,programoutcomes) values($ipno,'$type',$per,$i,'$po')";
                                                    $result_insert=mysqli_query($con,$insert) or die(mysqli_error($con));
                                                }
                                                header('location:../ui-features/indirectpos.php?msg=inserted');
                                            }
                                       }    
                                       else{
                                        header('location:../ui-features/indirectpos.php?error=invalidentry');  
                                       }
                                      }
                                      else{
                                        header('location:../ui-features/indirectpos.php?error=noQ');
                                      }
                                    }
                                    else if($type=="exit_survey"){
                                            for($i=1;$i<=12;$i++){
                                                $tem="PO".$i;
                                                if(isset($_POST[$tem]) and !empty($_POST[$tem])){
                                                }
                                                else{
                                                    $flage=False;
                                                    break;
                                                }
                                            }
                                            for($i=1;$i<=2;$i++){
                                                $tem="PSO".$i;
                                                if(isset($_POST[$tem]) and !empty($_POST[$tem])){
                                                }
                                                else{
                                                    $flage=False;
                                                }
                                            }
                                            if($flage){ 
                                                $select_id="select ipno from indirectpodetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch'";
                                                $result=mysqli_query($con,$select_id) or die(mysqli_error($con));
                                                if(mysqli_num_rows($result)>0){
                                                    $row=mysqli_fetch_row($result);
                                                    $ipno=$row[0];
                                                    for($i=1;$i<=12;$i++){
                                                          $tem="PO".$i;
                                                          $per=(double)$_POST[$tem];
                                                          $tem=$tem.",";
                                                          $insert="insert into pomapping(ipno,type,per,programoutcomes) values($ipno,'$type',$per,'$tem')";
                                                          $result_insert=mysqli_query($con,$insert) or die(mysqli_error($con));           
                                                    }
                                                    for($i=1;$i<=2;$i++){
                                                        $tem="PSO".$i;
                                                        $per=(double)$_POST[$tem];
                                                        $tem=$tem.",";
                                                        $insert="insert into pomapping(ipno,type,per,programoutcomes) values($ipno,'$type',$per,'$tem')";
                                                        $result_insert=mysqli_query($con,$insert) or die(mysqli_error($con));           
                                                    }
                                                    header('location:../ui-features/indirectpos.php?msg=inserted');
                                                }
                                                else{
                                                    $inset_details="insert into indirectpodetails(regulation,academicYear,branch) values('$regulation','$academicYear','$branch')";
                                                    $result_insert=mysqli_query($con,$inset_details) or die(mysqli_error($con));
    
                                                    $select_ipid="select ipno from indirectpodetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch'";
                                                    $result_ipid=mysqli_query($con,$select_ipid) or die(mysqli_error($con));
                                                    $row=mysqli_fetch_row($result_ipid);
                                                    $ipno=$row[0];
                                                    for($i=1;$i<=12;$i++){
                                                        $tem="PO".$i;
                                                        $per=(double)$_POST[$tem];
                                                        $tem=$tem.",";
                                                        $insert="insert into pomapping(ipno,type,per,programoutcomes) values($ipno,'$type',$per,'$tem')";
                                                        $result_insert=mysqli_query($con,$insert) or die(mysqli_error($con));           
                                                  }
                                                  for($i=1;$i<=2;$i++){
                                                      $tem="PSO".$i;
                                                      $per=(double)$_POST[$tem];
                                                      $tem=$tem.",";
                                                      $insert="insert into pomapping(ipno,type,per,programoutcomes) values($ipno,'$type',$per,'$tem')";
                                                      $result_insert=mysqli_query($con,$insert) or die(mysqli_error($con));           
                                                  }
                                                    header('location:../ui-features/indirectpos.php?msg=inserted');      
                                                } 
                                            }
                                            else{
                                                
                                                header('location:../ui-features/indirectpos.php?error=invalidentry');
                                            }
                                    }
                               }
                               else{
                                header('location:../ui-features/indirectpos.php?error=alreadyentered');           
                               }                             
                    //    }
                    //    else{
                    //        header('location:indirectpos.php?error=noQ');
                    //    }     
                }
                else{
                    header('location:../ui-features/indirectpos.php?error=type');    
                }
            }
            else{
                header('location:../ui-features/indirectpos.php?error=bran');
            }
        }
        else{
            header('location:../ui-features/indirectpos.php?error=acd');     
        }
    }    
    else{
        header('location:../ui-features/indirectpos.php?error=reg');
    }
}
else{
    header('location:../ui-features/indirectpos.php?error=retry');
}




?>
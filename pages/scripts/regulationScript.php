<?php

require '../common/connection.php';
$type=null;
if(isset($_POST) and !empty($_POST)){
    if(isset($_POST['type']) and !empty($_POST['type'])){
        $type=$_POST['type'];
           if($type==1){
                $result_arr=array();
                $json_Array=array();
                $retrive_reg="select rname from regulation order by rname";
                $result=mysqli_query($con,$retrive_reg) or die(mysqli_error($con));
                if(mysqli_num_rows($result)>0){
                   while($row=mysqli_fetch_row($result)){
                     array_push($result_arr,$row[0]);
                   } 
                   $json_Array['msg']=$result_arr;
                }
                else{
                  $json_Array['error']="There Is No Entry Of Regulation";
                }

                $result=json_encode($json_Array);
                header('Content-Type:application/json');
                echo $result; exit();    

           }
           else if($type==2){
                if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
                     $regulation=$_POST['regulation'];
                     $check_reg="select rname from regulation where rname='$regulation'";
                     $result_reg=mysqli_query($con,$check_reg) or die(mysqli_error($con));
                     if(mysqli_num_rows($result_reg)>0){
                        echo '<p style="color:red;">Already Entered.</p>';
                     }else{
                       $insert="insert into regulation(rname) values('$regulation')";
                       $result=mysqli_query($con,$insert) or die(mysqli_error($con));
                       echo '<p style="color:green;">Data Inserted Successfully!</p>';
                     }
                     

                }
                else{
                  echo '<p style="color:red;">Regulation Value is Empty!</p>';            
                }
           }
           else if($type==3){
            
               $result_arr=array();
               $json_Array=array();
               $retrive_acad="select rname,ayname from regulation r,academicyear a where r.rid=a.rid order by rname,ayname";
               $result=mysqli_query($con,$retrive_acad) or die(mysqli_error($con));
               if(mysqli_num_rows($result)>0){
                  while($row=mysqli_fetch_row($result)){
                      if(!array_key_exists($row[0],$result_arr)){
                             $result_arr[$row[0]]=array();
                             array_push($result_arr[$row[0]],$row[1]);
                      }
                      else{
                        array_push($result_arr[$row[0]],$row[1]);
                      }
                  }
                  $json_Array['msg']=$result_arr; 
               } 
               else{
                $json_Array['error']="There Is No Entry Of Batch";
               }
               $result=json_encode($json_Array);
               header('Content-Type:application/json');
               echo $result; exit();   
           }
           else if($type==4){
             if(isset($_POST['regulation']) and !empty($_POST['regulation']) ){
                if(isset($_POST['batch']) and !empty($_POST['batch'])){
                      $regulation=$_POST['regulation'];
                      $batch=$_POST['batch'];
                      $check_reg="SELECT rid from regulation where rname like '$regulation'";
                      $Cres=mysqli_query($con,$check_reg) or die(mysqli_error($con));
                      if(mysqli_num_rows($Cres)>0){
                        $row=mysqli_fetch_row($Cres);
                         $rid=$row[0];
                         $insert="insert into academicyear(ayname,rid) values('$batch',$rid)";
                         $res_1=mysqli_query($con,$insert) or die(mysqli_error($con));
                         echo '<p style="color:green;">Data Inserted Successfully!</p>';
                      }
                      else{
                        echo '<p style="color:red;">There is No Such Regulation.</p>';
                      }
                }
                else{
                  echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading batch</p>';     
                }
             }
             else{
              echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading regulation</p>';
             }
           }
           else if($type==5){
              if(isset($_POST['branch']) and !empty($_POST['branch'])){
                $branch=$_POST['branch'];
                $retrive_tvalue="SELECT tvalue from batchweightage where branch ='$branch'";
                $res=mysqli_query($con,$retrive_tvalue) or die(mysqli_error($con));
                if(mysqli_num_rows($res)>0){
                    $row=mysqli_fetch_row($res);
                    $json_Array=array();
                    $json_Array['msg']=$row[0];
                    $result=json_encode($json_Array);
                    header('Content-Type:application/json');
                    echo $result; exit();

                }
                else{
                  echo '<p style="color:red;">There is no TValue, Contact Admin</p>';  
                }

              }
              else{
                echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading Branch</p>';
              }
           }
           
           else if($type==6){
            //  print_r($_POST); exit();
                if(isset($_POST['branch']) and !empty($_POST['branch'])){
                   if(isset($_POST['tvalue']) and !empty($_POST['tvalue'])){
                        $branch=$_POST['branch'];
                        $tvalue=$_POST['tvalue'];
                        $update="update batchweightage set tvalue=$tvalue where branch='$branch'";
                        $res=mysqli_query($con,$update) or die(mysqli_error($con));
                        echo '<p style="color:green;">Data Updated Successfully!</p>';

                   } 
                   else{
                    echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading Tvalue</p>';   
                   }
                }
                else{
                  echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading Branch</p>';
                }
           }
           else if($type==7){
                      $previousPass=$newPass=$renewPass="";
                    if(isset($_POST['previousPass']) and !empty($_POST['previousPass'])){
                        if(isset($_POST['newPass']) and !empty($_POST['newPass'])){
                            if(isset($_POST['renewPass']) and !empty($_POST['renewPass'])){
                              if(isset($_POST['fid']) and !empty($_POST['fid'])){
                                  $previousPass=$_POST['previousPass'];
                                  $newPass=$_POST['newPass'];
                                  $renewPass=$_POST['renewPass'];
                                  if($newPass===$renewPass){
                                  $previousPass=md5($previousPass);
                                  $newPass=md5($newPass);
                                  $fid=$_POST['fid'];
                                  $check_pass="SELECT psid from password where fid=$fid and password='$previousPass'";
                                  $res=mysqli_query($con,$check_pass) or die(mysqli_error($con));
                                  if(mysqli_num_rows($res)>0){
                                      $insert="update password set password='$newPass' WHERE fid=$fid";
                                      $result=mysqli_query($con,$insert) or die(mysqli_error($con));
                                      echo '<p style="color:green;">Successfully Updated Password.</p>';

                                  }else{
                                    echo '<p style="color:red;">Previous Password MisMatch</p>';
                                  }
                                }
                                else{
                                  echo '<p style="color:red;">MisMatch of New and Re-entred Passwords</p>';
                                }
                             }else{
                              echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading fid</p>';
                             } 
                            }
                            else{
                              echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading re-enter new Password</p>';
                            }
                        }
                        else{
                          echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading  new Password</p>';
                        }
                    }
                    else{
                      echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading Previous Password</p>';
                    }
           }else if($type==8){
                if(isset($_POST['fid']) and !empty($_POST['fid'])){
                    if(isset($_POST['password']) and !empty($_POST['password'])){
                      $fid=$_POST['fid'];
                      $pass=$_POST['password']; 
                      $pass=md5($pass);
                          $insert="update password set password='$pass' WHERE fid=$fid";
                          $result=mysqli_query($con,$insert) or die(mysqli_error($con));
                          echo '<p style="color:green;">Successfully Updated Password.</p>';
                    }
                }
                else{
                  echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading fid</p>';
                }
           }
           else if($type==9){
                $result_Arr=array();
                $json_Array=array();
                $retrive_department="SELECT dname,sname from department";
                $res=mysqli_query($con,$retrive_department) or die(mysqli_error($con));
                if(mysqli_num_rows($res)>0){
                  while($row=mysqli_fetch_row($res)){
                    $result_Arr[$row[0]]=$row[1];
                  }
                  $json_Array['msg']=$result_Arr;
                }
                else{
                  $json_Array['error']="Department list is empty";
                }
                $result=json_encode($json_Array);
                header('Content-Type:application/json');
                echo $result; exit();
           }
           else if($type==10){
                if(isset($_POST['Sname']) and isset($_POST['Sname'])){
                    if(isset($_POST['Fname']) and !empty($_POST['Fname'])){
                        $sname=$_POST['Sname'];
                        $fname=$_POST['Fname'];
                        $select_query="SELECT * from department where dname='$sname' or sname='$fname'";
                        $result=mysqli_query($con,$select_query) or die(mysqli_error($con));
                        if(mysqli_num_rows($result)>0){
                            echo '<p style="color:red;">Already Entered Data!</p>';
                        }else{
                        $insert="insert into department(dname,sname) VALUES('$sname','$fname')";
                        $res=mysqli_query($con,$insert) or die(mysqli_error($con));
                        echo '<p style="color:green;">Successfully inserted the department.</p>';
                        }
                    }
                    else{
                      echo '<p style="color:red;">Full form is empty!</p>';
                    }
                }else{
                  echo '<p style="color:red;">short form is empty!</p>';
                }
           }
           else if($type==11){
                  if(isset($_POST['branch']) and !empty($_POST['branch'])){
                      if(isset($_POST['password']) and !empty($_POST['password'])){
                            $branch=$_POST['branch'];
                            $password=$_POST['password'];
                            $password=md5($password);
                            $des=$branch."-HOD";
                            $check_faculty="SELECT fid from faculty where designation='$des'";
                            $res=mysqli_query($con,$check_faculty) or die(mysqli_error($con));
                            if(mysqli_num_rows($res)>0){
                                echo '<p style="color:red;">Already '.$branch.' Hod Account Exist </p>';
                            }else{
                                $insert_q1="insert into faculty(fname,department,designation,isspecial) VALUES('Head of the Department','$branch','$des',1)";
                                $result=mysqli_query($con,$insert_q1) or die(mysqli_error($con));
                                $select_fid="select fid from faculty where designation='$des' and department='$branch'";
                                $res=mysqli_query($con,$select_fid) or die(mysqli_error($con));
                                if(mysqli_num_rows($res)>0){
                                    $row=mysqli_fetch_row($res);
                                    $fid=$row[0];
                                    $us="VCEHOD".strtoupper($branch);
                                    $insert="insert into password(username,password,fid) VALUES('$us','$password',$fid)";
                                    $res=mysqli_query($con,$insert) or die(mysqli_error($con));
                                    echo '<p style="color:green;">Account Created</p>';
                                }
                            }

                      }else{
                        echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading Password</p>';
                      }
                  }else{
                    echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading branch</p>';
                  }
           }
           else if($type==12){
                    if(isset($_POST['branch']) and !empty($_POST['branch'])){
                        if(isset($_POST['facultyId']) and !empty($_POST['facultyId'])){
                              $bran=$_POST['branch'];
                              $facultyId=$_POST['facultyId'];
                            $des=$bran."-HOD";
                            $select_query="SELECT fid from faculty where designation='$des'";
                            $res=mysqli_query($con,$select_query) or die(mysqli_error($con));
                            if(mysqli_num_rows($res)>0){
                                $row=mysqli_fetch_row($res);
                                $fid=$row[0];
                                $update_Q="update faculty set facultyID='$facultyId' where fid=$fid";
                                $result=mysqli_query($con,$update_Q) or die(mysqli_error($con));
                                echo '<p style="color:green;">Hod Mapped Successfully!</p>';
                            }
                            else{
                              echo '<p style="color:red;">Account for '.$bran.' HOD is not created.</p>';
                            }

                        }
                        else{
                          echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading facultyID</p>';
                        }
                    } 
                    else{
                      echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading Branch</p>';
                    }
           }

    }
    else{
      echo '<p style="color:red;">Something Went Wrong, Contact Admin, Regrading Type</p>';
    }
}
else{
  echo '<p style="color:red;">Something Went Wrong, Contact Admin</p>';
}































?>
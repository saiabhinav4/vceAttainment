<?php
$branch="";
require "../common/connection.php";
if(isset($_SESSION['department']) and !empty($_SESSION['department'])){
    $branch=$_SESSION['department'];
    if(isset($_POST) and !empty($_POST)){
        // print_r($_POST); exit();
        if(isset($_POST['check']) and !empty($_POST['check'])){
            if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
                if(isset($_POST['branch']) and !empty($_POST['branch'])){
                    $branch1=$_POST['branch'];
                    $batch=$_POST['academicYear'];
            // if($branch=="GlobalAdmin"){$branch1="IT";}
            $select_query="select catw,seew,codaw,coidaw,level1,level2,level3,podaw,poidaw,pota,cota from academicyear ac, batchweightage b where ac.aid=b.aid and ayname='$batch' and branch='$branch1'";
            $res=mysqli_query($con,$select_query) or die(mysqli_error($con));
            if(mysqli_num_rows($res)>0){
                $row=mysqli_fetch_row($res);
                $json_Array=array();
                $json_Array['catw']=$row[0];
                $json_Array['seew']=$row[1];
                $json_Array['codaw']=$row[2];
                $json_Array['coidaw']=$row[3];
                $json_Array['level1']=$row[4];
                $json_Array['level2']=$row[5];
                $json_Array['level3']=$row[6];
                $json_Array['podaw']=$row[7];
                $json_Array['poidaw']=$row[8];
                $json_Array['pota']=$row[9];
                $json_Array['cota']=$row[10];
                $json_Array['ischeck']=1;
                $result=json_encode($json_Array);
                header('Content-Type:application/json');
                echo $result;exit();   
            }
            else{
                $json_Array=array();
                $json_Array['ischeck']=0;
                $result=json_encode($json_Array);
                header('Content-Type:application/json');
                echo $result;exit(); 
            }
            }
          }
        }
    }
}
else{
    echo "<p>Session timout contact Admin</p>"; exit();
}

$ciew=$seew=$codaw=$coidaw=$level1=$level2=$level3=$podaw=$poidaw=$pota=$cota="";
if(isset($_POST) and  !empty($_POST)){
    if(isset($_POST['ciew']) and !empty($_POST['ciew'])){
        if(isset($_POST['seew']) and !empty($_POST['seew'])){
            if(isset($_POST['codaw']) and !empty($_POST['codaw'])){
                if(isset($_POST['coidaw']) and !empty($_POST['coidaw'])){
                    if(isset($_POST['level1']) and !empty($_POST['level1'])){
                        if(isset($_POST['level2']) and !empty($_POST['level2'])){
                            if(isset($_POST['level3']) and !empty($_POST['level3'])){
                                if(isset($_POST['podaw']) and !empty($_POST['podaw'])){
                                    if(isset($_POST['poidaw']) and !empty($_POST['poidaw'])){
                                        if(isset($_POST['pota']) and !empty($_POST['pota'])){
                                            if(isset($_POST['cota']) and !empty($_POST['cota'])){
                                                if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
                                                    if(isset($_POST['branch']) and !empty($_POST['branch'])){

                                                $ciew=$_POST['ciew'];
                                                $seew=$_POST['seew'];
                                                $codaw=$_POST['codaw'];
                                                $coidaw=$_POST['coidaw'];
                                                $level1=$_POST['level1'];
                                                $level2=$_POST['level2'];
                                                $level3=$_POST['level3'];
                                                $podaw=$_POST['podaw'];
                                                $poidaw=$_POST['poidaw'];
                                                $pota=$_POST['pota'];
                                                $cota=$_POST['cota'];
                                                $batch=$_POST['academicYear'];
                                                $branch1=$_POST['branch'];
                                                $select_weightage="SELECT catw,seew,codaw,coidaw,level1,level2,level3,podaw,poidaw,pota,cota,b.aid,wid from academicyear ac, batchweightage b where ac.aid=b.aid and ayname='$batch' and branch='$branch1'";
                                                $res=mysqli_query($con,$select_weightage) or die(mysqli_error($con));
                                                if(mysqli_num_rows($res)>0){
                                                    $row=mysqli_fetch_row($res);
                                                    $wid=$row[12];
                                                    $update_query="update batchweightage set catw=$ciew,seew=$seew,codaw=$codaw,coidaw=$coidaw,level1='$level1',level2='$level2',level3='$level3',podaw=$podaw,poidaw=$poidaw,pota=$pota,cota=$cota WHERE wid=$wid";
                                                    $res=mysqli_query($con,$update_query) or die(mysqli_error($con));
                                                    echo " Update Successfully! ";
                                                }
                                                else{
                                                    $retrive_batch="SELECT aid from  academicyear where ayname='$batch'";
                                                    $result=mysqli_query($con,$retrive_batch) or die(mysqli_error($con));
                                                    $row=mysqli_fetch_row($result);
                                                    $aid=$row[0];
                                                    $insert_query="insert into batchweightage(branch,catw,seew,codaw,coidaw,level1,level2,level3,podaw,poidaw,pota,cota,aid) values('$branch1',$ciew,$seew,$codaw,$coidaw,'$level1','$level2','$level3',$podaw,$poidaw,$pota,$cota,$aid)";
                                                    $res=mysqli_query($con,$insert_query) or die(mysqli_error($con));
                                                    echo " Insert Successfully! ";
                                                }

                                                }
                                                else{
                                                    echo "invalid branch value, retry";
                                                }
                                              }
                                              else{
                                                  echo "invalid academicYear value, retry";
                                              }
                                            }
                                            else{
                                                echo "CO target weightage is incorrect, retry";
                                            }
                                        }
                                        else{
                                            echo "PO target weightage is incorrect, retry";
                                        }
                                    }
                                    else{
                                        echo "PO indirect weightage is incorrect, retry";
                                    }
                                }
                                else{
                                    echo "PO direct weightage is incorrect, retry";
                                }
                            }
                            else{
                                echo "Level3 weightage is incorrect, retry";
                            }   
                        }
                        else{
                            echo "Level2 weightage is incorrect, retry";
                        }
                    }
                    else{
                        echo "Level1 weightage is incorrect, retry";
                    }
                }
                else{
                    echo "CO indirect weightage is incorrect, retry";
                }
            }
            else{
                echo "CO direct weightage is incorrect, retry";
            }
        }
        else{
            echo "see weightage is incorrect, retry";
        }    
    }
    else{
        echo "cie weightage is incorrect, retry";
    }
}
else{
    echo "Something went wrong, refresh and retry";
}


?>
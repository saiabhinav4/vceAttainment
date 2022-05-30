<?php
include '../common/connection.php';
// print_r($_POST); exit();
$regulation=$academicYear=$branch=$semesterNo=$Coursecode=$CourseName=$Co1_description=$Co2_description=$Co3_description=$Co4_description=$Co5_description=null;
$co1_f=$co2_f=$co3_f=$co4_f=$co5_f=null;
$cid=$noofcos=null;
$conoArray=array();
$feed=array();
if(isset($_POST)){
    $regulation=$_POST['regulation'];
    $academicYear=$_POST['academicYear'];
    $branch=$_POST['branch'];
    $semesterNo=$_POST['semesterNo'];
    $Coursecode=$_POST['CourseCode'];
    $CourseName=$_POST['CourseName'];
    $coid=$_POST['coid'];
    // $Co1_description=$_POST['Co1_description'];
    // $Co2_description=$_POST['Co2_description'];
    // $Co3_description=$_POST['Co3_description'];
    // $Co4_description=$_POST['Co4_description'];
    // $Co5_description=$_POST['Co5_description'];
    // $co1_f=$_POST['co1_f'];
    // $co2_f=$_POST['co2_f'];
    // $co3_f=$_POST['co3_f'];
    // $co4_f=$_POST['co4_f'];
    // $co5_f=$_POST['co5_f'];
    if(!empty($regulation)){
        if(!empty($academicYear)){
            if(!empty($branch)){
                if(!empty($semesterNo)){
                    if(!empty($Coursecode)){
                        if(!empty($CourseName)){
                            $select_cid="select cd.coid,cono,no_of_cos from coursedetails cd INNER JOIN courseoutcomes co on cd.coid=co.coid where regulation=? and academicYear=? and courseCode=? and branch=? order by courseoutcome";
                            $stmt=$con->prepare($select_cid);
                            $stmt->bind_param("ssss",$regulation,$academicYear,$Coursecode,$branch);
                            $stmt->execute();
                            $result=$stmt->get_result();
                            // $result=mysqli_query($con,$select_cid) or die(mysqli_error($con));
                            if($result->num_rows >0){
                                $i=1;
                                while($row=$result->fetch_row()){
                                    $cid=$row[0];$noofcos=$row[2];
                                    $temp="co".$i."_f";
                                    $conoArray[$temp]=$row[1];
                                    $feed[$temp]=$_POST[$temp];
                                     $i++;
                                }  
                             $select_query="select coid from feedback where coid=?";
                             $stmt=$con->prepare($select_query);
                             $stmt->bind_param("i",$cid);
                             $stmt->execute();
                             $result_q=$stmt->get_result();
                            //  $result_q=mysqli_query($con,$select_query);
                             if($result_q->num_rows >0){
                                 header("location:../ui-features/survey.php?id=$coid&error=alreadyExist");
                             }   
                             else{
                                 $flage=True;
                                 for($l=1;$l<=$noofcos;$l++){
                                     $temp="co".$l."_f";
                                     if(empty($feed[$temp])){
                                         $flage=False;
                                     }

                                 }   
                            if($flage){
                                    for($k=1;$k<=$noofcos;$k++){
                                        $temp="co".$k."_f";
                                        $cono=$conoArray[$temp];
                                        $f=(double)$feed[$temp];
                                        $insert_s="insert into feedback(coid,cono,feedbackvalue) values(?,?,?)";
                                        $stmt=$con->prepare($insert_s);
                                        $stmt->bind_param("iid",$cid,$cono,$f);
                                        $stmt->execute();
                                        // $res=mysqli_query($con,$insert_s) or die(mysqli_error($con));
                                    }
                                header("location:../ui-features/survey.php?id=$coid&msg=inserted");
                            }
                            else{
                             
                                header("location:../ui-features/survey.php?id=$coid&error=enter_CO_f_all");
                            }
                          }
                        }
                        else{
                            header("location:../ui-features/survey.php?id=$coid&error=enter_ar_first");
                        }
                        }
                        else{
                            header("location:../ui-features/survey.php?id=$coid&error=coursename");
                        }
                    }
                    else{
                        header("location:../ui-features/survey.php?id=$coid&error=coursecode");
                    }
                }
                else{
                    header("location:../ui-features/survey.php?id=$coid&error=semesterno");
                }
            }
            else{
                header("location:../ui-features/survey.php?id=$coid&error=branch");
            }
        }
        else{
            header("location:../ui-features/survey.php?id=$coid&error=academicyear");
        }
    }
    else{
        header("location:../ui-features/survey.php?id=$coid&error=regulation");
    }
}
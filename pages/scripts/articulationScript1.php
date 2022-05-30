<?php 
include '../common/connection.php';
// print_r($_POST); exit();
// foreach($_POST as $key =>$val){
//     echo "$key";
// }
// $CoArray=array();
// $noofCos=$_POST['no_of_COs'];
// for($i=1;$i<=$noofCos;$i++){
//     for($j=1;$j<=12;$j++){
//         $temp="co$i"."_po$j";
//         $CoArray[$temp]=$_POST[$temp];
//     }
//     for($j=1;$j<=2;$j++){
//         $temp="co$i"."_pso$j";
//         $CoArray[$temp]=$_POST[$temp];
//     }
// }
// echo "<br>";
// print_r($CoArray);
// echo "<br>";
// $CoDescription=array();
// for($i=1;$i<=$noofCos;$i++){
//     $temp="Co".$i."_description";
//     $CoDescription[$temp]=$_POST[$temp];
// }
// print_r($CoDescription); echo "<br>";
// $flage=false;
// foreach($CoArray as $key=>$value){
//     if($value!="")
//        $flage=true;
// }
// echo $flage."yo";
// exit();
function InsertArticulation($cono,$weight,$programOutcome,$programSpecificOutcome,$coid){
    global $con;
    $select_query="insert into articulation(coid,cono,weight,programOutcomes,programSpecificOutcome) values(?,?,?,?,?)";
    $stmt=$con->prepare($select_query);
    $stmt->bind_param("iiiss", $coid,$cono,$weight,$programOutcome,$programSpecificOutcome);
    $stmt->execute();
    // $result=mysqli_query($con,$select_query) or die(mysqli_error($con));  
}

function InsertRubric($coid,$rno,$rubricDescription,$cos){
    global $con;
    $insert_query="insert into rubricdescription(coid,rno,rubricdes,courseoutcomes) values(?,?,?,?)"; 
    $stmt=$con->prepare($insert_query);
    $stmt->bind_param("iiss", $coid,$rno,$rubricDescription,$cos);
    $stmt->execute();
    // $result=mysqli_query($con,$insert_query) or die(mysqli_error($con));     
}
function InsertDefaultRubric($coid,$deid,$co){
    global $con;
    $insert_query1="insert into comappingrubrics(coid,deid,courseoutcomes) values(?,?,?)"; 
    $stmt=$con->prepare($insert_query1);
    $stmt->bind_param("iis", $coid,$deid,$co);
    $stmt->execute();
    // $result=mysqli_query($con,$insert_query1) or die(mysqli_error($con));     
}
// print_r($_POST); exit();

$regulation=$academicYear=$branch=$semesterNo=$CourseCode=$noofpos=$noofpsos=$CourseName=$noofCos=$coid=$courseType=$noofRubrics=null;
$coid=$_POST['coid'];
if(isset($_POST)){
    // print_r($_POST);
    // $regulation=$_POST['regulation'];
    // $academicYear=$_POST['academicYear'];
    // $branch=$_POST['branch'];
    // $semesterNo=$_POST['semesterNo'];
    // $CourseCode=$_POST['CourseCode'];
    // $CourseName=$_POST['CourseName'];
    // $noofCos=$_POST['no_of_COs'];
    // $courseType=$_POST['courseType'];
    // $noofRubrics=$_POST['no_of_rubrics'];
    // $noofpos=$_POST['no_of_pos'];
    // $noofpsos=$_POST['no_of_psos'];

    $CoArray=array();$cidArray=array();
    $btarray=array();
    $rubricDescription=array();
    $rubricCO=array();
    echo "coid=".$coid."<br> ";
    // print_r($_POST);exit();
    if( isset($_POST['regulation'])  and  !empty($_POST['regulation'])){
        if( isset($_POST['academicYear'])  and !empty($_POST['academicYear'])){
            if( isset($_POST['branch']) and !empty($_POST['branch'])){
                if( isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){
                    if( isset($_POST['CourseCode']) and !empty($_POST['CourseCode'])){
                        if( isset($_POST['CourseName']) and  !empty($_POST['CourseName'])){
                            if(isset($_POST['courseType']) and !empty($_POST['courseType'])){
                                if( isset($_POST['no_of_COs']) and !empty($_POST['no_of_COs'])){
                                    if( isset($_POST['no_of_rubrics']) ){
                                        $noofRubrics=$_POST['no_of_rubrics'];
                                        $regulation=$_POST['regulation'];
                                        $academicYear=$_POST['academicYear'];
                                        $branch=$_POST['branch'];
                                        $semesterNo=$_POST['semesterNo'];
                                        $CourseCode=$_POST['CourseCode'];
                                        $CourseName=$_POST['CourseName'];
                                        $noofCos=$_POST['no_of_COs'];
                                        $courseType=$_POST['courseType'];
                                        
                                        for($i=1;$i<=$noofCos;$i++){
                                            for($j=1;$j<=12;$j++){
                                                $temp="co$i"."_po$j";
                                                $CoArray[$temp]=$_POST[$temp];
                                                }
                                            for($j=1;$j<=2;$j++){
                                                $temp="co$i"."_pso$j";
                                                $CoArray[$temp]=$_POST[$temp];
                                            }
                                        }
                                        $CoDescription=array();
                                        for($i=1;$i<=$noofCos;$i++){
                                            $temp="Co".$i."_description";
                                            $btemp="boom".$i;
                                            $btarray[$btemp]=$_POST[$btemp];
                                            $CoDescription[$temp]=$_POST[$temp];
                                    
                                        }
                                        if( $_POST['ishaverubrics']=="1" ){
                                           if($_POST['isdefault']==0){ 
                                            for($i=1;$i<=$noofRubrics;$i++){
                                                     $temp="R".$i."_description";
                                                     $cos=$i."_R";
                                                     $rubricDescription[$temp]=$_POST[$temp];
                                                     $res="";
                                                     for($j=0;$j<count($_POST[$cos]);$j++){
                                                         $res=$res.$_POST[$cos][$j];
                                                     }
                                                     $rubricCO[$i]=$res;
                                            }
                                          }
                                          else if($_POST['isdefault']!='0'){
                                            $deidArray=explode(",",$_POST['deid']);
                                            foreach($deidArray as $k=>$v){
                                                $cos=($k+1)."_R";
                                                $res="";
                                                for($j=0;$j<count($_POST[$cos]);$j++){
                                                    $res=$res.$_POST[$cos][$j];
                                                }
                                                $rubricCO[$v]=$res;
                                            }

                                        }
                                         //    print_r($rubricCO); exit();
                                        }
                                        $noofRubrics=count($rubricCO);
                                       
                                       
                                $select_check="select cono from courseoutcomes where coid=?";
                                $stmt=$con->prepare($select_check);
                                $stmt->bind_param("i", $coid);
                                $stmt->execute();
                                $result=$stmt->get_result();
                                // $result=mysqli_query($con,$select_check) or die(mysqli_error($con));        
                                if( $result->num_rows >0){
                                    header("location:../ui-features/articulation.php?id=$coid&error=alreadyentered");
                                }
                                else{
                                    $descflage=false;
                                    foreach($CoDescription as $key => $value){
                                            if($value!="")
                                               $descflage=true;
                                    }    
                              if($descflage){

                                        $Coflage=false;
                                        foreach($CoArray as $key => $value){
                                            if($value!="")
                                               $Coflage=true;
                                        }
                                if($Coflage){
                                    $rubric=true;   
                                        if( $_POST['ishaverubrics']=="1" ){
                                          if($_POST['isdefault']==0){ 
                                            for($i=1;$i<=$noofRubrics;$i++){
                                                $temp="R".$i."_description";
                                                if($rubricDescription[$temp]=="" and count($rubricCO[$i])==0){
                                                        $rubric=false;
                                                        break;
                                                }
                                              }
                                            if(!$rubric){
                                               
                                                header("location:../ui-features/articulation.php?id=$coid&error=rubric_desc");
                                            }   
                                           }
                                           else if($_POST['isdefault']!=0){ 
                                                foreach($rubricCO as $k=>$v){
                                                    if($v==""){
                                                        $rubric=false;
                                                        break;
                                                    }
                                                }
                                                if(!$rubric){
                                                 
                                                    header("location:../ui-features/articulation.php?id=$coid&error=rubric_desc");
                                                 } 
                                           }
                                        }

                                        // print_r($noofRubrics);
                                        // print_r($rubricCO); 
                                        // echo "<br>ishaverubrics= ".$_POST['ishaverubrics']." <br>isdefault= ".$_POST['isdefault'];
                                        // exit();
                                        
                                        if( $_POST['ishaverubrics']=="1" ){
                                            // $insert_Query="insert into coursedetails(regulation,academicYear,courseCode,branch,semesterNo,courseName,no_of_cos,courseType,no_of_rubrics) values('$regulation','$academicYear','$CourseCode','$branch',$semesterNo,'$CourseName',$noofCos,'$courseType',$noofRubrics)";
                                            $update_Query="update coursedetails set no_of_cos=$noofCos,no_of_rubrics=$noofRubrics where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and semesterNo=$semesterNo";
                                        }
                                        else{
                                            // $insert_Query="insert into coursedetails(regulation,academicYear,courseCode,branch,semesterNo,courseName,no_of_cos,courseType) values('$regulation','$academicYear','$CourseCode','$branch',$semesterNo,'$CourseName',$noofCos,'$courseType')";
                                            $update_Query="update coursedetails set no_of_cos=$noofCos where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and semesterNo=$semesterNo";
                                        }

                                        $result_in=mysqli_query($con,$update_Query) or die(mysqli_error($con));
                                        $select_coid="select coid from coursedetails where regulation='$regulation' and academicYear='$academicYear' and courseCode='$CourseCode' and branch='$branch' and semesterNo=$semesterNo";
                                        $resut_se=mysqli_query($con,$select_coid) or die(mysqli_error($con));
                                        $row_4=mysqli_fetch_row($resut_se); 
                                        if(!empty($row_4[0])){
                                            $coid=$row_4[0];

                                        for($i=1;$i<=$noofCos;$i++){
                                            $tem="CO".$i;
                                            $cidt="CONO".$i;
                                            $temp="Co".$i."_description";
                                            $btemp="boom".$i;
                                            $description=$CoDescription[$temp];
                                            $boomTaxnonomy=$btarray[$btemp];
                                            $insert_CO="insert into courseoutcomes(coid,courseDescription,courseoutcome,bt) values(?,?,?,?)";
                                            $stmt=$con->prepare($insert_CO);
                                            $stmt->bind_param("isss",$coid,$description,$tem,$boomTaxnonomy);
                                            $stmt->execute();
                                            $result_CO1=$stmt->get_result();
                                            // $result_CO1=mysqli_query($con,$insert_CO) or die(mysqli_error($con));
                                            $select_query="select cono from coursedetails cd,courseoutcomes co where cd.coid=co.coid and regulation=? and academicYear=? and courseCode=? and branch=? and courseoutcome=?";
                                            $stmt=$con->prepare($select_query);
                                            $stmt->bind_param("sssss", $regulation,$academicYear,$CourseCode,$branch,$tem);
                                            $stmt->execute();
                                            $result=$stmt->get_result();
                                            $row=$result->fetch_row();
                                            // $result=mysqli_query($con,$select_query) or die(mysqli_error($con));  
                                            // $row=mysqli_fetch_row($result);
                                            $cidArray[$cidt]=$row[0];     
                                        }

                                   
                                        for($i=1;$i<=$noofCos;$i++){
                                            for($j=1;$j<=12;$j++){
                                            $co="CO".$i;
                                            $po="PO".$j;
                                            $temp="co$i"."_po$j";
                                            $cidt="CONO".$i;
                                            $co_id=$cidArray[$cidt];
                                            $co_po=$CoArray[$temp];
                                            if($co_po!=""){
                                                InsertArticulation($co_id,$co_po,$po,"",$coid);      
                                            }
                                        }
                                        for($j=1;$j<=2;$j++){
                                            $temp="co$i"."_pso$j";
                                            $co="CO".$i;
                                            $pso="PSO".$j;
                                            $cidt="CONO".$i;
                                            $co_id=$cidArray[$cidt];
                                            $co_pso=$CoArray[$temp];
                                            if($co_pso!=""){
                                            InsertArticulation($co_id,$co_pso,"",$pso,$coid);
                                            }
                                        }
                                     }
                                            
                                        if($_POST['ishaverubrics']=="1" ){
                                            if($_POST['isdefault']==0){ 
                                                 for($i=1;$i<=$noofRubrics;$i++){
                                                    $temp="R".$i."_description";  
                                                      InsertRubric($coid,$i,$rubricDescription[$temp],$rubricCO[$i]);      
                                                 }              
                                            }
                                            else if($_POST['isdefault']!=0){
                                                    foreach($rubricCO as $k=>$val){
                                                        InsertDefaultRubric($coid,$k,$val);
                                                    }
                                            }
                                        }      
                                         header("location:../ui-features/articulation.php?id=$coid&msg=success");
                                        }
                                        else{
                                            header("location:../ui-features/articulation.php?id=$coid&error=reenter");
                                        }
                                    }
                                    else{
                                        header("location:../ui-features/articulation.php?id=$coid&error=map_cos_pos");
                                    }    
                              }else{
                                    header("location:../ui-features/articulation.php?id=$coid&error=co_description");
                              }
                               } 
                              }
                              else{
                                header("location:../ui-features/articulation.php?id=$coid&error=noofrubrics");
                              } 
                           }
                           else{
                            header("location:../ui-features/articulation.php?id=$coid&error=noofcos");
                           }    
                         }
                         else{
                            header("location:../ui-features/articulation.php?id=$coid&error=courseType");  
                         }
                        }  
                        else{
                            header("location:../ui-features/articulation.php?id=$coid&error=coursename");
                        }
                    }
                    else{
                        header("location:../ui-features/articulation.php?id=$coid&error=coursecode");
                    }
                }
                else{
                    header("location:../ui-features/articulation.php?id=$coid&error=semesterno");
                }
            }
            else{
                header("location:../ui-features/articulation.php?id=$coid&error=branch");
            }
        }
        else{
            header("location:../ui-features/articulation.php?id=$coid&error=acadamicyear");
        }
    }
    else{
        header("location:../ui-features/articulation.php?id=$coid&error=regulation");
    }
}
else{
    header("location:../ui-features/articulation.php?id=$coid&error=nopost");
}

?>



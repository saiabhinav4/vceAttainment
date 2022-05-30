<?php

require '../common/connection.php';
$dept="";
$check="";
$json_array=array();
// print_r($_POST); exit();
function get_progress($regulation,$academicYear,$branch,$semesterNo,$courseCode){
    $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regulation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&coursecode=".$courseCode."&endpoint=CheckStatus";
    $data=file_get_contents($url);
    $decode_Data=json_decode($data,true);
    if(isset($decode_Data['error'])){
        return 0;
    }
    else{
        $total=0;$entered=0;
        $arr=$decode_Data['courses'][0];
        foreach($arr['status'] as $k=>$val){
              if($k=="indirect"){
                  if($val){ $entered++; } 
                  $total++;
              }
              else{
                 $total+=count($val);
                 foreach($val as $k1=>$v){
                   if($v){ $entered++; }
                 }
              } 
        }
        return round(( ($entered*100)/$total));
    }
  }
if( isset($_POST) and !empty($_POST) ){
     if(isset($_POST['check']) and !empty($_POST['check'])){
          $check=$_POST['check'];
       if( $check==1 and  isset($_POST['dept']) and !empty($_POST['dept'])){
            $dept=$_POST['dept'];
            $select_faculty="SELECT facultyID,fname,fid from faculty where department='$dept' and isspecial=0";
            $res=mysqli_query($con,$select_faculty) or die(mysqli_error($con));
            if(mysqli_num_rows($res)){
                while($row=mysqli_fetch_row($res)){
                    if(!empty($row[0])){
                      $tem=array();
                      $tem['id']=$row[0];
                      $tem['name']=$row[1]; 
                      $tem['fid']=$row[2];
                      array_push($json_array,$tem); 
                    }
                }
                
                $result=json_encode($json_array);
                header('Content-Type:application/json');
                echo $result;exit();       
            }
            else{
                $json_array['msg']="Not Yet Entred!";
                $result=json_encode($json_array);
                header('Content-Type:application/json');
                echo $result;exit();
            }
       
        }
        else if($check==2){
            $regulation=$acdemicYear=$branch=$semesterNo=$courseName=$courseCode="";
                if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
                    if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
                        if(isset($_POST['branch']) and !empty($_POST['branch'])){
                            if(isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){   
                                if(isset($_POST['courseName']) and !empty($_POST['courseName'])){
                                    if(isset($_POST['courseCode']) and !empty($_POST['courseCode'])){
                                        $regulation=$_POST['regulation'];
                                        $acdemicYear=$_POST['academicYear'];
                                        $branch=$_POST['branch'];
                                        $semesterNo=$_POST['semesterNo'];
                                        $courseName=$_POST['courseName'];
                                        $courseCode=$_POST['courseCode'];
                                        $retrive_faculty="SELECT f.fid,fname,facultyID,department from coursedetails d,faculty f where d.fid=f.fid and regulation='$regulation' and academicyear='$acdemicYear' and branch='$branch' and semesterNo=$semesterNo and courseCode='$courseCode'";
                                        $result=mysqli_query($con,$retrive_faculty) or die(mysqli_error($con));
                                        if(mysqli_num_rows($result)){
                                            $row=mysqli_fetch_row($result);
                                            $json_array['fid']=$row[0];
                                            $json_array['name']=$row[1];
                                            $json_array['id']=$row[2];
                                            $json_array['dept']=$row[3];
                                            $result=json_encode($json_array);
                                            header('Content-Type:application/json');
                                            echo $result;exit();   

                                        }
                                        else{
                                            $json_array['msg']="This Course is not Yet mapped to any faculty";
                                            $result=json_encode($json_array);
                                            header('Content-Type:application/json');
                                            echo $result;exit();     
                                        }
                                    }
                                    else
                                    {
                                        $json_array['error']="Something went wrong, Contact Admin";
                                        $result=json_encode($json_array);
                                        header('Content-Type:application/json');
                                        echo $result;exit();
                    
                                    }
                                }
                                else
                                {
                                    $json_array['error']="Something went wrong, Contact Admin";
                                    $result=json_encode($json_array);
                                    header('Content-Type:application/json');
                                    echo $result;exit();
                
                                }
                            }
                            else
                            {
                                $json_array['error']="Something went wrong, Contact Admin";
                                $result=json_encode($json_array);
                                header('Content-Type:application/json');
                                echo $result;exit();
            
                            }
                        }
                        else
                        {
                            $json_array['error']="Something went wrong, Contact Admin";
                            $result=json_encode($json_array);
                            header('Content-Type:application/json');
                            echo $result;exit();
        
                        }
                    }
                    else
                    {
                        $json_array['error']="Something went wrong, Contact Admin";
                        $result=json_encode($json_array);
                        header('Content-Type:application/json');
                        echo $result;exit();
    
                    }   
                }
                else
                {
                    $json_array['error']="Something went wrong, Contact Admin";
                    $result=json_encode($json_array);
                    header('Content-Type:application/json');
                    echo $result;exit();

                }
        }
        else if($check==3){
            $regulation=$acdemicYear=$branch=$semesterNo=$courseName=$courseCode=$prefaculty=$newfaculty="";
            // print_r($_POST); exit();
            if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
                if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
                    if(isset($_POST['branch']) and !empty($_POST['branch'])){
                        if(isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){   
                            if(isset($_POST['courseName']) and !empty($_POST['courseName'])){
                                if(isset($_POST['courseCode']) and !empty($_POST['courseCode'])){
                                    if(isset($_POST['Prefaculty']) and !empty($_POST['Prefaculty'])){
                                    if(isset($_POST['Newfaculty']) and !empty($_POST['Newfaculty'])){
                                    $regulation=$_POST['regulation'];
                                    $acdemicYear=$_POST['academicYear'];
                                    $branch=$_POST['branch'];
                                    $semesterNo=$_POST['semesterNo'];
                                    $courseName=$_POST['courseName'];
                                    $courseCode=$_POST['courseCode'];
                                    $prefaculty=$_POST['Prefaculty']; 
                                    $newfaculty=explode("%",$_POST['Newfaculty']);
                                    $preID=$prefaculty;
                                    $newID=$newfaculty[1];
                                    $retrive_faculty="SELECT f.fid,coid from coursedetails d,faculty f where d.fid=f.fid and regulation='$regulation' and academicyear='$acdemicYear' and branch='$branch' and semesterNo=$semesterNo and courseCode='$courseCode'";
                                    $result=mysqli_query($con,$retrive_faculty) or die(mysqli_error($con));
                                    if(mysqli_num_rows($result)){
                                        $row=mysqli_fetch_row($result);
                                        $coid=$row[1];
                                        if($preID==$row[0]){
                                            $update_query="update coursedetails set fid=$newID where coid=$coid";
                                            $res=mysqli_query($con,$update_query) or die(mysqli_error($con));
                                            $json_array['msg']='<p style="color:green;">faculty Mapping updated successfuly!</p>';
                                            $result=json_encode($json_array);
                                            header('Content-Type:application/json');
                                            echo $result;exit();
                                        }
                                        else{
                                            $json_array['error']='<p style="color:red;">Mismatch Previous faculty Ids, Contact Admin</p>';
                                            $result=json_encode($json_array);
                                            header('Content-Type:application/json');
                                            echo $result;exit();      
                                        }

                                    }
                                    else{
                                        $json_array['msg']='<p style="color:red;">This Course is not Yet mapped to any faculty</p>';
                                        $result=json_encode($json_array);
                                        header('Content-Type:application/json');
                                        echo $result;exit();     
                                    }
                                  }
                                  else{
                                    $json_array['error']='<p style="color:red;">Something went wrong, Contact Admin</p>';
                                    $result=json_encode($json_array);
                                    header('Content-Type:application/json');
                                    echo $result;exit();
                
                                    }
                                  }
                                  else{
                                    $json_array['error']='<p style="color:red;">Something went wrong, Contact Admin</p>';
                                    $result=json_encode($json_array);
                                    header('Content-Type:application/json');
                                    echo $result;exit();
                
                                  }
                                }
                                else
                                {
                                    $json_array['error']='<p style="color:red;">Something went wrong, Contact Admin</p>';
                                    $result=json_encode($json_array);
                                    header('Content-Type:application/json');
                                    echo $result;exit();
                
                                }
                            }
                            else
                            {
                                $json_array['error']='<p style="color:red;">Something went wrong, Contact Admin</p>';
                                $result=json_encode($json_array);
                                header('Content-Type:application/json');
                                echo $result;exit();
            
                            }
                        }
                        else
                        {
                            $json_array['error']='<p style="color:red;">Something went wrong, Contact Admin</p>';
                            $result=json_encode($json_array);
                            header('Content-Type:application/json');
                            echo $result;exit();
        
                        }
                    }
                    else
                    {
                        $json_array['error']='<p style="red;">Something went wrong, Contact Admin</p>';
                        $result=json_encode($json_array);
                        header('Content-Type:application/json');
                        echo $result;exit();
    
                    }
                }
                else
                {
                    $json_array['error']='<p style="color:red;">Something went wrong, Contact Admin</p>';
                    $result=json_encode($json_array);
                    header('Content-Type:application/json');
                    echo $result;exit();

                }   
            }
            else
            {
                $json_array['error']='<p style="color:red;">Something went wrong, Contact Admin</p>';
                $result=json_encode($json_array);
                header('Content-Type:application/json');
                echo $result;exit();

            }
        }else if($check==4){
            $fid=null;
            $result='';
          
            if($_POST['fid'] and !empty($_POST['fid'])){
                $fid=$_POST['fid'];
                $select_courses="SELECT regulation,academicYear,courseCode,semesterNo,courseName,branch from coursedetails where fid=$fid";
                $res=mysqli_query($con,$select_courses) or die(mysqli_error($con));
                if(mysqli_num_rows($res)>0){
                    while($row=mysqli_fetch_row($res)){
                        $val= get_progress($row[0],$row[1],$row[5],$row[3],$row[2]);
                        $result.='
                            <div class="row apply-border" style="">
                                <div style="display:flex;justify-content: space-between">
                                <p class="custom-list"><b>Regulation: </b>'.$row[0].'</p>
                                <p class="custom-list"><b>AcademicYear: </b>'.$row[1].'</p>
                                <p class="custom-list"><b>SemesterNo: </b>'.$row[3].'</p>
                                </div>
                                <div style="display:flex;gap:20px;">
                                <p class="custom-list"><b>Branch: </b>'.$row[5].'</p>
                                <p class="custom-list"><b>CourseCode: </b>'.$row[2].'</p>
                                </div>
                                <p class="custom-list"><b>Course Name: </b>'.$row[4].'</p>
                                <p class="custom-list"><b>Status : </b>
                                <div class="progress" style="height:15px;">
                                <div
                                    class="progress-bar bg-success"
                                    role="progressbar"
                                    style="width: '.$val.'%"
                                    aria-valuenow='.$val.'"
                                    aria-valuemin="0"
                                    aria-valuemax="100"
                                >'.$val.'%</div>
                                </div>
                                </p>
                            </div>
                        ';
                    }
                }
                else{
                    $result.='<p style="color:red;">Courses are not mapped to these faculty</p>';
                }

                echo $result;
                exit();
            }
            else{
                $json_array['error']='<p style="color:red;">Fid is empty!, contact admin</p>';
                $result=json_encode($json_array);
                header('Content-Type:application/json');
                echo $result;exit();
            }
        }
        else{
            $json_array['error']="Something went wrong, Contact Admin";
            $result=json_encode($json_array);
            header('Content-Type:application/json');
            echo $result;exit();
        }
      }
       else{
        $json_array['error']="Something went wrong, Contact Admin";
        $result=json_encode($json_array);
        header('Content-Type:application/json');
        echo $result;exit();
       } 
}
else{
    $json_array['error']="Something went worng, Refresh and try";
    $result=json_encode($json_array);
    header('Content-Type:application/json');
    echo $result;exit();
}



?>
<?php
require "../common/connection.php";
$regulation=$academicYear=$branch=$semesterNo=$courseCode=$courseName=null;
if(isset($_POST) and !empty($_POST)){    
    if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
        if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
            if(isset($_POST['branch']) and !empty($_POST['branch'])){
                if(isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){
                            $regulation=$_POST['regulation'];
                            $academicYear=$_POST['academicYear'];
                            $branch=$_POST['branch'];
                            $semesterNo=$_POST['semesterNo'];
                    if(isset($_POST['type'])){
                        if($_POST['type']==1){
                            // print_r($_POST['type']);exit();
                        if(isset($_POST['courseCode']) and !empty($_POST['courseCode'])){
                            if(isset($_POST['courseName']) and !empty($_POST['courseName'])){
                            
                            $courseCode=$_POST['courseCode'];
                            $courseName=$_POST['courseName'];

                            $select_exist="select coid from coursedetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and semesterNo=$semesterNo and courseCode='$courseCode'";
                            $res=mysqli_query($con,$select_exist) or die(mysqli_error($con));
                            if(mysqli_num_rows($res)>0){
                                echo "<p> course is already entered </p>";      
                            }
                            else{

                                $insert_query="insert into coursedetails(regulation,academicYear,branch,semesterNo,courseCode,courseName) values('$regulation','$academicYear','$branch',$semesterNo,'$courseCode','$courseName')";
                                if($result=mysqli_query($con,$insert_query) or die(mysqli_error($con))){
                                    echo "<p> course Entered Successfuly! </p>";                                   
                                }
                                else{
                                    echo "<p> Something went wrong, re-enter course </p>";   
                                }
                            }
                        }
                        else{
                            echo "<p> Enter CourseName properly, re-enter course. </p>";
                        }
                    }
                    else{
                        echo "<p> Enter CourseCode properly, re-enter course. </p>";
                    }

                    }
                    else if($_POST['type']==0){   
                        // echo "YO $regulation $academicYear $branch $semesterNo <br>";
                        $select_courses="select courseCode,courseName from coursedetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and semesterNo=$semesterNo";
                        $result_courses=mysqli_query($con,$select_courses) or die(mysqli_error($con));
                        if(mysqli_num_rows($result_courses)>0){
                            // $rows=mysqli_fetch_row($result_courses)
                         ?> <div class="table-responsive pt-3">  

                            <table id="coursesTable" class="table table-bordered" >
                                  <thead>
                                       <tr class="table-info">
                                           <th>SNO</th>
                                           <th>Course Code</th>
                                           <th>Course Name</th> 
                                       </tr> 
                                  </thead>
                                  <tbody>   
                                       <?php 
                                        $i=1;
                                        while($row=mysqli_fetch_row($result_courses)){ ?>
                                            <tr class="table-info2">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row[0]; ?></td>
                                                <td><?php echo $row[1]; ?></td>
                                            </tr>            
                                       <?php $i++; }
                                       ?>     
                                  </tbody>  
                            </table>    
                                        </div>
                                        <script>
                                            $(document).ready(function () {
                                                $("#coursesTable").DataTable();
                                                });
                                        </script>
                        <?php }
                        else{
                            echo "<p> Not Yet Entered! </p>";
                        }
                    }else if($_POST['type']==2){
                        $json_array=array();
                        $select_courses="select courseCode,courseName from coursedetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and semesterNo=$semesterNo";
                        $result_courses=mysqli_query($con,$select_courses) or die(mysqli_error($con));
                        if(mysqli_num_rows($result_courses)>0){
                            while($row=mysqli_fetch_row($result_courses)){
                                $json_array[$row[1]]=$row[0];
                            }           
                        }
                        else{
                            $json_array['error']="NOT YET Entered!";                            
                        }
                        
                        $result=json_encode($json_array);
                        header('Content-Type:application/json');
                        echo $result; exit();  
                    }else if($_POST['type']==3){
                       if(isset($_POST['Fid']) and !empty($_POST['Fid'])){
                           $fid=$_POST['Fid'];
                        $json_array=array();
                        $select_courses="select courseCode,courseName from coursedetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and semesterNo=$semesterNo and fid=$fid";
                        $result_courses=mysqli_query($con,$select_courses) or die(mysqli_error($con));
                        if(mysqli_num_rows($result_courses)>0){
                            while($row=mysqli_fetch_row($result_courses)){
                                $json_array[$row[1]]=$row[0];
                            }           
                        }
                        else{
                            $json_array['error']="NOT YET Entered!";                            
                        }
                        
                        $result=json_encode($json_array);
                        header('Content-Type:application/json');
                        echo $result; exit();   
                      }
                      else{
                        echo "<p> contact Admin! something went wrong, regrading Fid </p>";
                      }
                    }   
                  }
                  else{
                    echo "<p> contact Admin! something went wrong </p>";
                  }

                }
                else{
                    echo "<p> Enter SemesterNo properly, re-enter course. </p>";
                }
            }   
            else{
                echo "<p> Enter branch properly, re-enter course. </p>";
            }
        }
        else{
            echo "<p> Enter academicYear properly, re-enter course. </p>";
        }
    }else{
        echo "<p> Enter regulation properly, re-enter course. </p>";
    }
}
else{
    echo "<p> Somthing went worng, re-enter course. </p>";
}







?>
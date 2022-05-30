<?php

require "../common/connection.php";
// print_r($_POST);exit();


$type=$facultyId=$facultyName=$department=$password=$designation=null;
if(isset($_SESSION['department']) and !empty($_SESSION['department'])){
    $department=$_SESSION['department']; 
}
else{
 header('location:../../index.php');
}
if(isset($_POST) and !empty($_POST)){
    if(isset($_POST['type']) ){
        $type=$_POST['type'];
        if($type==0){
            if(isset($_POST['facultyId']) and !empty($_POST['facultyId'])){
                if(isset($_POST['facultyName']) and !empty($_POST['facultyName'])){
                    if(isset($_POST['designation']) and !empty($_POST['designation'])){
                        if(isset($_POST['password']) and !empty($_POST['password'])){
                                $facultyId=$_POST['facultyId'];
                                $facultyName=$_POST['facultyName'];
                                $password=md5($_POST['password']);
                                $designation=$_POST['designation'];
                                $check_exist="SELECT fid from faculty where facultyID='$facultyId' and department='$department' and designation='$designation'";
                                $res=mysqli_query($con,$check_exist) or die($con);
                                if(mysqli_num_rows($res)>0){
                                    echo "<p>Faculty details are Already Entered </p>";
                                }else{
                                  $insert_query="insert into faculty(fname,department,designation,isspecial,facultyID) values('$facultyName','$department','$designation',0,'$facultyId')";
                                  if($result=mysqli_query($con,$insert_query) or die(mysqli_error($con))){
                                    $select_q="SELECT fid from faculty where facultyID='$facultyId' and department='$department' and designation='$designation'";
                                    if($re=mysqli_query($con,$select_q) or die(mysqli_error($con))){
                                        $row=mysqli_fetch_row($re);
                                        $fid=$row[0];
                                        $insert_pass="insert into password(username,password,fid) values('$facultyId','$password',$fid)";
                                        if($result=mysqli_query($con,$insert_pass) or die(mysqli_errno($con))){
                                               echo "<p> Faculty Data Entered Successfuly! </p>"; 
                                        }
                                        else{
                                            echo "<p> Something went wrong, re-enter course </p>";  
                                        }
                                    }
                                    else{
                                        echo "<p> Something went wrong, re-enter course </p>";   
                                    }
                                 
                                  }
                                  else{
                                    echo "<p> Something went wrong, re-enter course </p>";   
                                  }
                                
                                }
                        }
                        else{
                            echo "<p> Enter password properly, re-enter course. </p>";
                        }
                    }
                    else{
                        echo "<p> Enter designation properly, re-enter course. </p>";
                    }
                }
                else{
                    echo "<p> Enter facultyName properly, re-enter course. </p>";
                }   
            }
            else{
                echo "<p> Enter faculty properly, re-enter course. </p>";
            }
        }
        else if($type==1){
                        $select_faculty="select facultyID,fname,designation,fid from faculty where department='$department' and isspecial=0";
                        $result_faculty=mysqli_query($con,$select_faculty) or die(mysqli_error($con));
                        if(mysqli_num_rows($result_faculty)>0){
                            // $rows=mysqli_fetch_row($result_courses)
                         ?> <div class="table-responsive pt-3">  
                            <table id="facultyTable" class="table table-bordered">
                                  <thead>
                                       <tr class="table-info">
                                           <th>SNO</th>
                                           <th>Faculty ID</th>
                                           <th>Faculty Name</th>
                                           <th>Designation</th> 
                                           <th>NO Of Course Mapped</th>
                                           <th>View Mapping details</th>
                                           <th>View Passwords</th>
                                           <th>Modify</th>
                                           <th>Delete faculty</th>
                                       </tr> 
                                  </thead>
                                  <tbody>   
                                       <?php 
                                        $i=1;
                                        while($row=mysqli_fetch_row($result_faculty)){ 
                                            if(!empty($row[0])){
                                                $retrive_count="SELECT coid from coursedetails where fid=?";
                                                $stmt=$con->prepare($retrive_count);
                                                $stmt->bind_param("i", $row[3]);
                                                $stmt->execute();
                                                $result=$stmt->get_result();
                                            ?>
                                            <tr class="table-info2">
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $row[0]; ?></td>
                                                <td><?php echo $row[1]; ?></td>
                                                <td><?php echo $row[2]; ?></td>
                                                <td style="text-align:center"><?php if($result->num_rows==0){ echo "0";}else{ echo $result->num_rows; } ?></td>
                                                <td><a class="btn btn-primary viewMdetails" data-fid="<?php echo $row[3]; ?>" value="<?php echo $row[3]; ?>" data-facultyid="<?php echo $row[0];  ?>" data-fname="<?php echo $row[1]; ?>" >click here</a></td>
                                                <td><a class="btn btn-primary viewPassword" data-fid="<?php echo $row[3]; ?>" value="<?php echo $row[3]; ?>" data-facultyid="<?php echo $row[0];  ?>" data-fname="<?php echo $row[1]; ?>" >click here</a></td>
                                                <td><a class="btn btn-primary  modify" data-fid="<?php echo $row[3]; ?>" data-facultyid="<?php echo $row[0];  ?>" data-fname="<?php echo $row[1]; ?>" value="<?php echo $row[3]; ?>" >click here</a></td>
                                                <td style="padding-left:20px;"><a  class="btn btn-danger  delete" value="<?php echo $row[3]; ?>">X</a></td>
                                            </tr>            
                                       <?php $i++;} }
                                       ?>     
                                  </tbody>  
                            </table>    
                            <script>
                                  $(document).ready(function () {
                                                $("#facultyTable").DataTable();
                                    });
                                $('.modify').click(function(e){
                                    var str=$(this).attr('value');
                                    // console.log(str);
                                    // console.log($(this).attr("data-facultyid"));
                                    // console.log($(this).attr("data-fname"));
                                    $('#prevName').html(`Previous Faculty : ${$(this).attr("data-fname")}-${$(this).attr("data-facultyid")}`);
                                    $('#prevName').attr('data-fid',$(this).attr('data-fid'));
                                    // var insert=document.getElementById('checkIT');

                                $('#myModal').modal('show');    
                                   
                                });

                                $('.viewMdetails').click(function(){
                                    var V=$(this).attr('data-fid');
                                    $('#prevName1').html(`Faculty : ${$(this).attr("data-fname")}-${$(this).attr("data-facultyid")}`);
                                    $('#prevName1').attr('data-fid',$(this).attr('data-fid'));
                    $.ajax({
                      url:'../scripts/fetchFacultyScript.php',
                      type:'post',
                      data:{check:4,fid:V},
                      beforeSend: function(){
                        $('#result-modify1').empty();  
                        $("#loader1").show();
                        },
                        success: function(response){
                        $('#result-modify1').empty();
                        $('#result-modify1').append(response);
                        },
                        complete:function(data){
                        $("#loader1").hide();
                        } 
                        }); 
                                    $('#myModal-mapp').modal('show');

                                });

                                $('.viewPassword').click(function(){
                                    var V=$(this).attr('data-fid');
                                    $('#prevName2').html(`Faculty : ${$(this).attr("data-fname")}-${$(this).attr("data-facultyid")}`);
                                    $('#prevName2').attr('data-fid',$(this).attr('data-fid'));
                                    $('#myModal-password').modal('show');
                                });   


                                $('.delete').click(function(e){
                                    var V=$(this).attr('value');
                                    console.log(V);
                                    $.ajax({
                      url:'../scripts/facultymodifyScript.php',
                      type:'post',
                      data:{type:0,fid:V},
                      beforeSend: function(){
                        $('.response').empty();  
                        $("#loader").show();
                        },
                        success: function(response){
                        $('.response').empty();
                        $('.response').append(response);
                        },
                        complete:function(data){
                        $("#loader").hide();
                        } 
                        }); 
                                    // var insert=document.getElementById('checkIT');
                                // $('#myModal').modal('show');    

                                });
                            </script>
                                        </div>
                        <?php }
                        else{
                            echo "<p> Not Yet Entered! </p>";
                        }
        }
    }
    else{
        echo "<p> contact Admin! something went wrong </p>";
    }
}
else{
    echo "<p> Somthing went worng, re-enter details. </p>";
}





























?>
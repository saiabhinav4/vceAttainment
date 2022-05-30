<?php 
include '../common/connection.php';
$courseName=null;
$regulation=$_POST['regulation'];
$academicyear=$_POST['academicYear'];
$branch=$_POST['branch'];
$semester=$_POST['semester'];
$coursecode=$_POST['coursecode'];
$select_Query="select courseCode,courseDescription,no_of_cos,courseName from coursedetails cd INNER JOIN courseoutcomes co on cd.coid=co.coid where regulation=? and academicYear=? and courseCode=? and branch=? order by courseoutcome ";
$stmt=$con->prepare($select_Query);
$stmt->bind_param("ssss",$regulation,$academicyear,$coursecode,$branch);
$stmt->execute();
$result=$stmt->get_result();
// $result=mysqli_query($con,$select_Query);
// echo "[";
// $result=mysqli_query($con,$select_Query);
// while($row=mysqli_fetch_row($result)){
//     // print_r($row);
// echo '{"courseCode":"'.$row[0].'","courseDescription":"'.$row[1].'","CourseName":"'.$row[2].'"},';
// }
// echo "{}]";
if($result->num_rows >0){
?>
<div class="container">
            <div class="row">
            <div class="table-responsive" >
                <table class="table table-bordered" style="width:700px;">
                    <thead>
                      <tr class="table-info">
                        <th class="changeCO">Course Outcomes</th>
                        <th>Course Description</th>
                        <th class="changeTd">Feedback</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php   $i=1;
                            while($row=$result->fetch_row()){
                                $courseName=$row[3];
                             ?>
                        <tr class="table-info2">
                        <td id="t_co<?php echo $i; ?>"><?php echo "$row[0]".".".$i; ?></td>
                        <td>
                        <div class="form-group">
                        <input type="text" class="form-control" name="Co<?php echo $i; ?>_description" id="CO<?php echo $i; ?>_D" placeholder="CO<?php echo $i; ?> description" pattern="[A-Za-\s,z]+" title="Enter CO1 description" value="<?php echo $row[1]; ?>"  required>
                        </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input type="text" class="form-control" name="co<?php echo $i; ?>_f" placeholder="" title="Enter the rate">
                        </div>
                        </td>
                        </tr>
                        <?php  $i++; } ?>
                    </tbody>
                </table> 
                </div>         
            </div>
        </div>
        <div class="container">
        <div class="row">
            <div class="col-md-2">
                <input type="submit" class="btn btn-success">
            </div>
        </div>
      </div>
      <span style="display:none" id="courseNamehide"><?php echo $courseName; ?></span> 
<?php 
}
else{
    echo '<div class="container">
    <div class="row">
        <div class="co-md-8">
                <p>CourseCode :'.$coursecode.' has no entry in articulation.  </p>
                <p>first enter data in articulation.</p>
        </div> 
    </div>
</div>';
echo '<span style="display:none" id="courseNamehide"></span> ';
}
?>
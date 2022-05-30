<?php
include('../common/connection.php');
// print_r($_POST); exit();
if (isset($_POST['Submitbtn'])) {

    $regulation=$_POST['regulation'];
    $academicYear=$_POST['academicYear'];
    $branch=$_POST['branch'];
    $semesterNo=$_POST['semesterNo'];
    $CourseCode=$_POST['CourseCode'];
    $CourseName=$_POST['CourseName'];
    $courseType=explode("%",$_POST['coursetype']);
    $csid=$courseType[1];
    $courseType=$courseType[0];
    $fname =explode("%",$_POST['Fname']);
    $fid=$fname[1];
    $fname=$fname[0];
    // echo "$regulation   $academicYear   $branch  $semesterNo   $CourseCode   $CourseName  $courseType  $csid  $fid   $fname"; exit();
    if (!empty($regulation) and !empty($academicYear) and !empty($branch) and !empty($semesterNo) and !empty($CourseCode)
        and !empty($courseType) and !empty($fname) and !empty($CourseName)) {
            // echo "demo"; exit();
        $check_select="select coid from coursedetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and courseCode='$CourseCode' and csid<>'' and fid<>'' ";
        $cres=mysqli_query($con,$check_select) or die(mysqli_error($con));
        if(mysqli_num_rows($cres)>=1){
            header('location:../ui-features/mappingfandc.php?insert=alreadyexist');
        } else{
            // $insert_query="insert into coursedetails(regulation,academicYear,courseCode,branch,semesterNo,courseName,courseType,csid,fid) values('$regulation','$academicYear','$CourseCode','$branch',$semesterNo,'$CourseName','$courseType',$csid,$fid)";
            $update_query="update coursedetails set courseType='$courseType',csid=$csid,fid=$fid where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and courseCode='$CourseCode' ";
            if(mysqli_query($con,$update_query) or die(mysqli_error($con))){
                header("location:../ui-features/mappingfandc.php?insert=success");
            }
            else{
                header("location:../ui-features/mappingfandc.php?insert=error");
            }
          }
            // $tsql = "select coid,courseName from coursedetails where courseCode like '$CourseCode'";
            // $result=mysqli_query($con,$tsql);
            // $row = mysqli_fetch_assoc($result);
            // $x = $row['courseName'];
            // $y = $row['coid'];

            // $tsql2 = "select fid from facultydetails where fname like '$fname'";
            // $result2 = mysqli_query($con,$tsql2);
            // $row2 = mysqli_fetch_assoc($result2);
            // $z = $row2['fid'];

            // $sql = "insert into mappingfc values($z,$y,'$x','$CourseCode','$courseType','$fname','$branch',$semesterNo,'$academicYear','$regulation')";
            // if(mysqli_query($con,$sql)) {
            // }
            // else {
            // }
    }
    else {
        header("location:../ui-features/mappingfandc.php?insert=error");
    }

}

if (isset($_POST['Submitbtn2'])) {
    $sql = "SELECT d.fid,fname,courseCode,courseName,branch,semesterNo,academicYear,regulation from coursedetails d,faculty f where d.fid=f.fid ";
    $res = mysqli_query($con,$sql);
    $tablevar = '';
    if (mysqli_num_rows($res) > 0) {
        $tablevar = "<table><tr><th>Faculty ID</th><th>Faculty Name</th><th>Course Code</th><th>Course Name</th><th>Branch</th><th>Semester</th><th>Academic Year</th><th>Regulation</th></tr>";

        while($row = $res->fetch_assoc()) {
            $a1 = $row['fid'];
            $a2 = $row['fname'];
            $a3 = $row['coursecode'];
            $a4 = $row['cname'];
            $a5 = $row['department'];
            $a6 = $row['semester'];
            $a7 = $row['academic_year'];
            $a8 = $row['regulation'];
            $tablevar = $tablevar."<tr><td>$a1</td><td><a href='#' style='color:purple;'>$a2</a></td><td>$a3</td><td>$a4</td><td>$a5</td><td>$a6</td><td>$a7</td><td>$a8</td></tr>";
        }
        
        $tablevar = $tablevar."</table>";

        include_once("../ui-features/mappingfandc.php");
    }
    else {
        header("location:../ui-features/mappingfandc.php?insert=error");
    }
}


?>
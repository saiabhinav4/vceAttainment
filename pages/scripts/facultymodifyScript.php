<?php 

require "../common/connection.php";
// print_r($_POST);exit();
$type=$facultyId=$facultyName=$department=$password=$designation=null;
$fid=null;
if(isset($_SESSION['department']) and !empty($_SESSION['department'])){
    $department=$_SESSION['department']; 
}
else{
 header('location:../ui-features/faculty.php');
}

if(isset($_POST) and !empty($_POST)){
    if(isset($_POST['type']) ){
        $type=$_POST['type'];
        if($type==0){
            if(isset($_POST['fid']) and !empty($_POST['fid'])){
                  $check_count="SELECT coid from coursedetails where fid=?";
                  $stmt=$con->prepare($check_count);
                  $stmt->bind_param("i", $_POST['fid']);
                  $stmt->execute();
                  $result=$stmt->get_result();
                  if($result->num_rows==0){
                        $delete="delete from password where fid=?";
                        $stmt=$con->prepare($delete);
                        $stmt->bind_param("i", $_POST['fid']);
                        $stmt->execute();
                        $result=$stmt->get_result();
                        $delete_f="delete from faculty where fid=?";
                        $stmt=$con->prepare($delete_f);
                        $stmt->bind_param("i", $_POST['fid']);
                        $stmt->execute();
                        $result=$stmt->get_result();
                        echo "<p>Successfully deleted!</p>";

                  }  
                  else{
                      echo '<p>These Faculty has one or more courses mapped <br> re-mapp these courses to another faculty then delete. </p>';
                  }
            }
            else{
                echo "<p> invalid fid, retry again! </p>";
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
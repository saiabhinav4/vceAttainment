<?php

  require('../common/connection.php');

  if (isset($_POST['loginbtn'])) {

    $uname = $_POST['user'];
    $pwd =md5($_POST['pwd']);

    // $sql="SELECT fid,isspecial from password where  username = '$uname' and password = '$pwd'";
    $sql = "select p.fid,fname,isspecial,department from password p,faculty f  where p.fid=f.fid and username = '$uname' and password = '$pwd'";

    $result=mysqli_query($con,$sql) or die(mysqli_error($con));
    if(mysqli_num_rows($result) == 1) {
      $row=mysqli_fetch_row($result);
      $_SESSION['fid']=$row[0];

      $_SESSION['name']=$row[1];
      $_SESSION['department']=$row[3];
      // print_r($_SESSION); exit();
      if ($row[2] == 1) {
        header("location:../../admin.php");
      }
      else if ($row[2] == 0) {
        header("location:../ui-features/faculty.php");
      }
      else if($row[2]==2){
        header('location:../../GlobalAdmin.php');
      }
    }
    else {
      // echo"<script>alert('Invalid details');</script>";
      header("location:../../index.php?err=invalid");
    }
  }
?>
<?php
require "../common/connection.php";
if(isset($_SESSION['fid']) and !empty($_SESSION['fid'])){
    $branch=$_SESSION['department'];
}
else{
header('location:../../index.php');
}


function get_semester($sno){
    if($sno==1){
        return "I";
    }
    else if($sno==2){
        return "II";
    }
    else if($sno==3){
        return "III";
    }
    else if($sno==4){
        return "IV";
    }
    else if($sno==5){
        return "V";
    }
    else if($sno==6){
        return "VI";
    }
    else if($sno==7){
        return "VII";
    }
    else if($sno==8){
        return "VIII";
    }
}
$regulation=$academicYear=$branch=$semesterno=$courseType=$courseCode=$courseName=$csid=$isdefault=null;
if( isset($_GET['id']) and !empty($_GET['id'])  ){
    $coid=$_GET['id'];
    $select_query="select regulation,academicYear,courseCode,branch,semesterNo,courseName,courseType,csid from coursedetails where coid=?";
    $stmt=$con->prepare($select_query);
    $stmt->bind_param("i", $coid);
    $stmt->execute();
    if($result=$stmt->get_result()){
        // $row=mysqli_fetch_row($res);
        $row=$result->fetch_row();
        $regulation=$row[0];
        $branch=$row[3];
        $academicYear=$row[1];
        $semesterno=$row[4];
        $courseCode=$row[2];
        $courseName=$row[5];
        $courseType=$row[6];
        $csid=$row[7]; 
        $select_query1="select csid,courseType,ishaveinternal,ishaveexternal,ishaveaat,ishaverubrics,isdefault from coursestructure1 where csid=?";
        $stmt=$con->prepare($select_query1);
        $stmt->bind_param("i", $csid);
        $stmt->execute();
        $result=$stmt->get_result();
        $row=$result->fetch_row();
        // $result=mysqli_query($con,$select_query1) or die(mysqli_error($con));
        // $row=mysqli_fetch_array($result);
        $ishaverubric=$row[5];
        $isdefault=$row[6];
    }
    else{
    header('location:faculty.php'); 
    }
    

}
else{
    header('location:faculty.php');
}

?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>Course Details </title>
    <!-- plugins:css -->
    <!-- <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    /> -->
    <link
      rel="stylesheet"
      href="../../vendors/ti-icons/css/themify-icons.css"
    />
    <!-- <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css" /> -->
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
 
 
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/css/bootstrap-select.min.css">



    <style>
      .main-panel{
        width: 100% !important;
      }
       #loader {
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../images/Hourglass.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }
        /* .custome{
            margin-top: 1rem;         
        }
        .custome1{
          margin-left: 1.2rem;
        } */
        td{
          padding-top: 1rem !important;
          height:4rem;
          padding-bottom: 0 !important ;
        }
        /* .dropdown-menu{
        position: relative !important;
    } */
    </style>
  </head>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include "../common/header1.php"; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php // include "../common/sidenav1.php"; ?>

        <!-- partial -->
        <div class="main-panel"  >
        <form
             method="post"
            action="../scripts/articulationScript1.php"
                          >
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Course Details</h4>
                          <!-- <p class="card-description">
                            Enter the facullty details to create an account
                          </p> -->
                         
                          <div class="row">
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputUsername1"
                                  >Regulation</label
                                >
                                <select
                                  name="regulation"
                                  id="reg"
                                  class="form-control"
                                >
                                <option value="<?php echo $regulation;?>"><?php echo $regulation;  ?></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputUsername1">Batch</label>
                                <select
                                  name="academicYear"
                                  id="acad"
                                  class="form-control"
                                >
                                <option value="<?php echo $academicYear; ?>"><?php echo $academicYear;  ?></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="exampleInputUsername1"
                                  >Branch</label
                                >
                                <select
                                  name="branch"
                                  id="bran"
                                  class="form-control"
                                >
                                <option value="<?php echo $branch; ?>"><?php  echo get_department($branch);   ?></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputUsername1"
                                  >Semester</label
                                >
                                <select
                                  name="semesterNo"
                                  id="semester"
                                  class="form-control"
                                >
                                <option value="<?php echo $semesterno; ?>"><?php echo get_semester($semesterno);  ?></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Course Name</label
                                >
                                <input
                                  type="text"
                                  name="CourseName"
                                  class="form-control"
                                  placeholder="Ex:Programming in python"
                                  value="<?php echo $courseName; ?>"
                                  title="Enter course name"
                                  required
                                />
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Course Type</label
                                >
                                <select
                                  name="courseType"
                                  class="form-control"
                                  id="CT"
                                >
                                <option value="<?php  echo $courseType ?>"><?php  echo $courseType ?></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Course Code</label
                                >
                                <input
                                  type="text"
                                  class="form-control"
                                  name="CourseCode"
                                  id="CCode"
                                  placeholder="ex:A6521"
                                  value="<?php echo $courseCode; ?>"
                                  title="start with A then followed by digits with length 4"
                                  pattern="[A][0-9]{4}"
                                  required
                                />
                              </div>
                            </div>

                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >No of CO's</label
                                >
                                <input
                                  type="number"
                                  class="form-control"
                                  name="no_of_COs"
                                  id="noOfCos"
                                  placeholder="ex:5"
                                  title="enter number of course Outcomes"
                                />
                              </div>
                            </div>
                            <div class="col-md-2" id="NOR">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >No of Rubrics</label
                                >
                                <input
                                  type="number"
                                  class="form-control"
                                  name="no_of_rubrics"
                                  id="noOfRubrics"
                                  placeholder="ex:5"
                                  title="enter number of Rubrics"
                                />
                              </div>
                            </div>
                            <input type="hidden" name="ishaverubrics" value="<?php echo $ishaverubric; ?>" />
                            <input type="hidden" name="isdefault" value="<?php echo $isdefault; ?>" />
                            <input type="hidden" name="coid" value="<?php echo $_GET['id']; ?>" />
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <a class="btn btn-xs btn-primary" id="Artbtn"
                                  >Generate Articulation Martrix</a
                                >
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Articulation Matrix:</h4>
                    <!-- <p class="card-description">
                      Add class <code>.table-bordered</code>
                    </p> -->
                    <div id="loader" style="display: none; height: 300px"></div>
                    <div id="examp" class="response"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>

  </form>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
         <?php include '../common/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>



    
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <?php  if(isset($_GET['error'])){  ?>
        <h4 class="modal-title" id="exampleModalLabel" ><span style="color:red;">Error Message</span></h4>
        <?php } else if(isset($_GET['msg'])){ ?>
            <h4 class="modal-title" id="exampleModalLabel"><span style="color:green;">Success Message</span></h4>
        <?php } ?>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <?php  if(isset($_GET['error'])){
                if($_GET['error']=="map_cos_pos"){
                    echo "<p>Atleast Map one courseOutcoms to ProgramOutcomes</p>";
                }
                else if($_GET['error']=="co_description"){
                    echo "<p>Enter ALL 5 course description</p>";
                }
                else if($_GET['error']=="coursename"){
                    echo "<p>Enter valid coursename </p>";
                } 
                else if($_GET['error']=="coursecode"){
                    echo "<p>Enter valid coursecode </p>";
                }
                else if($_GET['error']=="noofrubrics"){
                    echo "<p>Enter valid noofrubrics value </p>";
                }
                else if($_GET['error']=="semesterno"){
                    echo "<p>Enter valid semesterno </p>";
                }   
                else if($_GET['error']=="branch"){
                    echo "<p>Enter valid branch </p>";
                } 
                else if($_GET['error']=="noofcos"){
                    echo "<p>Enter valid no of cos value </p>";
                }
                else if($_GET['error']=="acadamicyear"){
                    echo "<p>Enter valid acadamicyear </p>";
                } 
                else if($_GET['error']=="regulation"){
                    echo "<p>Enter valid regulation </p>";
                } 
                else if($_GET['error']=="courseType"){
                    echo "<p>Enter valid courseType </p>";
                } 
                else if($_GET['error']=="nopost"){
                    echo "<p>Something went wrong , Plz re-enter the data again </p>";
                } 
                else if($_GET['error']=="alreadyentered"){
                    echo "<p>Given data already exist  </p>";
                }
                else if($_GET['error']=="rubric_desc"){
                    echo "<p> rubric data is incomplete, re-enter the data again </p>";
                } 
                else if($_GET['error']=="reenter"){
                    echo "<p>something went wrong plz re-enter the data again</p>";
                } 

           }
           else if(isset($_GET['msg'])){
               echo "<p>Succesfully inserted data</p>";
           }        
               ?>
      </div>
    </div>
  </div>
</div>
    



    
 
    <!-- container-scroller -->
    <!-- plugins:js -->
      
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> 
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>  -->
  
    <script>
      // $(document).ready(function () {
      //   $("#facultyTable").DataTable();
      // });
      
    </script>
    <?php 
    if(isset($_GET['error']) or isset($_GET['msg'])){ ?>
     <!-- <script> $('#exampleModal').modal('show'); </script> -->
     <script>
      var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
                document.onreadystatechange = function () {
                myModal.show();
        };
     </script>
   <?php } ?>

   <script>

      // $('#courseList').addClass('active');
      // $('#Sett').removeClass('active');
      // $('template').removeClass('active');

       <?php if($ishaverubric=="0"){ ?>
        $('#NOR').hide();
      <?php } 
        if($isdefault!=0){ ?>
        $('#NOR').hide();
    <?php    }
      ?>
$("#Artbtn").click(function(e){
    var cc=document.getElementById('CCode');
    var noofCo=document.getElementById('noOfCos');
    var regulation=document.getElementById('reg');
    var noofr=document.getElementById('noOfRubrics');
    var isdefault=`<?php echo $isdefault; ?>`;
    // var noofpos=document.getElementById('noOfPOs');
    // var noofpsos=document.getElementById('noOfPSOs');
    var type=document.getElementById('CT');
        // console.log(typeof noofr,noofr.value);
    var check=false;
    var rcheck=false;
    <?php
        if( $isdefault=="0"){   ?>
            check=true;
    <?php   } ?>
    <?php
        if( $ishaverubric=="1"){   ?>
            rcheck=true;
    <?php   } ?>
          console.log(`${regulation.value}  ${cc.value}  ${noofCo.value} ${type.value} ${check}  ${noofr.value}  ${rcheck}`);  
        if( regulation.value!="" && cc.value!="" && noofCo.value!="" &&  type.value!="" && ( !rcheck || ( (check && noofr.value!="") || (!check) ) )   ){

    //    $("#changeDynamic").load("tableCos.php",{no_of_COs:noofCo.value,courseCode:cc.value,regulation:regulation.value,no_on_R:noofr.value});

                $.ajax({
                      url:'../scripts/tableCos.php',
                      type:'post',
                      data:{no_of_COs:noofCo.value,courseCode:cc.value,regulation:regulation.value,no_of_R:noofr.value,ishavedefault:isdefault},
                      beforeSend: function(){
                        $('.response').empty();  
                        $("#loader").show();
                        },
                        success: function(response){
                        $('.response').empty();
                        $('.response').append(response);
                        $('.selectpick').selectpicker();
                        },
                        complete:function(data){
                        $("#loader").hide();
                        } 
                        });

        }
        else{
            noofCo.value="";
            alert("enter NO Of COs and/or  NO Of Rubrics to change the table dynamic");
        } 
    });


</script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script> -->

<script src="../../js/jquery.cookie.js" type="text/javascript"></script>

    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <!-- endinject -->
    
  </body>
</html>

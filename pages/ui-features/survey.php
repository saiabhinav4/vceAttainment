<?php require '../common/connection.php';
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
$regulation=$academicYear=$branch=$semesterno=$courseType=$courseCode=$courseName=$csid=null;
if( isset($_GET['id']) and !empty($_GET['id'])  ){
    $coid=$_GET['id'];
    $select_query="select regulation,academicYear,courseCode,branch,semesterNo,courseName,courseType,csid from coursedetails where coid=?";
    $stmt=$con->prepare($select_query);
    $stmt->bind_param("i",$coid);
    $stmt->execute();
    if($res=$stmt->get_result()){
        // $row=mysqli_fetch_row($res);
        $row=$res->fetch_row();
        $regulation=$row[0];
        $branch=$row[3];
        $academicYear=$row[1];
        $semesterno=$row[4];
        $courseCode=$row[2];
        $courseName=$row[5];
        $courseType=$row[6];
        $csid=$row[7]; 

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
    <title>Indirect CO Assessment</title>
    <!-- plugins:css -->
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    />
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
        .apply-bg{
          background-color:#c6d9f1;
          padding:1rem 0rem;
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
        <?php //include "../common/sidenav1.php"; ?>

        <!-- partial -->
        <div class="main-panel">
        <form
        action="../scripts/surveyScript.php" method="POST"
                          >
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Student Feedback (Indirect Assessment)</h4>
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
                                  id="sem"
                                  class="form-control"
                                >
                                <option value="<?php echo $semesterno; ?>"><?php echo get_semester($semesterno);  ?></option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Course Code</label
                                >
                                <input
                                  type="text"
                                  name="CourseCode"
                                  id="CCode"
                                  class="form-control"
                                  placeholder="ex:A6521"
                                  value="<?php echo $courseCode; ?>"
                                  title="start with A then followed by digits with length 4"
                                  pattern="[A][0-9]{4}"
                                />
                              </div>
                            </div>
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Course Name</label
                                >
                                <input
                                  type="text"
                                  name="CourseName"
                                  id="CName"
                                  class="form-control"
                                  placeholder="Ex:Programming in python"
                                  value="<?php echo $courseName; ?>"
                                  title="Enter the Course Name"
                                  
                                />
                              </div>
                            </div>
                           
                            
                            <input type="hidden" name="coid" value="<?php echo $_GET['id'];  ?>">
                           
                          </div>
                          <div class="row">
                          <div id="dychange">
        <div class="container">
            <div class="row">
            <div>
                <table class="table table-bordered" style="width:800px;">
                    <thead>
                      <tr class="table-info">
                        <th class="changeCO">Course Outcomes</th>
                        <th>Course Description</th>
                        <th class="changeTd">Feedback</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr class="table-info2">
                        <td id="t_co1">CO1</td>
                        <td>
                        <div class="form-group">
                        <input type="text" class="form-control" name="Co1_description" id="CO1_D" placeholder="CO1 description" pattern="[A-Za-\s,z]+" title="Enter CO1 description" required>
                        </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input type="number" class="form-control" name="co1_f" placeholder="" title="Enter the rate">
                        </div>
                        </td>
                        </tr>
                        <tr class="table-info2">
                        <td id="t_co2">CO2</td>
                        <td>
                        <div class="form-group">
                        <input type="text" class="form-control" name="Co2_description" id="CO2_D" placeholder="CO2 description" pattern="[A-Za-\s,z]+" title="Enter CO2 description" required>
                        </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input type="number" class="form-control" name="co2_f" placeholder="" title="Enter the rate">
                        </div>
                        </td>
                        </tr>
                        <tr class="table-info2">
                        <td id="t_co3">CO3</td>
                        <td>
                        <div class="form-group">
                        <input type="text" class="form-control" name="Co3_description" placeholder="CO3 description" id="CO3_D" pattern="[A-Za-\s,z]+" title="Enter CO3 description" required>
                        </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input type="number" class="form-control" name="co3_f" placeholder="" title="Enter the rate">
                        </div>
                        </td>
                        </tr>
                        <tr class="table-info2">
                        <td id="t_co4">CO4</td>
                        <td>
                        <div class="form-group">
                        <input type="text" class="form-control" name="Co4_description" placeholder="CO4 description" id="CO4_D" pattern="[A-Za-\s,z]+" title="Enter CO4 description" required>
                        </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input type="number" class="form-control" name="co4_f" placeholder="" title="Enter the rate">
                        </div>
                        </td>
                        </tr>
                        <tr class="table-info2">
                        <td id="t_co5">CO5</td>
                        <td>
                        <div class="form-group">
                        <input type="text" class="form-control" name="Co5_description" placeholder="CO5 description" id="CO5_D" pattern="[A-Za-\s,z]+" title="Enter CO5 description" required>
                        </div>
                        </td>
                        <td>
                        <div class="form-group">
                            <input type="number" class="form-control" name="co5_f" placeholder="" title="Enter the rate">
                        </div>
                        </td>
                        </tr>
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
    </div> 

                          </div>
                        </div>
                      </div>
                    </div>
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
                if($_GET['error']=="enter_CO_f_all"){
                    echo "<p>Enter ALL Course feedback fields</p>";
                }
                else  if($_GET['error']=="enter_ar_first"){
                    echo "<p>Enter the course details first</p>";
                }
                else if($_GET['error']=="coursename"){
                    echo "<p>Enter valid coursename </p>";
                } 
                else if($_GET['error']=="coursecode"){
                    echo "<p>Enter valid coursecode </p>";
                }
                else if($_GET['error']=="semesterno"){
                    echo "<p>Enter valid semesterno </p>";
                }   
                else if($_GET['error']=="branch"){
                    echo "<p>Enter valid branch </p>";
                } 
                else if($_GET['error']=="academicyear"){
                    echo "<p>Enter valid acadamicyear </p>";
                } 
                else if($_GET['error']=="regulation"){
                    echo "<p>Enter valid regulation </p>";
                } 
                else if($_GET['error']=="alreadyExist"){
                    echo "<p>Given data already exist  </p>";
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



    

    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
           
    

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
    //    $('#CCode').on('input',function(e){
        var regulation=document.getElementById('reg');
               var academicYear=document.getElementById('acad');
               var branch=document.getElementById('bran');
               var semester=document.getElementById('sem');
               var coursecode=document.getElementById('CCode');
               var courseName=document.getElementById('CName');
                var co1Description=document.getElementById('CO1_D');
                var co2Description=document.getElementById('CO2_D');
                var co3Description=document.getElementById('CO3_D');
                var co4Description=document.getElementById('CO4_D');
                var co5Description=document.getElementById('CO5_D');
                var tco1=document.getElementById('t_co1');
                var tco2=document.getElementById('t_co2');
                var tco3=document.getElementById('t_co3');
                var tco4=document.getElementById('t_co4');
                var tco5=document.getElementById('t_co5');
                const descriptions=[co1Description,co2Description,co3Description,co4Description,co5Description];
                const t_cos=[tco1,tco2,tco3,tco4,tco5];
                if((regulation.value!="") && (branch.value!="") && (semester.value!="") && (academicYear.value!="") && (/[A][0-9]{4}/.test(coursecode.value))){
                $('#dychange').load('../scripts/checkScript.php',{regulation:regulation.value,academicYear:academicYear.value,branch:branch.value,semester:semester.value,coursecode:coursecode.value},
                function(data,status,xhr){
                    var tdemp=document.getElementById('courseNamehide');
                    if(tdemp.textContent!=""){
                        courseName.value=tdemp.textContent;
                    }
                }
                );
                }
                else{
                    coursecode.value=""; 
                   alert("Enter first Regulation,Academic Year,Branch,Semester No. then CourseCode"); 
                }
            
    //    });
    </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script> -->
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script> -->

    <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script> -->

    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <!-- endinject -->
    
  </body>
</html>





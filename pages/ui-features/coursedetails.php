<?php
require '../common/connection.php';
if(isset($_SESSION['fid']) and !empty($_SESSION['fid'])){
    $branch=$_SESSION['department'];
}
else{
header('location:../../index.php');
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
    <title>Course Details</title>
    <!-- plugins:css -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    />
    <link
      rel="stylesheet"
      href="../../vendors/ti-icons/css/themify-icons.css"
    />
    <link rel="stylesheet" href="../../vendors/base/vendor.bundle.base.css" />
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../../css/style.css" />
    <!-- endinject -->
    <link rel="shortcut icon" href="../../images/favicon.png" />
    <!-- <script src="../../js/dynamicbatch.js" async></script> -->
    <style>
      .branch-heading{
        color:#000;
      }
    </style>
  </head>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include "../common/header.php"; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
          <?php include "../common/sidenav.php"; ?>

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Course Details</h4>
                          <p class="card-description">
                            Enter the all course details for a semester
                          </p>
                          <form class="forms-sample">
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
                                    <option value="">--SELECT--</option>
                                    <!-- <option value="R-20">R-20</option>
                                    <option value="R-19">R-19</option>
                                    <option value="R-18">R-18</option>
                                    <option value="R-15">R-15</option> -->
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Batch</label
                                  >
                                  <select
                                    name="academicYear"
                                    id="acad"
                                    class="form-control"
                                  >
                                    <option value="">--SELECT--</option>
                                    <!-- <option value="2015-2019">2015-2019</option>
                                    <option value="2016-2020">2016-2020</option>
                                    <option value="2017-2021">2017-2021</option>
                                    <option value="2018-2022">2018-2022</option>
                                    <option value="2019-2023">2019-2023</option>
                                    <option value="2020-2024">2020-2024</option> -->
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
                                    <option value="">--SELECT--</option>
                                    <!-- <option value="IT">
                                      Information Technology
                                    </option>
                                    <option value="CSE">
                                      Computer Science And Engineering
                                    </option>
                                    <option value="ECE">
                                      Electronics and Communication Engineering
                                    </option>
                                    <option value="EEE">
                                      Electrical and Electronics Engineering
                                    </option>
                                    <option value="MECH">
                                      Mechanical Engineering
                                    </option>
                                    <option value="CIVIL">
                                      Civil Engineerring
                                    </option> -->
                                    <?php  
                                $select_branch="SELECT dname,sname from department";
                                $result=mysqli_query($con,$select_branch) or die(mysqli_error($con));
                                while($row=mysqli_fetch_row($result)){ ?>
                            <option value="<?php echo $row[0]; ?>"><?php  echo $row[1];   ?></option>
                        <?php   }
                            ?>
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
                                    id="seme"
                                    class="form-control"
                                  >
                                    <option value="">--SELECT--</option>
                                    <option value="1">I</option>
                                    <option value="2">II</option>
                                    <option value="3">III</option>
                                    <option value="4">IV</option>
                                    <option value="5">V</option>
                                    <option value="6">VI</option>
                                    <option value="7">VII</option>
                                    <option value="8">VIII</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1"
                                    >CourseCode</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="CourseCode"
                                    id="CCode"
                                    placeholder="ex:A6521"
                                    title="start with A then followed by digits with length 4"
                                    pattern="[A][0-9]{4}"
                                  />
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputPassword1"
                                    >CourseCode</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="CourseName"
                                    id="CName"
                                    placeholder="Programming in Java"
                                    title="Enter course name"
                                  />
                                </div>
                              </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="col-md-6">
                              </div> -->
                            <div class="row">
                              <div class="col-md-6">
                                <a
                                  id="Submitbtn-c"
                                  value="Insert"
                                  class="btn btn-primary me-2"
                                >
                                  Submit
                                </a>
                                <a
                                  class="btn btn-success"
                                  value="check"
                                  id="Submitbtn-ch"
                                  >Display Courses</a
                                >
                              </div>
                            </div>
                            <!-- </div> -->
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 grid-margin stretch-card">                 
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Result</h4>
                    <div id="loader" style="display:none;height:300px;"></div>
                        <div id="examp" class="response">
                    <!-- <h4></h4> -->
                        </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <?php include '../common/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
      // $(document).ready(function () {
      //   $("#coursesTable").DataTable();
      // });

      $('#attainments').removeClass('active');
      $('#Mcourses').addClass('active');
      $('#Mfaculty').removeClass('active');
      $('#Mweights').removeClass('active');
      $('#Ipoassessment').removeClass('active');
      $('#Regulation').removeClass('active');


      var regulation=document.getElementById('reg');
       var academicYear=document.getElementById('acad');
       var branch=document.getElementById('bran');
       var semesterNo=document.getElementById('seme');
       var courseCode=document.getElementById('CCode');
       var courseName=document.getElementById('CName');

       let regulationArray=[];
       let batchArray=[]; 
       function get_Batch(){
                $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:3},
                      beforeSend: function(){
                        },
                        success: function(response){
                         if("msg" in response){
                           regulationArray= Object.keys(response.msg);
                           batchArray=response.msg;
                           console.log(regulationArray);
                           console.log(batchArray);
                           let res=`<option value="">--SELECT--</option>`;
                           regulationArray.forEach((r)=>{
                             res+=`<option value="${r}">${r}</option>`;
                           });
                           regulation.innerHTML=res;

                         } 
                         else if("error" in response){
                              res=response.error;
                              
                         }
                        },
                        complete:function(data){
                        } 
                  });
     }
     get_Batch();
     
     $('#reg').change(function(e){
          let r=this.value;
          let res=``;
          if(regulationArray.includes(r)){
            res+=`<option value="">--SELECT--</option>`;
            batchArray[r].forEach((ele)=>{
              res+=`<option value="${ele}" >${ele}</option>`; 
            });
          }
          else{
              res+=`<option value="">Not Yet Entered</option>`;
          }
          academicYear.innerHTML=res;
     });



       $('#Submitbtn-c').click(function(){
               
             if(regulation.value!="" && academicYear.value!="" && branch.value!="" && semesterNo.value!="" && courseCode.value!="" && courseName.value!=""){
                $.ajax({
                      url:'../scripts/coursedetailsScript.php',
                      type:'post',
                      data:{courseCode:courseCode.value,regulation:regulation.value,academicYear:academicYear.value,branch:branch.value,semesterNo:semesterNo.value,courseName:courseName.value,type:1},
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
                        courseCode.value="";
                        courseName.value="";
                        } 
                        });
             }
             else{
                alert('Enter all fields properly');
             }    

       });

       $('#Submitbtn-ch').click(function(){
               
               if(regulation.value!="" && academicYear.value!="" && branch.value!="" && semesterNo.value!="" ){
                  $.ajax({
                        url:'../scripts/coursedetailsScript.php',
                        type:'post',
                        data:{courseCode:courseCode.value,regulation:regulation.value,academicYear:academicYear.value,branch:branch.value,semesterNo:semesterNo.value,courseName:courseName.value,type:0},
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
               }
               else{
                  alert('Enter regulation, academicYear,branch,SemesterNo properly to check');
               }    
               
         });

         






    </script>
    <!-- <script src="../../vendors/base/vendor.bundle.base.js"></script> -->
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>

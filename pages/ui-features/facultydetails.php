<?php
    require "../common/connection.php";
    if(isset($_SESSION['department']) and !empty($_SESSION['department'])){
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
    <title>Faculty Details</title>
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
    <style>
      .apply-scrollbar{
         height:400px;
         overflow: auto;
      }
      .apply-border{
        border-bottom: 1px solid rgba(0, 0, 0,0.2);
        padding: 12px 6px;
      }
      .custom-list{
          margin: 0;
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
        #loader1 {
            /* position: relative;
            left: 0px;
            top: 0px;
            width: 100px;
            height: 200px;
            z-index: 9999;
            background: url('../../images/Hourglass.gif') 50% 50% no-repeat rgb(249, 249, 249); */
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../images/loading1.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }
        .branch-heading{
        color:#000;
      }
    </style>
    <script src="../../js/dynamicbatch.js" async></script>
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
                          <h4 class="card-title">Faculty Details</h4>
                          <p class="card-description">
                            Enter the facullty details to create an account
                          </p>
                          <form class="forms-sample">
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Faculty ID</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="Fid"
                                    id="facId"
                                    placeholder="VCE120"
                                    title="Enter Faculty Id"
                                  />
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Faculty Name</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="FName"
                                    id="facName"
                                    placeholder="Nature"
                                    title="Enter Faculty Name"
                                  />
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputPassword1"
                                    >Designation</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="Fdesignation"
                                    id="FacDes"
                                    placeholder="Assistant Professer"
                                    title="Enter Faculty Designation"
                                  />
                                </div>
                                <div class="form-group">
                                  <label for="exampleInputConfirmPassword1"
                                    >Password</label
                                  >
                                  <input
                                    type="password"
                                    class="form-control"
                                    name="Fpassword"
                                    id="FacPass"
                                    placeholder="Enter Faculty Password"
                                  />
                                </div>
                              </div>

                              <div class="col-md-6">
                                <a id="Insert" class="btn btn-primary me-2">
                                  Submit
                                </a>
                                <a class="btn btn-success" id="getfaculty"
                                  >Display Faculty</a
                                >
                              </div>
                            </div>
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
                    <h4 class="card-title">Faculty List</h4>
                    <div id="loader" style="display:none;height:300px;"></div>
                        <div id="examp" class="response">
                    
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


    
    <div class="modal " id="myModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h4 style="display:inline" class="modal-title" id="exampleModalLabel">Modify Faculty-Course Mapping</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    
      <div class="modal-body">
        <!-- <div class="container"> -->
          <div class="row">
            <h6 id="prevName">Previous Faculty : Demo</h6>
          </div>
            <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Regulation</label
                                  >
                                  <select
                                    name="regulation"
                                    id="reg"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT--</option>
                                    <option value="R-20">R-20</option>
                                    <option value="R-19">R-19</option>
                                    <option value="R-18">R-18</option>
                                    <option value="R-15">R-15</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Batch</label
                                  >
                                  <select
                                    name="academicYear"
                                    id="acad"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT--</option>
                                    <option value="2015-2019">2015-2019</option>
                                    <option value="2016-2020">2016-2020</option>
                                    <option value="2017-2021">2017-2021</option>
                                    <option value="2018-2022">2018-2022</option>
                                    <option value="2019-2023">2019-2023</option>
                                    <option value="2020-2024">2020-2024</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-5">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Branch</label
                                  >
                                  <select
                                    name="branch"
                                    id="bran"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT--</option>
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
            </div>
            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Semester</label
                                  >
                                  <select
                                    name="semesterNo"
                                    id="semester"
                                    class="form-control"
                                    required
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
                              <div class="col-md-6">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Course Name</label
                                  >
                                  <select
                                    name="CourseName"
                                    id="courseN"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT--</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-3">
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
                                  title="start with A then followed by digits with length 4"
                                  pattern="[A][0-9]{4}"
                                  required
                                />
                              </div>
                            </div>
            </div>
            <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Faculty Dept</label
                                  >
                                  <select
                                    name="Fdept"
                                    id="Fdeptid"
                                    class="form-control"
                                    required
                                  >
                                    <!-- <option value="">--SELECT--</option> -->
                                    <?php  
                                $select_branch="SELECT dname,sname from department";
                                $result=mysqli_query($con,$select_branch) or die(mysqli_error($con));
                                while($row=mysqli_fetch_row($result)){ ?>
                            <option value="<?php echo $row[0]; ?>"><?php  echo $row[0];   ?></option>
                        <?php   }
                            ?>
                                  </select>
                                </div>
                              </div>

                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >New Faculty Name</label
                                  >
                                  <select
                                    name="Fname"
                                    id="fnameid"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT--</option>
                                    <?php    
                         $select_faculty="select fid,fname,department,designation,facultyID from faculty where department='$branch' and designation not like '%HOD' ";
                         $res=mysqli_query($con,$select_faculty) or die(mysqli_error($con));
                         while($row=mysqli_fetch_row($res)){
                             echo '<option value="'.$row[1].'%'.$row[0].'">'.$row[1]."-".$row[4].'</option>';
                         }
                        ?>
                                  </select>
                                </div>
                              </div>   
            </div>
            <div class="row">
                  <div class="col-md-2">
                  <a class="btn btn-xs btn-success" value="Insert" id="InsertM" name="Submitbtn">Modify</a>
                  </div>
            </div>
            <div class="row">
            <div id="result-modify">
                  </div>       
            </div>
        <!-- </div> -->
      </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>







  <div class="modal " id="myModal-mapp" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h4 style="display:inline" class="modal-title" id="exampleModalLabel">Faculty-Course Mapping Details</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    
      <div class="modal-body">
        <!-- <div class="container"> -->
          <div class="row">
            <h6 id="prevName1">Faculty : Demo</h6>
          </div>
            <div class="row apply-scrollbar">
            <div id="loader1" style="display: none;"></div>
            <div id="result-modify1">
                         
            </div>       
            </div>
        <!-- </div> -->
      </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>


  
  <div class="modal " id="myModal-password" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
         <h4 style="display:inline" class="modal-title" id="exampleModalLabel">Reset Faculty Password</h4>
         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
    
      <div class="modal-body">
        <!-- <div class="container"> -->
          <div class="row">
            <h6 id="prevName2">Faculty : Demo</h6>
          </div>
          <div class="row">
                <div class="col-md-6">
                <!-- <div class="col-md-4"> -->
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >New Password</label
                                >
                                <input
                                  type="password"
                                  name="password"
                                  id="Npassword"
                                  class="form-control"
                                  placeholder="Enter password"
                                  title="Enter New Password"
                                />
                              </div>
                            <!-- </div> -->
                            <div class="col-md-2">
                                <!-- <h4>&nbsp;</h4> -->
                              <a class="btn btn-xs btn-success" id="modify-password">submit</a>
                            </div>
                </div>
          </div>
          <div class="row">
            <div id="result6">

            </div>
          </div>
            <!-- <div class="row apply-scrollbar">
            <div id="result-modify1">
                         
            </div>       
            </div> -->
        <!-- </div> -->
      </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>







    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>


    <script>

          // $( "#myModal-mapp" ).on('shown', function(){
          //   alert("I want this to appear after the modal has opened!");
          // });


       var dept=`<?php echo $branch; ?>`;

            var courseNameArray=null;
            var regulation=document.getElementById('reg');
            var academicYear=document.getElementById('acad');
            var branch=document.getElementById('bran');
            var semesterNo=document.getElementById('semester');
            var courseName=document.getElementById('courseN');
            var courseCode=document.getElementById('CCode');
            var facDept=document.getElementById('Fdeptid'); 
            var faculty=document.getElementById('fnameid');  
            // var PrefacDept=document.getElementById('FPdeptid'); 
            // var Prefaculty=document.getElementById('fnamePid');   
            setSelectedValue(facDept,dept);

            function setSelectedValue(selectObj, valueToSet) {
                for (var i = 0; i < selectObj.options.length; i++) {
                    if (selectObj.options[i].value== valueToSet) {
                            selectObj.options[i].selected = true;
                            return;
                        }
                }
            }

            $('#modify-password').click(function(){
                 var pname=document.getElementById('prevName2');
                 var password=document.getElementById('Npassword');
                //  console.log(pname.dataset.fid,password.value);
                var fid=pname.dataset.fid;
                var pass=password.value;
                if( fid!="" && pass!=""){
                  $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:8,fid:fid,password:pass},
                      beforeSend: function(){
                            $('#result6').empty();
                        },
                        success: function(response){
                          $('#result6').empty();
                            $('#result6').html(response);
                        },
                        complete:function(data){     
                          
                        } 
                        }); 
                }
                else{
                    alert("retry again, something went wrong");
                }
                 password.value="";

            });

            $('#myModal-password').on('hidden.bs.modal', function () {
                    var display=document.getElementById('result6');
                    display.innerHTML='';
                });

            $('#InsertM').on('click',function(){
              let pfid= $('#prevName').attr('data-fid');
                  if(regulation.value!="" && academicYear.value!="" && branch.value!="" && semesterNo.value!="" && courseName.value!="" && courseCode.value!="" && faculty.value!="" ){
              $.ajax({
                    url:'../scripts/fetchFacultyScript.php',
                    type:'post',
                    data:{check:3,regulation:regulation.value,academicYear:academicYear.value,branch:branch.value,semesterNo:semesterNo.value,courseName:courseName.value,courseCode:courseCode.value,Prefaculty:pfid,Newfaculty:faculty.value},
                    beforeSend: function(){
                    },
                    success: function(response){
                        // console.log(response);
                          if('msg' in response){
                              // alert(`${response['msg']}`);
                              $('#result-modify').html(`${response['msg']}`);
                          }
                          else if('error' in response){
                              // alert(`${response['error']}`);
                              $('#result-modify').html(`${response['error']}`);
                          } 
                          //  alert(response);   
                      },
                    complete:function(data){   
            
                    } 
                  }); 
              }
              else{
                  alert('Enter all Details correctly');
                }   

            });


            $('#Fdeptid').on('change',function(){
                     if(facDept.value!=""){ 
                        $.ajax({
                      url:'../scripts/fetchFacultyScript.php',
                      type:'post',
                      data:{check:1,dept:facDept.value},
                      beforeSend: function(){
                        },
                        success: function(response){
                             if('msg' in response){
                                var tex=`<option value="">${response['msg']}</option>`;
                                faculty.innerHTML=tex;
                             }
                             else if('error' in response){
                                alert(`${response['error']}`);
                             }
                             else{
                                 var tex='<option value="">--SELECT--</option>';
                                  for(let i=0;i<response.length;i++){
                                      var ob=response[i];
                                      tex+=`<option value="${ob['name']+'%'+ob['fid']}">${ob['name']+'-'+ob['id']}</option>`;
                                  }      
                                faculty.innerHTML=tex; 
                             }   
                        //  alert(response);   
                        },
                        complete:function(data){   
                        } 
                        }); 
                     }else{
                        alert('Select Faculty Dept');
                     }   
            });






            $('#CCode').focus(function(){
                if(courseNameArray!=null && courseName.value!=""){
                      courseCode.value=courseNameArray[courseName.value];      
                }
                else{
                    alert('CourseName is empty, refresh and retry ');
                    $('#CCode').blur();
                }
            });


            $('#courseN').focus(function(){
            console.log('inside focus');
            let fid= $('#prevName').attr('data-fid');
            if(regulation.value!="" && academicYear.value!="" && branch.value!="" && semesterNo.value!=""){
                $.post('../scripts/coursedetailsScript.php',{regulation:regulation.value,academicYear:academicYear.value,branch:branch.value,semesterNo:semesterNo.value,Fid:fid,type:3},function(result){
                    console.log(result);
                    courseNameArray=result;
                    courseName.innerHTML="";
                    var opt=document.createElement('option');
                    opt.value="";
                    opt.innerHTML="--SELECT--";
                    courseName.appendChild(opt); 
                    for(var key in result){
                        var opt=document.createElement('option');
                        if(key=="error"){
                            opt.value="";
                            opt.innerHTML=result[key];
                        }
                        else{
                            opt.innerHTML=key;
                            opt.value=key;
                        }
                        courseName.appendChild(opt);
                    }

                });

            }
            else{
                alert('Enter Regulation,AcademicYear,Branch,SemesterNo to retrive Course Name');
                $('#courseN').blur();
            }
        });   

    </script>                     











    <script>
      // $(document).ready(function () {
      //   $("#facultyTable").DataTable();
      // });

      $('#attainments').removeClass('active');
      $('#Mcourses').removeClass('active');
      $('#Mfaculty').addClass('active');
      $('#Mweights').removeClass('active');
      $('#Ipoassessment').removeClass('active');
      $('#Regulation').removeClass('active');


      

      var facultyId=document.getElementById('facId');
        var facultyName=document.getElementById('facName');
        var designation=document.getElementById('FacDes');
        var password=document.getElementById('FacPass');
        var department=`<?php echo $_SESSION['department']; ?>`;
        $('#Insert').click(function(){
            if(facultyId.value!='' && facultyName.value!='' && designation.value!='' && password.value!=''){
                $.ajax({
                      url:'../scripts/facultydetailsScript.php',
                      type:'post',
                      data:{type:0,facultyId:facultyId.value,facultyName:facultyName.value,designation:designation.value,password:password.value,department:department.value},
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
                        facultyId.value="";
                        facultyName.value="";
                        designation.value="";
                        password.value="";
                        } 
                        }); 
            }   
            else{
                alert('Enter all details to insert');
            }
        });

        function getFaculty(){
          $.ajax({
                      url:'../scripts/facultydetailsScript.php',
                      type:'post',
                      data:{type:1},
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
                        facultyId.value="";
                        facultyName.value="";
                        designation.value="";
                        password.value="";
                        } 
                        }); 
        }

        $('#getfaculty').click(getFaculty);
        
        $(document).on('hide.bs.modal','#myModal',function(){
            console.log("out");
            getFaculty();
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

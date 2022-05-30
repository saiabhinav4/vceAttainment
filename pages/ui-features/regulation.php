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
    <title>Regulation & Batch</title>
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
      .badge{
        margin-bottom:3px;
      }
      #disAcad{
        display: flex;
        gap:20px;
      }
      dt{
        /* display: inline-block; */
        margin-bottom: 5px;        
      }
      dd{
        padding-left: 4px;
      }
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
                          <h4 class="card-title">Enter Regulation</h4>
                          <p class="card-description">
                            Add The New Regulation Below
                          </p>
                          <form class="forms-sample">
                            <div class="row">
                              <h6>Existing Regulations</h6>
                              <div id="disR" class="col-md-12">
                                   <h4 class="d-inline"> <span class="badge bg-primary">R-15</span> </h4>
                                   <h4 class="d-inline"> <span class="badge bg-primary">R-18</span> </h4>
                                   <h4 class="d-inline"> <span class="badge bg-primary">R-19</span> </h4>
                                   <h4 class="d-inline"> <span class="badge bg-primary">R-20</span> </h4>
                              </div>
                            </div>
                              <div class="row">
                                <h6>&nbsp;</h6>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Enter Regulation</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="regulation"
                                    id="reg"
                                    placeholder="ex:R-18"
                                    title="Enter Regulation- Start with R- then two digit number"
                                  />
                                </div>
                              </div>
                              <div class="col-md-2">
                                <h4>&nbsp;</h4>
                              <a
                                  class="btn btn-xs btn-success"
                                  value="check"
                                  id="insertReg"
                                  >Insert</a
                                >
                              </div>
                             
                            </div>
                            <div class="row">
                              <div id="result1-reg" class="col-md-12">

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
                    <h4 class="card-title">Enter Batch</h4>
                    <p class="card-description">
                            Add The Batch For Particular Regulation Below
                    </p>
                    <form >
                      <div class="row">
                              <h6>Existing Batch's</h6>
                              <div id="disAcad" class="col-md-12">
                                  <dl>
                                      <dt>R-15</dt>
                                      <dd>2015-2019</dd>
                                      <dd>2016-2020</dd>
                                      <dd>2017-2021</dd>
                                  </dl>
                              </div>
                      </div>
                      <div class="row">
                                <h6>&nbsp;</h6>
                                <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Select Regulation</label
                                  >
                                  <select
                                    name="s-regulation"
                                    id="s-reg"
                                    class="form-control"
                                  >
                                    <option value="">--SELECT--</option>

                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Enter Batch</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="academicYear"
                                    id="acad"
                                    placeholder="ex:2018-2022"
                                    title="Enter AcademicYear"
                                  />
                                </div>
                              </div>
                              <div class="col-md-2">
                                <h4>&nbsp;</h4>
                              <a
                                  class="btn btn-xs btn-success"
                                  value="check"
                                  id="insertAcad"
                                  >Insert</a
                                >
                              </div>
                      </div>
                      <div class="row">
                              <div id="result2-reg" class="col-md-12">

                              </div>
                      </div>   
                    </form>
                  </div>
                </div>
              </div>
              <div class="col-12 grid-margin stretch-card">                 
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Enter Department</h4>
                    <p class="card-description">
                            Add The New Department Below
                    </p>
                    <form >
                      <div class="row">
                              <h6>Existing Departments</h6>
                              <div id="disDept" class="col-md-12">
                                  <dl>
                                      <dt>R-15</dt>
                                      <dd>2015-2019</dd>
                                      <dd>2016-2020</dd>
                                      <dd>2017-2021</dd>
                                  </dl>
                              </div>
                      </div>
                      <div class="row">
                                <h6>&nbsp;</h6>
                                <div class="col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Enter Short Name of Department</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="short_dept"
                                    id="Sdept"
                                    placeholder="ex:IT"
                                    title="Enter short form of department"
                                  />
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Enter Full Name of Department</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="full_dept"
                                    id="Fdept"
                                    placeholder="ex:Information Technology"
                                    title="Enter full form of department"
                                  />
                                </div>
                              </div>
                              <div class="col-md-2">
                                <h4>&nbsp;</h4>
                              <a
                                  class="btn btn-xs btn-success"
                                  value="check"
                                  id="insertDept"
                                  >Insert</a
                                >
                              </div>
                      </div>
                      <div class="row">
                              <div id="result3-dept" class="col-md-12">

                              </div>
                      </div>   
                    </form>
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
      $('#Mcourses').removeClass('active');
      $('#Mfaculty').removeClass('active');
      $('#Mweights').removeClass('active');
      $('#Ipoassessment').removeClass('active');
      $('#Regulation').addClass('active');

      

     function get_Regulation(){
      $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:1},
                      beforeSend: function(){
                        $('#disR').empty();  
                        $('#s-reg').empty();
                        },
                        success: function(response){
                        $('#disR').empty();
                        let res='';
                         if("msg" in response){
                              response.msg.forEach((ele)=>{
                                    res+=`<h4 class="d-inline"> <span class="badge bg-primary">${ele}</span> </h4>`;
                              });
                              let fres=`<option value="">--SELECT--</option>`;
                              response.msg.forEach((ele)=>{
                                  fres+=`<option value="${ele}">${ele}</option>`;
                              });
                              $('#s-reg').html(fres);
                              $('#disR').html(res);
                         } 
                         else if("error" in response){
                              res=response.error;
                              $('#disR').html(res);
                              $('#s-reg').html(fres);
                         }
                          // console.log(response);
                        // $('#disR').append(response);
                        },
                        complete:function(data){
                        } 
                  });
     }
     function get_Batch(){
                $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:3},
                      beforeSend: function(){
                        $('#disAcad').empty();  
                        },
                        success: function(response){
                        $('#disAcad').empty();
                        let res='';
                         if("msg" in response){
                          Object.keys(response.msg).forEach((ele)=>{
                              let temp='';
                              response.msg[ele].forEach((val)=>{
                                  temp+=`<dd>${val}<dd>`;
                              });

                                    res+=`<dl>
                                        <dt>${ele}</dt>
                                        ${temp}
                                    </dl>`;
                              });
                              $('#disAcad').html(res);
                         } 
                         else if("error" in response){
                              res=response.error;
                              $('#disAcad').html(res);
                         }
                        // $('#disAcad').append(response);
                        },
                        complete:function(data){
                        } 
                  });
     }

     function get_department(){
      $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:9},
                      beforeSend: function(){
                        $('#disDept').empty();  
                        },
                        success: function(response){
                          console.log(response);
                        $('#disDept').empty();
                        let res='';
                         if("msg" in response){
                          Object.keys(response.msg).forEach((ele)=>{
                            console.log(ele);
                              res+=`<h4 class="d-inline " > <span class="badge bg-primary">${ele+' - '+response.msg[ele]}</span> </h4>`;
                              
                              });
                              $('#disDept').html(res);

                         } 
                         else if("error" in response){
                              res=response.error;
                              $('#disDept').html(res);
                         }
                        // $('#disAcad').append(response);
                        },
                        complete:function(data){
                        } 
                  });
     }

     get_Regulation();
     get_Batch();
     get_department();
      let regulation=document.getElementById('reg');
     $('#insertReg').click(function(){
       
          if(regulation.value!=""){
            console.log("inside");
            $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:2,regulation:regulation.value},
                      beforeSend: function(){
                        $('#result1-reg').empty();  
                        },
                        success: function(response){
                        $('#result1-reg').empty();
                        $('#result1-reg').html(response);
                          // console.log(response);
                        // $('#disR').append(response);
                        },
                        complete:function(data){
                          get_Regulation();
                        } 
                  });
          } 
          else{
    
              alert('enter new regulation value');
          } 
     });

     let reg=document.getElementById('s-reg');
     let acad=document.getElementById('acad');
     $('#insertAcad').click(function(){
       
       if(reg.value!="" && acad.value!=""){
         $.ajax({
                   url:'../scripts/regulationScript.php',
                   type:'post',
                   data:{type:4,regulation:reg.value,batch:acad.value},
                   beforeSend: function(){
                     $('#result2-reg').empty();  
                     },
                     success: function(response){
                     $('#result2-reg').empty();
                     $('#result2-reg').html(response);
                       // console.log(response);
                     // $('#disR').append(response);
                     },
                     complete:function(data){
                       get_Batch();
                       acad.value="";
                     } 
               });
       } 
       else{
 
           alert('Select regulation value and enter batch');
       } 
  });


      var sname=document.getElementById('Sdept');
      var fname=document.getElementById('Fdept');
    $('#insertDept').click(function(){
        if(sname.value!="" && fname.value!=""){
          $.ajax({
                   url:'../scripts/regulationScript.php',
                   type:'post',
                   data:{type:10,Sname:sname.value,Fname:fname.value},
                   beforeSend: function(){
                     $('#result3-dept').empty();  
                     },
                     success: function(response){
                     $('#result3-dept').empty();
                     $('#result3-dept').html(response);
                       // console.log(response);
                     // $('#disR').append(response);
                     },
                     complete:function(data){
                       get_department();
                       sname.value="";
                       fname.value="";
                     } 
               });
        } 
        else{

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

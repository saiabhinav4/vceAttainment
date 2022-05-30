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
    <title>CO Attainment</title>
    <!-- plugins:css -->
    <!-- <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"
    /> -->
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
      .bg-regulation{
        /* background-color:#43A6C6 !important; */
        background-color:rgb(217, 51, 146) !important;
        color:#fff;
      }
      .bg-batch{
        /* background-color:#67B7D1 !important; */
        background-color:rgb(228, 103, 172) !important;
        color:#fff;
        /* color:aliceblue; */
      }
      .bg-semester{
        /* background-color:#8AC7DB !important; */
        background-color:rgb(237, 154, 200) !important;
        color:#fff;
        /* color:aliceblue; */
      }
      .bg-courses{
        background-color: rgb(248,206,229) !important;
        /* color:#fff; */
      }
      #loader {
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            padding: 2rem 0;
            background: url('../../images/Hourglass.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }

       .loading{
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 80%;
            padding: 2rem 0;
            z-index: 9999;
            background: url('../../images/loading_1.gif') 50% 50% no-repeat rgba(249, 249, 249,0.2);
       } 
       .branch-heading{
        color:#000;
      }
    </style>
    <!-- <script src="../../js/dynamicbatch.js" async></script> -->
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
              <!-- <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Weightages</h4>
                          <p class="card-description">
                            Customize the Weightage Values
                          </p>
                          <form class="forms-sample">
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >CIE Weightage(%)</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="ciew"
                                    id="ciewId"
                                    placeholder="ex:50"
                                    title="Enter CIE Weightage in Percentage"
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >SEE Weightage(%)</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="seew"
                                    id="seeId"
                                    placeholder="ex:50"
                                    title="Enter SEE Weightage in Percentage"
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Target Attainment</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="tatt"
                                    id="ftattId"
                                    placeholder="ex:65"
                                    title="Enter Target Attainment Value "
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Direct CO Weightage (%)</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="dcow"
                                    id="dcoId"
                                    placeholder="ex:90"
                                    title="Enter direct CO Weightage in Percentage"
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Indirect CO Weightage (%)</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="icow"
                                    id="icoId"
                                    placeholder="ex:10"
                                    title="Enter Indirect Weightage in Percentage"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                               <div class="col-md-3">
                                 <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Level-1 Range</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="level1"
                                    id="level1Id"
                                    placeholder="ex:65-70"
                                    title="Enter Level-1 Range"
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Level-2 Range</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="level2"
                                    id="level2Id"
                                    placeholder="ex:70-75"
                                    title="Enter Level-2 Range"
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                 <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Level-3 Range</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="level3"
                                    id="level3Id"
                                    placeholder="ex:75-100"
                                    title="Enter Level-3 Range"
                                  />
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Create Hod Account</h4>
                    <div class="row">
                      <div class="col-md-3">
                      <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Select the Department</label
                                  >
                                  <select
                                    name="department"
                                    id="branch"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT DEPARTMENT--</option>
                                 
                                  </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Enter Password </label
                                  >
                                  <input
                                    type="password"
                                    class="form-control"
                                    name="hodpass"
                                    id="Hpass"
                                    placeholder="Enter Password"
                                    title="Enter The Password of the hod"
                                  />
                                </div>
                        </div>
                        <div class="col-md-2">
                                <h4>&nbsp;</h4>
                              <a
                                  class="btn btn-xs btn-success"
                                  value="check"
                                  id="insertHOD"
                                  >Insert</a
                                >
                              </div>
                        <div class="row">
                        <div class="col-md-12" id="disDept">

                        </div>
                        </div>
                    </div>
                    </div>

                </div>
              </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Assign Hod </h4>
                    <div class="row">
                      <div class="col-md-3">
                      <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Select the Department</label
                                  >
                                  <select
                                    name="department"
                                    id="branch1"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT DEPARTMENT--</option>
                                 
                                  </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                      <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Select the Faculty as HOD</label
                                  >
                                  <select
                                    name="HOD"
                                    id="facltyHOD"
                                    class="form-control"
                                    required
                                  >
                                    <option value="">--SELECT Faculty--</option>
                                 
                                  </select>
                        </div>
                        </div>
                        <div class="col-md-2">
                                <h4>&nbsp;</h4>
                              <a
                                  class="btn btn-xs btn-success"
                                  value="check"
                                  id="insertFHOD"
                                  >Insert</a
                                >
                              </div>
                        <div class="row">
                        <div class="col-md-12" id="disDept1">

                        </div>
                        </div>
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

                       


       var dept=`<?php echo $branch; ?>`;
      // $(document).ready(function () {
      //   $("#facultyTable").DataTable();
      // });
        var branch=document.getElementById('branch');
        var pass=document.getElementById('Hpass');
        $('#insertHOD').click(function(){
            if(branch.value!="" && pass.value!=""){
              $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:11,branch:branch.value,password:pass.value},
                      beforeSend: function(){
                        
                        },
                        success: function(response){
                            // console.log(response);
                            $('#disDept').html(response);
                        },
                        complete:function(data){
                            pass.value="";
                        } 
                  });
            }
            else{
                alert('incomplete data entred!');
            }
        });

      function get_department(){
      $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:9},
                      beforeSend: function(){
                        $('#disDept').empty(); 
                        $('#branch').empty(); 
                        },
                        success: function(response){
                          // console.log(response);
                        $('#disDept').empty();
                        $('#branch').empty();
                        let res=`<option value="">--SELECT DEPARTMENT--</option>`;
                         if("msg" in response){
                          Object.keys(response.msg).forEach((ele)=>{
                            // console.log(ele);
                              res+=`<option value="${ele}">${response.msg[ele]}</option>`;
                              // res+=`<h4 class="d-inline " > <span class="badge bg-primary">${ele+' - '+response.msg[ele]}</span> </h4>`;
                              
                              });
                              $('#branch').html(res);
                              $('#branch1').html(res);

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
     
     get_department();

     var branch_1=document.getElementById('branch1');
     var facultyList=document.getElementById('facltyHOD');
     $('#branch1').on('change',function(){
                  if(branch_1.value!=""){ 
                     $.ajax({
                   url:'../scripts/fetchFacultyScript.php',
                   type:'post',
                   data:{check:1,dept:branch_1.value},
                   beforeSend: function(){
                     },
                     success: function(response){
                      //  console.log(response);
                          if('msg' in response){
                             var tex=`<option value="">${response['msg']}</option>`;
                             facultyList.innerHTML=tex;
                          }
                          else if('error' in response){
                             alert(`${response['error']}`);
                          }
                          else{
                              var tex='<option value="">--SELECT--</option>';
                               for(let i=0;i<response.length;i++){
                                   var ob=response[i];
                                   tex+=`<option value="${ob['id']}">${ob['name']+'-'+ob['id']}</option>`;
                               }      
                             facultyList.innerHTML=tex; 
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

         $('#insertFHOD').click(function(){
          //  console.log("inside1");
                if(branch_1.value!="" && facultyList.value!=""){
                  // console.log('inside');
                  $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:12,branch:branch_1.value,facultyId:facultyList.value},
                      beforeSend: function(){
                          $('#disDept1').empty();
                        },
                        success: function(response){
                            $('#disDept1').html(response);
                        },
                        complete:function(data){
                        } 
                  });
                }
                else{
                  alert('Select Department and Faculty to assign as hod');
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

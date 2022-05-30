<?php
require "../common/connection.php";
$branch="";
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
    <title>Indirect PO Assessment</title>
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

<!-- <script src="../../js/dynamicbatch.js" async></script> -->

    <style>
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
          padding:1rem 1rem;
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
        .branch-heading{
        color:#000;
      }
        /* .dropdown-menu{
        position: relative !important;
    } */
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
        <form
        action="../scripts/indirectpoScript.php" method="POST"
                          >
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">PO Indirect Assessment</h4>
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
                                <label for="exampleInputUsername1">Batch</label>
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
                            
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="exampleInputUsername1"
                                  >Indirect Assessment Type</label
                                >
                                <select class="form-control" name="examType" id="ExamChange">
                                    <option value="">--Enter--</option>
                                    <option value="co_curricular">Co-Curricular Activities</option>
                                    <option value="extra_curricular">Extra-Curricular Activites</option>
                                    <option value="exit_survey">Student Exit Survey</option>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div  id="qexam" class="col-md-3">
                              <div class="form-group">
                                <label id="headercng" for="exampleInputPassword1"
                                  >No of Question</label
                                >
                                <input type="number" class="form-control" name="noofQ" id="part" placeholder="ex:4" title="Enter the number of questions" >
                              </div>
                            </div>     
                          </div>
                          <div class="row">
                                <div id="dyaat" class="container">
                                    <div id="placeoptions" class="row">

                                          </div>  
                                   </div>
                          </div>
                          <div class="row">
                                    <div class="col-md-3"> 
                                    <div class="form-group">
                                        <a class="btn btn-primary" id="pQpbtn">Generate Question Paper</a>    
                                   </div>
                              </div>
                          </div>      
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 grid-margin stretch-card" style="min-width:100px;">
                <div class="card" >
                  <div class="card-body">
                  <div class="card-title">
                    Result:
                  </div>
                      <div class="row">
                        <div class="col-md-12" >
                          <h4></h4>  
                          <div id="loader" style="display:none;height:300px;"></div>
                              <div class="response ">
                              <h4>&nbsp;</h4>
                    <h4>&nbsp;</h4>
                    <h4>&nbsp;</h4>
                    <h4>&nbsp;</h4>
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
                if($_GET['error']=="examType"){
                    echo "<p>Enter valid ExamType</p>";
                }
                else if($_GET['error']=="reenter"){
                    echo "<p>Reenter the data once Again. Something went worng.</p>";
                }
                else if($_GET['error']=="noofQ"){
                    echo "<p>Enter valid no of Questions </p>";
                } 
                else if($_GET['error']=="CCode"){
                    echo "<p>Enter valid Qpcode </p>";
                }
                else if($_GET['error']=="semNo"){
                    echo "<p>Enter valid semesterno </p>";
                }   
                else if($_GET['error']=="bran"){
                    echo "<p>Enter valid branch </p>";
                } 
                else if($_GET['error']=="acad"){
                    echo "<p>Enter valid acadamicyear </p>";
                } 
                else if($_GET['error']=="reg"){
                    echo "<p>Enter valid regulation </p>";
                } 
                else if($_GET['error']=="alreadyInserted"){
                    echo "<p>Given data already exist  </p>";
                }
                else if($_GET['error']=="enterAllMC"){
                    echo "<p>Enter the Data Correct.  </p>";
                }
                else if($_GET['error']=="enterart"){
                    echo "<p>Enter course details first (articulation).";
                }
                else if($_GET['error']=="examType"){
                    echo "<p>Enter valid examtype</p>";
                }
                else if($_GET['error']=="conlost"){
                    echo "<p>connection is lost ,plz try after some time.</p>";
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
      $('#attainments').removeClass('active');
      $('#Mcourses').removeClass('active');
      $('#Mfaculty').removeClass('active');
      $('#Mweights').removeClass('active');
      $('#Ipoassessment').addClass('active');
      $('#Regulation').removeClass('active');


      var regulation=document.getElementById('reg');
        var academicYear=document.getElementById('acad');

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





        $('#qexam').hide();
        $('#dyaat').hide();
        $('#cocgiven').hide();
        $('#ExamChange').change(function(e){
            if(e.target.options[e.target.selectedIndex].value=="exit_survey"){
                   $('#qexam').hide();
                   $('#cocgiven').hide();
                   $('#dyaat').hide();
            }
            else if(e.target.options[e.target.selectedIndex].value=="co_curricular" || e.target.options[e.target.selectedIndex].value=="extra_curricular" ){
                if(e.target.options[e.target.selectedIndex].value=="co_curricular"){
                    $('#headercng').html(function(){
                        return 'No of Co-Curricular Activities <span style="color:red">*</span>';
                    });
                }    
                else if(e.target.options[e.target.selectedIndex].value=="extra_curricular"){
                    $('#headercng').html(function(){
                        return 'No of Extra-Curricular Activities <span style="color:red">*</span>';
                    });    
                }
                $('#qexam').show();

            }
            // else if(e.target.options[e.target.selectedIndex].value=="" ){
            //        $('#cocgiven').show();
            //        $('#qexam').hide();
            //        $('#naat').blur(function(){
            //             //   $('#placeoptions').html("");
            //             var valNOAAT=$('#naat').val();
            //             var place=document.getElementById('placeoptions');
            //             // console.log(place,valNOAAT,"nature");
            //             if(valNOAAT!='' && valNOAAT<=8 ){
            //                 place.innerHTML="";
            //                 for(var i=1;i<=valNOAAT;i++){
            //                     place.innerHTML +=`
            //                     <div class="col-md-2">
            //                         <h4>No of inputs in Co curricular activities-${i}</h4>
            //                         <div class="form-group">
            //                         <input type="number" class="form-control" id="no_of_qaat${i}" name="noofQaat${i}" placeholder="ex:8" title="Enter the number of questions in AAT-${i}" required> 
            //                         </div>
            //                     </div>`;
            //                 }
            //                 $('#dyaat').show();
            //             }else{
            //                 place.innerHTML="";
            //                 $('#dyaat').hide();
            //             }

            //        });
            // }
            else{
                $('#qexam').hide();
                   $('#cocgiven').hide();
                   $('#dyaat').hide();
            }
        });








    $('#pQpbtn').click(function(){
        var regulation=document.getElementById('reg');
        var academicYear=document.getElementById('acad');
        var branch=document.getElementById('bran');
        var examtype=document.getElementById('ExamChange');
            if(regulation.value!="" && academicYear.value!="" && branch.value!=""){
                if(examtype.value=='co_curricular' || examtype.value=='extra_curricular'){
                    var part=document.getElementById('part');
                if(part.value!=""){    
                $.ajax({
                      url:'../scripts/indirectpodynamic.php',
                      type:'post',
                      data:{noofQ:part.value,regulation1:regulation.value,academicYear1:academicYear.value,branch1:branch.value,examtype:examtype.value},
                      beforeSend: function(){
                        $('.response').empty();  
                        $("#loader").show();
                        },
                        success: function(response){
                        $('.response').empty();
                        $('.response').addClass('apply-bg');
                        $('.response').append(response);
                        $('.selectpick').selectpicker();
                        },
                        complete:function(data){
                        $("#loader").hide();
                        } 
                  });
                }else{
                    alert('incomplete data');
                }

                }
                // else if(examtype.value=="co_curricular"){
                //             var noofaat=document.getElementById('naat');
                //     if(noofaat.value!=""){
                //          var attArray=[];
                //          var checks=0;
                //          for(var i=1;i<=noofaat.value;i++){
                //              var tem=`no_of_qaat${i}`;
                //              var tid=`#no_of_qaat${i}`;
                //              var val=document.getElementById(`no_of_qaat${i}`).value;
                //              console.log(val);
                //              attArray.push(val);
                //              checks+=val;
                //          }
                //          console.log(attArray);
                //          if(checks>0){
                //          $.ajax({
                //       url:'indirectpodynamic.php',
                //       type:'post',
                //       data:{regulation1:regulation.value,academicYear1:academicYear.value,branch1:branch.value,noofaat:noofaat.value,QAAtarray:attArray,examtype:examtype.value},
                //       beforeSend: function(){
                //         $('.response').empty();  
                //         $("#loader").show();
                //         },
                //         success: function(response){
                //         $('.response').empty();
                //         $('.response').append(response);
                //         $('.selectpick').selectpicker();
                //         },
                //         complete:function(data){
                //         $("#loader").hide();
                //         } 
                //         });
                //       }else{
                //            alert('incomplete Data'); 
                //       }
                //     }
                //     else{
                //         alert('incomplete Data');
                //     } 
                // }  
                else if(examtype.value=="exit_survey"){
                    console.log("inside exit");
                    $.ajax({
                      url:'../scripts/indirectpodynamic.php',
                      type:'post',
                      data:{regulation1:regulation.value,academicYear1:academicYear.value,branch1:branch.value,examtype:examtype.value},
                      beforeSend: function(){
                        $('.response').empty();  
                        $("#loader").show();
                        },
                        success: function(response){
                        $('.response').empty();
                        $('.response').addClass('apply-bg');
                        $('.response').append(response);
                        $('.selectpick').selectpicker();
                        },
                        complete:function(data){
                        $("#loader").hide();
                        } 
                  });
                }
            }
            else{
                // ccode.value="";
            alert("enter first regulation,AcademicYear,Branch,ExamType,Question paper code, then number of question");
            }
        });


    // $('#pQpbtn').click(function(e){
    //     var part=document.getElementById('part');
    //     var regulation=document.getElementById('reg');
    //     var academicYear=document.getElementById('acaYear');
    //     var branch=document.getElementById('bran');
    //     var ccode=document.getElementById('CoCode');
    //     if( part.value!="" && regulation.value!="" && academicYear.value!="" && branch.value!="" && ccode.value!=""){
    //         $('#pQdynamic').load('PQpdynamic.php',{noofQ:part.value,regulation1:regulation.value,academicYear1:academicYear.value,branch1:branch.value,courseCode:ccode.value})
    //     }
    //     else{
    //         part.value="";ccode.value="";
    //         alert("enter first regulation,AcademicYear,Branch,ExamType,Question paper code, then number of question");
    //     }
    // });


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





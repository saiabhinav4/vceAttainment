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
function formate_input($row_s){
    if(!empty($row_s)){
        return explode(",",$row_s);
    } 
 return array();
}
$regulation=$academicYear=$branch=$semesterno=$courseType=$courseCode=$courseName=$csid=$isdefault=null;
if( isset($_GET['id']) and !empty($_GET['id']) ){
    $coid=$_GET['id'];
    $select_query="select regulation,academicYear,courseCode,branch,semesterNo,courseName,courseType,csid from coursedetails where coid='$coid'";
    if($res=mysqli_query($con,$select_query) or die(mysqli_error($con))){
        $row=mysqli_fetch_row($res);
        $regulation=$row[0];
        $branch=$row[3];
        $academicYear=$row[1];
        $semesterno=$row[4];
        $courseCode=$row[2];
        $courseName=$row[5];
        $courseType=$row[6];
        $csid=$row[7]; 
        // $select_query1="select csid,courseType,ishaveinternal,ishaveexternal,ishaveaat,ishaverubrics,internalTypes_s,internalTypes_f,externalTypes_s,externalTypes_f from coursestructure where csid=$csid";
        $select_query1="SELECT csid,courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,int_par_short,int_par_long,int_proj_short,int_proj_long,ext_th_short,ext_th_long,ext_par_short,ext_par_long,ext_proj_short,ext_proj_long,isdefault from coursestructure1 where csid=$csid";

        $result=mysqli_query($con,$select_query1) or die(mysqli_error($con));
        $row=mysqli_fetch_array($result);
        $ishaveinternal=$row[3];
        $ishaveexternal=$row[4];
        $ishaveaat=$row[5];
        $type=$row[6];
        $isdefault=$row[19];
        $internal=array();


        $internal_s=array();
        $internal_f=array();
        $external_s=array();
        $external_f=array();

        if($type=="theoretical"){

            if($ishaveinternal=="1"){
              $in_th_s=formate_input($row[7]);
              $in_th_l=formate_input($row[8]);

              $internal_s=$in_th_s;
              $internal_f=$in_th_l;

            }
            if($ishaveexternal=="1"){
                $ex_th_s=formate_input($row[13]);
                $ex_th_l=formate_input($row[14]);

                $external_s=$ex_th_s;
                $external_f=$ex_th_l;
            }

        }
        else if($type=="practical"){
            if($ishaveinternal=="1"){
                $in_pa_s=formate_input($row[9]);
                $in_pa_l=formate_input($row[10]);

                $internal_s=$in_pa_s;
                $internal_f=$in_pa_l;

              }
              if($ishaveexternal=="1"){
                  $ex_pa_s=formate_input($row[15]);
                  $ex_pa_l=formate_input($row[16]);

                  $external_s=$ex_pa_s;
                  $external_f=$ex_pa_l;
              }

        }
        else if($type=="both"){
            if($ishaveinternal=="1"){
                $in_th_s=formate_input($row[7]);
                $in_th_l=formate_input($row[8]);
                $in_pa_s=formate_input($row[9]);
                $in_pa_l=formate_input($row[10]);

                $internal_s=array_merge($in_th_s,$in_pa_s);
                $internal_f=array_merge($in_th_l,$in_pa_l);

              }
              if($ishaveexternal=="1"){
                $ex_th_s=formate_input($row[13]);
                $ex_th_l=formate_input($row[14]);
                $ex_pa_s=formate_input($row[15]);
                $ex_pa_l=formate_input($row[16]);

                $external_s=array_merge($ex_th_s,$ex_pa_s);
                $external_f=array_merge($ex_th_l,$ex_pa_l);
            }


        }
        else if($type=="project"){

            if($ishaveinternal=="1"){
                $in_proj_s=formate_input($row[11]);
                $in_proj_l=formate_input($row[12]);

                $internal_s=$in_proj_s;
                $internal_f=$in_proj_l;

              }
              if($ishaveexternal=="1"){
                  $ex_proj_s=formate_input($row[17]);
                  $ex_proj_l=formate_input($row[18]);

                  $external_s=$ex_proj_s;
                  $external_f=$ex_proj_l;
              }

        }


        // print_r($internal_s);
        // print_r($external_f);
        if($ishaveinternal=="1"){
            foreach($internal_s as $key=>$val){
                array_push($internal,$val);
            }
        }
        if($ishaveaat=="1"){
            array_push($internal,"AAT");
        }
        if($ishaveexternal=="1"){
            foreach($external_s as $key=>$val){
                array_push($internal,$val);
            }
        }
        // print_r($internal);exit();
        $ishaverubric=$row[2];





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
    <title>ProjectMapping</title>
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
        action="../scripts/projectmappingScript.php" method="post"
                          >
                          <input type="hidden" name="coid" value="<?php echo $_GET['id'];  ?>">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">Question Paper Mapping</h4>
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
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Project Paper Code</label
                                >
                                <input
                                  type="text"
                                  name="QPCode"
                                  id="CoCode"
                                  class="form-control"
                                  placeholder="ex:A6521"
                                  value="<?php echo $courseCode; ?>"
                                  title="start with A then followed by digits with length 4"
                                  pattern="[A][0-9]{4}"
                                />
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputUsername1"
                                  >Project Type</label
                                >
                                <select
                                  name="projectType"
                                  id="CT"
                                  class="form-control"
                                >
                                <option value="<?php echo $courseType; ?>"><?php echo $courseType; ?></option>
                                </select>
                              </div>
                            </div>
                            <div class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputUsername1"
                                  >Review Type</label
                                >
                                <select
                                  name="reviewType"
                                  id="reviewChange"
                                  class="form-control"
                                >
                               <option value="">--SELECT--</option>
                               <?php
                                      foreach($internal as $key=>$val){  ?>
                                          <option value="<?php echo $val; ?>"><?php echo $val; ?></option>
                                      <?php  }
                                        ?>
                                </select>
                              </div>
                            </div>
                              
                            <div id="qexamA" class="col-md-2">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >No of Rubrics</label
                                >
                                <input
                                  type="number"
                                  class="form-control"
                                  name="noofrubrics"
                                  id="noofr"
                                  placeholder="ex:5"
                                  title="Enter the number of Rubrics"
                                />
                              </div>
                            </div>            
                            </div>

                            <input type="hidden" name="isdefault" value="<?php echo $isdefault; ?>">
                               
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <a class="btn btn-xs btn-primary " id="Qpbtn"
                                  >Generate rubrics description</a
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
              </div>
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Result:</h4>
                    <!-- <p class="card-description">
                      Add class <code>.table-bordered</code>
                    </p> -->
                    <div id="loader" style="display: none; height: 300px"></div>
                    <div  class="response"></div>
                  </div>
                </div>
              </div>

            </div>
          <!-- </div> -->

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
                else  if($_GET['error']=="noofr"){
                    echo "<p>Enter valid No Of rubrics</p>";
                }
                else  if($_GET['error']=="reviewtype"){
                    echo "<p>Enter valid reviewType</p>";
                }
                else  if($_GET['error']=="projtype"){
                    echo "<p>Enter valid ProjectType</p>";
                }
                else if($_GET['error']=="reenter"){
                    echo "<p>Enter Target score with corresponding courseOutcome</p>";
                }
                else if($_GET['error']=="coursename"){
                    echo "<p>Enter valid coursename </p>";
                } 
                else if($_GET['error']=="Qpcode"){
                    echo "<p>Enter valid Qpcode </p>";
                }
                else if($_GET['error']=="semesterno"){
                    echo "<p>Enter valid semesterno </p>";
                }   
                else if($_GET['error']=="branch"){
                    echo "<p>Enter valid branch </p>";
                } 
                else if($_GET['error']=="invalid"){
                    echo "<p>Enter valid rubrics mapped values </p>";
                } 
                else if($_GET['error']=="acadamicyear"){
                    echo "<p>Enter valid acadamicyear </p>";
                } 
                else if($_GET['error']=="regulation"){
                    echo "<p>Enter valid regulation </p>";
                } 
                else if($_GET['error']=="alreadyExist"){
                    echo "<p>Given data already exist  </p>";
                }
                else if($_GET['error']=="nopost"){
                    echo "<p>Something went wrong, re-enter the data again  </p>";
                }
                else if($_GET['error']=="enterFirstArt"){
                    echo "<p>Enter the articulation matrix first  </p>";
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
   <?php  if($isdefault!=0){  ?>
         <script>   $('#qexamA').hide(); </script>
       <?php }?>

       <script>
      
        
   

      $('#Qpbtn').click(function(){
          var regulation=document.getElementById('reg');
          var academicYear=document.getElementById('acad');
          var branch=document.getElementById('bran');
          var ccode=document.getElementById('CoCode');
          var projecttype=document.getElementById('CT');
          var reviewtype=document.getElementById('reviewChange');
          var noofr=document.getElementById('noofr');
          var isdefault=`<?php echo $isdefault; ?>`;
          var check=false;
      <?php
          if( $isdefault=="0"){   ?>
              check=true;
      <?php   } ?>
              if(regulation.value!="" && academicYear.value!="" && branch.value!="" && ccode.value!="" && projecttype.value!="" && reviewtype.value!="" && ((check && noofr.value!="") || (!check))){
                  console.log('inside main');
  
                  $.ajax({
                        url:'../scripts/dynamicRubrics.php',
                        type:'post',
                        data:{isdefault:isdefault,regulation:regulation.value,academicYear:academicYear.value,branch:branch.value,projectCode:ccode.value,projectType:projecttype.value,reviewType:reviewtype.value,noofr:noofr.value},
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
                  ccode.value="";
              alert("Data incomplete");
              }
  
          });
  
     
      
     </script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/js/bootstrap.bundle.min.js"></script> -->
   <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.18/js/bootstrap-select.min.js"></script> -->

    <!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>

<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/i18n/defaults-*.min.js"></script>

    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <!-- endinject -->
    
  </body>
</html>





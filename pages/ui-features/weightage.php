<?php
    require "../common/connection.php";
    if(isset($_SESSION['department']) and !empty($_SESSION['department'])){
        $branch=$_SESSION['department'];
    }
    else{
        header('location:../../index.php');
    }

?>

<?php 
        // $ciew=$seew=$codaw=$coidaw=$level1=$level2=$level3=$podaw=$poidaw=$pota=$cota="";
        //     $select_weightage="SELECT catw,seew,codaw,coidaw,level1,level2,level3,podaw,poidaw,pota,cota from batchweightage where branch='$branch'";
        //     $res=mysqli_query($con,$select_weightage) or die(mysqli_error($con));
        //     if(mysqli_num_rows($res)>0){
        //         $row=mysqli_fetch_row($res);
        //         $ciew=$row[0];
        //         $seew=$row[1];
        //         $codaw=$row[2];
        //         $coidaw=$row[3];
        //         $level1=$row[4];
        //         $level2=$row[5];
        //         $level3=$row[6];
        //         $podaw=$row[7];
        //         $poidaw=$row[8];
        //         $pota=$row[9];
        //         $cota=$row[10];
        //     }
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
    <title>Modify Weightage</title>
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
        <?php  include "../common/sidenav.php"; ?>

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
                          <h4 class="card-title">Weightages</h4>
                          <p class="card-description">
                            Enter the below weightages
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
                                    required
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
                                    required
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
                                    required
                                  >
                                    <option value="">--SELECT--</option>
                                    <?php  
                                 if($branch=="GlobalAdmin"){
                                  $select_branch="SELECT dname,sname from department";
                                }else{
                                  $select_branch="SELECT dname,sname from department where dname='$branch'";
                                }
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
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >CIE Weightage
                                  </label>
                                  <input
                                    type="number"
                                    class="form-control"
                                    name="ciew"
                                    id="ciewId"
                                    placeholder=""
                                    title="Enter CIE Weightage"
                                    disabled
                                  />
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >SEE Weightage
                                  </label>
                                  <input
                                    type="number"
                                    class="form-control"
                                    name="seew"
                                    id="seewid"
                                    placeholder=""
                                    title="Enter SEE Weightage"
                                    disabled
                                  />
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Target Attainment
                                  </label>
                                  <input
                                    type="number"
                                    class="form-control"
                                    name="Tatt"
                                    id="Tattid"
                                    placeholder=""
                                    title="Enter Target Attainment"
                                    disabled
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Direct CO Weightage
                                  </label>
                                  <input
                                    type="number"
                                    class="form-control"
                                    name="directcow"
                                    id="directcoId"
                                    placeholder=""
                                    title="Enter Direct CO Wegitage"
                                    disabled
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >InDirect CO Weightage
                                  </label>
                                  <input
                                    type="number"
                                    class="form-control"
                                    name="indirectcow"
                                    id="indirectcoId"
                                    placeholder=""
                                    title="Enter Indirect CO Wegitage"
                                    disabled
                                  />
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Level-1 Weightage
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="level1"
                                    id="level1w"
                                    placeholder="ex:65-70"
                                    title="Enter level1 weightage"
                                    disabled
                                  />
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Level-2 Weightage
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="level2"
                                    id="level2w"
                                    placeholder="ex:70-75"
                                    title="Enter level2 weightage"
                                    disabled
                                  />
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Level-3 Weightage
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="level3"
                                    id="level3w"
                                    placeholder="ex:75-100"
                                    title="Enter level3 weightage"
                                    disabled
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Direct PO Weightage
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="pdirectw"
                                    id="pdirectid"
                                    placeholder=""
                                    title="Enter PO Direct Weightage"
                                    disabled
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1">
                                    InDirect PO Weightage
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="pindirectw"
                                    id="Pindirectid"
                                    placeholder=""
                                    title="Enter PO InDirect Weightage"
                                    disabled
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1">
                                    PO Target Attainment
                                  </label>
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="PTatt"
                                    id="PTattid"
                                    placeholder=""
                                    title="Enter PO Target Attainment"
                                    disabled
                                  />
                                </div>
                              </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="col-md-6">
                              </div> -->
                        <?php if(($_SESSION['department']=="GlobalAdmin")){ ?>
                            <div class="row">
                              <div class="col-md-6">
                                <a id="submit" class="btn btn-primary me-2">
                                  Submit
                                </a>
                                <a
                                  class="btn btn-info"
                                  value="check"
                                  id="modify"
                                  >Modify</a
                                >
                              </div>
                            </div>
                            <?php } ?>
                            <!-- </div> -->
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Result:</h4>
                    <div id="loader" style="display:none;height:300px;"></div>
                        <div id="examp" class="response">
                          
                        </div>
                  </div>
                </div>
              </div> -->
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
      $(document).ready(function () {
        $("#facultyTable").DataTable();
      });

      $('#attainments').removeClass('active');
      $('#Mcourses').removeClass('active');
      $('#Mfaculty').removeClass('active');
      $('#Mweights').addClass('active');
      $('#Ipoassessment').removeClass('active');
      $('#Regulation').removeClass('active');
      
       var ciew=document.getElementById('ciewId');
        var seew=document.getElementById('seewid');
        var CoTaw=document.getElementById('Tattid');
        var Codirectw=document.getElementById('directcoId');
        var Coindirectw=document.getElementById('indirectcoId');
        var level1w=document.getElementById('level1w');
        var level2w=document.getElementById('level2w');
        var level3w=document.getElementById('level3w');
        var Podirectw=document.getElementById('pdirectid');
        var Poindirectw=document.getElementById('Pindirectid');
        var PoTaw=document.getElementById('PTattid');
        var regulation=document.getElementById('reg');
        var academicYear=document.getElementById('acad');
        var branch=document.getElementById('bran');
        
      

        $('#submit').click(function(){
            if(regulation.value!="" && academicYear.value!="" && branch.value!="" && ciew.value!="" && seew.value!="" && CoTaw.value!="" && Codirectw.value!="" && Coindirectw.value!="" && level1w.value!="" && level2w.value!="" && level3w.value!="" && Podirectw.value!="" && Poindirectw.value!="" && PoTaw.value!="" ){
                $.ajax({
                      url:'../scripts/weightAssignScript.php',
                      type:'post',
                      data:{academicYear:academicYear.value,branch:branch.value,ciew:ciew.value,seew:seew.value,codaw:Codirectw.value,coidaw:Coindirectw.value,level1:level1w.value,level2:level2w.value,level3:level3w.value,podaw:Podirectw.value,poidaw:Poindirectw.value,pota:PoTaw.value,cota:CoTaw.value},
                      beforeSend: function(){
                        // $('.response').empty();  
                        // $("#loader").show();
                        },
                        success: function(response){
                        // $('.response').empty();
                        // $('.response').append(response);
                         alert(response);   
                        },
                        complete:function(data){
                        // $("#loader").hide();
                          //  location.reload(true);    
                           ciew.disabled=true;
                           seew.disabled=true;
                           CoTaw.disabled=true;
                           Codirectw.disabled=true;
                           Coindirectw.disabled=true;
                           level1w.disabled=true;
                           level2w.disabled=true;
                           level3w.disabled=true;
                           Podirectw.disabled=true;
                           Poindirectw.disabled=true;
                           PoTaw.disabled=true; 
                        } 
                        }); 
            }
            else{
                alert('Enter all fields');
            }
        });

        var ciewValue=`<?php // echo $ciew; ?>`;
        var seewValue=`<?php // echo $seew; ?>`;
        var codawValue=`<?php //echo $codaw; ?>`;
        var coidawValue=`<?php //echo $coidaw; ?>`;
        var level1Value=`<?php //echo $level1; ?>`;
        var level2Value=`<?php //echo $level2; ?>`;
        var level3Value=`<?php //echo $level3; ?>`;
        var podawValue=`<?php //echo $podaw; ?>`;
        var poidawValue=`<?php //echo $poidaw; ?>`;
        var potaValue=`<?php //echo $pota; ?>`;
        var cotaValue=`<?php // echo $cota; ?>`;
        

        if(ciewValue!="" && seewValue!="" && codawValue!="" && coidawValue!="" && coidawValue!="" && level1Value!="" && level2Value!="" && level3Value!="" && podawValue!="" && poidawValue!="" && potaValue!="" && cotaValue!=""){
                ciew.value=ciewValue;  ciew.disabled=true;
                seew.value=seewValue; seew.disabled=true;
                CoTaw.value=cotaValue; CoTaw.disabled=true;
                Codirectw.value=codawValue; Codirectw.disabled=true;
                Coindirectw.value=coidawValue; Coindirectw.disabled=true;
                level1w.value=level1Value; level1w.disabled=true;
                level2w.value=level2Value; level2w.disabled=true;
                level3w.value=level3Value; level3w.disabled=true;
                Podirectw.value=podawValue; Podirectw.disabled=true;
                Poindirectw.value=poidawValue; Poindirectw.disabled=true;
                PoTaw.value=potaValue; PoTaw.disabled=true;
        }
        else{
           // alert('one or more weightages are Empty');
        }

        $('#modify').click(function(){
             ciew.disabled=false;
               seew.disabled=false;
                CoTaw.disabled=false;
                Codirectw.disabled=false;
                Coindirectw.disabled=false;
                 level1w.disabled=false;
                   level2w.disabled=false;
                level3w.disabled=false;
              Podirectw.disabled=false;
                Poindirectw.disabled=false;
                PoTaw.disabled=false;
        });


        // var regulation=document.getElementById('reg');
        // var academicYear=document.getElementById('acad');


        $('#bran').on('change',function(){
              if(regulation.value!="" && academicYear.value!="" && branch.value!=""){
                $.ajax({
                      url:'../scripts/weightAssignScript.php',
                      type:'post',
                      data:{check:1,academicYear:academicYear.value,branch:branch.value},
                      beforeSend: function(){
                        // $('.response').empty();  
                        // $("#loader").show();
                        ciew.value=``;  ciew.disabled=true;
                        seew.value=``; seew.disabled=true;
                        CoTaw.value=``; CoTaw.disabled=true;
                        Codirectw.value=``; Codirectw.disabled=true;
                        Coindirectw.value=``; Coindirectw.disabled=true;
                        level1w.value=``; level1w.disabled=true;
                        level2w.value=``; level2w.disabled=true;
                        level3w.value=``; level3w.disabled=true;
                        Podirectw.value=``; Podirectw.disabled=true;
                        Poindirectw.value=``; Poindirectw.disabled=true;
                        PoTaw.value=``; PoTaw.disabled=true;  
                        },
                        success: function(response){
                        // $('.response').empty();
                        // $('.response').append(response);
                        // console.log("YO");
                         console.log(response); 
                       if( response.ischeck==0){
                       }
                       else{
                        
                        ciew.value=response.catw;  ciew.disabled=true;
                        seew.value=response.seew; seew.disabled=true;
                        CoTaw.value=response.cota; CoTaw.disabled=true;
                        Codirectw.value=response.codaw; Codirectw.disabled=true;
                        Coindirectw.value=response.coidaw; Coindirectw.disabled=true;
                        level1w.value=response.level1; level1w.disabled=true;
                        level2w.value=response.level2; level2w.disabled=true;
                        level3w.value=response.level3; level3w.disabled=true;
                        Podirectw.value=response.podaw; Podirectw.disabled=true;
                        Poindirectw.value=response.poidaw; Poindirectw.disabled=true;
                        PoTaw.value=response.pota; PoTaw.disabled=true;  
                       }
                        
                        },
                        complete:function(data){
                        // $("#loader").hide();
                          //  location.reload(true);     
                        } 
                        }); 
              }
              else{
                  alert('regulation or academicYear or branch is empty!.');
              }
        });



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
                          //  console.log(regulationArray);
                          //  console.log(batchArray);
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

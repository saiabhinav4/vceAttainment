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
    <title>PO Attainments</title>
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
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-body">
                          <h4 class="card-title">PO Attainment</h4>
                          <p class="card-description">
                            Customize the Weightage Values
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
                            </div>
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
                                    id="catweight"
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
                                    id="seeweight"
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
                                    id="targetatt1"
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
                                    id="direct_co"
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
                                    id="indirect_co"
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
                                    id="level_1_w"
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
                                    id="level_2_w"
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
                                    id="level_3_w"
                                    placeholder="ex:75-100"
                                    title="Enter Level-3 Range"
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputUsername1"
                                    >Direct PO Weightage(%)</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="podirectw"
                                    id="direct_po"
                                    placeholder="ex:80"
                                    title="Enter direct PO Weightage in Percentage"
                                  />
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="exampleInputEmail1"
                                    >Indirect PO Weightage(%)</label
                                  >
                                  <input
                                    type="text"
                                    class="form-control"
                                    name="poindirectw"
                                    id="indirect_po"
                                    placeholder="ex:20"
                                    title="Enter Indirect PO Weightage in Percentage"
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
                                    name="potatt"
                                    id="targetatt"
                                    placeholder="ex:75"
                                    title="Enter PO Target Attainment Value "
                                  />
                                </div>
                              </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-3">
                <!-- <input type="submit" id="dbutton" class="btn btn-success"> -->
                                        <a class="btn btn-primary" id="dbutton">Direct PO Assessment</a>
                                    </div>
                                    <div class="col-md-3">
                <!-- <input type="submit" id="dbutton" class="btn btn-success"> -->
                                        <a class="btn btn-primary" id="idbutton">Indirect PO Assessment</a>
                                    </div>
                                    <div class="col-md-3">
                <!-- <input type="submit" id="dbutton" class="btn btn-success"> -->
                                        <a class="btn btn-primary" id="obutton">OverAll PO Attainment</a>
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
                    <h4 class="card-title">Result:</h4>
                    <div class="row">
                    <div id="loader" style="display:none;height:300px;"></div>
                        <div id="examp" class="response">
                          <!-- <h4>Not Yet Generated PO Attainment</h4> -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

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

      $('#attainments').addClass('active');
      $('#Mcourses').removeClass('active');
      $('#Mfaculty').removeClass('active');
      $('#Mweights').removeClass('active');
      $('#Ipoassessment').removeClass('active');
      $('#Regulation').removeClass('active');

                // $.ajax({
                //       url:'../scripts/attainmentScript.php',
                //       type:'post',
                //       data:{branch:dept},
                //       beforeSend: function(){
                //           $('#co-att').empty();
                //           $('#loader').show();
                //         },
                //         success: function(response){
                //             $('#co-att').empty();
                //             $('#co-att').html(response);
                //         },
                //         complete:function(data){
                //           $('#loader').hide();
                //         } 
                //   }); 
        
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


    </script>

<script>
            var catweight = document.getElementById("catweight");
            var seeweight = document.getElementById("seeweight");
            var directco=document.getElementById("direct_co");
            var indirectco=document.getElementById("indirect_co");
            var level1=document.getElementById("level_1_w");
            var level2=document.getElementById("level_2_w");
            var level3=document.getElementById("level_3_w");
            var targetAttainment1 = document.getElementById("targetatt1");
            var directweight=document.getElementById('direct_po');
            var indirectweight=document.getElementById('indirect_po');
            var targetattainment=document.getElementById('targetatt');
            var weightages="";

            var reg=document.getElementById('reg');
            var acd=document.getElementById('acad');
            var bran=document.getElementById('bran');
          $('#bran').on('change',function(){
            if(acd.value!="" && bran.value!=""){
            $.ajax({
                      url:'../scripts/weightAssignScript.php',
                      type:'post',
                      data:{check:1,academicYear:acd.value,branch:bran.value},
                      beforeSend: function(){
                        catweight.value="";
                          seeweight.value="";
                          directco.value="";
                          indirectco.value="";
                          level1.value="";
                          level2.value="";
                          level3.value="";
                          targetAttainment1.value="";
                          directweight.value="";
                          indirectweight.value="";
                          targetattainment.value="";
                        },
                        success: function(response){
                        console.log(response);
                         weightages=response; 
                         if(weightages['ischeck']==1){
                          catweight.value=weightages['catw'];
                          seeweight.value=weightages['seew'];
                          directco.value=weightages['codaw'];
                          indirectco.value=weightages['coidaw'];
                          level1.value=weightages['level1'];
                          level2.value=weightages['level2'];
                          level3.value=weightages['level3'];
                          targetAttainment1.value=weightages['cota'];
                          directweight.value=weightages['podaw'];
                          indirectweight.value=weightages['poidaw'];
                          targetattainment.value=weightages['pota'];

                        }
                         
                        },
                        complete:function(data){     
                        } 
                        }); 

                  }

          });
           




        $('#pdf').hide();
        $('#dbutton').click(function(){
            var reg=document.getElementById('reg');
            var acd=document.getElementById('acad');
            var bran=document.getElementById('bran');
            var semno=document.getElementById('sem');
            var catweight = document.getElementById("catweight");
            var seeweight = document.getElementById("seeweight");
            var directco=document.getElementById("direct_co");
            var indirectco=document.getElementById("indirect_co");
            var level1=document.getElementById("level_1_w");
            var level2=document.getElementById("level_2_w");
            var level3=document.getElementById("level_3_w");
            var targetAttainment1 = document.getElementById("targetatt1");
            var directweight=document.getElementById('direct_po');
            var indirectweight=document.getElementById('indirect_po');
            var targetattainment=document.getElementById('targetatt');
            if(reg.value!='' && acd.value!='' && bran.value!=''  && semno.value!='' && targetAttainment1.value!='' && level1.value!='' && level2.value!='' && level3.value!=''  && indirectco.value!='' && directco.value!='' && catweight.value!='' && seeweight.value!='' && directweight.value!='' && indirectweight.value!='' && targetattainment.value!=''){
                $.ajax({
                      url:'../scripts/poattainmentScript4.php',
                      type:'post',
                      data:{ catw:catweight.value,seew:seeweight.value,directco:directco.value,indirectco:indirectco.value,level1:level1.value,level2:level2.value,level3:level3.value,targetAttainmentCO:targetAttainment1.value,regulation:reg.value,academicYear:acd.value,branch:bran.value,semesterNo:semno.value,directw:directweight.value,indirectw:indirectweight.value,target:targetattainment.value,type:'direct'},
                      beforeSend: function(){
                        $('.response').empty();  
                        $("#loader").show();
                        },
                        success: function(response){
                        $('.response').empty();
                        $('.response').append(response);
                        $('#pdf').show();
                        },
                        complete:function(data){
                        $("#loader").hide();
                        } 
                  }); 
            }
            else{
                alert('Data incomplete');
            }

        });


        $('#idbutton').click(function(){
            var reg=document.getElementById('reg');
            var acd=document.getElementById('acad');
            var bran=document.getElementById('bran');
            var semno=document.getElementById('sem');
            var catweight = document.getElementById("catweight");
            var seeweight = document.getElementById("seeweight");
            var directco=document.getElementById("direct_co");
            var indirectco=document.getElementById("indirect_co");
            var level1=document.getElementById("level_1_w");
            var level2=document.getElementById("level_2_w");
            var level3=document.getElementById("level_3_w");
            var targetAttainment1 = document.getElementById("targetatt1");
            var directweight=document.getElementById('direct_po');
            var indirectweight=document.getElementById('indirect_po');
            var targetattainment=document.getElementById('targetatt');
            if(reg.value!='' && acd.value!='' && bran.value!=''  && semno.value!='' && targetAttainment1.value!='' && level1.value!='' && level2.value!='' && level3.value!=''  && indirectco.value!='' && directco.value!='' && catweight.value!='' && seeweight.value!='' && directweight.value!='' && indirectweight.value!='' && targetattainment.value!=''){
                $.ajax({
                      url:'../scripts/poattainmentScript4.php',
                      type:'post',
                      data:{catw:catweight.value,seew:seeweight.value,directco:directco.value,indirectco:indirectco.value,level1:level1.value,level2:level2.value,level3:level3.value,targetAttainmentCO:targetAttainment1.value,regulation:reg.value,academicYear:acd.value,branch:bran.value,semesterNo:semno.value,directw:directweight.value,indirectw:indirectweight.value,target:targetattainment.value,type:'indirect'},
                      beforeSend: function(){
                        $('.response').empty();  
                        $("#loader").show();
                        },
                        success: function(response){
                        $('.response').empty();
                        $('.response').append(response);
                        $('#pdf').show();
                        },
                        complete:function(data){
                        $("#loader").hide();
                        } 
                  }); 
            }
            else{
                alert('Data incomplete');
            }

        });

        $('#obutton').click(function(){
            var reg=document.getElementById('reg');
            var acd=document.getElementById('acad');
            var bran=document.getElementById('bran');
            var semno=document.getElementById('sem');
            var catweight = document.getElementById("catweight");
            var seeweight = document.getElementById("seeweight");
            var directco=document.getElementById("direct_co");
            var indirectco=document.getElementById("indirect_co");
            var level1=document.getElementById("level_1_w");
            var level2=document.getElementById("level_2_w");
            var level3=document.getElementById("level_3_w");
            var targetAttainment1 = document.getElementById("targetatt1");
            var directweight=document.getElementById('direct_po');
            var indirectweight=document.getElementById('indirect_po');
            var targetattainment=document.getElementById('targetatt');
            if(reg.value!='' && acd.value!='' && bran.value!=''  && semno.value!='' && targetAttainment1.value!='' && level1.value!='' && level2.value!='' && level3.value!=''  && indirectco.value!='' && directco.value!='' && catweight.value!='' && seeweight.value!='' && directweight.value!='' && indirectweight.value!='' && targetattainment.value!=''){
                $.ajax({
                      url:'../scripts/poattainmentScript4.php',
                      type:'post',
                      data:{catw:catweight.value,seew:seeweight.value,directco:directco.value,indirectco:indirectco.value,level1:level1.value,level2:level2.value,level3:level3.value,targetAttainmentCO:targetAttainment1.value,regulation:reg.value,academicYear:acd.value,branch:bran.value,semesterNo:semno.value,directw:directweight.value,indirectw:indirectweight.value,target:targetattainment.value,type:'overallpo'},
                      beforeSend: function(){
                        $('.response').empty();  
                        $("#loader").show();
                        },
                        success: function(response){
                        $('.response').empty();
                        $('.response').append(response);
                        $('#pdf').show();
                        },
                        complete:function(data){
                        $("#loader").hide();
                        } 
                  }); 
            }
            else{
                alert('Data incomplete');
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

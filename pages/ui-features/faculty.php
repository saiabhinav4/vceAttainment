<?php
 require("../common/connection.php"); 
 function formate_input($row_s){
    if(!empty($row_s)){
        return explode(",",$row_s);
    } 
 return array();
}
function updateComplete($coid){
    global $con;
    $update="UPDATE coursedetails SET iscomplete=1 WHERE coid=$coid";
    $result=mysqli_query($con,$update) or die(mysqli_error($con));

}
function get_progress($regulation,$academicYear,$branch,$semesterNo,$courseCode){
  $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regulation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&coursecode=".$courseCode."&endpoint=CheckStatus";
  $data=file_get_contents($url);
  $decode_Data=json_decode($data,true);
  if(isset($decode_Data['error'])){
      return 0;
  }
  else{
      $total=0;$entered=0;
      $arr=$decode_Data['courses'][0];
      foreach($arr['status'] as $k=>$val){
            if($k=="indirect"){
                if($val){ $entered++; } 
                $total++;
            }
            else{
               $total+=count($val);
               foreach($val as $k1=>$v){
                 if($v){ $entered++; }
               }
            } 
      }
      return round(( ($entered*100)/$total));
  }
}


if(isset($_SESSION['fid']) and !empty($_SESSION['fid'])){
// print_r($_SESSION); exit();
$select_query="select fid,fname,department,designation,facultyID from faculty where fid=".$_SESSION['fid'];
$res=mysqli_query($con,$select_query) or die(mysqli_error($con));
$row=mysqli_fetch_row($res);
$fid=$row[0];
$facultyId=$row[4];
$fname=$row[1];
$branch=$row[2];
$designation=$row[3];
// echo "$fid $facultyId $fname $branch $designation  ".$_SESSION['fid']; exit();
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
      .branch-heading{
        color:#000;
      }
             #loader {
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../images/loading3.gif') 50% 50% no-repeat rgb(249, 249, 249);
            /* background-size: 100px 25px; */
        }

         #loading {
            position: relative;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url('../../images/loading1.gif') 50% 50% no-repeat rgb(249, 249, 249);
        }
      .table thead{
    background-color: #000;
    color:white;
}
/* .table tbody tr:nth-child(odd){
    background-color: azure;
}
.table tbody tr:nth-child(even){
    background-color: bisque;
} */
#lastrow{
    background-color:#92A0AD;
}
    </style>
  </head>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <?php include "../common/header1.php"; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
       <?php include "../common/sidenav1.php"; ?>

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
                          <!-- <p class="card-description">
                            Enter the facullty details to create an account
                          </p> -->
                          <div class="row">
                            <div class="col-3 col-md-2">
                              <img
                              src="../../images/faces/<?php  if( file_exists("../../images/faces/$facultyId.jpg") ){   echo $facultyId; } else{  echo "profile"; } ?>.jpg"
                                alt="nature img"
                                class="rounded"
                                height="100px"
                              />
                            </div>
                            <div class="col-8">
                              <p class="ml-2"><b>Faculty Name:</b> <?php echo $fname; ?></p>
                              <p class="ml-2"><b>Faculty ID:</b> <?php echo $facultyId; ?></p>
                              <p class="ml-2">
                                <b>Designation:</b> <?php echo $designation; ?>
                              </p>
                              <p class="ml-2">
                                <b>Department:</b> <?php echo get_department($branch); ?>
                              </p>
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
                    <h4 class="card-title">Course List</h4>
                    <!-- <p class="card-description">
                      Add class <code>.table-bordered</code>
                    </p> -->
                    <div class="table-responsive pt-3">
                      <table id="facultyTable" class="table table-bordered" style="width:300px;" >
                        <thead>
                          <tr class="table-info">
                            <th>Regulation</th>
                            <th>Academic Year</th>
                            <th>Branch</th>
                            <th>Semester</th>
                            <th>Course Code</th>
                            <th>Course Type</th>
                            <th>Course Name</th>
                            <th>Enter Course Details</th>
                            <th>Enter Question Paper Mapping</th>
                            <th>Enter Feedback</th>
                            <th>Progress</th>
                            <th>Check Status</th>
                            <th>Generate Report</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php
                                 $sql = "SELECT d.fid,fname,courseCode,courseName,branch,semesterNo,academicYear,regulation,coid,courseType,csid,iscomplete from coursedetails d,faculty f where d.fid=f.fid and f.fid=$fid";
                                 $res = mysqli_query($con,$sql) or die(mysqli_error($con));
                                 while($row=mysqli_fetch_row($res)){  ?>
                                  <tr class="table-info2">
                                    <?php   
                                        $iscompleted=$row[11];
                                        $csid=$row[10];
                                        $prog=get_progress($row[7],$row[6],$row[4],$row[5],$row[2]);
                                    $select_check="SELECT ishaverubrics from coursestructure1 where csid=$csid";
                                    $result=mysqli_query($con,$select_check) or die(mysqli_error($con));
                                    $crow=mysqli_fetch_row($result);
                                      ?>
                                    <td><?php  echo $row[7];  ?></td>
                                    <td><?php  echo $row[6];   ?></td>
                                    <td><?php  echo $row[4];   ?></td>
                                    <td><?php  echo $row[5];   ?></td>
                                    <td><?php  echo $row[2];   ?></td>
                                    <td><?php  echo $row[9];  ?></td>
                                    <td><?php  echo $row[3];   ?></td>
                                    <td><a href="articulation.php?id=<?php  echo $row[8]; ?>" target="_blank">click here</a></td>
                                    <td><a style="cursor:pointer; color:blue; "  class="upload1" data-csid="<?php echo $csid; ?>"  data-coursecode="<?php echo $row[2]; ?>"    data-coid="<?php echo $row[8]; ?>"  value="<?php  if($crow[0]=="1") { echo "projectMapping.php?id=".$row[8];    } else{ echo "mappingcos.php?id=".$row[8]; }?>" target="_blank">click here</a></td>
                                    <td><a href="survey.php?id=<?php  echo $row[8]; ?>" target="_blank">click here</a></td>
                                    <td style="color:black">
                                    <div class="progress" style="height:20px;">
                                        <div
                                            class="progress-bar bg-success"
                                            role="progressbar"
                                            style="width: <?php echo $prog.'%' ?>;"
                                            aria-valuenow="<?php echo $prog;  ?>"
                                            aria-valuemin="0"
                                            aria-valuemax="100"
                                        ><?php echo $prog.'%'; ?></div>
                                    </div>
                                    <!-- <div class="progress" style="height:20px">
                                        <div class="progress-bar" role="progressbar" style="width:<?php echo $prog.'%' ?>;" aria-valuenow="<?php echo $prog;  ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $prog.'%'; ?></div>
                                    </div> -->
                                    </td>
                                    <td><a class="status btn btn-xs btn-primary" value="<?php echo $row[7].','.$row[6].','.$row[5].','.$row[4].','.$row[2];  ?>" >click here <a></td>
                                    <td> <?php if($prog==100){ 
                                        if($iscompleted==0){
                                          updateComplete($row[8]);
                                        }
                                      echo '<a class="gen btn btn-xs btn-primary" value="'.$row[7].','.$row[6].','.$row[5].','.$row[4].','.$row[2].'" >click here <a>'; } else{ echo '<a class="btn btn-xs btn-primary" disabled> Click Here </a>';  }   ?> </td>
                                  </tr>

                            <?php     }
                              ?>
                        </tbody>
                      </table>
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




<!-- Model for upload -->
<div class="modal " id="myModal1" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Enter Question Paper Mapping</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <!-- <h2 class="modal-title" id="exampleModalLabel">Enter Question Paper Mapping</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
          <!-- <span aria-hidden="true">&times;</span> -->
        </button>
      </div>
      <div class="modal-body">
        <div id="upload"></div>
          <div class="container">
              <div class="row">
                   <div class="col-md-8" style="text-align:center">
                        <h6>Import (Xlsx,Csv,Xls)</h6>          
                   </div>               
                   <div class="col-md-4" style="text-align:center">
                        <h6>Manual Entry</h2>
                   </div>  
              </div>
              <div class="row">
                      <div class="col-md-8"> 
                        <form method="post" id="load_excel_form" enctype="multipart/form-data">
                             <input type="hidden" id="coid-id" name="coid" value=""> 
                             <input type="hidden" id="courseCode-id" name="coursecode" value="">  
                              <table class="table table-bordered " >
                                <tr class="table-info" >
                                    <td width="25%" align="left">
                                          <div class="" >
                                          <label for="ExamType" style="margin-bottom:0.4rem">Select Exam Type</label>
                                            <select id="examType" class="form-control" name="eType" required>
                                                <option value="">--SELECT--</option>
                        
                                            </select>
                                          </div>
                                    </td>
                                    <!-- <td width="50%"><input type="file" name="select_excel" /></td>
                                    <td width="25%"><input type="submit" name="load" class="btn btn-primary" /></td> -->
                                </tr>
                                  
                                <tr class="table-info1">
                                  <td>Download Template : <a class="" style="cursor:pointer;color:#000" id="download-templete" ><span class="ti-import"></span></a></td>
                                </tr>
                                <tr class="table-info2">
                                    <td width="50%"><input type="file"  name="select_excel" required/></td>
                                </tr>
                                <tr class="table-info2">
                                    <td width="25%"><input type="submit" name="load" class="btn btn-xs btn-primary" />
                                          <div style="width:50px;height:25px;display:inline-block;float:right;" id="loader">  </div>  
                                  </td>
                                </tr>
                              </table>
                        </form>     
                      </div>            
                      <div class="col-md-4" style="text-align:center">
                           <a id="insert-link" target="_blank" >CLICK HERE</a>         
                      </div>
              </div> 
              <br>
              <div class="row">
               <div class="col-md-12">
                 <div id="excel_area" style="text-align:center"></div>                
               </div>                   
              </div>                   
          </div>                        
      
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>



      
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="exampleModalLabel" >Change Password</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>  
      <div class="modal-body">
          <!-- <p>Modify the threshold Value,  Which is the Percentage of Maximum Marks.</p> -->
          <form >
            <div class="row">          
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Enter Previous Password</label
                                >
                                <input
                                  type="password"
                                  name="thValue"
                                  id="prePass"
                                  class="form-control"
                                  placeholder="Enter Here"
                                  title="Enter Previous Password"
                                />
                              </div>
                            </div>
                           
            </div>
            <div class="row">
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Enter New Password</label
                                >
                                <input
                                  type="password"
                                  name="new-Value"
                                  id="newPass"
                                  class="form-control"
                                  placeholder="Enter Here"
                                  title="Enter New Password"
                                />
                              </div>
                            </div>
                            <div class="col-md-5">
                              <div class="form-group">
                                <label for="exampleInputPassword1"
                                  >Re-Enter New Password</label
                                >
                                <input
                                  type="password"
                                  name="rnew-Value"
                                  id="RnewPass"
                                  class="form-control"
                                  placeholder="Enter Here"
                                  title="Re-Enter New Password"
                                />
                              </div>
                            </div>
            </div>
            <div class="row">
                            <div class="col-md-2">
                            
                              <a class="btn btn-xs btn-success" id="submit-pass">submit</a>
                            </div>        
            </div>
            <div class="row">
              <div id="result4" class="col-md-12">

              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>





    
<!-- Modal -->
<div class="modal " id="myModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Course Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <!-- <span aria-hidden="true">&times;</span> -->
        <!-- </button> -->
      </div>
      <div class="modal-body">
      <div style="width:450px;height:50px;display:inline-block;" id="loading">  </div>  
        <div id="checkIT">

        </div>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
      $(document).ready(function () {
        $("#facultyTable").DataTable();
      });
    </script>
      <script>

      $('#courseList').addClass('active');
      $('#Sett').removeClass('active');
      $('template').removeClass('active');

        let fid=`<?php echo $fid; ?>`;
          $('#submit-pass').click(function(){
              let prevPas=document.getElementById('prePass');
              let newPass=document.getElementById('newPass');
              let renewPass=document.getElementById('RnewPass');
              if(prevPas.value!='' && newPass.value!="" && renewPass.value!=''){
                $.ajax({
                      url:'../scripts/regulationScript.php',
                      type:'post',
                      data:{type:7,previousPass:prevPas.value,newPass:newPass.value,renewPass:renewPass.value,fid:fid},
                      beforeSend: function(){
                            $('#result4').empty();
                        },
                        success: function(response){
                          $('#result4').empty();
                            $('#result4').html(response);
                        },
                        complete:function(data){     
                          
                        } 
                        }); 

              }else{
                alert('Enter all Fields in Password Modal');
              }

          });

            // console.log("YO");                  
            $(document).ready(function(){

              $('#examType').change(function(){
                $('#download-templete').attr('href','');
              });

              $('#download-templete').click(function(){

                var select_c=document.getElementById('examType');
                var display=document.getElementById('excel_area');
                var coid=$('#coid-id').attr('value');
                if(select_c.value!=''){
                  $('#download-templete').attr('href',`../PhpSpreadSheet-master/AnyFolder/PhpOffice/generateExcel.php?coid=${coid}&examtype=${select_c.value}`);
                  // var win = window.open("", "_blank");
                  
                    // console.log('inside sucess');
                    // $.ajax({
                    //   url:'PhpSpreadSheet-master/AnyFolder/PhpOffice/generateExcel.php',
                    //   type:"GET",
                    //   data:{coid:coid,examtype:select_c.value},
                    //   contentType:false,
                    //   cache:false,
                    //   processData:true,
                    //   beforeSend:function(){
                    //       $('#loader').show();
                    //   },
                    //   success:function(data)
                    //   {
                    //     // display.innerHTML=data;
                    //     // var win = window.open("", "_blank");
                    //     // win.location.href = data;
                    //   },
                    //   complete:function(data){
                    //     $('#loader').hide();
                    //   }
                    // });


                }else{
                  display.innerHTML='<span style="color:red"> Select the examType! </span>';
                }                
              });

              $('#myModal1').on('hidden.bs.modal', function () {
                    var display=document.getElementById('excel_area');
                    display.innerHTML='';
                });


              $('#loader').hide();
              $('#load_excel_form').on('submit', function(event){
                console.log("inside");
                event.preventDefault();
                var select_c=document.getElementById('examType');
                var display=document.getElementById('excel_area');
                if(select_c.value!=""){
                  $.ajax({
                      url:'../PhpSpreadSheet-master/AnyFolder/PhpOffice/upload.php',
                      method:"POST",
                      data:new FormData(this),
                      contentType:false,
                      cache:false,
                      processData:false,
                      beforeSend:function(){
                          $('#loader').show();
                      },
                      success:function(data)
                      {
                        $('#excel_area').html(data);
                        $('table').css('width','100%');
                      },
                      complete:function(data){
                        $('#load_excel_form')[0].reset();
                        $('#loader').hide();
                      }
                    });
                   }
                   else{
                      display.innerHTML="Select the examType!";
                   }
                  });
                });

            $('.upload1').click(function(e){
                var str=$(this).attr('value');
                var csid=$(this).attr('data-csid');
                var coid=$(this).attr('data-coid');
                var courseCode=$(this).attr('data-coursecode');
                var select_c=document.getElementById('examType');
                console.log(`coid= ${coid}`);
                $('#coid-id').attr('value',coid);
                $('#courseCode-id').attr('value',courseCode);
                $.ajax({
                      url:'../scripts/get_examtypes.php',
                      type:'post',
                      data:{csid:csid},
                      beforeSend: function(){
                        },
                        success: function(response){
                          console.log(response);
                          var insert=`<option value="">--SELECT--</option>`;
                          // for(let i=0;i<response.length;i++){
                          //     insert+=`<option value="${response[i]}">${response[i]}</option>`;
                          // }
                          for (let [key, value] of Object.entries(response)) {
                              console.log(key, value);
                              insert+=`<option value="${value}">${value+' - '+key}</option>`;
                          }
                          select_c.innerHTML=insert; 
                        },
                        complete:function(data){     
                          
                        } 
                        }); 


                $('#insert-link').attr('href',str);
                $('#myModal1').modal('show');  

            });
             $('.status').click(function(e) {
              var str=$(this).attr('value').split(",");
                  var regulation=str[0];
                  var academicYear=str[1];
                  var branch=str[3];
                  var semesterNo=str[2];
                  var courseCode=str[4];

                  $.ajax({
                      url:'../scripts/coattainmentScript4.php',
                      type:"POST",
                      data:{
                        regulation: regulation,
                        academicYear: academicYear,
                        branch: branch,
                        semesterNo: semesterNo,
                        courseCode:courseCode,
                        ischeck: 1
                      },
                      beforeSend:function(){
                        $('#checkIT').empty();
                          $('#loading').show();
                      },
                      success:function(data)
                      {
                        $('#checkIT').empty();
                        $('#checkIT').append(data);
                      },
                      complete:function(data){
                        $('#loading').hide();
                      }
                    });

                // $('#checkIT').load('coattainmentScript4.php', {
                //     regulation: regulation,
                //     academicYear: academicYear,
                //     branch: branch,
                //     semesterNo: semesterNo,
                //     courseCode:courseCode,
                //     ischeck: 1
                // })
                $('#myModal').modal('show');

        });


        $('.gen').click(function(e) {
          var ischeck=false;
          var weightages="";
          var This=this;
          var str=$(This).attr('value').split(",");
          var regulation=str[0];
          var academicYear=str[1];
          var branch=str[3];
          var semesterNo=str[2];
          var courseCode=str[4];
          $.ajax({
                      url:'../scripts/weightAssignScript.php',
                      type:'post',
                      data:{check:1,academicYear:academicYear,branch:branch},
                      beforeSend: function(){
                        },
                        success: function(response){
                         weightages=response; 
                         if(weightages['ischeck']==1){
                         
                          window.open(`http://localhost/templete/pages/scripts/generatecoursepdf.php?regulation=${regulation}&academicYear=${academicYear}&branch=${branch}&semesterno=${semesterNo}&coursecode=${courseCode}&catw=${weightages['catw']}&seew=${weightages['seew']}&targetA=${weightages['cota']}&directCO=${weightages['codaw']}&indirectCO=${weightages['coidaw']}&level1=${weightages['level1']}&level2=${weightages['level2']}&level3=${weightages['level3']}&endpoint=COURSECOPDF`,"_blank");
                         }
                         else{
                          alert('weightages are not entered by Admin, Contact Admin');
                         }
                        },
                        complete:function(data){     
                        } 
                        }); 
          //  if(ischeck){

          //     var str=$(this).attr('value').split(",");
          //         var regulation=str[0];
          //         var academicYear=str[1];
          //         var branch=str[3];
          //         var semesterNo=str[2];
          //         var courseCode=str[4];
          //         window.open(`http://192.168.0.30/vce/generatecoursepdf.php?regulation=${regulation}&academicYear=${academicYear}&branch=${branch}&semesterno=${semesterNo}&coursecode=${courseCode}&catw=${weightages['catw']}&seew=${weightages['seew']}&targetA=${weightages['cota']}&directCO=${weightages['codaw']}&indirectCO=${weightages['coidaw']}&level1=${weightages['level1']}&level2=${weightages['level2']}&level3=${weightages['level3']}&endpoint=COURSECOPDF`,"_blank");
          //  }
          //  else{
          //    alert('weightages are not entered by Admin, Contact Admin');
          //  }

        });
        </script>
    <!-- <script src="../../vendors/base/vendor.bundle.base.js"></script> -->
    <script src="../../js/jquery.cookie.js" type="text/javascript"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>

<?php include "../common/connection.php" ;
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
    <title>Faculty-Course Mapping</title>
    <!-- plugins:css -->
    <!-- <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"
    /> -->
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
      <?php include "../common/header.php"; ?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php include "../common/sidenav.php" ?>

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
                          <h4 class="card-title">Faculty-Course Mapping</h4>
                          <p class="card-description"></p>
                          <form  method="post" action="../scripts/mappingfandc-Script.php" class="forms-sample">
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
                            </div>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label for="exampleInputPassword1"
                                    >Course Name</label
                                  >
                                  <select
                                    name="CourseName"
                                    class="form-control"
                                    id="courseN"
                                    required
                                  >
                                    <option value="">--SELECT--</option>
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2">
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
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1"
                                    >Faculty Dept</label
                                  >
                                  <select
                                    name="Fdept"
                                    class="form-control"
                                    id="Fdeptid"
                                    required
                                  >
                                  <?php  
                                $select_branch="SELECT dname,sname from department";
                                $result=mysqli_query($con,$select_branch) or die(mysqli_error($con));
                                while($row=mysqli_fetch_row($result)){ ?>
                                        <option value="<?php echo $row[0]; ?>"><?php  echo $row[0];   ?></option>
                                  <?php   }
                                    ?>
                                    <!-- <option value="">--SELECT--</option>
                                    <option value="IT">IT</option>
                                    <option value="CSE">CSE</option>
                                    <option value="ECE">ECE</option>
                                    <option value="EEE">EEE</option>
                                    <option value="MECH">MECH</option>
                                    <option value="CIVIL">CIVIL</option> -->
                                    
                                  </select>
                                </div>
                              </div>
                              <div class="col-md-2">
                                <div class="form-group">
                                  <label for="exampleInputPassword1"
                                    >Faculty Name</label
                                  >
                                  <select
                                    name="Fname"
                                    class="form-control"
                                    id="fnameid"
                                    required
                                  >
                                    <option value="">--SELECT--</option>
                                    <?php    
                         $select_faculty="select fid,fname,department,designation,facultyID from faculty where department='$branch' and isspecial=0";
                         $res=mysqli_query($con,$select_faculty) or die(mysqli_error($con));
                         while($row=mysqli_fetch_row($res)){
                             if(!empty($row[4])){
                             echo '<option value="'.$row[1].'%'.$row[0].'">'.$row[1]."-".$row[4].'</option>';
                             }
                         }
                                     ?>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <!-- <div class="form-group"> -->
                                <label for="exampleInputPassword1"
                                style="margin-bottom:0.5rem;"
                                  >Course Type</label
                                >
                              
                                <?php
                    function formate_input($row_s){
                           if(!empty($row_s)){
                               return explode(",",$row_s);
                           } 
                        return array();
                    }
                    $select_query="SELECT csid,courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,int_par_short,int_par_long,int_proj_short,int_proj_long,ext_th_short,ext_th_long,ext_par_short,ext_par_long,ext_proj_short,ext_proj_long,coursedesc from coursestructure1";
                          
                    $result=mysqli_query($con,$select_query) or die(mysqli_error($con));
                    while($row=mysqli_fetch_array($result)){
                        $csid=$row[0];
                        $courseType=$row[1];
                        $ishaveinternal=$row[3];
                        $ishaveexternal=$row[4];
                        $ishaveaat=$row[5];
                        $ishaverubrics=$row[2];
                        $coursedescription=$row[19];

                        $type=$row[6];

                        $internal_s=array();
                        $internal_f=array();
                        $external_s=array();
                        $external_f=array();

                        if($type=="theoretical"){

                            if($ishaveinternal){
                              $in_th_s=formate_input($row[7]);
                              $in_th_l=formate_input($row[8]);

                              $internal_s=$in_th_s;
                              $internal_f=$in_th_l;

                            }
                            if($ishaveexternal){
                                $ex_th_s=formate_input($row[13]);
                                $ex_th_l=formate_input($row[14]);

                                $external_s=$ex_th_s;
                                $external_f=$ex_th_l;
                            }

                        }
                        else if($type=="practical"){
                            if($ishaveinternal){
                                $in_pa_s=formate_input($row[9]);
                                $in_pa_l=formate_input($row[10]);
  
                                $internal_s=$in_pa_s;
                                $internal_f=$in_pa_l;
  
                              }
                              if($ishaveexternal){
                                  $ex_pa_s=formate_input($row[15]);
                                  $ex_pa_l=formate_input($row[16]);
  
                                  $external_s=$ex_pa_s;
                                  $external_f=$ex_pa_l;
                              }

                        }
                        else if($type=="both"){
                            if($ishaveinternal){
                                $in_th_s=formate_input($row[7]);
                                $in_th_l=formate_input($row[8]);
                                $in_pa_s=formate_input($row[9]);
                                $in_pa_l=formate_input($row[10]);
  
                                $internal_s=array_merge($in_th_s,$in_pa_s);
                                $internal_f=array_merge($in_th_l,$in_pa_l);
  
                              }
                              if($ishaveexternal){
                                $ex_th_s=formate_input($row[13]);
                                $ex_th_l=formate_input($row[14]);
                                $ex_pa_s=formate_input($row[15]);
                                $ex_pa_l=formate_input($row[16]);
                          
                                $external_s=array_merge($ex_th_s,$ex_pa_s);
                                $external_f=array_merge($ex_th_l,$ex_pa_l);
                            }


                        }
                        else if($type=="project"){

                            if($ishaveinternal){
                                $in_proj_s=formate_input($row[11]);
                                $in_proj_l=formate_input($row[12]);
  
                                $internal_s=$in_proj_s;
                                $internal_f=$in_proj_l;
  
                              }
                              if($ishaveexternal){
                                  $ex_proj_s=formate_input($row[17]);
                                  $ex_proj_l=formate_input($row[18]);
  
                                  $external_s=$ex_proj_s;
                                  $external_f=$ex_proj_l;
                              }

                        }


                        if($ishaveaat=="1"){
                            $in=count($internal_s)+1;
                        }
                        else{
                            $in=count($internal_s);
                        }
                        $ex=count($external_s);
                        $ex=($ex==0)?1:$ex;
                      ?>  
                       <div class="col-md-6 d-flex">
                                <table  class="table table-bordered flex-fill  ">
                                    <thead>
                                        <tr class="table-info">
                                            <th colspan="<?php echo ($in+$ex); ?>"><input type="radio" value="<?php  echo $courseType."%".$csid;   ?>" name="coursetype" required><?php  echo "  ".$courseType; if($ishaverubrics=="1"){echo " (rubric based)";}  ?> </th>
                                        </tr>
                                        <tr class="table-info1">
                                            <th colspan="<?php echo ($in+$ex); ?>"><?php if( !empty($coursedescription) ){ echo $coursedescription; } else {  echo "All Regulations";  }?></th>
                                        </tr>
                                        <tr class="table-info1">
                                            <th colspan="<?php echo $in; ?>">Internal </th>
                                            <th colspan="<?php echo $ex;?>">External </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tbody>
                                            <tr class="table-info2">
                                                <?php
                                                   if(count($internal_s)!=0){ 
                                                    foreach($internal_s as $key=>$val){
                                                         echo '<td><abbr  title="'.$internal_f[$key].'" >'.$val.'</abbr></td>';   
                                                    }
                                                  }
                                                  else{
                                                    echo '<td></td>';
                                                  }
                                                    if($ishaveaat=="1"){
                                                        echo '<td><abbr title="Alternative Assessment Test" >AAT</abbr></td>';
                                                    }
                                                  if(count($external_s)!=0){  
                                                    foreach($external_s as $key=>$val){
                                                        echo '<td><abbr  title="'.$external_f[$key].'" >'.$val.'</abbr></td>'; 
                                                   }
                                                  }
                                                  else{
                                                    echo '<td></td>';
                                                  }
                                                ?>
                                               
                                            </tr>
                                        </tbody>
                                    </tbody>
                                </table>
                        </div>
                    <?php
                    }    
                  ?>
                              
                              <!-- </div> -->
                              <div class="col-md-6">
                                <span>OR</span>
                                <a class="btn btn-xs btn-primary" id="csbutton">Create Course Structure</a>
                                
                              </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="col-md-6">
                              </div> -->
                            <div class="row">
                          
                              <div class="col-md-6">
                               <input type="submit"
                                class="btn btn-success"
                                value="Insert"
                                name="Submitbtn"
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


    <?php if (isset($_GET['insert'])) { 
            if($_GET['insert'] == 'success') { ?>
                <script>alert("Successfully inserted data.");</script>
            <?php } 
            else if($_GET['insert']=='alreadyexist'){  ?>
                 <script>alert("Already Mapped the course.");</script>
             <?php }
            else if($_GET['insert']=='error'){?>
                <script>alert("Error! try again.");</script>
        <?php }
            }?>




     
    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
          <!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header"> 
                <h5 class="modal-title" id="exampleModalLabel">Course Structure</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                  <form method="POST" name="submitCourseStruct" action="../scripts/createStructureScript.php">    
                   <div class="row">
                       <div class="col-md-6">
                       <h4>Enter Course Type Name <span style="color:red;">*</span></h4>
                        <div class="form-group">
                         <input type="text" class="form-control" name="coursetype" id="course_type"  placeholder="ex:Integrated"  title="Enter Course Type Name" required>
                        </div>
                       </div>
                       <div class="col-md-6">
                           <!-- <h4>&nbsp;</h4> -->
                           <div class="checkbox" style="margin-bottom: 0.5rem;">
                              <label><input type="checkbox" name="ishaverubrics" id="isrubrics">&nbsp;Course Have Rubrics</label>
                           </div>
                           <div class="radio">
                              <label ><input type="radio" name="iswttype" value="theoretical" id="rt">&nbsp;theoretical</label>
                              <label ><input type="radio" name="iswttype" value="practical" id="rp">&nbsp;Practical</label>
                              <label ><input type="radio" name="iswttype" value="both" id="rb">&nbsp;Both(theoretical & Practical)</label>
                              <label ><input type="radio" name="iswttype" value="project" id="rproj">&nbsp;Project/others</label>                                
                           </div>
                       </div>   
                   </div>
                   <div style="margin-bottom: 0.5rem;">
                           <h4>Internal Types</h4>
                           <div  class="checkbox">
                              <label><input type="checkbox" name="ishaveinternal" id="isinternal">&nbsp;Course Have internal</label>
                           </div>
                   </div>
                   <div class="row" id="internalNoOf">
                      <div class="col-md-6" id="inter-t">      
                          <h6>Enter No of Theoretical types <span style="color:red;">*</span></h6>
                          <div class="form-group">
                              <input type="number" class="form-control" name="internaltheorytypeNo" id="in-theoryNO"  placeholder="ex:2"  title="Enter No of Types in Theoretical " >
                          </div>
                      </div>
                      <div class="col-md-6" id="inter-pr">      
                          <h6>Enter No of Practical types <span style="color:red;">*</span></h6>
                          <div class="form-group">
                              <input type="number" class="form-control" name="internalpracticaltypeNo" id="in-practicalNO"  placeholder="ex:2"  title="Enter No of Types in Practical " >
                          </div>
                      </div>
                      <div class="col-md-6" id="inter-proj">      
                          <h6>Enter No of Project types <span style="color:red;">*</span></h6>
                          <div class="form-group">
                              <input type="number" class="form-control" name="internalprojecttypeNo" id="in-projectNO"  placeholder="ex:2"  title="Enter No of Types in Project " >
                          </div>
                      </div>  
                   </div>   
                   <div class="row" id="internal-types-theory">
                   </div>
                   <div class="row" id="internal-types-practical">    
                   </div>
                   <div class="row" id="internal-types-project">
                   </div>
                   <div style="margin-bottom: 0.5rem;">
                           <!-- <h4>Internal Types</h4> -->
                           <div class="checkbox">
                              <label><input type="checkbox" name="ishaveatt">&nbsp;Course Have ATT</label> 
                          </div>
                   </div>
                   <div style="margin-bottom: 0.5rem;">
                           <h4>External Types</h4>
                           <div class="checkbox">
                              <label><input type="checkbox" name="ishaveexternal" id="isexternal">&nbsp;Course Have External</label>
                           </div>
                   </div>
                   <div class="row" id="ExternalNoOf">
                      <div class="col-md-6" id="exter-t">      
                          <h6>Enter No of Theoretical types <span style="color:red;">*</span></h6>
                          <div class="form-group">
                              <input type="number" class="form-control" name="externaltheorytypeNo" id="ex-theoryNO"  placeholder="ex:2"  title="Enter No of Types in Theoretical">
                          </div>
                      </div>
                      <div class="col-md-6" id="exter-pr">      
                          <h6>Enter No of Practical types <span style="color:red;">*</span></h6>
                          <div class="form-group">
                              <input type="number" class="form-control" name="externalpracticaltypeNo" id="ex-practicalNO"  placeholder="ex:2"  title="Enter No of Types in Practical" >
                          </div>
                      </div>
                      <div class="col-md-6" id="exter-proj">      
                          <h6>Enter No of Project types <span style="color:red;">*</span></h6>
                          <div class="form-group">
                              <input type="number" class="form-control" name="externalprojecttypeNo" id="ex-projectNO"  placeholder="ex:2"  title="Enter No of Types in Project " >
                          </div>
                      </div>  
                   </div> 
                   <div class="row" id="external-types-theory">
                   </div>
                   <div class="row" id="external-types-practical">    
                   </div>
                   <div class="row" id="external-types-project">
                   </div>
                   <!-- <div class="row">
                   <div class="col-md-6">
                          <h5>Enter External Types(short forms) <span style="color:red;">*</span></h5>
                          <div class="form-group">
                              <input type="text" class="form-control" name="externaltype_short" id="external_short" pattern="[a-zA-Z\,]+" placeholder="ex:SEE,PSEE"  title="Enter External types in Short Forms" disabled>
                          </div>
                      </div> 
                      <div class="col-md-6">
                          <h5>Enter External Types(full forms) <span style="color:red;">*</span></h5>
                          <div class="form-group">
                              <input type="text" class="form-control" name="externaltype_full" id="external_full" pattern="[a-zA-Z\,]+" placeholder="ex:Semester End Exam,Practical Semster End Exam"  title="Enter External types in Full Forms" disabled>
                          </div>
                      </div> 
                   </div> -->
                   <div class="row">
                          <div class="col-md-4">
                          <button class="btn btn-primary" id="submit">Submit</button>
                          </div>
                   </div>
                   </div>
                  </form>
              </div>

          </div>
      </div>
















    <!-- plugins:js -->
    <script src="../../vendors/base/vendor.bundle.base.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
    <!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script> -->

    <!-- <script src="../../vendors/base/vendor.bundle.base.js"></script> -->
    <!-- endinject -->
    <!-- inject:js -->
    <script>
         $('#attainments').removeClass('active');
      $('#Mcourses').removeClass('active');
      $('#Mfaculty').addClass('active');
      $('#Mweights').removeClass('active');
      $('#Ipoassessment').removeClass('active');
      $('#Regulation').removeClass('active');

      
        var dept=`<?php echo $branch; ?>`;
         
            
         console.log('outside focus');
         var courseNameArray=null;
         var regulation=document.getElementById('reg');
         var academicYear=document.getElementById('acad');
         var branch=document.getElementById('bran');
         var semesterNo=document.getElementById('semester');
         var courseName=document.getElementById('courseN');
         var courseCode=document.getElementById('CCode');
         var facDept=document.getElementById('Fdeptid'); 
         var faculty=document.getElementById('fnameid');   
            
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

         
         
         
         
         setSelectedValue(facDept,dept);

         function setSelectedValue(selectObj, valueToSet) {
             for (var i = 0; i < selectObj.options.length; i++) {
                 if (selectObj.options[i].value== valueToSet) {
                         selectObj.options[i].selected = true;
                         return;
                     }
             }
         }
         $('#Fdeptid').on('change',function(){
                  if(facDept.value!=""){ 
                     $.ajax({
                   url:'../scripts/fetchFacultyScript.php',
                   type:'post',
                   data:{check:1,dept:facDept.value},
                   beforeSend: function(){
                     },
                     success: function(response){
                       console.log(response);
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

         $('#courseN').on('change',function(){
             if(courseNameArray!=null && courseName.value!=""){
                   courseCode.value=courseNameArray[courseName.value];      
             }
             else{
                 courseCode.value="";
             }
         });
         $('#courseN').focus(function(){
         console.log('inside focus');
         if(regulation.value!="" && academicYear.value!="" && branch.value!="" && semesterNo.value!=""){
             $.post('../scripts/coursedetailsScript.php',{regulation:regulation.value,academicYear:academicYear.value,branch:branch.value,semesterNo:semesterNo.value,type:2},function(result){
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






      
      $('#csbutton').click(function() {
            $('#myModal').modal('show')
        });

        var ishaveinternal=document.getElementById('isinternal');
        var ishaveexternal=document.getElementById('isexternal');
        // var internal_s=document.getElementById('internal_short');
        // internal_s.disabled=false;
        // var internal_f=document.getElementById('internal_full');
        // internal_f.disabled=false;
       // var external_s=document.getElementById('external_short');
        // external_s.disabled=false;
        //var external_f=document.getElementById('external_full');
        // external_f.disabled=false;
        // console.log(is haveexternal,internal_s);
        var theory=document.getElementById('rt');
        var practical=document.getElementById('rp');
        var both=document.getElementById('rb');
        var project=document.getElementById('rproj');
        var internalNoOf=document.getElementById('internalNoOf');
        var internalTypesTheory=document.getElementById('internal-types-theory');
        var internalTypesPractical=document.getElementById('internal-types-practical');
        var internalTypesProject=document.getElementById('internal-types-project');

        var externalTypesTheory=document.getElementById('external-types-theory');
        var externalTypesPractical=document.getElementById('external-types-practical');
        var externalTypesProject=document.getElementById('external-types-project');
        $('#inter-t').hide();
        $('#inter-pr').hide();
        $('#inter-proj').hide();
        $('#exter-t').hide();
        $('#exter-pr').hide();
        $('#exter-proj').hide();

        $('input[type=radio][name=iswttype]').change(function() {
                $('#inter-t').hide();
                $('#inter-pr').hide();
                $('#inter-proj').hide();
                $('#exter-t').hide();
                $('#exter-pr').hide();
                $('#exter-proj').hide();
                internalTypesTheory.innerHTML="";
                internalTypesPractical.innerHTML="";
                internalTypesProject.innerHTML="";
                externalTypesTheory.innerHTML="";
                externalTypesPractical.innerHTML="";
                externalTypesProject.innerHTML="";
            ishaveinternal.checked=false;
            ishaveexternal.checked=false;

        });

        $('#ex-theoryNO').on('blur',function(){
                   var val=this.value;
                   if(val!="" && val>=0 && val<=10){
                    externalTypesTheory.innerHTML="";
                        for(var i=1;i<=val;i++){
                            externalTypesTheory.innerHTML+=`
                            <div class="col-md-6">
                                    <h6>theoretical Type-${i} (Short Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="exTs${i}" name="ex-Ts-${i}" placeholder="ex:SEE" title="Enter theoretical Type-${i} (short form)" required> 
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <h6>theoretical Type-${i} (Long Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="exTl${i}" name="ex-Tl-${i}" placeholder="ex:Semester End Exam" title="Enter theoretical Type-${i} (long form)" required> 
                                    </div>
                            </div>
                            `;
                        }
                   }
                   else{
                        alert("enter valid number (non empty positive number and lessthan 10)");
                   }
        }); 
        $('#ex-practicalNO').on('blur',function(){
            var val=this.value;
                   if(val!="" && val>=0 && val<=10){
                    externalTypesPractical.innerHTML="";
                        for(var i=1;i<=val;i++){
                            externalTypesPractical.innerHTML+=`
                            <div class="col-md-6">
                                    <h6>Practical Type-${i} (Short Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="exPs${i}" name="ex-Ps-${i}" placeholder="ex:PSEE" title="Enter Practical Type-${i} (short form)" required> 
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <h6>Practical Type-${i} (Long Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="exPl${i}" name="ex-Pl-${i}" placeholder="ex:Practical Semester End exam" title="Enter Practical Type-${i} (long form)" required> 
                                    </div>
                            </div>
                            `;
                        }
                   }
                   else{
                        alert("enter valid number (non empty positive number and lessthan 10)");
                   }
        });   
        $('#ex-projectNO').on('blur',function(){
            var val=this.value;
                   if(val!="" && val>=0 && val<=10){
                    externalTypesProject.innerHTML="";
                        for(var i=1;i<=val;i++){
                            externalTypesProject.innerHTML+=`
                            <div class="col-md-6">
                                    <h6>Project Type-${i} (Short Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="exProjs${i}" name="ex-Projs-${i}" placeholder="ex:PCR" title="Enter Project Type-${i} (short form)" required> 
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <h6>Project Type-${i} (Long Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="exProjl${i}" name="ex-Projl-${i}" placeholder="Project Completion Review " title="Enter Project Type-${i} (long form)" required> 
                                    </div>
                            </div>
                            `;
                        }
                   }
                   else{
                        alert("enter valid number (non empty positive number and lessthan 10)");
                   }
        });
        $('#in-projectNO').on('blur',function(){
            var val=this.value;
                   if(val!="" && val>=0 && val<=10){
                    internalTypesProject.innerHTML="";
                        for(var i=1;i<=val;i++){
                            internalTypesProject.innerHTML+=`
                            <div class="col-md-6">
                                    <h6>Project Type-${i} (Short Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="Projs${i}" name="in-Projs-${i}" placeholder="ex:ALR" title="Enter Project Type-${i} (short form)" required> 
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <h6>Project Type-${i} (Long Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="Projl${i}" name="in-Projl-${i}" placeholder="ex:Abstract Level Review" title="Enter Project Type-${i} (long form)" required> 
                                    </div>
                            </div>
                            `;
                        }
                   }
                   else{
                        alert("enter valid number (non empty positive number and lessthan 10)");
                   }
        });
        $('#in-practicalNO').on('blur',function(){
            var val=this.value;
                   if(val!="" && val>=0 && val<=10){
                    internalTypesPractical.innerHTML="";
                        for(var i=1;i<=val;i++){
                            internalTypesPractical.innerHTML+=`
                            <div class="col-md-6">
                                    <h6>Practical Type-${i} (Short Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="Ps${i}" name="in-Ps-${i}" placeholder="ex:PCAT1" title="Enter Practical Type-${i} (short form)" required> 
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <h6>Practical Type-${i} (Long Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="Pl${i}" name="in-Pl-${i}" placeholder="ex:Practical Continous Assessment Test 1" title="Enter Practical Type-${i} (long form)" required> 
                                    </div>
                            </div>
                            `;
                        }
                   }
                   else{
                        alert("enter valid number (non empty positive number and lessthan 10)");
                   }
        });
        $('#in-theoryNO').on('blur',function(){
                   var val=this.value;
                   if(val!="" && val>=0 && val<=10){
                    internalTypesTheory.innerHTML="";
                        for(var i=1;i<=val;i++){
                            internalTypesTheory.innerHTML+=`
                            <div class="col-md-6">
                                    <h6>theoretical Type-${i} (Short Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="Ts${i}" name="in-Ts-${i}" placeholder="ex:CAT1" title="Enter theoretical Type-${i} (short form)" required> 
                                    </div>
                            </div>
                            <div class="col-md-6">
                                    <h6>theoretical Type-${i} (Long Form)</h6>
                                    <div class="form-group">
                                    <input type="text" class="form-control" id="Tl${i}" name="in-Tl-${i}" placeholder="ex:Continous Assessment Test 1" title="Enter theoretical Type-${i} (long form)" required> 
                                    </div>
                            </div>
                            `;
                        }
                   }
                   else{
                        alert("enter valid number (non empty positive number and lessthan 10)");
                   }
        });    
        $('#isinternal').change(function(){
            if(this.checked){
                if( theory.checked==false && practical.checked==false && both.checked==false && project.checked==false ){
                    alert('select theoritical or pracctical or both or project');
                    this.checked=false;
                }
                else{
                    if(theory.checked){
                        $('#inter-t').show();
                    }
                    else if(practical.checked){
                        $('#inter-pr').show();
                    }
                    else if(both.checked){
                        $('#inter-t').show();
                        $('#inter-pr').show();
                    }else if(project.checked){
                        $('#inter-proj').show();
                    }
                }
                // internal_s.disabled=false;
                // internal_f.disabled=false;
            }
            else{
                $('#inter-t').hide();
                $('#inter-pr').hide();
                $('#inter-proj').hide();
                internalTypesTheory.innerHTML="";
                internalTypesPractical.innerHTML="";
                internalTypesProject.innerHTML="";
                // internal_s.disabled=true;
                // internal_f.disabled=true;
            }
        });

        $('#isexternal').change(function(){
            if(this.checked){
                if( theory.checked==false && practical.checked==false && both.checked==false && project.checked==false ){
                    alert('select theoritical or pracctical or both or project');
                    this.checked=false;
                }
                else{
                    if(theory.checked){
                        $('#exter-t').show();
                    }
                    else if(practical.checked){
                        $('#exter-pr').show();
                    }
                    else if(both.checked){
                        $('#exter-t').show();
                        $('#exter-pr').show();
                    }else if(project.checked){
                        $('#exter-proj').show();
                    }
                }
                // internal_s.disabled=false;
                // internal_f.disabled=false;
            }
            else{
                $('#exter-t').hide();
                $('#exter-pr').hide();
                $('#exter-proj').hide();
                externalTypesTheory.innerHTML="";
                externalTypesPractical.innerHTML="";
                externalTypesProject.innerHTML="";
                // internal_s.disabled=true;
                // internal_f.disabled=true;
            }
        });
    </script>
    <script src="../../js/off-canvas.js"></script>
    <script src="../../js/hoverable-collapse.js"></script>
    <script src="../../js/template.js"></script>
    <script src="../../js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>

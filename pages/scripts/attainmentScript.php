<?php
include '../common/connection.php';
$branch="";
if(isset($_POST) and !empty($_POST)){
    if(isset($_POST['branch']) and !empty($_POST['branch'])){
      $branch=$_POST['branch'];
      $result_arr=array();
      $result_dept=array();
      $retrive_acad="select rname,ayname from regulation r,academicyear a where r.rid=a.rid order by rname,ayname";
      $result=mysqli_query($con,$retrive_acad) or die(mysqli_error($con));
      if(mysqli_num_rows($result)>0){
         while($row=mysqli_fetch_row($result)){
             if(!array_key_exists($row[0],$result_arr)){
                    $result_arr[$row[0]]=array();
                    array_push($result_arr[$row[0]],$row[1]);
             }
             else{
               array_push($result_arr[$row[0]],$row[1]);
             }
         }
      
        //  print_r($result_arr);
         $regulationArray=array_keys($result_arr);
        //  print_r($regulationArray);

         if($_POST['branch']=="GlobalAdmin"){
              $retrive_dept="select dname,sname from department";
              $res=mysqli_query($con,$retrive_dept) or die(mysqli_error($con));
              if(mysqli_num_rows($res)>0){
                  while($row=mysqli_fetch_row($res)){
                      $result_dept[$row[0]]=$row[1];
                  }
              }
         }


       ?>
      <?php 
           if($_POST['branch']=="GlobalAdmin"){  ?>
    <div class="accordion" id="BranchAcc">
        <?php   foreach($result_dept as $branch => $branch_val){  ?>
          <div class="accordion-item">
                <h2 class="accordion-header " id="headingB<?php echo $branch; ?>">
                    <button class="accordion-button collapsed bg-regulation" type="button" data-bs-toggle="collapse" data-bs-target="#collapseB<?php echo $branch; ?>" aria-expanded="false" aria-controls="collapseB<?php echo $branch; ?>">
                      <?php echo $branch_val; ?>
                    </button>
                </h2>
            <div id="collapseB<?php echo $branch; ?>" class="accordion-collapse collapse " aria-labelledby="headingB<?php echo $branch; ?>" data-bs-parent="#BranchAcc">
                <div class="accordion-body">
                      <div class="accordion" id="RegulationAcc">
              <?php  foreach($regulationArray as $k=>$regulation){  ?>           
                  <div class="accordion-item">
                      <h2 class="accordion-header " id="headingR<?php echo "$branch-$k"; ?>">
                        <button class="accordion-button collapsed bg-regulation" type="button" data-bs-toggle="collapse" data-bs-target="#collapseR<?php echo "$branch-$k"; ?>" aria-expanded="false" aria-controls="collapseR<?php echo "$branch-$k"; ?>">
                              <?php echo $regulation; ?>
                        </button>
                      </h2>
                  
                  <div id="collapseR<?php echo "$branch-$k"; ?>" class="accordion-collapse collapse " aria-labelledby="headingR<?php echo "$branch-$k"; ?>" data-bs-parent="#RegulationAcc">
                      <div class="accordion-body">
                          <div class="accordion" id="BatchAcc">
                              <?php foreach($result_arr[$regulation] as $k1=>$batch){   ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header " id="headingB<?php echo "$branch-$regulation-$k1"; ?>">
                                      <button class="accordion-button collapsed bg-batch" type="button" data-bs-toggle="collapse" data-bs-target="#collapseB<?php echo "$branch-$regulation-$k1"; ?>" aria-expanded="false" aria-controls="collapseB<?php echo "$branch-$regulation-$k1"; ?>">
                                        <?php echo $batch; ?>
                                      </button>
                                    </h2>
                                    <div id="collapseB<?php echo "$branch-$regulation-$k1"; ?>" class="accordion-collapse collapse " aria-labelledby="headingB<?php echo "$branch-$regulation-$k1"; ?>" data-bs-parent="#BatchAcc">
                                      <div class="accordion-body">
                                        <div class="accordion" id="SemesterAcc">
                                            <?php
                                              for($i=1;$i<=8;$i++){ ?>
                                                <div class="accordion-item">
                                                  <h2 class="accordion-header" id="headingS<?php echo "$branch-$regulation-$batch-$i"; ?>">
                                                    <button class="accordion-button collapsed bg-semester  Semester-dump" type="button"  data-regulation="<?php echo $regulation; ?>" data-batch="<?php echo $batch; ?>" data-semesterNo="<?php echo $i; ?>" data-branch="<?php echo $branch; ?>"  data-bs-toggle="collapse" data-bs-target="#collapseS<?php echo "$branch-$regulation-$batch-$i"; ?>" aria-expanded="false" aria-controls="collapseS<?php echo "$branch-$regulation-$batch-$i"; ?>">
                                                      <?php echo "Semester-$i"; ?>
                                                    </button>
                                                  </h2>
                                                  <div id="collapseS<?php echo "$branch-$regulation-$batch-$i"; ?>" class="accordion-collapse collapse " aria-labelledby="headingS<?php echo "$branch-$regulation-$batch-$i"; ?>" data-bs-parent="#SemesterAcc">
                                                     <div id="dump-<?php echo "$regulation-$batch-$branch-$i"; ?>" class="accordion-body"  >
                                                     <div class="loading" style="height:200px;"></div>    
                                                    </div>
                                                  </div>  
                                                </div>   
                    <?php                    }
                                            ?>
                                        </div>
                                      </div>
                                    </div> 
                                </div>
                    <?php      } ?>
                           </div>            
                        </div>
                    </div>
                  </div>
      <?php  }

      ?>
          </div>
                      </div>           
                  </div>
              </div>
         <?php   }     ?>
      </div>
      <?php     }else{  ?>

 
          <div class="accordion" id="RegulationAcc">
      <?php  foreach($regulationArray as $k=>$regulation){  ?>           
                  <div class="accordion-item">
                      <h2 class="accordion-header " id="headingR<?php echo $k; ?>">
                        <button class="accordion-button collapsed bg-regulation" type="button" data-bs-toggle="collapse" data-bs-target="#collapseR<?php echo $k; ?>" aria-expanded="false" aria-controls="collapseR<?php echo $k; ?>">
                              <?php echo $regulation; ?>
                        </button>
                      </h2>
                  
                  <div id="collapseR<?php echo $k; ?>" class="accordion-collapse collapse " aria-labelledby="headingR<?php echo $k; ?>" data-bs-parent="#RegulationAcc">
                      <div class="accordion-body">
                          <div class="accordion" id="BatchAcc">
                              <?php foreach($result_arr[$regulation] as $k1=>$batch){   ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header " id="headingB<?php echo "$regulation-$k1"; ?>">
                                      <button class="accordion-button collapsed bg-batch" type="button" data-bs-toggle="collapse" data-bs-target="#collapseB<?php echo "$regulation-$k1"; ?>" aria-expanded="false" aria-controls="collapseB<?php echo "$regulation-$k1"; ?>">
                                        <?php echo $batch; ?>
                                      </button>
                                    </h2>
                                    <div id="collapseB<?php echo "$regulation-$k1"; ?>" class="accordion-collapse collapse " aria-labelledby="headingB<?php echo "$regulation-$k1"; ?>" data-bs-parent="#BatchAcc">
                                      <div class="accordion-body">
                                        <div class="accordion" id="SemesterAcc">
                                            <?php
                                              for($i=1;$i<=8;$i++){ ?>
                                                <div class="accordion-item">
                                                  <h2 class="accordion-header" id="headingS<?php echo "$regulation-$batch-$i"; ?>">
                                                    <button class="accordion-button collapsed bg-semester  Semester-dump" type="button"  data-regulation="<?php echo $regulation; ?>" data-batch="<?php echo $batch; ?>" data-semesterNo="<?php echo $i; ?>" data-branch="<?php echo $branch; ?>"  data-bs-toggle="collapse" data-bs-target="#collapseS<?php echo "$regulation-$batch-$i"; ?>" aria-expanded="false" aria-controls="collapseS<?php echo "$regulation-$batch-$i"; ?>">
                                                      <?php echo "Semester-$i"; ?>
                                                    </button>
                                                  </h2>
                                                  <div id="collapseS<?php echo "$regulation-$batch-$i"; ?>" class="accordion-collapse collapse " aria-labelledby="headingS<?php echo "$regulation-$batch-$i"; ?>" data-bs-parent="#SemesterAcc">
                                                     <div id="dump-<?php echo "$regulation-$batch-$branch-$i"; ?>" class="accordion-body"  >
                                                     <div class="loading" style="height:200px;"></div>    
                                                    </div>
                                                  </div>  
                                                </div>   
                    <?php                    }
                                            ?>
                                        </div>
                                      </div>
                                    </div> 
                                </div>
                    <?php      } ?>
                           </div>            
                        </div>
                    </div>
                  </div>
      <?php  }

      ?>
          </div>


          <?php    }
      ?>
          <script>
            // var catweight = document.getElementById("ciewId");
            // var seeweight = document.getElementById("seeId");
            // var directco=document.getElementById("dcoId");
            // var indirectco=document.getElementById("icoId");
            // var level1=document.getElementById("level1Id");
            // var level2=document.getElementById("level2Id");
            // var level3=document.getElementById("level3Id");
            // var targetAttainment = document.getElementById("ftattId");

            //       $.ajax({
            //           url:'../scripts/weightAssignScript.php',
            //           type:'post',
            //           data:{check:1},
            //           beforeSend: function(){
            //             },
            //             success: function(response){
            //             // console.log(response);
            //              weightages=response; 
            //              if(weightages['ischeck']==1){
            //               catweight.value=weightages['catw'];
            //               seeweight.value=weightages['seew'];
            //               directco.value=weightages['codaw'];
            //               indirectco.value=weightages['coidaw'];
            //               level1.value=weightages['level1'];
            //               level2.value=weightages['level2'];
            //               level3.value=weightages['level3'];
            //               targetAttainment.value=weightages['cota'];

            //             }
                         
            //             },
            //             complete:function(data){     
            //             } 
            //             }); 


             $('.Semester-dump').click(async function(e){
               console.log(e);
             if(!e.target.className.includes('collapsed')){  
               let displayId=`dump-${this.dataset.regulation}-${this.dataset.batch}-${this.dataset.branch}-${this.dataset.semesterno}`;
                console.log(displayId);
                var response= fetch('../scripts/weightAssignScript.php')
               $.ajax({
                      url:'../scripts/get_courseTables.php',
                      type:'post',
                      data:{regulation:this.dataset.regulation,batch:this.dataset.batch,branch:this.dataset.branch,semesterNo:this.dataset.semesterno},
                      beforeSend: function(){
                          // $(`#${displayId}`).empty();
                          $(".loading").show();
                        },
                        success: function(response){
                          $(`#${displayId}`).empty();
                          $(`#${displayId}`).html(response);
                        },
                        complete:function(data){
                          $(".loading").hide();

                        } 
                  });
                }
              
              }); 
            
          </script>
      <?php
      
      
      
      
      
      
      
       
      } 
      else{
        echo '<p style="color:red;">There Is No Entry Of Batch ,Contact Admin</p>';
      }
    }else{
      echo '<p style="color:red;">Something Went Wrong Regrading branch ,Contact Admin</p>';
    }   
}
else{
  echo '<p style="color:red;">Something Went Wrong ,Contact Admin</p>';
}





?>
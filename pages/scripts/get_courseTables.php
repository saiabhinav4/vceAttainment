<?php
include '../common/connection.php';
$regulation=$batch=$branch=$semesterNo="";
// print_r($_POST); exit();
if(isset($_POST) and !empty($_POST)){
    if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
      if(isset($_POST['batch']) and !empty($_POST['batch'])){
        if(isset($_POST['branch']) and !empty($_POST['branch'])){
          if(isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){
              $regulation=$_POST['regulation'];
              $batch=$_POST['batch'];
              $branch=$_POST['branch'];
              $semesterNo=$_POST['semesterNo'];
              $retrive_weightages="select catw,seew,codaw,coidaw,level1,level2,level3,podaw,poidaw,pota,cota from academicyear ac, batchweightage b where ac.aid=b.aid and ayname='$batch' and branch='$branch'";
              $res=mysqli_query($con,$retrive_weightages) or die(mysqli_error($con));
              if(mysqli_num_rows($res)>0){
                $row=mysqli_fetch_row($res);
                $ciew=$row[0];
                $seew=$row[1];
                $targetA=$row[10];
                $directw=$row[2];
                $indirectw=$row[3];
                $level1=$row[4];
                $level2=$row[5];
                $level3=$row[6]; 
              
              //  $ciew=$_POST['ciew'];
              //  $seew=$_POST['seew'];
              //  $targetA=$_POST['targetA'];
              //  $directw=$_POST['directco'];
              //  $indirectw=$_POST['indirectco'];
              //  $level1=$_POST['level1'];
              //  $level2=$_POST['level2'];
              //  $level3=$_POST['level3']; 
               
               $retrive_courses="SELECT courseCode,courseName from coursedetails where regulation='$regulation' and academicYear='$batch' and branch='$branch' and semesterNo=$semesterNo order by courseCode,courseName";
               $result=mysqli_query($con,$retrive_courses) or die(mysqli_error($con));
                if(mysqli_num_rows($result)>0){   ?>
                        <div class="accordion" id="CourseAcc<?php echo "-$semesterNo"; ?>">  
                  <?php
                    $te=0;
                    while($row=mysqli_fetch_row($result)){
                        $te++;   
                      $courseCode=$row[0];
                      $courseName=$row[1];                 ?>
                         
                         <div class="accordion-item">
                              <h2 class="accordion-header" id="headingC<?php echo "$semesterNo-$te"; ?>">
                                <button class="accordion-button collapsed bg-courses" type="button" data-bs-toggle="collapse" data-bs-target="#collapseC<?php echo "$semesterNo-$te"; ?>" aria-expanded="false" aria-controls="collapseC<?php echo "$semesterNo-$te"; ?>">
                                      <?php echo "$courseName ($courseCode)"; ?>
                                </button>
                              </h2>
                              <div id="collapseC<?php echo "$semesterNo-$te"; ?>" class="accordion-collapse collapse " aria-labelledby="headingC<?php echo "$semesterNo-$te"; ?>" data-bs-parent="#CourseAcc<?php echo "-$semesterNo"; ?>">
                                  <div class="accordion-body">
                                    <?php
                                              $url="http://localhost/VCEStudentAttainment/simpleapi4.php?regulation=".$regulation."&academicYear=".$batch."&branch=".$branch."&semesterNo=".$semesterNo."&coursecode=".$courseCode."&catw=".$ciew."&seew=".$seew."&targetA=".$targetA."&directCO=".$directw."&indirectCO=".$indirectw."&level1=".$level1."&level2=".$level2."&level3=".$level3."&endpoint=COURSECOPDF";
                                              $data=file_get_contents($url);
                                              $decode_Data=json_decode($data,true);
                                              if(isset($decode_Data['error'])){
                                                echo '<p style="color:red;">'.$decode_Data['error'].'</p>';
                                            }
                                            else{
                                                $course=$decode_Data['courselist']['coursedetails'][0];
                                                $noofcos=$course['noofcos'];
                                                $ciew=$decode_Data['courselist']['CIEw'];
                                                $seew=$decode_Data['courselist']['SEEw'];
                                                $targetA=$decode_Data['courselist']['targetattainment'];
                                                $directco=$decode_Data['courselist']['codirectw'];
                                                $indirectco=$decode_Data['courselist']['coindirectw'];
                                                $struct=$course['structure'];
                                                $internal_h=$struct['internal'];
                                                $external_h=$struct['external'];  
                                                $ishaveAAT=$struct['ishaveaat'];
                                                $c_i=count($struct['internal']);
                                                $c_e=count($struct['external']);
                                                
                                                $internal_len=($c_i+ (($ishaveAAT==true)?1:0));
                                                $external_len=$c_e;

                                                if($internal_len==0 && $external_len!=0){
                                                  $seew+=$ciew;
                                                }else if($internal_len!=0 && $external_len==0 ){
                                                  $ciew+=$seew;
                                                }  
                                                

                                               ?>
                                               <div class="table-responsive m-3" >
                                                <table class="table table-bordered">
                                                    <thead>
                                                      <tr class="table-info">
                                                        <th rowspan="2">CO#</th>
                                                        <?php 
                                                           if($internal_len!=0){ ?>
                                                                  <th colspan="<?php echo $internal_len; ?>">Internal</th>
                                                    <?php       }
                                                        ?>
                                                         <?php 
                                                           if($external_len!=0){ ?>
                                                                  <th colspan="<?php echo $external_len; ?>">External</th>
                                                    <?php       }
                                                        ?>
                                                         <?php 
                                                           if($internal_len!=0){ ?>
                                                                  <th rowspan="2">100% of Internal (CIE)</th>
                                                    <?php       }
                                                        ?>
                                                         <?php 
                                                           if($external_len!=0){ ?>
                                                                  <th rowspan="2">100% of External (SEE)</th>
                                                    <?php       }
                                                        ?>

                                                    <?php 
                                                           if($internal_len!=0){ ?>
                                                                  <th rowspan="2"><?php echo $ciew; ?>% of Internal (CIE)</th>
                                                    <?php       }
                                                        ?>
                                                         <?php 
                                                           if($external_len!=0){ ?>
                                                                  <th rowspan="2"><?php echo $seew; ?>% of External (SEE)</th>
                                                    <?php       }
                                                        ?>      

                                                        <th rowspan="2">Total Direct CO (DA)</th>
                                                         <th rowspan="2">Total Indirect CO (IDA)</th>
                                                         <th rowspan="2"><?php echo $directco; ?>% Total Direct CO</th>
                                                         <th rowspan="2"><?php echo $indirectco; ?>% Total Indirect CO</th> 
                                                         <th rowspan="2">Total CO AT Through DA & IDA </th>
                                                         <th rowspan="2">Target AT</th>
                                                         <th rowspan="2">CO Attained(Y/N)</th>
                                                         <th rowspan="2">Levels</th>  
                                                      </tr>
                                                      <tr class="table-info">
                                                      <?php 
                                                           if($internal_len!=0){ 
                                                            foreach($internal_h as $k => $v){ ?>
                                                                  <th><?php echo $v; ?></th>
                                               <?php        }
                                                          }
                                                        ?>
                                                        <?php 
                                                           if($ishaveAAT){  ?>
                                                                 <th>AAT</th>       
                                          <?php             }
                                                        ?>
                                                        <?php 
                                                           if($external_len!=0){ 
                                                            foreach($external_h as $k => $v){ ?>
                                                                  <th><?php echo $v; ?></th>
                                               <?php        }
                                                          }
                                                        ?>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                            <?php
                                                                 for($i=1;$i<=$noofcos;$i++){ 
                                                                      $tem="CO".$i;
                                                                   ?>
                                                                    <tr class="table-info2">
                                                                        <td><?php echo "$courseCode.$i"; ?></td>
                                                                         <?php 
                                                                          if($internal_len!=0){
                                                                           foreach($course['internal'] as $type=>$val){
                                                                               if(array_key_exists($tem,$val)){  ?>
                                                                                 <td><?php echo $val[$tem]; ?></td>
                                                                      <?php    }
                                                                               else{  ?>
                                                                                    <td></td>
                                                                  <?php         }
                                                                           }
                                                                          }
                                                                         ?>
                                                                      <?php 
                                                                      if($external_len!=0){
                                                                           foreach($course['external'] as $type=>$val){
                                                                               if(array_key_exists($tem,$val)){  ?>
                                                                                 <td><?php echo $val[$tem]; ?></td>
                                                                      <?php    }
                                                                               else{  ?>
                                                                                    <td></td>
                                                                  <?php         }
                                                                           }
                                                                          }
                                                                         ?>
                                                                         
                                                                         <?php if($internal_len!=0) {
                                                                           ?>
                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['cie'])){
                                                                                echo $course['coattainment']['cie'][$tem];
                                                                            }
                                                                        ?></td>

                                                                        <?php } ?>
                                                                         
                                                                        <?php if($external_len!=0) {
                                                                           ?>
                                                                         <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['see'])){
                                                                                echo $course['coattainment']['see'][$tem];
                                                                            }
                                                                        ?></td>
                                                                        <?php } ?>

                                                                        <?php if($internal_len!=0) {
                                                                           ?>
                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['xcie'])){
                                                                                echo $course['coattainment']['xcie'][$tem];
                                                                            }
                                                                        ?></td>
                                                                         <?php } ?>
                                                                         <?php if($external_len!=0) {
                                                                           ?> 
                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['xsee'])){
                                                                                echo $course['coattainment']['xsee'][$tem];
                                                                            }
                                                                        ?></td>
                                                                         <?php } ?>

                                                                         <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['direct'])){
                                                                                echo $course['coattainment']['direct'][$tem];
                                                                            }
                                                                        ?></td>       

                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['indirect'])){
                                                                                echo $course['indirect'][$tem];
                                                                            }
                                                                        ?></td> 

                                                                          <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['xdirect'])){
                                                                                echo $course['coattainment']['xdirect'][$tem];
                                                                            }
                                                                        ?></td> 

                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['yindirect'])){
                                                                                echo $course['coattainment']['yindirect'][$tem];
                                                                            }
                                                                        ?></td> 

                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['totalattainment'])){
                                                                                echo $course['coattainment']['totalattainment'][$tem];
                                                                            }
                                                                        ?></td> 

                                                                        <td><?php echo $targetA; ?></td>
                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['attain_Y_N'])){
                                                                                echo $course['coattainment']['attain_Y_N'][$tem];
                                                                            }
                                                                        ?></td>  
                                                                        <td><?php 
                                                                            if( array_key_exists($tem,$course['coattainment']['levels'])){
                                                                                echo $course['coattainment']['levels'][$tem];
                                                                            }
                                                                        ?></td> 
                                                                    </tr>                 
                                                      <?php      }         
                                                            ?>
                                                    </tbody>
                                                </table>

                                               </div>     
                              <?php       }
                                     ?>
                                  </div>
                              </div>
                         </div>


      <?php           }  ?>

                        </div>

      <?php     }else{
                  echo '<p style="color:red;">Course List Empty.</p>';         
                } 
              }else{
                echo '<p style="color:red;">Weightage are not entered for these batch</p>'; 
              }
          }
          else{
            echo '<p style="color:red;">Something Went Wrong regrading semesterNo,Contact Admin!</p>'; 
          } 
        }
        else{
          echo '<p style="color:red;">Something Went Wrong regrading branch,Contact Admin!</p>'; 
        }     
      }
      else{
        echo '<p style="color:red;">Something Went Wrong regrading batch,Contact Admin!</p>'; 
      }    
    }
    else{
      echo '<p style="color:red;">Something Went Wrong regrading regulation,Contact Admin!</p>'; 
    }
}
else{
    echo '<p style="color:red;">Something Went Wrong,Contact Admin!</p>';
}







?>
<?php
$regulation=$academicYear=$branch=$semesterNo=$type=null;
$podirect=$poindirect=$pota=null;
if(isset($_POST)){
    if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
        if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
            if(isset($_POST['branch']) and !empty($_POST['branch'])){
                if(isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){
                    if(isset($_POST['directw']) and !empty($_POST['directw'])){
                        if(isset($_POST['indirectw']) and !empty($_POST['indirectw'])){
                            if(isset($_POST['target']) and !empty($_POST['target'])){
                                if(isset($_POST['type']) and !empty($_POST['type'])){
                                    if(isset($_POST['catw']) and !empty($_POST['catw'])){
                                    if(isset($_POST['seew']) and !empty($_POST['seew'])){
                                    if(isset($_POST['directco']) and !empty($_POST['directco'])){
                                    if(isset($_POST['indirectco']) and !empty($_POST['indirectco'])){
                                    if(isset($_POST['level1']) and !empty($_POST['level1'])){
                                    if(isset($_POST['level2']) and !empty($_POST['level2'])){
                                    if(isset($_POST['level3']) and !empty($_POST['level3'])){
                                    if(isset($_POST['targetAttainmentCO']) and !empty($_POST['targetAttainmentCO'])){
                                $regulation=$_POST['regulation'];
                                $academicYear=$_POST['academicYear'];
                                $branch=$_POST['branch'];
                                $semesterNo=$_POST['semesterNo'];
                                $podirect=$_POST['directw'];
                                $poindirect=$_POST['indirectw'];
                                $pota=$_POST['target'];
                                $type=$_POST['type'];
                                $ciew=$_POST['catw'];
                                $seew=$_POST['seew'];
                                $directco=$_POST['directco'];
                                $indirectco=$_POST['indirectco'];
                                $level1=$_POST['level1'];
                                $level2=$_POST['level2'];
                                $level3=$_POST['level3'];
                                $targetA_co=$_POST['targetAttainmentCO'];

                                 if($type=="direct"){    
                                  $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regulation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&catw=".$ciew."&seew=".$seew."&targetA=".$targetA_co."&directCO=".$directco."&indirectCO=".$indirectco."&level1=".$level1."&level2=".$level2."&level3=".$level3."&directw=".$podirect."&indirectw=".$poindirect."&target=".$pota."&endpoint=DIRECTPOATTAINMENT";
                                  $data=file_get_contents($url);
                                  $decode_Data=json_decode($data,true);
                                  if(isset($decode_Data['error'])){
                                    echo '<p style="color:red;">'.$decode_Data['error'].'</p>';
                                }
                                else{
                                    // print_r($decode_Data); exit();
                                    // foreach($decode_Data['Coursedetails'] as $key=>$val ){
                                        ?>
                        <div class="table-responsive"> 
                           <table id="example" class="table table-striped table-bordered dt-responsive nowrap">
                             <thead>
                             <tr class="table-info" >
                                <th>Sno</th>
                                <th>Course Name</th>
                                <th>Course Code</th>
                                <th>PO1</th>
                                <th>PO2</th>
                                <th>PO3</th>
                                <th>PO4</th>
                                <th>PO5</th>
                                <th>PO6</th>
                                <th>PO7</th>
                                <th>PO8</th>
                                <th>PO9</th>
                                <th>PO10</th>
                                <th>PO11</th>
                                <th>PO12</th>
                                <th>PSO1</th>
                                <th>PSO2</th>
                             </tr>     
                             </thead>
                             <tbody>
                                <?php 
                                  foreach($decode_Data['directpoAttainment'] as $key=>$val ){
                                 ?>       
                                    <tr  class="table-info2">
                                    <td><?php echo $key+1;?></td>
                                    <td><?php echo $val['coursename'];?></td>
                                    <td><?php echo $val['coursecode'];?></td>
                                    <?php 
                                  for($i=1;$i<=14;$i++){ 
                                            $tem="PO".$i;
                                            if($i==13){ $tem="PSO1"; }
                                            else if($i==14){ $tem="PSO2"; }  
                                            if( array_key_exists($tem,$val['pos'])) {
                                               ?>
                                         <td><?php if($val['pos'][$tem]!=0){echo $val['pos'][$tem]; }  ?></td>
                                  <?php 
                                            }
                                            else{  ?>
                                        <td></td>                         
                                  <?php          }
                                }    ?>
                                    </tr>
                                 <?php   
                                  } 
                                ?>
                                 <tr class="table-info2" id="lastrow"><td colspan="3" style="text-align:center">Overal PO At in % </td>
                                    <?php for($i=1;$i<=14;$i++){ $tem="PO".$i;
                                              if($i==13){ $tem="PSO1"; }
                                            else if($i==14){ $tem="PSO2"; }  
                                            if( array_key_exists($tem,$decode_Data['overall'])) {    
                                        ?>
                                           <td><?php if($decode_Data['overall'][$tem]!=0){echo $decode_Data['overall'][$tem];} ?></td>  
                                    <?php }
                                        else { ?>
                                            <td></td>
                                    <?php    }
                                    } 
                                    ?>

                                </tr>
                             </tbody>
                           </table>
                        </div>
                                    <?php
                                    // }  
                                    // print_r($decode_Data);
                                   }
                                  }
                                  else if($type=="indirect"){
                                        $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regulation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&catw=".$ciew."&seew=".$seew."&targetA=".$targetA_co."&directCO=".$directco."&indirectCO=".$indirectco."&level1=".$level1."&level2=".$level2."&level3=".$level3."&directw=".$podirect."&indirectw=".$poindirect."&target=".$pota."&endpoint=INDIRECTPOATTAINMENT";
                                        $data=file_get_contents($url);
                                        $decode_Data=json_decode($data,true);
                                        if(isset($decode_Data['error'])){
                                        echo '<p style="color:red;">'.$decode_Data['error'].'</p>';
                                        }
                                        else{
                                            ?>
                                            <div class="table-responsive"> 
                                                <table id="example" class="table table-striped table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr class="table-info">
                                                        <th>Sno</th>
                                                        <th>Survey</th>
                                                        <th>PO1</th>
                                                        <th>PO2</th>
                                                        <th>PO3</th>
                                                        <th>PO4</th>
                                                        <th>PO5</th>
                                                        <th>PO6</th>
                                                        <th>PO7</th>
                                                        <th>PO8</th>
                                                        <th>PO9</th>
                                                        <th>PO10</th>
                                                        <th>PO11</th>
                                                        <th>PO12</th>
                                                        <th>PSO1</th>
                                                        <th>PSO2</th>
                                                    </tr>        
                                                    </thead>
                                                    <tbody>
                                                        <tr class="table-info2">
                                                            <td>1</td>
                                                            <td>Co-Curricular Activities</td>
                                                        <?php for($i=1;$i<=14;$i++){ 
                                                            $tem="PO".$i;
                                                            if($i==13){$tem="PSO1";}
                                                            if($i==14){$tem="PSO2";} 
                                                            ?>
                                                             <td><?php if( array_key_exists($tem,$decode_Data['co_curricular']) ){  echo $decode_Data['co_curricular'][$tem]; } ?></td>   
                                                            <?php
                                                         }   ?>
                                                        </tr> 
                                                        <tr class="table-info2">
                                                            <td>2</td>
                                                            <td>Extra-Curricular Activities</td>
                                                        <?php for($i=1;$i<=14;$i++){ 
                                                            $tem="PO".$i;
                                                            if($i==13){$tem="PSO1";}
                                                            if($i==14){$tem="PSO2";} 
                                                            ?>
                                                             <td><?php if( array_key_exists($tem,$decode_Data['extra_curricular']) ){ echo $decode_Data['extra_curricular'][$tem]; } ?></td>   
                                                            <?php
                                                         }   ?>
                                                        </tr>   
                                                        <tr class="table-info2">
                                                            <td>3</td>
                                                            <td>Student Exit Survey</td>
                                                        <?php for($i=1;$i<=14;$i++){ 
                                                            $tem="PO".$i;
                                                            if($i==13){$tem="PSO1";}
                                                            if($i==14){$tem="PSO2";} 
                                                            ?>
                                                             <td><?php if( array_key_exists($tem,$decode_Data['student_exit']) ){  echo $decode_Data['student_exit'][$tem]; } ?></td>   
                                                            <?php
                                                         }   ?>
                                                        </tr>
                                                        <tr class="table-info2">
                                                           <td  style="text-align:center" colspan="2">Total PO & PSO Attainment in Levels Through Indirect Assessment</td>
                                                           <?php for($i=1;$i<=14;$i++){ 
                                                            $tem="PO".$i;
                                                            if($i==13){$tem="PSO1";}
                                                            if($i==14){$tem="PSO2";} 
                                                            ?>
                                                             <td><?php  if( array_key_exists($tem,$decode_Data['total']) ){   echo $decode_Data['total'][$tem]; } ?></td>   
                                                            <?php
                                                         }   ?>
                                                        </tr>   
                                                    </tbody>
                                                </table>
                                            </div>   
                                        <?php
                                        }
                                  }
                                  else if($type=="overallpo"){
                                    $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regulation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&catw=".$ciew."&seew=".$seew."&targetA=".$targetA_co."&directCO=".$directco."&indirectCO=".$indirectco."&level1=".$level1."&level2=".$level2."&level3=".$level3."&directw=".$podirect."&indirectw=".$poindirect."&target=".$pota."&endpoint=OVERALLPOATTAINMENT";
                                    $data=file_get_contents($url);
                                    $decode_Data=json_decode($data,true);
                                        if(isset($decode_Data['error'])){
                                            echo '<p style="color:red;">'.$decode_Data['error'].'</p>';
                                        }
                                        else{
                                            ?>
                                                 <table id="example" class="table table-striped table-bordered dt-responsive nowrap">
                                                    <thead>
                                                    <tr class="table-info">
                                                        <th>Program Outcomes</th>
                                                        <th>Attainment Through Direct Assessment (100%)</th>
                                                        <th>Attainment Through Direct Assessment  (<?php echo $decode_Data['directw'] ?>%)</th>
                                                        <th>Attainment Through InDirect Assessment (100%)</th>
                                                        <th>Attainment Through InDirect Assessment (<?php echo $decode_Data['indirectw'] ?>%)</th>
                                                        <th>Overall Attainment</th>
                                                        <th>Target</th>
                                                        <th>Attained (YES/NO)</th>
                                                    </tr>        
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                                for($i=1;$i<=14;$i++){
                                                                      $tem="PO".$i;
                                                                      if($i==13){
                                                                          $tem="PSO1";
                                                                      }
                                                                      else if($i==14){
                                                                          $tem="PSO2";
                                                                      }
                                                                  ?>
                                                                    <tr class="table-info2">
                                                                        <td><?php echo $tem;?></td>
                                                                        <td><?php if(  array_key_exists($tem,$decode_Data['direct_assessment']) ){ echo $decode_Data['direct_assessment'][$tem];} ?></td>
                                                                        <td><?php if(  array_key_exists($tem,$decode_Data['xdirect_assessment']) ){ echo $decode_Data['xdirect_assessment'][$tem];} ?></td>
                                                                        <td><?php if(  array_key_exists($tem,$decode_Data['indirect_assessment']) ){ echo $decode_Data['indirect_assessment'][$tem];} ?></td>
                                                                        <td><?php if(  array_key_exists($tem,$decode_Data['ydirect_assessment']) ){ echo $decode_Data['ydirect_assessment'][$tem];} ?></td>
                                                                        <td><?php if(  array_key_exists($tem,$decode_Data['overall_assessment']) ){ echo $decode_Data['overall_assessment'][$tem];} ?></td>
                                                                        <td><?php if($decode_Data['target']!=0){echo $decode_Data['target']; }?></td>
                                                                        <td><?php if(  array_key_exists($tem,$decode_Data['attainmed']) ){ echo $decode_Data['attainmed'][$tem];} ?></td>
                                                                    </tr>
                                                                  <?php

                                                                }
                                                        ?>
                                                    </tbody>
                                                 </table> 
                                            <?php
                                        }
                                  }             
                                                            }
                                                            else{
                                                                echo "CO targetAttainment is empty";    
                                                            }
                                                        }
                                                        else{
                                                            echo "level-3 is empty";
                                                        }
                                                    }
                                                    else{
                                                        echo "level-2 is empty";
                                                    }   
                                                }
                                                else{
                                                    echo "level-1 is empty";
                                                }
                                            }
                                            else{
                                                echo "indirectCO weightage is empty";
                                            }
                                        }
                                        else{
                                            echo "directCO weightage is empty";
                                        }
                                    }
                                    else{
                                        echo "SEE weightage is empty";
                                    }

                                 }
                                 else{
                                    echo "CIE weightage is empty";
                                 }

                                }
                                else{
                                    echo "PO type is empty";
                                }
                            }
                            else{
                                echo "target is empty";
                            }
                        }
                        else{
                            echo "indirect po weight is empty";
                        }
                    }else{
                        echo "direct po weight is empty";
                    }
                }
                else{
                    echo "semesterNo is empty";
                }
            }
            else{
               echo "branch is empty";
            }
        }
        else{
            echo "batch is empty";
        }
    }
    else{
        echo "regulation empty";    
    }
}
else{
    echo "plz refresh the page and try";
}






?>
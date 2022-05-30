<?php 
// print_r($_POST);exit();
$regualation=$academicYear=$branch=$semesterNo=$catweight=$seeweight=$targetAttainment=null;
$directw=$indirectw=$level1w=$level2w=$level3w=null;
$data=null;
$global_sno=0;
if(isset($_POST)){
    if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
        if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
            if(isset($_POST['branch']) and !empty($_POST['branch'])){
                if(isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){
                   if(isset($_POST['ischeck']) and $_POST['ischeck']==0){    
                   
                    if(isset($_POST['catw']) and !empty($_POST['catw'])){
                        if(isset($_POST['seew']) and !empty($_POST['seew'])){
                            if(isset($_POST['targetA']) and !empty($_POST['targetA'])){
                                if(isset($_POST['directCO']) and !empty($_POST['directCO'])){
                                    if(isset($_POST['indirectCO']) and  !empty($_POST['indirectCO'])){
                                        if(isset($_POST['level1']) and !empty($_POST['level1'])){
                                            if(isset($_POST['level2']) and !empty($_POST['level2'])){
                                                if(isset($_POST['level3']) and !empty($_POST['level3'])){
                                                    $regualation=$_POST['regulation'];
                                                    $academicYear=$_POST['academicYear'];
                                                    $branch=$_POST['branch'];
                                                    $semesterNo=$_POST['semesterNo'];
                                                    $catweight=$_POST['catw'];
                                                    $seeweight=$_POST['seew'];
                                                    $targetAttainment=$_POST['targetA'];
                                                    $directw=$_POST['directCO'];
                                                    $indirectw=$_POST['indirectCO'];
                                                    $level1w=$_POST['level1'];
                                                    $level2w=$_POST['level2'];
                                                    $level3w=$_POST['level3'];
                                                    $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regualation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&catw=".$catweight."&seew=".$seeweight."&targetA=".$targetAttainment."&directCO=".$directw."&indirectCO=".$indirectw."&level1=".$level1w."&level2=".$level2w."&level3=".$level3w."&endpoint=COATTAINMENT";
                                                    $data=file_get_contents($url);
                                                    $decode_Data=json_decode($data,true);
                                                    // print_r($decode_Data); exit();  
                                                    if(isset($decode_Data['error'])){
                                                        echo '<p style="color:red;">'.$decode_Data['error'].'</p>';
                                                    }
                                                    else{
                                                        // print_r($decode_Data);
                                                        // foreach($decode_Data as $key=>$val){
                                                            $in_t=0;
                                                            $in_p=0;
                                                            $ex_t=0;
                                                            $ex_p=0;
                                                            $in_t_A=array();
                                                            $in_p_A=array();
                                                            $ex_t_A=array();
                                                            $ex_p_A=array();
                                                            $check_aat=false;
                                                            $internal_cp=0;
                                                            $external_cp=0;
                                                        foreach($decode_Data['coursedetails'] as $k=>$val){
                                                                if($val['structure']['type']=="theoretical"){
                                                                       if($val['structure']['ishaveinternal']){
                                                                           $in_t=max($in_t,count($val['structure']['internal_theory_short']));
                                                                           foreach($val['structure']['internal_theory_short'] as $ke=>$v){
                                                                                 if( in_array($v,$in_t_A)==false ){
                                                                                        array_push($in_t_A,$v);
                                                                                 }
                                                                           }
                                                                       }
                                                                       if($val['structure']['ishaveexternal']){
                                                                            $ex_t=max($ex_t,count($val['structure']['external_theory_short']));
                                                                            foreach($val['structure']['external_theory_short'] as $ke=>$v){
                                                                                if( in_array($v,$ex_t_A)==false ){
                                                                                       array_push($ex_t_A,$v);
                                                                                }
                                                                          }
                                                                       }
                                                                       if($val['structure']['ishaveaat']){
                                                                            $check_aat=true;
                                                                       } 
                                                                }
                                                                else if($val['structure']['type']=="practical"){
                                                                    if($val['structure']['ishaveinternal']){
                                                                        $in_p=max($in_p,count($val['structure']['internal_practical_short']));
                                                                        foreach($val['structure']['internal_practical_short'] as $ke=>$v){
                                                                            if( in_array($v,$in_p_A)==false ){
                                                                                   array_push($in_p_A,$v);
                                                                            }
                                                                      }
                                                                    }
                                                                    if($val['structure']['ishaveexternal']){
                                                                         $ex_p=max($ex_p,count($val['structure']['external_practical_short']));
                                                                         foreach($val['structure']['external_practical_short'] as $ke=>$v){
                                                                            if( in_array($v,$ex_p_A)==false ){
                                                                                   array_push($ex_p_A,$v);
                                                                            }
                                                                      }
                                                                    }
                                                                    if($val['structure']['ishaveaat']){
                                                                         $check_aat=true;
                                                                    }    
                                                                }
                                                                else if($val['structure']['type']=="both"){
                                                                    if($val['structure']['ishaveinternal']){
                                                                        $in_t=max($in_t,count($val['structure']['internal_theory_short']));
                                                                        foreach($val['structure']['internal_theory_short'] as $ke=>$v){
                                                                            if( in_array($v,$in_t_A)==false ){
                                                                                   array_push($in_t_A,$v);
                                                                            }
                                                                      }
                                                                        $in_p=max($in_p,count($val['structure']['internal_practical_short']));
                                                                        foreach($val['structure']['internal_practical_short'] as $ke=>$v){
                                                                            if( in_array($v,$in_p_A)==false ){
                                                                                   array_push($in_p_A,$v);
                                                                            }
                                                                      }
                                                                    }
                                                                    if($val['structure']['ishaveexternal']){
                                                                         $ex_t=max($ex_t,count($val['structure']['external_theory_short']));
                                                                         foreach($val['structure']['external_theory_short'] as $ke=>$v){
                                                                            if( in_array($v,$ex_t_A)==false ){
                                                                                   array_push($ex_t_A,$v);
                                                                            }
                                                                      }
                                                                         $ex_p=max($ex_p,count($val['structure']['external_practical_short']));
                                                                         foreach($val['structure']['external_practical_short'] as $ke=>$v){
                                                                            if( in_array($v,$ex_p_A)==false ){
                                                                                   array_push($ex_p_A,$v);
                                                                            }
                                                                      }
                                                                    }
                                                                    if($val['structure']['ishaveaat']){
                                                                         $check_aat=true;
                                                                    }     
                                                                }
                                                        } 

                                                           //calculate internal colspan
                                                            if($in_t!=0){
                                                                $internal_cp+=$in_t;
                                                            } 
                                                            else{
                                                                $internal_cp+=1;
                                                            }
                                                            if($in_p!=0){
                                                                $internal_cp+=$in_p;
                                                            }
                                                            else{
                                                                $internal_cp+=1;
                                                            }

                                                        //    $internal_cp=$in_t+$in_p;

                                                           if($check_aat){ $internal_cp++; }

                                                           if($ex_t!=0){
                                                               $external_cp+=$ex_t;
                                                           }
                                                           else{
                                                               $external_cp+=1;
                                                           }
                                                           if($ex_p!=0){
                                                               $external_cp+=$ex_p;
                                                           }
                                                           else{
                                                               $external_cp+=1;
                                                           }

                                                        //    $external_cp=$ex_t+$ex_p; 
                                                           
                                                           
                                                           // print_r($in_t);print_r($in_p);print_r($ex_t);print_r($ex_p);print_r($internal_cp);print_r($external_cp); exit();
                                                               ?>
                                                            <h4>OverAll CO Attainment</h4>   
                                                           <div id="cpdf" class="table-responsive"> 
                                                            <table id="tcdemo" class="table" border="1px">
                                                                <thead>
                                                                    <tr>
                                                                    <th rowspan="3">sno</th>
                                                                    <th  rowspan="3">Course Name</th>
                                                                    <th  rowspan="3">CO#</th>
                                                                    
                                                                    <th colspan="<?php if($internal_cp!=0){ echo $internal_cp;}else{ echo 2;} ?>">Internal (CIE)</th>
                                                                    <th colspan="<?php if($external_cp<1){ echo $external_cp;}else{ echo 2; } ?>">External (SEE)</th>
                                                                    <th  rowspan="3">100% of Internal (CIE)</th>
                                                                    <th  rowspan="3">100% of External (SEE)</th>
                                                                    <th  rowspan="3"><?php echo $decode_Data['CIEw'];  ?>% of Internal (CIE)</th>
                                                                    <th  rowspan="3"><?php echo $decode_Data['SEEw'];  ?>% of External (SEE)</th>
                                                                    <th  rowspan="3">Total Direct CO </th>
                                                                    <th  rowspan="3">Total InDirect CO</th>
                                                                    <th  rowspan="3"><?php echo $decode_Data['codirectw'];  ?>% Total Direct CO</th>
                                                                    <th  rowspan="3"><?php echo $decode_Data['coindirectw'];  ?>% Total InDirect CO</th>
                                                                    <th  rowspan="3">Total CO AT Through DA&IDA </th>
                                                                    <th  rowspan="3">Target AT</th>
                                                                    <th  rowspan="3">CO Attained(Y/N)</th>  
                                                                    <th  rowspan="3">Levels</th> 
                                                                    </tr>
                                                                    <tr>
                                                                          <th colspan="<?php if($in_t!=0){ echo $in_t; } else{ echo 0; }?>">Theory</th>
                                                                          <th colspan="<?php if($in_p!=0){ echo $in_p; }else{ echo 0; } ?>">Practical</th>
                                                                          <?php if($check_aat){ ?>
                                                                            <th >AAT</th>
                                                                          <?php } ?>  
                                                                          <th colspan="<?php if($ex_t!=0){ echo $ex_t;} else{ echo 0; } ?>">Theory</th>
                                                                          <th colspan="<?php if($ex_p!=0){ echo $ex_p; }else{ echo 0; } ?>">Practical</th>
                                                                    </tr>
                                                                    <tr>
                                                                    <?php  if(count($in_t_A)!=0){    foreach($in_t_A as $k1=>$v1){ ?>
                                                                                <td><?php echo $v1; ?></td>
                                                                         <?php }  } else { ?>  <td></td>   <?php     }  ?> 
                                                                         <?php  if(count($in_p_A)!=0){    foreach($in_p_A as $k1=>$v1){ ?>
                                                                                <td><?php echo $v1; ?></td>
                                                                         <?php }  } else { ?>  <td></td>   <?php     }  ?>
                                                                         <?php
                                                                            if($check_aat){ ?>  <td></td>  <?php     } ?>   
                                                                         <?php  if(count($ex_t_A)!=0){    foreach($ex_t_A as $k1=>$v1){ ?>
                                                                                <td><?php echo $v1; ?></td>
                                                                         <?php }  } else { ?>  <td></td>   <?php     }  ?>      
                                                                         <?php  if(count($ex_p_A)!=0){    foreach($ex_p_A as $k1=>$v1){ ?>
                                                                                <td><?php echo $v1; ?></td>
                                                                         <?php }  } else { ?>  <td></td>   <?php     }  ?>
                                                                    </tr>
                                                                    <!-- <tr>
                                                                        <th>CAT1</th>
                                                                        <th>CAT2</th>
                                                                        <th>AAT</th>
                                                                        <th>CAT1</th>
                                                                        <th>CAT2</th>
                                                                        <th>SEE</th>
                                                                    </tr> -->
                                                                </thead>
                                                                <tbody>
                                                                <?php  
                                                                  foreach($decode_Data['coursedetails'] as $key=>$val){
                                                                      if($val['structure']['type']!="project"){
                                                                        $global_sno++;
                                                                      for($i=0;$i<$val['noofcos'];$i++){
                                                                        $tem="CO".($i+1); 
                                                                        if($i==0){
                                                                            ?>
                                                                             <tr <?php echo 'rowspan="'.($val['noofcos']).'"'; ?>>
                                                                                <td <?php echo 'rowspan="'.($val['noofcos']).'"'; ?> > <?php echo $global_sno; ?> </td>
                                                                                <td <?php echo 'rowspan="'.($val['noofcos']).'"'; ?> > <?php echo $val['coursename']; ?> </td>
                                                                                <td><?php  echo $val['coursecode'].".".($i+1);  ?></td>
                                                                                <!--   internal theory      -->
                                                                                <?php if( count($in_t_A)!=0 ){
                                                                                    foreach($in_t_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['internal'])){
                                                                                            if( array_key_exists($tem,$val['internal'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['internal'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                <!--  internal practical   -->

                                                                                <?php if( count($in_p_A)!=0 ){
                                                                                    foreach($in_p_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['internal'])){
                                                                                            if( array_key_exists($tem,$val['internal'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['internal'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                <!--  AAT  -->
                                                                                 <?php   if($check_aat){  
                                                                                            if(  array_key_exists("aat",$val['internal'] )){
                                                                                                  if( array_key_exists($tem,$val['internal']['aat'] ) ){  ?>
                                                                                                            <td><?php echo $val['internal']['aat'][$tem]; ?></td>
                                                                                              <?php    }
                                                                                                  else{  ?>
                                                                                                            <td></td>
                                                                                             <?php     }                     
                                                                                            }
                                                                                            else{     ?>
                                                                                                            <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{   ?>
                                                                                                          <td></td>                
                                                                                    <?php    }            
                                                                                  ?>  
                                                                                  
                                                                                <!--  external theory   -->
                                                                                <?php if( count($ex_t_A)!=0 ){
                                                                                    foreach($ex_t_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['external'])){
                                                                                            if( array_key_exists($tem,$val['external'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['external'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                <!-- external Practical  -->

                                                                                <?php if( count($ex_p_A)!=0 ){
                                                                                    foreach($ex_p_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['external'])){
                                                                                            if( array_key_exists($tem,$val['external'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['external'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['cie'])){ echo $val['coattainment']['cie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['see'])){ echo $val['coattainment']['see'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xcie'])){ echo $val['coattainment']['xcie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xsee'])){ echo $val['coattainment']['xsee'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['direct'])){ echo $val['coattainment']['direct'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['indirect'])){ echo $val['indirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xdirect'])){ echo $val['coattainment']['xdirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['yindirect'])){ echo $val['coattainment']['yindirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['totalattainment'])){ echo $val['coattainment']['totalattainment'][$tem];  } ?>  </td>
                                                                                <td><?php  echo $decode_Data['targetattainment'];?></td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['attain_Y_N'])){ echo $val['coattainment']['attain_Y_N'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['levels'])){ echo $val['coattainment']['levels'][$tem];  } ?>  </td>
                                                                                
                                                                              
                                                                             </tr>           
                                                                            <?php
                                                                        }
                                                                        else{
                                                                            ?>
                                                                            <tr>
                                                                            <td><?php  echo $val['coursecode'].".".($i+1);  ?></td>
                                                                                <!--   internal theory      -->
                                                                                <?php if( count($in_t_A)!=0 ){
                                                                                    foreach($in_t_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['internal'])){
                                                                                            if( array_key_exists($tem,$val['internal'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['internal'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                <!--  internal practical   -->

                                                                                <?php if( count($in_p_A)!=0 ){
                                                                                    foreach($in_p_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['internal'])){
                                                                                            if( array_key_exists($tem,$val['internal'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['internal'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                <!--  AAT  -->
                                                                                 <?php   if($check_aat){  
                                                                                            if(  array_key_exists("aat",$val['internal'] )){
                                                                                                  if( array_key_exists($tem,$val['internal']['aat'] ) ){  ?>
                                                                                                            <td><?php echo $val['internal']['aat'][$tem]; ?></td>
                                                                                              <?php    }
                                                                                                  else{  ?>
                                                                                                            <td></td>
                                                                                             <?php     }                     
                                                                                            }
                                                                                            else{     ?>
                                                                                                            <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{   ?>
                                                                                                          <td></td>                
                                                                                    <?php    }            
                                                                                  ?>  
                                                                                  
                                                                                <!--  external theory   -->
                                                                                <?php if( count($ex_t_A)!=0 ){
                                                                                    foreach($ex_t_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['external'])){
                                                                                            if( array_key_exists($tem,$val['external'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['external'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                <!-- external Practical  -->

                                                                                <?php if( count($ex_p_A)!=0 ){
                                                                                    foreach($ex_p_A as $k=>$v){
                                                                                        if( array_key_exists($v,$val['external'])){
                                                                                            if( array_key_exists($tem,$val['external'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['external'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                                
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['cie'])){ echo $val['coattainment']['cie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['see'])){ echo $val['coattainment']['see'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xcie'])){ echo $val['coattainment']['xcie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xsee'])){ echo $val['coattainment']['xsee'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['direct'])){ echo $val['coattainment']['direct'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['indirect'])){ echo $val['indirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xdirect'])){ echo $val['coattainment']['xdirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['yindirect'])){ echo $val['coattainment']['yindirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['totalattainment'])){ echo $val['coattainment']['totalattainment'][$tem];  } ?>  </td>
                                                                                <td><?php  echo $decode_Data['targetattainment'];?></td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['attain_Y_N'])){ echo $val['coattainment']['attain_Y_N'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['levels'])){ echo $val['coattainment']['levels'][$tem];  } ?>  </td>
                                                                                
                                                                            </tr>

                                                                            <?php
                                                                        }
                                                                      } 
                                                                    }
                                                                  }
                                                                ?>
                                                                </tbody>
                                                                </table>
                                                           </div> 
                                                           
                                                           <br><br> 

                                                           


                                                           <h4>OverAll CO Attainment (Projects)</h4>   

                                                           <?php  
                                                            foreach($decode_Data['coursedetails'] as $k=>$val){
                                                                if($val['structure']['type']=="project"){
                                                                    $global_sno++;
                                                                    $in=0;
                                                                    $ex=0;
                                                                    if($val['structure']['ishaveinternal']){
                                                                            $in=count($val['structure']['internal']);    
                                                                    }
                                                                    if($val['structure']['ishaveexternal']){
                                                                            $ex=count($val['structure']['internal']);
                                                                    }

                                                                    
                                                            
                                                           ?>

                                                           <div id="cpdf" class="table-responsive"> 

                                                              <table id="tcdemo" class="table" border="1px">
                                                                <thead>
                                                                    <tr>
                                                                    <th rowspan="2">sno</th>
                                                                    <th rowspan="2">Course Name</th>
                                                                    <th rowspan="2">CO#</th>
                                                                    <th colspan="<?php if($in!=0){ echo $in; }else{ echo 1; } ?>">Internal Reviews</th>
                                                                    <th rowspan="<?php if($ex!=0){ echo $ex; }else{ echo 1; } ?>">External</th>
                                                                    <th  rowspan="2">100% of Internal (CIE)</th>
                                                                    <th  rowspan="2">100% of External (SEE)</th>
                                                                    <th  rowspan="2"><?php echo $decode_Data['CIEw'];  ?>% of Internal (CIE)</th>
                                                                    <th  rowspan="2"><?php echo $decode_Data['SEEw'];  ?>% of External (SEE)</th>
                                                                    <th  rowspan="2">Total Direct CO </th>
                                                                    <th  rowspan="2">Total InDirect CO</th>
                                                                    <th  rowspan="2"><?php echo $decode_Data['codirectw'];  ?>% Total Direct CO</th>
                                                                    <th  rowspan="2"><?php echo $decode_Data['coindirectw'];  ?>% Total InDirect CO</th>
                                                                    <th  rowspan="2">Total CO AT Through DA&IDA </th>
                                                                    <th  rowspan="2">Target AT</th>
                                                                    <th  rowspan="2">CO Attained(Y/N)</th>  
                                                                    <th  rowspan="2">Levels</th> 
                                                                   </tr> 
                                                                   <tr>
                                                                       <!-- <th></th> -->
                                                                        <!-- <th>ALR</th>
                                                                        <th >ILR</th>
                                                                        <th >PCR</th> -->
                                                                        <?php  if(count($val['structure']['internal'])!=0){    foreach($val['structure']['internal'] as $k1=>$v1){ ?>
                                                                                <td><?php echo $v1; ?></td>
                                                                         <?php }  } else { ?>  <td></td>   <?php     }  ?> 
                                                                         <?php  if(count($val['structure']['external'])!=0){    foreach($val['structure']['external'] as $k1=>$v1){ ?>
                                                                                <td><?php echo $v1; ?></td>
                                                                         <?php }  } else { ?>  <td></td>   <?php     }  ?> 

                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                  <?php // print_r($val['noofcos']);exit();
                                                                    for($i=0;$i<$val['noofcos'];$i++){
                                                                      $tem="CO".($i+1);
                                                                      if($i==0){
                                                                        ?>
                                                                         <tr <?php echo 'rowspan="'.($val['noofcos']).'"'; ?>>
                                                                            <td <?php echo 'rowspan="'.($val['noofcos']).'"'; ?> > <?php echo $global_sno; ?> </td>
                                                                            <td <?php echo 'rowspan="'.($val['noofcos']).'"'; ?> > <?php echo $val['coursename']; ?> </td>
                                                                            <td><?php  echo $val['coursecode'].".".($i+1);  ?></td>
                                                                            <!-- internal -->
                                                                            <?php if( count($val['structure']['internal'])!=0 ){
                                                                                    foreach($val['structure']['internal'] as $k=>$v){
                                                                                        if( array_key_exists($v,$val['internal'])){
                                                                                            if( array_key_exists($tem,$val['internal'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['internal'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                            <!-- external  -->
                                                                            <?php if( count($val['structure']['external'])!=0 ){
                                                                                    foreach($val['structure']['external'] as $k=>$v){
                                                                                        if( array_key_exists($v,$val['external'])){
                                                                                            if( array_key_exists($tem,$val['external'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['external'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>    


                                                                          
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['cie'])){ echo $val['coattainment']['cie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['see'])){ echo $val['coattainment']['see'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xcie'])){ echo $val['coattainment']['xcie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xsee'])){ echo $val['coattainment']['xsee'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['direct'])){ echo $val['coattainment']['direct'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['indirect'])){ echo $val['indirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xdirect'])){ echo $val['coattainment']['xdirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['yindirect'])){ echo $val['coattainment']['yindirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['totalattainment'])){ echo $val['coattainment']['totalattainment'][$tem];  } ?>  </td>
                                                                                <td><?php  echo $decode_Data['targetattainment'];?></td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['attain_Y_N'])){ echo $val['coattainment']['attain_Y_N'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['levels'])){ echo $val['coattainment']['levels'][$tem];  } ?>  </td>

                                                                         </tr>           
                                                                        <?php
                                                                    }
                                                                    else{
                                                                        ?>
                                                                        <tr>
                                                                        <td><?php  echo $val['coursecode'].".".($i+1);  ?></td>
                                                                        <!-- internal -->
                                                                        <?php if( count($val['structure']['internal'])!=0 ){
                                                                                    foreach($val['structure']['internal'] as $k=>$v){
                                                                                        if( array_key_exists($v,$val['internal'])){
                                                                                            if( array_key_exists($tem,$val['internal'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['internal'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>
                                                                            <!-- external  -->
                                                                            <?php if( count($val['structure']['external'])!=0 ){
                                                                                    foreach($val['structure']['external'] as $k=>$v){
                                                                                        if( array_key_exists($v,$val['external'])){
                                                                                            if( array_key_exists($tem,$val['external'][$v]) ){ ?>
                                                                                                    <td><?php echo $val['external'][$v][$tem]; ?></td>
                                                                                          <?php  }
                                                                                            else{ ?>
                                                                                                    <td></td>
                                                                                        <?php    }
                                                                                        }
                                                                                        else{  ?>
                                                                                                    <td></td>
                                                                                    <?php    }
                                                                                    }
                                                                                }
                                                                                else{ ?>
                                                                                    <td></td>
                                                                                <?php }   
                                                                                ?>    


                                                                          
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['cie'])){ echo $val['coattainment']['cie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['see'])){ echo $val['coattainment']['see'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xcie'])){ echo $val['coattainment']['xcie'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xsee'])){ echo $val['coattainment']['xsee'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['direct'])){ echo $val['coattainment']['direct'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['indirect'])){ echo $val['indirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['xdirect'])){ echo $val['coattainment']['xdirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['yindirect'])){ echo $val['coattainment']['yindirect'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['totalattainment'])){ echo $val['coattainment']['totalattainment'][$tem];  } ?>  </td>
                                                                                <td><?php  echo $decode_Data['targetattainment'];?></td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['attain_Y_N'])){ echo $val['coattainment']['attain_Y_N'][$tem];  } ?>  </td>
                                                                                <td>  <?php if(array_key_exists($tem,$val['coattainment']['levels'])){ echo $val['coattainment']['levels'][$tem];  } ?>  </td>
                                                                        </tr>

                                                                        <?php
                                                                    





                                                                    }
                                                                   }
                                                                 
                                                                  
                                                                  ?>
                                                                </tbody>
                                                              </table>
                                                            </div>
                                                  <?php   
                                                               }

                                                               echo "<br>";
                                                            }           
                                                        // }
                                                    }
                                                }
                                                else{
                                                    echo "level-3 % range is empty";
                                                }
                                            }
                                            else{
                                                echo "level-2 % range is empty";
                                            }
                                        }
                                        else{
                                            echo "level-1 % range is empty";
                                        }
                                    }
                                    else{
                                        echo "indirect co % is empty";
                                    }
                                }
                                else{
                                    echo "direct co % is empty";
                                }
                            }
                            else{
                                echo "target attainment is empty";
                            }
                        }
                        else{
                            echo "see weightage is empty";
                        }  
                    }
                    else{
                        echo "CIE weightage is empty";
                    }
                  }
                  else if(isset($_POST['ischeck']) and $_POST['ischeck']==1){
                    $regualation=$_POST['regulation'];
                    $academicYear=$_POST['academicYear'];
                    $branch=$_POST['branch'];
                    $semesterNo=$_POST['semesterNo'];
                    $courseCode=null;
                    if(isset($_POST['courseCode'])){
                       $courseCode=$_POST['courseCode']; 
                    }
                    try{
                   if(!empty($courseCode)){
                    //    echo "inside nature"; exit(); 
                    $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regualation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&coursecode=".$courseCode."&endpoint=CheckStatus";
                   }else{      
                    $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regualation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&endpoint=CheckStatus";
                   }
                    $data=file_get_contents($url);
                    // print_r($data);
                    $decode_Data=json_decode($data,true);
                    // print_r($decode_Data); exit();
                    // try{
                    if(isset($decode_Data['error'])){
                        echo '<p style="color:red;">'.$decode_Data['error'].'</p>';
                    }
                    else{
                    ?>
                        <div class="table-responsive" style="height:430px">
                                  <table class="table table-bordered">
                                      <thead>
                                        <tr class="table-info">
                                            <th>Sno</th>
                                            <th>CourseName</th>
                                            <th>Type</th>
                                            <th>Status</th>  
                                        </tr>
                                      </thead>
                                      <tbody>
                                            <?php 
                                                foreach($decode_Data['courses'] as $key => $val ){ 
                                                    $rs=0; 
                                                    $tem=array();              
                                                    foreach($val['status'] as $k=>$v ){
                                                        if($k!="indirect"){
                                                            foreach($v as $idx => $ele){
                                                                $tem[$idx]=$ele;
                                                            }
                                                        }
                                                        else{
                                                            $tem[$k]=$v;
                                                        }
                                                    }
                                                    $rs=count($tem);$i=0;
                                                    // print_r($tem);
                                                    // print_r($rs);exit();
                                                    foreach($tem as $k=>$v){ 
                                                     if($i==0){                   ?>
                                                   <tr class="table-info2">
                                                       <td rowspan="<?php echo $rs;?>"> <?php echo ($key+1); ?> </td>
                                                       <td  rowspan="<?php echo $rs;?>"> <?php echo $val['courseName'] ?> </td>
                                                       <td><?php echo $k; ?></td>
                                                       <td><?php  if($v){ echo '<span class="ti-check"></span>'; }else{ echo '<span class="ti-close"></span>'; }   ?></td>
                                                   </tr>      
                                                   <?php  }
                                                     else{ ?>
                                                     <tr class="table-info2">           
                                                       <td><?php echo $k; ?></td>
                                                       <td><?php  if($v){ echo '<span class="ti-check"></span>'; }else{ echo '<span class="ti-close"></span>'; }   ?></td>
                                                     </tr>       
                                               <?php     }
                                                   ?>      
                                                  
                                                   <?php $i++;  } ?>
                                    <?php    }
                                            ?>     
                                      </tbody>  
                                  </table>  
                            </div> 

                    <?php                    
                       }
                     }
                     catch(Exception $e){
                            echo "contact admin.....";
                     }
                  }
                  else{
                      echo "somthing went wrong contact admin..";
                  }
                }
                else{
                    echo "semester no is empty";
                }
            }
            else{
                echo "branch is empty";
            }
        }
        else{
            echo "academicyear is empty";
        }
    }
    else{
        echo "regulation is empty";
    }
}
else{
    echo "plz refresh the page and try";
}



?>




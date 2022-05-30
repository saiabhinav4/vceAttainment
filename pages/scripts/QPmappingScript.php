<?php

include '../common/connection.php';
    // print_r($_POST); exit();  
 $regulation=$academicYear=$branch=$examType=$semesterNo=$QpCode=$marks=$QuestionNo=$co=$coid=$mid=$noofcos=$int_practical_noofQ=$pexamtype=$noofAAT=null;
 $checkacad=null;
 $checkFlagePartA=True;
 $checkflagePartACo=True;
 $checkFlagePartB=True;
 $checkFlagePartBCo=True;
 $checkFlagePartA16=True;
 $checkflagePartACo16=True;
 $checkFlagePartB16=True;
 $checkFlagePartBCo16=True;
 $checkQP=True;
 $flage=True;
 $attflage=True;
 $totalaatflage=True;
 $totalpracticalflage=True;
 $partA=array();
 $partB=array();
 $aatnoofQ=array();
 $conoArray=array();   
 $coid=$_POST['coid'];
 if(isset($_POST)){
    if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
        if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
            if(isset($_POST['branch']) and !empty($_POST['branch'])){
                if(isset($_POST['examType']) and !empty($_POST['examType'])){
                    if(isset($_POST['semesterNo']) and !empty($_POST['semesterNo'])){
                        if(isset($_POST['QPCode']) and !empty($_POST['QPCode'])){ 
                            // if(isset($_POST['noofQ_part_a']) and !empty($_POST['noofQ_part_a'])){
                                // if(isset($_POST['noofQ_part_b']) and !empty($_POST['noofQ_part_b'])){
                                    $regulation=$_POST['regulation'];
                                    $academicYear=$_POST['academicYear'];
                                    $branch=$_POST['branch'];
                                    $examType=$_POST['examType'];
                                    $semesterNo=$_POST['semesterNo'];
                                    $QpCode=$_POST['QPCode'];
                                    // $noofQ_A=$_POST['noofQ_part_a'];
                                    // $noofQ_B=$_POST['noofQ_part_b'];
                                    // $splitArray=explode("-",$academicYear);
                                    // $checkacad=(int)$splitArray[0];
                                $select_check="select coid,no_of_cos from coursedetails where regulation=? and academicYear=? and courseCode=? and branch=?";
                                $stmt=$con->prepare($select_check);
                                $stmt->bind_param("ssss",$regulation,$academicYear,$QpCode,$branch);
                                $stmt->execute();
                                $result_check=$stmt->get_result();
                                $row_4=$result_check->fetch_row();
                                // $result_check=mysqli_query($con,$select_check) or die(mysqli_error($con));
                                // $row_4=mysqli_fetch_row($result_check);
                                if(!empty($row_4[0])){
                                  $coid=$row_4[0];
                                  $noofcos=$row_4[1];
                                //   $selectQuery="select mid from mappingcos where coid=$coid  and  examType='$examType'";
                                //   $result=mysqli_query($con,$selectQuery) or die(mysqli_error($con));    
                                //   if(mysqli_num_rows($result)>0){
                                //     header('location:mapping.php?error=alreadyInserted');
                                //   }
                                //   else{  
                                    for($i=1;$i<=$noofcos;$i++){
                                        $temp="CO".$i;
                                        $select_query="select cono from coursedetails cd,courseoutcomes co where cd.coid=co.coid and regulation=? and academicYear=? and courseCode=? and branch=? and courseoutcome=?";
                                        $stmt=$con->prepare($select_query);
                                        $stmt->bind_param("sssss",$regulation,$academicYear,$QpCode,$branch,$temp);
                                        $stmt->execute();
                                        $result=$stmt->get_result();
                                        $row=$result->fetch_row();
                                        // $result=mysqli_query($con,$select_query) or die(mysqli_error($con));
                                        // $row=mysqli_fetch_row($result);
                                        $conoArray[$temp]=$row[0];
                                    }
                                    // if($checkacad<=2016){
                                    if($examType!="AAT"){
                                        $selectQuery="select mid from mappingcos where coid=?  and  examType=?";
                                        $stmt=$con->prepare($selectQuery);
                                        $stmt->bind_param("is",$coid,$examType);
                                        $stmt->execute();
                                        $result=$stmt->get_result();
                                        // $result=mysqli_query($con,$selectQuery) or die(mysqli_error($con));    
                                        if(  $result->num_rows >0){ 
                                            header("location:../ui-features/mappingcos.php?id=$coid&error=alreadyInserted");
                                        }   
                                        else{
                                        if(isset($_POST['noofQ_part_a']) ){
                                            if(isset($_POST['noofQ_part_b']) and !empty($_POST['noofQ_part_b'])){
                                                $noofQ_A=$_POST['noofQ_part_a'];
                                                $noofQ_B=$_POST['noofQ_part_b'];
                                        for($i=1;$i<=$noofQ_A;$i++){
                                            $temp="1_".chr(97+($i-1));
                                            if(isset($_POST[$temp])){
                                            $partA[$temp]=$_POST[$temp];
                                            }
                                            else{
                                                $checkFlagePartA16=False;
                                                break;
                                            }
                                       }      
                                       for($i=1;$i<=$noofQ_A;$i++){
                                           $temp="1_".chr(97+($i-1))."_co";
                                           if(isset($_POST[$temp])){
                                           $partA[$temp]=$_POST[$temp];
                                           }
                                           else{
                                               $checkflagePartACo16=False;
                                               break;
                                           }
                                       }
                                       
                                       for($i=1;$i<=$noofQ_B;$i++){
                                           $temp="B_".($i+1);
                                           if(isset($_POST[$temp])){
                                           $partB[$temp]=$_POST[$temp];
                                           }
                                           else{
                                               $checkFlagePartB16=False;
                                               break;
                                           }
                                       }      
                                       for($i=1;$i<=$noofQ_B;$i++){
                                           $temp="B_".($i+1)."_co";
                                           if(isset($_POST[$temp])){
                                           $partB[$temp]=$_POST[$temp];
                                           }
                                           else{
                                               $checkFlagePartBCo16=False;
                                               break;
                                           }
                                       }
                    
                                       if($checkFlagePartA16 and $checkflagePartACo16 and $checkFlagePartB16 and $checkFlagePartBCo16){

                                       $flage=True;
                                    for($i=1;$i<=$noofQ_A;$i++){
                                        $temp="1_".chr(97+($i-1));
                                        $temp1="1_".chr(97+($i-1))."_co";  
                                        if(($partA[$temp]!="" && count($partA[$temp1]))!=0 || ($partA[$temp]=="" && count($partA[$temp1])==0)){
                                            $flage=($flage && True);
                                        }
                                        else{
                                            $flage=($flage && False);
                                        }
                                    }      
                                    
                                        for($i=1;$i<=$noofQ_B;$i++){
                                             $temp="B_".($i+1);
                                            $temp1="B_".($i+1)."_co";
                                            if(($partB[$temp]!="" && count($partB[$temp1])!=0)|| ($partB[$temp]=="" && count($partB[$temp1])==0)){
                                                 $flage=($flage && True);
                                            }
                                            else{
                                             $flage=($flage && False);
                                            }
                                        }


                                        if($flage){

                                            // print_r($partA); echo "<br>";
                                            // print_r($partB);
                                            for($i=1;$i<=$noofQ_A;$i++){
                                                $temp="1_".chr(97+($i-1));
                                                $temp1="1_".chr(97+($i-1))."_co";  
                                                if(($partA[$temp]!="" && count($partA[$temp1])!=0)) {
                                                    $ACo="";
                                                    foreach($partA[$temp1] as $key => $val){
                                                        $ACo=$ACo.$val;
                                                    }

                                                    $marks=(double)$partA[$temp];
                                                    $QuestionNo=$temp;
                                                    // $ACo=$partA[$temp1];
                                                    // $ACono=$conoArray[$ACo];

                                                    // echo "<br> ".$ACo; exit();
                                                    // $insertQuery="insert into mappingcos(coid,cono,examtype,noofStudents_A,question) values($coid,$ACono,'$examType',$marks,'$QuestionNo')";
                                                    $insertQuery="insert into mappingcos(coid,examtype,noofStudents_A,question,courseoutcomes) values(?,?,?,?,?)";
                                                    $stmt=$con->prepare($insertQuery);
                                                    $stmt->bind_param("isdss",$coid,$examType,$marks,$QuestionNo,$ACo);
                                                    $stmt->execute();
                                                    // $resultQuery=mysqli_query($con,$insertQuery) or die(mysqli_error($con)); 
                                                }
                                            }
                                            for($i=1;$i<=$noofQ_B;$i++){
                                                $temp="B_".($i+1);
                                                $temp1="B_".($i+1)."_co";
                                                if(($partB[$temp]!="" && count($partB[$temp1])!=0)){
                                                    $BCo="";
                                                    foreach($partB[$temp1] as $key => $val ){
                                                        $BCo=$BCo.$val;
                                                    }
                                                    $marks=(double)$partB[$temp];
                                                    $QuestionNo=$temp;
                                                    // $BCo=$partB[$temp1];    
                                                    // $BCono=$conoArray[$BCo];
                                                    // $insertQuery="insert into mappingcos(coid,cono,examtype,noofStudents_A,question) values($coid,$BCono,'$examType',$marks,'$QuestionNo')";
                                                    $insertQuery="insert into mappingcos(coid,examtype,noofStudents_A,question,courseoutcomes) values(?,?,?,?,?)";
                                                    $stmt=$con->prepare($insertQuery);
                                                    $stmt->bind_param("isdss",$coid,$examType,$marks,$QuestionNo,$BCo);
                                                    $stmt->execute();
                                                    // $resultQuery=mysqli_query($con,$insertQuery) or die(mysqli_error($con));     
                                                }
                                                
                                             } 

                                             header("location:../ui-features/mappingcos.php?id=$coid&msg=inserted");
                                        }
                                        else{
                                            header("location:../ui-features/mappingcos.php?id=$coid&error=reenter");
                                        }
                                     }  
                                     else{
                                        header("location:../ui-features/mappingcos.php?id=$coid&error=swr");
                                        }
                                      }
                                      else{
                                        header("location:../ui-features/mappingcos.php?id=$coid&error=nopartB");
                                      }
                                    }
                                    else{
                                        header("location:../ui-features/mappingcos.php?id=$coid&error=nopartA");
                                    } 
                                   }
                                  }
                                  else if($examType=="AAT"){   
                                    $selectQuery="select atid from alternativetest where coid=?";
                                    $stmt=$con->prepare($selectQuery);
                                    $stmt->bind_param("i",$coid);
                                    $stmt->execute();
                                    $result=$stmt->get_result();
                                    // $result=mysqli_query($con,$selectQuery) or die(mysqli_error($con));    
                                    if( $result->num_rows >0){ 
                                        header("location:../ui-features/mappingcos.php?id=$coid&error=alreadyInserted");
                                    }   
                                    else{
                                        if(isset($_POST['noofaat']) && !empty($_POST['noofaat'])){
                                                $noofAAT=$_POST['noofaat'];                                                                       
                                            for($i=1;$i<=$noofAAT;$i++){
                                                    $tem="noofQaat".$i;
                                                  if(isset($_POST[$tem]) and !empty($_POST[$tem])){
                                                         $aatnoofQ[$tem]=$_POST[$tem];      
                                                  }
                                                  else{
                                                      $attflage=False;
                                                      break;
                                                  }
                                            }
                                            if($attflage){

                                                for($i=1;$i<=$noofAAT;$i++){
                                                    $tem="noofQaat".$i;
                                                    for($j=1;$j<=$aatnoofQ[$tem];$j++){
                                                        $qn="A_".$i."_Q_".$j;
                                                        $qnco="A_".$i."_Q_".$j."_co";
                                                        if((isset($_POST[$qn]) and !empty($_POST[$qn])) and ((isset($_POST[$qnco])) and count($_POST[$qnco])!=0 ) ){
                                                        }else{
                                                            $totalaatflage=False;
                                                            break;
                                                        }     
                                                    }
                                                }
                                              if($totalaatflage){

                                                for($i=1;$i<=$noofAAT;$i++){
                                                    $tem="noofQaat".$i;
                                                    for($j=1;$j<=$aatnoofQ[$tem];$j++){
                                                        $qn="A_".$i."_Q_".$j;
                                                        $qnco="A_".$i."_Q_".$j."_co";
                                                        $Aco="";
                                                        foreach($_POST[$qnco] as $key => $val){
                                                            $Aco=$Aco.$val;
                                                        }
                                                        // $cono=$conoArray[$_POST[$qnco]];
                                                        $per=(double)$_POST[$qn];
                                                        $aatno="A_".$i;
                                                        $quono="Q_".$j;
                                                        // $insert_aat="insert into alternativetest(coid,cono,aatno,permarks,questionno) values($coid,$cono,'$aatno',$per,'$quono')";
                                                        $insert_aat="insert into alternativetest(coid,aatno,permarks,questionno,courseoutcomes) values(?,?,?,?,?)";
                                                        $stmt=$con->prepare($insert_aat);
                                                        $stmt->bind_param("isdss",$coid,$aatno,$per,$quono,$Aco);
                                                        $stmt->execute();
                                                        // $result_aat=mysqli_query($con,$insert_aat) or die(mysqli_error($con));                        
                                                    }
                                                }

                                                header("location:../ui-features/mappingcos.php?id=$coid&msg=inserted");
                                              }
                                              else{
                                                header("location:../ui-features/mappingcos.php?id=$coid&error=mis_over_AAT");   
                                              }
                                            }else{
                                                header("location:../ui-features/mappingcos.php?id=$coid&error=mis_sub_AAT");
                                            }
                                        }
                                        else{
                                            header("location:../ui-features/mappingcos.php?id=$coid&error=mis_AAT");
                                        }
                                    }   
                                  }
                                //   else if($examType=="practical"){
                                //     if(isset($_POST['int_partical_no_of_Q']) and !empty($_POST['int_partical_no_of_Q'])){
                                //         if(isset($_POST['pexamType']) and !empty($_POST['pexamType'])){
                                //             $int_practical_noofQ=$_POST['int_partical_no_of_Q'];
                                //             $pexamtype=$_POST['pexamType'];
                                //             $selectQuery="select ipid from integratedpractical where coid=$coid and examType='$pexamtype'";
                                //             $result_1=mysqli_query($con,$selectQuery) or die(mysqli_error($con)); 
                                //             if(mysqli_num_rows($result_1)>0){
                                //                 header('location:mapping.php?error=alreadyInserted');
                                //             }else{  
                                                
                                //                 for($i=1;$i<=$int_practical_noofQ;$i++){
                                //                     $tem="PQ_".$i;
                                //                     $tem_co="PQ_".$i."_co";
                                //                     if( (isset($_POST[$tem]) and !empty($_POST[$tem])) and ((isset($_POST[$tem_co])) and (count($_POST[$tem_co])!=0))){
                                //                     }
                                //                     else{
                                //                         $totalpracticalflage=False;
                                //                         break;
                                //                     }
                                //                 }
                                //                 if($totalpracticalflage){
                                //                     for($i=1;$i<=$int_practical_noofQ;$i++){
                                //                         $tem="PQ_".$i;
                                //                         $tem_co="PQ_".$i."_co";
                                //                         $pco="";
                                //                         foreach($_POST[$tem_co] as $key => $val){
                                //                                 $pco=$pco.$val;
                                //                         }
                                //                         // echo $conoArray('')."<br>"; exit();
                                //                         // $cono=$conoArray[$_POST[$tem_co]];
                                //                         $per=(double)$_POST[$tem];
                                //                         // $insert_part="insert into integratedpractical(coid,cono,practicalper,examtype,questionno) values($coid,$cono,$per,'$pexamtype','$tem')";
                                //                         $insert_part="insert into integratedpractical(coid,practicalper,examtype,questionno,courseoutcomes) values($coid,$per,'$pexamtype','$tem','$pco')";
                                //                         $result_part=mysqli_query($con,$insert_part) or die(mysqli_error($con));
                                //                     }
                                //                     header('location:mapping.php?msg=inserted');
                                //                 }
                                //                 else{
                                //                     header('location:mapping.php?error=ent_tot_par');    
                                //                 }
                                //             }
                                //         }
                                //         else{
                                //             header('location:mapping.php?error=pexamtype');        
                                //         }
                                //     }
                                //     else{
                                //         header('location:mapping.php?error=pnoofQ');   
                                //     }
                                //   }
                                //  }
                                    // else if($checkacad>=2017){
                                    //    for($i=1;$i<=$noofQ_A;$i++){
                                    //        $inp1="1_".chr(97+($i-1))."_noofSA";
                                    //        $inp2="1_".chr(97+($i-1))."_noofS1";
                                    //        $inp3="1_".chr(97+($i-1))."_noofS2";
                                    //        $inp4="1_".chr(97+($i-1))."_noofS3";
                                    //        if(isset($_POST[$inp1])){
                                    //            $partA[$inp1]=$_POST[$inp1];
                                    //        }
                                    //        else{
                                    //            $checkFlagePartA=False;
                                    //            break; 
                                    //         }
                                    //         if(isset($_POST[$inp2])){
                                    //             $partA[$inp2]=$_POST[$inp2];
                                    //         }
                                    //         else{
                                    //             $checkFlagePartA=False;
                                    //             break; 
                                    //          }
                                    //          if(isset($_POST[$inp3])){
                                    //             $partA[$inp3]=$_POST[$inp3];
                                    //         }
                                    //         else{
                                    //             $checkFlagePartA=False;
                                    //             break; 
                                    //          }
                                    //          if(isset($_POST[$inp4])){
                                    //             $partA[$inp4]=$_POST[$inp4];
                                    //         }
                                    //         else{
                                    //             $checkFlagePartA=False;
                                    //             break; 
                                    //          }
                                    //    }
                                       
                                    //    for($i=1;$i<=$noofQ_B;$i++){
                                    //         $inp1="B_".($i+1)."_noofSA";
                                    //         $inp2="B_".($i+1)."_noofS1";
                                    //         $inp3="B_".($i+1)."_noofS2";
                                    //         $inp4="B_".($i+1)."_noofS3";
                                    //         if(isset($_POST[$inp1])){
                                    //             $partB[$inp1]=$_POST[$inp1];
                                    //         }
                                    //         else{
                                    //             $checkFlagePartB=False;
                                    //             break;
                                    //         }
                                    //         if(isset($_POST[$inp2])){
                                    //             $partB[$inp2]=$_POST[$inp2];
                                    //         }
                                    //         else{
                                    //             $checkFlagePartB=False;
                                    //             break;
                                    //         }
                                    //         if(isset($_POST[$inp3])){
                                    //             $partB[$inp3]=$_POST[$inp3];
                                    //         }
                                    //         else{
                                    //             $checkFlagePartB=False;
                                    //             break;
                                    //         }
                                    //         if(isset($_POST[$inp4])){
                                    //             $partB[$inp4]=$_POST[$inp4];
                                    //         }
                                    //         else{
                                    //             $checkFlagePartB=False;
                                    //             break;
                                    //         }
                                    //    }  
                                    //    for($i=1;$i<=$noofQ_A;$i++){
                                    //     $temp="1_".chr(97+($i-1))."_co";
                                    //     if(isset($_POST[$temp])){
                                    //     $partA[$temp]=$_POST[$temp];
                                    //     }
                                    //     else{
                                    //         $checkflagePartACo=False;
                                    //         break;
                                    //     }
                                    //     }

                                    //     for($i=1;$i<=$noofQ_B;$i++){
                                    //         $temp="B_".($i+1)."_co";
                                    //         if(isset($_POST[$temp])){
                                    //         $partB[$temp]=$_POST[$temp];
                                    //         }else{
                                    //             $checkFlagePartBCo=False;
                                    //             break;
                                    //         }
                                    //     }    

                                    //     if($checkFlagePartA and $checkFlagePartB and $checkflagePartACo and $checkFlagePartBCo){
                                    //         for($i=1;$i<=$noofQ_A;$i++){
                                    //             $inp1="1_".chr(97+($i-1))."_noofSA";
                                    //             $inp2="1_".chr(97+($i-1))."_noofS1";
                                    //             $inp3="1_".chr(97+($i-1))."_noofS2";
                                    //             $inp4="1_".chr(97+($i-1))."_noofS3";
                                    //             $temp="1_".chr(97+($i-1))."_co";
                                    //             if((!empty($partA[$inp1]) and (!empty($partA[$inp2]) or !empty($partA[$inp3]) or !empty($partA[$inp4])) and !empty($partA[$temp]))){

                                    //             }
                                    //             else{
                                    //                $checkQP=False;
                                    //                break; 
                                    //             }    
                                    //         }

                                    //         for($i=1;$i<=$noofQ_B;$i++){
                                    //             $inp1="B_".($i+1)."_noofSA";
                                    //             $inp2="B_".($i+1)."_noofS1";
                                    //             $inp3="B_".($i+1)."_noofS2";
                                    //             $inp4="B_".($i+1)."_noofS3";
                                    //             $temp="B_".($i+1)."_co";
                                    //             if((!empty($partB[$inp1]) and (!empty($partB[$inp2]) or !empty($partB[$inp3]) or !empty($partB[$inp4])) and !empty($partB[$temp]))){

                                    //             }
                                    //             else{
                                    //                $checkQP=False;
                                    //                break; 
                                    //             }  
                                    //         }
                                            
                                    //         if($checkQP){   
                                    //             // echo "nature"; exit();
                                    //             for($i=1;$i<=$noofQ_A;$i++){
                                    //                 $inp1="1_".chr(97+($i-1))."_noofSA";
                                    //                 $inp2="1_".chr(97+($i-1))."_noofS1";
                                    //                 $inp3="1_".chr(97+($i-1))."_noofS2";
                                    //                 $inp4="1_".chr(97+($i-1))."_noofS3";
                                    //                 $temp="1_".chr(97+($i-1))."_co";
                                    //                 if(!empty($partA[$inp1]) and !empty($partA[$temp])){
                                    //                      $noofSA=$partA[$inp1];                                                         
                                    //                      $BCo=$partA[$temp];    
                                    //                      $BCono=$conoArray[$BCo];
                                    //                      $question="1_".chr(97+($i-1));
                                    //                     $insertQuery="insert into mappingcos(coid,cono,examtype,noofStudents_A,question) values($coid,$BCono,'$examType',$noofSA,'$question')";
                                    //                     $resultQuery=mysqli_query($con,$insertQuery) or die(mysqli_error($con));  
                                    //                     $select_mid="select mid from mappingcos where coid=$coid and cono=$BCono and examtype='$examType' and question='$question'";
                                    //                     $result_mid=mysqli_query($con,$select_mid) or die(mysqli_error($con));
                                    //                     $row_44=mysqli_fetch_row($result_mid);
                                    //                     $mid=$row_44[0];     
                                    //                 }
                                    //                 if(!empty($partA[$inp2])){
                                    //                     $marks=(double)$partA[$inp2];
                                    //                     $Qno=$inp2;
                                    //                     $colevel=1;
                                    //                     $insert_1="insert into childmappingcos(mid,marks,questionno,colevel) values($mid,$marks,'$Qno','$colevel')";
                                    //                     $result_1=mysqli_query($con,$insert_1);
                                    //                 }
                                    //                 if(!empty($partA[$inp3])){
                                    //                     $marks=(double)$partA[$inp3];
                                    //                     $Qno=$inp3;
                                    //                     $colevel=2;
                                    //                     $insert_2="insert into childmappingcos(mid,marks,questionno,colevel) values($mid,$marks,'$Qno','$colevel')";
                                    //                     $result_2=mysqli_query($con,$insert_2);
                                    //                 }
                                    //                 if(!empty($partA[$inp4])){
                                    //                     $marks=(double)$partA[$inp4];
                                    //                     $Qno=$inp4;
                                    //                     $colevel=3;
                                    //                     $insert_3="insert into childmappingcos(mid,marks,questionno,colevel) values($mid,$marks,'$Qno','$colevel')";
                                    //                     $result_3=mysqli_query($con,$insert_3);
                                    //                 }
                                    //             }

                                    //             for($i=1;$i<=$noofQ_B;$i++){

                                    //                 $inp1="B_".($i+1)."_noofSA";
                                    //                 $inp2="B_".($i+1)."_noofS1";
                                    //                 $inp3="B_".($i+1)."_noofS2";
                                    //                 $inp4="B_".($i+1)."_noofS3";
                                    //                 $temp="B_".($i+1)."_co";
                                    //                 if(!empty($partB[$inp1]) and !empty($partB[$temp])){
                                    //                      $noofSA=$partB[$inp1];                                                         
                                    //                      $BCo=$partB[$temp];    
                                    //                      $BCono=$conoArray[$BCo];
                                    //                      $question="B_".($i+1);
                                    //                     $insertQuery="insert into mappingcos(coid,cono,examtype,noofStudents_A,question) values($coid,$BCono,'$examType',$noofSA,'$question')";
                                    //                     $resultQuery=mysqli_query($con,$insertQuery) or die(mysqli_error($con));  
                                    //                     $select_mid="select mid from mappingcos where coid=$coid and cono=$BCono and examtype='$examType' and question='$question'";
                                    //                     $result_mid=mysqli_query($con,$select_mid) or die(mysqli_error($con));
                                    //                     $row_44=mysqli_fetch_row($result_mid);
                                    //                     $mid=$row_44[0];     
                                    //                 }
                                    //                 if(!empty($partB[$inp2])){
                                    //                     $marks=(double)$partB[$inp2];
                                    //                     $Qno=$inp2;
                                    //                     $colevel=1;
                                    //                     $insert_1="insert into childmappingcos(mid,marks,questionno,colevel) values($mid,$marks,'$Qno','$colevel')";
                                    //                     $result_1=mysqli_query($con,$insert_1);
                                    //                 }
                                    //                 if(!empty($partB[$inp3])){
                                    //                     $marks=(double)$partB[$inp3];
                                    //                     $Qno=$inp3;
                                    //                     $colevel=2;
                                    //                     $insert_2="insert into childmappingcos(mid,marks,questionno,colevel) values($mid,$marks,'$Qno','$colevel')";
                                    //                     $result_2=mysqli_query($con,$insert_2);
                                    //                 }
                                    //                 if(!empty($partB[$inp4])){
                                    //                     $marks=(double)$partB[$inp4];
                                    //                     $Qno=$inp4;
                                    //                     $colevel=3;
                                    //                     $insert_3="insert into childmappingcos(mid,marks,questionno,colevel) values($mid,$marks,'$Qno','$colevel')";
                                    //                     $result_3=mysqli_query($con,$insert_3);
                                    //                 }
                                    //             }

                                    //             header('location:mapping.php?msg=inserted');

                                    //         }
                                    //         else{
                                    //             header('location:mapping.php?error=reenter');
                                    //         }
                                    //    }
                                    //    else{
                                    //         header('location:mapping.php?error=swr');
                                    //    }
                                    // }//>=2017 if confition
                                //   }
                                 }
                                 else{
                                    header("location:../ui-features/mappingcos.php?id=$coid&error=enterFirstArt");
                                 }
                                // }       
                                // else{
                                //     header('location:mapping.php?error=nopartB');
                                // }
                            // }
                            // else{
                            //     header('location:mapping.php?error=nopartA');
                            // }
                        }
                        else{
                            header("location:../ui-features/mappingcos.php?id=$coid&error=Qpcode");
                        }
                    }
                    else{
                        header("location:../ui-features/mappingcos.php?id=$coid&error=semesterNo");
                    }
                }
                else{
                    header("location:../ui-features/mappingcos.php?id=$coid&error=examType");
                }
            }
            else{
                header("location:../ui-features/mappingcos.php?id=$coid&error=branch");
            }
        }
        else{
            header("location:../ui-features/mappingcos.php?id=$coid&error=academicYear");
        }
    }
    else{
        header("location:../ui-features/mappingcos.php?id=$coid&error=regulation");
    }
}
else{
    header("location:../ui-features/mappingcos.php?id=$coid");
}

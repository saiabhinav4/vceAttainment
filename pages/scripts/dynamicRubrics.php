<?php
 include '../common/connection.php';
$regulation=$projectCode=$projectType=$academicYear=$branch=$reviewType=$noofr=$coid=$isdefault=null;
$rubric_desc=array();
$flage=True;
// print_r($_POST); exit();
if(isset($_POST) and !empty($_POST)){
    $isdefault=$_POST['isdefault'];
    if(isset($_POST['regulation']) and !empty($_POST['regulation'])){
        if(isset($_POST['projectCode']) and !empty($_POST['projectCode'])){
            if(isset($_POST['projectType']) and !empty($_POST['projectType'])){
                if(isset($_POST['reviewType']) and !empty($_POST['reviewType'])){
                    if(isset($_POST['noofr']) and ( ($isdefault==0 and !empty($_POST['noofr'])) or $isdefault!=0 ) ){
                        if(isset($_POST['academicYear']) and !empty($_POST['academicYear'])){
                            if(isset($_POST['branch']) and !empty($_POST['branch'])){
                            $regulation=$_POST['regulation'];
                            $projectCode=$_POST['projectCode'];
                            $projectType=$_POST['projectType'];
                            $reviewType=$_POST['reviewType'];
                            $academicYear=$_POST['academicYear'];
                            $branch=$_POST['branch'];
                            $noofr=$_POST['noofr'];
                            // print_r($_POST);
                           $select_project="select coid from coursedetails where regulation like '$regulation' and academicYear like '$academicYear' and courseCode like'$projectCode' and branch like '$branch' and courseType like '$projectType'"; 
                           $result=mysqli_query($con,$select_project) or die(mysqli_error($con));     
                           if(mysqli_num_rows($result)==1){    
                                $row=mysqli_fetch_row($result);
                                $coid=$row[0];
                              if($isdefault==0){  
                                $select_rubric="select coid,rid,rubricdes from rubricdescription where coid=$coid order by coid,rid";
                                $result_rubric=mysqli_query($con,$select_rubric) or die(mysqli_error($con));
                                while($rows=mysqli_fetch_row($result_rubric)){
                                      $rubric_desc[$rows[1]]=$rows[2];  
                                }
                              
                              

                            ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:500px">
                                <thead>
                              <tr class="table-info"> 
                                    <th>S.No</th> 
                                    <th>Rubric</th> 
                                    <th>value</th>
                              </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for($i=1;$i<=$noofr;$i++){
                                            ?>
                                              <tr class="table-info2">
                                                  <td> <?php echo $i; ?> </td>
                                                  <td> 
                                                  <div class="form-group">
                                                    <select class="form-control" class="rubicselect" name="projectType-<?php echo $i; ?>" id="projectTypeid-<?php echo $i; ?>" >
                                                    <option value="">--Select--</option>
                                                      <?php 
                                                        foreach($rubric_desc as $key=>$val){
                                                            ?>
                                                            <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
                                                            <?php
                                                        }
                                                      ?>
                                                    </select>
                                                    </div> 
                                                  </td>
                                                  <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="R_<?php echo $i; ?>"  placeholder="ex:75.5" title="Enter the % of students >60%">
                                                    </div>
                                                  </td>
                                              </tr>  
                                            <?php
                                        }
                                    ?>
                                </tbody>
                            </table>    
                        </div>
                                        <br>
                                        <div class="form-group">
                                            <!-- <a  class="btn btn-success" >Submit</a>     -->
                                            <button class="btn btn-success">Submit</button>
                                        </div>
                                       
                            <script async>
                                
                                 var rubricSelect=[];
                                 var optionsSelect=[];
                                 var selected=[];
                                 var selectedoptions=[];
                                 <?php
                                    for($i=1;$i<=$noofr;$i++){
                                          $id="projectTypeid-$i"; ?>
                                        optionsSelect.push(document.getElementById(<?php echo "'$id'"; ?>));
                                    <?php     
                                    }
                                    foreach($rubric_desc as $key=>$val){ ?>
                                    rubricSelect.push({<?php echo $key ?>:<?php echo "'$val'"; ?>});
                                    <?php
                                    }
                                 ?>
                                    console.log(rubricSelect);
                                    console.log(optionsSelect);
                                    $('select').on('change', function(e) {
                                            console.log(this.id);

                                            console.log(optionsSelect.includes(this));
                                            if(optionsSelect.includes(this)){
                                                    selected.push(this.id);
                                                    selectedoptions.push(this.value);
                                                    console.log(optionsSelect,selected,selectedoptions,optionsSelect[0].value);
                                                    var text=`<option value=''>--SELECT--</option>`;
                                                for(var i=0;i<rubricSelect.length;i++){           
                                                        //  console.log(optionsSelect[i].value,optionsSelect[i].id,!selectedoptions.includes(optionsSelect[i].value));
                                                    if(!selectedoptions.includes(Object.keys(rubricSelect[i])[0])){
                                                         text+=`<option value="${Object.keys(rubricSelect[i])[0]}">${rubricSelect[i][Object.keys(rubricSelect[i])[0]]}</option>`;      
                                                    }
                                                }
                                                console.log(text);
                                                for(var i=0;i<optionsSelect.length;i++){
                                                    if(!selected.includes(optionsSelect[i].id)){
                                                        optionsSelect[i].innerHTML=text;
                                                    }
                                                }

                                                
                                            }
                                        });
                            </script>
                            
                        <?php       }
                                    else if($isdefault!=0){
                                        $select_rubric="SELECT d.deid,rno,description from defaultrubricsdes d, defaultrubricmapping m WHERE d.deid=m.deid and rid=$isdefault and reviewType='$reviewType' order by rmid";
                                        $result_rubric=mysqli_query($con,$select_rubric) or die(mysqli_error($con));
                                        if(mysqli_num_rows($result_rubric)>0){
                                          ?>   
                      <div class="table-responsive">
                        <table class="table table-bordered" style="width:500px">
                                <thead>
                              <tr class="table-info"> 
                                    <th>S.No</th> 
                                    <th>Rubric</th> 
                                    <th>value</th>
                              </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i=1; $deidArray=array();
                                         while($rows=mysqli_fetch_row($result_rubric)){
                                             array_push($deidArray,$rows[0]);
                                            ?>
                                              <tr class="table-info2">
                                                  <td> <?php echo $i; ?> </td>
                                                  <td> 
                                                  <div class="form-group">
                                                    <input type="text" class="form-control" name="projectType-<?php echo $i; ?>" value="<?php echo $rows[2]; ?>" title="<?php echo $rows[2]; ?>"   disabled> 
                                                    </div> 
                                                  </td>
                                                  <td>
                                                    <div class="form-group">
                                                        <input type="text" class="form-control" name="R_<?php echo $i; ?>"  placeholder="ex:75.5" title="Enter the % of students >60%">
                                                    </div>
                                                  </td>
                                              </tr>  
                                            <?php
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table> 
                        </div>   
                                        <br>
                                        <input type="hidden" name="deidArray" value="<?php echo join(",",$deidArray); ?>">
                                        <div class="form-group">
                                            <!-- <a  class="btn btn-success" >Submit</a>     -->
                                            <button class="btn btn-success">Submit</button>
                                        </div>
                                       

                                    <?php  
                                            }
                                            else{
                                                echo "rubrics are not entred, Contact Admin";
                                            }
                                      }
                                }
                                else{
                                    echo "no such project entry";
                                }
                            }
                            else{
                                echo "invalid branch";
                            }
                        }
                        else{
                            echo "invalid academicYear";
                        }
                    }
                    else{
                        echo 'invalid no of rubrics ';
                    }
                }
                else{
                    echo 'invalid review Type';
                }
            }
            else{
                echo 'invalid project Type';
            }
        }
        else{
            echo 'invalid project Code';
        }
    }
    else{
        echo 'invalid regulation';
    }
}
else{
    echo '<p>something went worng contact admin..!</p>';
}
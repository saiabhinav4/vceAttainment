<?php
require '../common/connection.php';
// print_r($_POST);exit(); 
if(isset($_POST)){
    if(isset($_POST['no_of_COs']) && isset($_POST['courseCode']) && isset($_POST['regulation']) && isset($_POST['no_of_R']) and isset($_POST['ishavedefault'])){
        $regulation=$_POST['regulation'];
        $noofr=$_POST['no_of_R'];
        $no_of_COs=$_POST['no_of_COs'];
        $courseCode=$_POST['courseCode'];
        $noofpos=12;
        $noofpsos=2;
        $ishavedefault=$_POST['ishavedefault'];
        $i=1;
        $reg=(int)explode("-",$regulation)[1];
?>
 <div class="row">
                <div class="col-md-3">
                    <h5>Course Articulation Matrix</h5>
                </div>
    </div>
<div style="margin:10px;">
<div class="table-responsive">
<table class="table table-bordered">
                <thead>
            <tr class="table-info" > 
                <th>Course Outcomes</th> <th>CO Description</th> <th>Bloom's Taxonomy</th> 
                <?php for($j=1;$j<=$noofpos;$j++){  ?>
                <th>PO<?php echo $j ?></th> 
                <?php } ?>
                <?php for($j=1;$j<=$noofpsos;$j++){  ?>
                <th>PSO<?php echo $j ?></th> 
                <?php } ?>   
            </tr>
                </thead>
                <tbody>
<?php
        while($i<=$no_of_COs){
?>
            <tr style="text-align:center;" class="table-info2">
                    
                    <td id="co1"><?php echo "$courseCode."."$i"; ?></td>
                    <td   >
                    <div class="form-group" style="width:150px;">
                        <input type="text" class="form-control custome" name="Co<?php echo "$i"; ?>_description" placeholder="Co<?php echo "$i"; ?> description" pattern="[A-Za-z,\s]+" title="Enter CO<?php echo "$i"; ?> description" required>
                    </div>  
                    </td>

                    <td  >
                        <div class="form-group" style="width:70px">
                            <!-- <input type="number" class="form-control" name="col_po1" placeholder="" title="Enter the weight"> -->
                            <select class="form-control custome custome1" name="boom<?php echo "$i"; ?>" title="Enter the level" required>
                        <option value=""></option>
                        <option value="L1">L1</option>
                        <option value="L2">L2</option>
                        <option value="L3">L3</option>
                        <option value="L4">L4</option>
                        <option value="L5">L5</option>
                        <option value="L6">L6</option>
                    </select>
                        </div>
                    </td>
                    <?php  for($j=1;$j<=$noofpos;$j++){ ?>

                        <td  >
                            <div class="form-group" style="width:60px">
                                <!-- <input type="number" class="form-control" name="col_po1" placeholder="" title="Enter the weight"> -->
                            <select class="form-control custome" name="co<?php echo "$i"; ?>_po<?php echo $j ?>" title="Enter the weight">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                            </select>
                            </div>
                        </td>
            
                  <?php  }   ?>
                    
                       <?php for($j=1;$j<=$noofpsos;$j++){ ?>
                        <td >
                            <div class="form-group" style="width:60px">
                                <!-- <input type="number" class="form-control" name="co1_pso1" placeholder="" title="Enter the weight"> -->
                                <select class="form-control custome" name="co<?php echo "$i"; ?>_pso<?php echo $j ?>" title="Enter the weight">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </td>

                        <?php }  ?> 
                  </tr> 
<?php 
        $i+=1;
        }
 ?>
   </tbody>
    </table>
</div>
</div>

  <?php if($ishavedefault==0 && $noofr!=0){ ?>      
        <br><br>

        <h4>Rubrics Details</h4>
<div style="margin:10px;">
<div class="table-responsive">
        <table class="table table-bordered" >
                <thead>
                <tr class="table-info"> 
                    <th>Rubric Number</th> 
                    <th>Rubric Description</th> 
                    <th>Course Outcome</th>
                </tr>
                </thead>
                <tbody>
                  <?php 
                    for($i=1;$i<=$noofr;$i++){
                          ?>
                          <tr class="table-info2">
                                <td style="text-align:center"><?php echo $i; ?></td>
                                <td>
                                <div class="form-group" style="width:300px;">
                                    <input type="text" class="form-control " name="R<?php echo "$i"; ?>_description" placeholder="Rubric<?php echo "$i"; ?> description" pattern="[A-Za-z,\s]+" title="Enter Rubric<?php echo "$i"; ?> description" required>
                                </div>
                                </td>
                                <td style="width:400px;">
                                    <div class="form-group" style="margin-top:4px;width:350px" >
                                        <select class="form-control selectpick" name="<?php echo $i; ?>_R[]" style="width:102px;"  title="Select COs"   multiple>
                                            <!-- <option value="">Enter Co</option> -->
                                        <?php for($k=1;$k<=$no_of_COs;$k++){ ?>
                                        <option value="CO<?php echo $k; ?>"><?php echo "CO".$k; ?></option>
                                        <?php } ?>
                                        </select>       
                                    </div>     
                                </td>
                            
                          </tr>
                          <?php
                    }
                  ?>   
                </tbody>
        </table>
</div>
</div>

<?php }
        else if($ishavedefault!=0){     
            $retrive_rubrics="SELECT deid,rno,description from defaultrubricsdes where rid=$ishavedefault order by rno";
            $result=mysqli_query($con,$retrive_rubrics) or die(mysqli_error($con));          
          if(mysqli_num_rows($result)>0){
            ?>   
            <br><br>
<h4>Rubrics Details</h4>
<div style="margin:10px;">
    
<div class="table-responsive">
        <table class="table table-bordered" style="width:500px">
                <thead>
                <tr class="table-info"> 
                    <th>Rubric Number</th> 
                    <th>Rubric Description</th> 
                    <th>Course Outcome</th>
                </tr>
                </thead>
                <tbody>
                  <?php
                    $deidArray=array(); 
                    while($row=mysqli_fetch_row($result)){
                        array_push($deidArray,$row[0]);
                          ?>
                          <tr class="table-info2">
                                <td style="text-align:center"><?php echo $row[1]; ?></td>
                                <td>
                                <div class="form-group" style="width:300px;">
                                    <input type="text" class="form-control" value="<?php echo $row[2]; ?>" name="R<?php echo $row[1]; ?>_description_<?php echo $row[0]; ?>" placeholder="Rubric<?php echo "$i"; ?> description"  title="<?php echo $row[2]; ?>" required disabled>
                                </div>
                                </td>
                                <td style="width:400px;">
                                    <div class="form-group" style="margin-top:4px;width:350px" >
                                        <select class="form-control  selectpick" name="<?php echo $row[1]; ?>_R[]" style="width:102px;"  title="Select COs"   multiple>
                                            <!-- <option value="">Enter Co</option> -->
                                        <?php for($k=1;$k<=$no_of_COs;$k++){ ?>
                                        <option value="CO<?php echo $k; ?>"><?php echo "CO".$k; ?></option>
                                        <?php } ?>
                                        </select>       
                                    </div>     
                                </td>
                            
                          </tr>
                          <?php
                    }
                  ?>   
                </tbody>
        </table>
</div>
               <input type="hidden" name="deid" value="<?php echo join(",",$deidArray); ?>" >     
</div>

        <?php 
        }
        else{
            echo '<p style="color:red;">Rubrics are not entered, Contact Admin</p>';
        }    
    }
?>

<div class="container">
        <div class="row">
            <div class="col-md-2">
                <input type="submit" class="btn btn-success">
            </div>
        </div>
      </div>    
 <?php        
    }
    else{
        echo '<p style="color:red;">Plz Enter the proper inputs</p>';
    }
}
else{
    echo '<p style="color:red;">Somthing went worng contact admin..</p>';
}

?>
<?php
// echo "yo4";
// print_r($_POST); exit();
include '../common/connection.php';
// function assignWeight($acad){
//     if($acad==2017){
//         $wei=60;
//     }
//     else if($acad>=2018){
//         $wei=65;
//     }
//    return $wei; 
// }
$regulation=$academicYear=$branch=$courseCode=$examtype=null;
if(isset($_POST)){
    $regulation=$_POST['regulation1'];
    $academicYear=$_POST['academicYear1'];
    $branch=$_POST['branch1'];
    $courseCode=$_POST['courseCode'];  
    $i=1;$j=1;$l=1;$p=1;
    $noofcos=$checkacad=$courseType=$wei=null;
// echo "yo00";
$select_Qu="select coid,no_of_cos,courseType from coursedetails where regulation=? and academicYear=? and branch=? and courseCode=?";
$stmt=$con->prepare($select_Qu);
$stmt->bind_param("ssss",$regulation,$academicYear,$branch,$courseCode);
$stmt->execute();
$result=$stmt->get_result();
$row=$result->fetch_row();
// $result=mysqli_query($con,$select_Qu) or die(mysqli_error($con));
// $row=mysqli_fetch_row($result);

// echo "yo44";
if(!empty($row[0])){
    $noofcos=$row[1];
    $courseType=$row[2];
// echo $_POST['examtype'];
    if(isset($_POST['examtype']) && !empty($_POST['examtype'])){
        $examtype=$_POST['examtype'];
        if($examtype!='AAT'){
            $noofQ_part_a=$_POST['noofA'];
            $noofQ_part_b=$_POST['noofB'];
      ?>      

 <div class="container">
    <div class="row">
          <div class="col-md-2">
          <h4>PART-A</h4>
          <?php 
           if($noofQ_part_a==0){
            echo "<p>No Question in Part-A</p>";
            }
            for(;$i<=$noofQ_part_a;$i++){
                if($i<=5){
                ?>
            <h6>Question: <?php echo "1-".chr((97+($i-1))); ?></h6>    
            <div class="form-group">
                        <input type="text" class="form-control" name="1_<?php echo chr((97+($i-1))); ?>" placeholder="Enter 1-<?php echo chr((97+($i-1))); ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
            <h6>&nbsp;</h6>
          <?php 
            for(;$j<=$noofQ_part_a;$j++){
                if($j<=5){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group"  style="margin-bottom:0.8rem;" >
                    <select class="form-control  selectpick" name="1_<?php echo chr((97+($j-1))); ?>_co[]" style="width:102px;"  title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h4>&nbsp;</h4>
          <!-- <br><span style="margin-top:6px"></span> -->
          <?php 
            for(;$i<=$noofQ_part_a;$i++){
                if($i<=10){
                ?>
             <h6>Question: <?php echo "1-".chr((97+($i-1))); ?></h6>    
            <div class="form-group">
                        <input type="text" class="form-control" name="1_<?php echo chr((97+($i-1))); ?>" placeholder="Enter 1-<?php echo chr((97+($i-1))); ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h6>&nbsp;</h6>
          <?php 
            for(;$j<=$noofQ_part_a;$j++){
                if($j<=10){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group" style="margin-bottom:0.8rem;">
                    <select class="form-control selectpick" name="1_<?php echo chr((97+($j-1))); ?>_co[]" style="width:102px;" title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
            }
          ?>  
          </div>
    </div>
</div>
<div class="container">
    <div class="row">
    <div class="col-md-2">
          <h4>PART-B</h4>
          <?php 
            for(;$l<=$noofQ_part_b;$l++){
                if($l<=20){
                ?>
            <h6>Question: <?php echo ($l+1); ?></h6>    
            <div class="form-group"  >
                        <input type="text" class="form-control" name="B_<?php echo ($l+1); ?>" placeholder="Enter <?php echo ($l+1); ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h6>&nbsp;</h6>
          <?php 
            for(;$p<=$noofQ_part_b;$p++){
                if($p<=20){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group" style="margin-bottom:0.8rem;">
                    <select class="form-control selectpick" name="B_<?php echo ($p+1); ?>_co[]" style="width:102px;" title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h4>&nbsp;</h4>
          <?php 
            for(;$l<=$noofQ_part_b;$l++){
                if($l<=40){
                ?>
            <h6>Question: <?php echo ($l+1); ?></h6>       
            <div class="form-group">
                        <input type="text" class="form-control" name="B_<?php echo ($l+1); ?>" placeholder="Enter <?php echo ($l+1); ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h6>&nbsp;</h6>
          <?php 
            for(;$p<=$noofQ_part_b;$p++){
                if($p<=40){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group" style="margin-bottom:0.8rem;">
                    <select class="form-control selectpick" name="B_<?php echo ($p+1); ?>_co[]" style="width:102px;" title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
    </div>
    <div class="form-group">
                <input type="submit" class="btn  btn-success">
          </div>
    </div>
</div> 
       <?php         
        }
        else if($examtype=='AAT'){ //////////////////////////2
              $no_of_aat=$_POST['noofaat'];  
              $no_of_Q_array=$_POST['QAAtarray'];  

            //   for($i=1;$i<=$no_of_aat;$i++){
          ?>   
        <div class="container">
        <?php    for($y=0;$y<$no_of_aat;$y++){  $i=1;$j=1;$l=1;$p=1;  $noofQ_part_a=$no_of_Q_array[$y]; ?>
            <!-- <h4>Questions of AAT-<?php  //echo ($y+1); ?></h4> -->
            <div class="row">
          <div class="col-md-3">
          <h5>Questions of AAT-<?php echo ($y+1); ?></h5>
          <?php 
            for(;$i<=$noofQ_part_a;$i++){
                if($i<=5){
                ?>
            <h6>Question: <?php echo $i; ?></h6>        
            <div class="form-group">
                        <input type="text" class="form-control" name="A_<?php echo ($y+1); ?>_Q_<?php echo $i; ?>" placeholder="Q-<?php echo $i; ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h6>&nbsp;</h6>
          <?php 
            for(;$j<=$noofQ_part_a;$j++){
                if($j<=5){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group" style="margin-bottom:0.8rem">
                    <select class="form-control selectpick" name="A_<?php echo ($y+1); ?>_Q_<?php echo $j; ?>_co[]" style="width:102px;" title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-3">
          <h5>&nbsp;</h5> 
          <?php 
            for(;$i<=$noofQ_part_a;$i++){
                if($i<=10){
                ?>
             <h6>Question: <?php echo $i; ?></h6>    
            <div class="form-group">
                        <input type="text" class="form-control" name="A_<?php echo ($y+1); ?>_Q_<?php echo $i; ?>" placeholder="Q-<?php echo $i; ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h6>&nbsp;</h6>
          <?php 
            for(;$j<=$noofQ_part_a;$j++){
                if($j<=10){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group" style="margin-bottom: 0.8rem;">
                    <select class="form-control selectpick" name="A_<?php echo ($y+1); ?>_Q_<?php echo $j; ?>_co[]" style="width:102px;" title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
            }
          ?>  
          </div>
    </div>
       <?php } ?>     
        <div class="form-group">
                <input type="submit" class="btn  btn-success">
        </div>
</div>
 
          <?php  
        }
        else if($examtype=='practical'){ ////////////////////////////////////////////////3
            $no_of_q_ip=$_POST['IPnoofQ']; $i=1;$j=1;$l=1;$p=1;
            ?>

<div class="container">
    <div class="row">
          <div class="col-md-2">
          <h4>Enter Question</h4>
          <?php 
            for(;$i<=$no_of_q_ip;$i++){
                if($i<=5){
                ?>
            <h6>Question: <?php echo $i; ?></h6>        
            <div class="form-group">
                        <input type="text" class="form-control" name="PQ_<?php echo $i; ?>" placeholder="Q-<?php echo $i; ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
            <h6>&nbsp;</h6>
          <?php 
            for(;$j<=$no_of_q_ip;$j++){
                if($j<=5){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group" style="margin-bottom:0.8rem;">
                    <select class="form-control selectpick" name="PQ_<?php echo $j; ?>_co[]" style="width:102px;" title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h4>&nbsp;</h4> 
          <?php 
            for(;$i<=$no_of_q_ip;$i++){
                if($i<=10){
                ?>
             <h6>Question: <?php echo $i; ?></h6>    
            <div class="form-group">
                        <input type="text" class="form-control" name="PQ_<?php echo $i; ?>" placeholder="Q-<?php echo $i; ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
            }
          ?>  
          </div>
          <div class="col-md-2">
          <h6>&nbsp;</h6>
          <?php 
            for(;$j<=$no_of_q_ip;$j++){
                if($j<=10){
                ?>
                <h6>&nbsp;</h6>
            <div class="form-group" style="margin-bottom:0.8rem;">
                    <select class="form-control selectpick" name="PQ_<?php echo $j; ?>_co[]" style="width:102px;" title="Select COs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="CO<?php echo $k; ?>"><?php echo $k; ?></option>
                    <?php } ?>
                        <!-- <option value="CO2">2</option>
                        <option value="CO3">3</option>
                        <option value="CO4">4</option>
                        <option value="CO5">5</option> -->
                    </select>
        
        </div>
        <?php
                }
            }
          ?>  
          </div>
    </div>
    <div class="form-group">
                <input type="submit" class="btn  btn-success">
          </div>
    </div>
</div>


     <?php       
        }


  }
  else{
    echo '<div class="container">
    <div class="row">
        <div class="co-md-8">
                <p>SomeThing went worng! plz refresh the page and retry! </p>
        </div> 
    </div>
    </div>';
  }



}

else{ 
echo '<div class="container">
    <div class="row">
        <div class="co-md-8">
                <p>CourseCode :'.$courseCode.' has no entry in articulation.  </p>
                <p>first enter data in articulation.</p>
        </div> 
    </div>
</div>';
 
}

}
?>
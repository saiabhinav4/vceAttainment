<?php
// echo "yo4";
include '../common/connection.php';
// print_r($_POST); exit();
$finaltype=$noofQ_part_a=null;
if(isset($_POST)){
$regulation=$_POST['regulation1'];
$academicYear=$_POST['academicYear1'];
$branch=$_POST['branch1'];
// $courseCode=$_POST['courseCode'];
$i=1;$j=1;$l=1;$p=1;
$noofcos=$courseType=$checkacad=$typein=null;
$noofcos=12;
$splitArray=explode("-",$academicYear);
$checkacad=(int)$splitArray[0];
// echo "yo00";
// echo $checkacad; exit();

// $select_Qu="select coid,no_of_cos,courseType from coursedetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and courseCode='$courseCode'";
// $result=mysqli_query($con,$select_Qu) or die(mysqli_error($con));
// $row=mysqli_fetch_row($result);
// // echo "yo44";
// if(!empty($row[0])){
//     $noofcos=$row[1];
//     $courseType=$row[2];
// // echo "YO";
// if($courseType=='Non-Integrated'){
//     $finaltype="Theory";
// }
// else{
//     $finaltype=$courseType;
// }        
    // if($courseType=="Practical"){
        if(isset($_POST['examtype']) and !empty($_POST['examtype'])){
            $examtype=$_POST['examtype'];

            $select_check="select p.ipno from indirectpodetails p,pomapping m where p.ipno=m.ipno and regulation='$regulation' and academicYear='$academicYear' and branch='$branch' and type='$examtype' ";
            $result_check=mysqli_query($con,$select_check) or die(mysqli_error($con));
            if(mysqli_num_rows($result_check)==0){ 
                
            if($examtype=='co_curricular' or $examtype=='extra_curricular' ){
                if($examtype=='co_curricular'){
                    $typein="Co-Curricular Activity";
                }
                else if($examtype=='extra_curricular'){
                    $typein="Extra-Curricular Activity";
                }
                $noofQ_part_a=$_POST['noofQ'];
?>
<div class="container">
    <div class="row">
          <div class="col-md-2">
          <!-- <h4></h4> -->
          <?php 
            for(;$i<=$noofQ_part_a;$i++){
                if($i<=5){
                ?>
            <h6><?php echo $typein."-".$i; ?></h6>        
            <div class="form-group">
                        <input type="text" class="form-control" name="A_<?php echo $i; ?>" placeholder="Activity-<?php echo $i; ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
                else{
                    break;
                }
            }
          ?>  
          </div>
          <div class="col-md-4">
              <h5></h5>
          <!-- <br> -->
          <?php 
            for(;$j<=$noofQ_part_a;$j++){
                if($j<=5){
                ?>
                <h4>&nbsp;</h4>
            <div class="form-group">
                    <select class="form-control selectpick" name="A_<?php echo $j; ?>_co[]" style="width:102px;" title="Select POs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="PO<?php echo $k; ?>"><?php echo "PO".$k; ?></option>
                    <?php }
                    ?>
                    <option value="PSO1">PSO1</option>
                    <option value="PSO2">PSO2</option>
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
          <!-- <h4>&nbsp;</h4>  -->
          <?php 
            for(;$i<=$noofQ_part_a;$i++){
                if($i<=10){
                ?>
            <h6><?php echo $typein."-".$i; ?></h5>   
            <div class="form-group">
                        <input type="text" class="form-control" name="A_<?php echo $i; ?>" placeholder="Activity-<?php echo $i; ?>" pattern="^(100|([0-9][0-9]?(\.[0-9]+)?))$" title="only digits or digits followed by . then followed by digits">
            </div> 
        <?php
                }
            }
          ?>  
          </div>
          <div class="col-md-4">
            <h5></h5>
          <!-- <br> -->
          <?php 
            for(;$j<=$noofQ_part_a;$j++){
                if($j<=10){
                ?>
                <h4>&nbsp;</h4>
            <div class="form-group" >
                    <select class="form-control selectpick" name="A_<?php echo $j; ?>_co[]" style="width:102px;" title="Select POs"   multiple>
                    <!-- <option value="">Enter Co</option> -->
                    <?php for($k=1;$k<=$noofcos;$k++){ ?>
                        <option value="PO<?php echo $k; ?>"><?php echo "PO".$k; ?></option>
                    <?php } ?>
                    <option value="PSO1">PSO1</option>
                    <option value="PSO2">PSO2</option>
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
        else if($examtype=='exit_survey'){

            $select_po="select programoutcome,poDescription from programoutcomes where department like 'overall' order by programoutcome";
            $result_po=mysqli_query($con,$select_po) or die(mysqli_error($con));
            
            $select_pso="select programoutcome,poDescription from programoutcomes where department like '$branch' order by programoutcome";
            $result_pso=mysqli_query($con,$select_pso) or die(mysqli_error($con));   
            if(mysqli_num_rows($result_po)>0 and mysqli_num_rows($result_pso)>0 ){
                
                ?>
        <div class="row">
            <div class="col-md-5">
            <h4>Student Exit Survey</h4>

                <?php  for($h=1;$h<=7;$h++){
                    $row=mysqli_fetch_row($result_po);
                       ?>
                <h5><?php echo $row[0]; ?></h5>
                <div class="form-group">
                        <p style="background-color:white;padding:4px;border-radius:4px"><?php echo $row[1]; ?> </p>
                        <div class="form-group">
                        <input  type="text"  name="<?php echo $row[0];?>" class="form-control"  placeholder="Ex:84"> 
                         </div>
                </div>
                <?php } ?>
                
            </div>
            <div class="col-md-5">
                <h4>&nbsp;</h4>
            <?php  for($h=1;$h<=5;$h++){  
                $row=mysqli_fetch_row($result_po);
                    if($h==2){
                        echo "<br>";
                    }
                       ?>
                <h5><?php echo $row[0]; ?></h5>
                <div class="form-group">
                        <p style="background-color:white;padding:4px;border-radius:4px"><?php echo $row[1]; ?> </p>
                        <div class="form-group">
                        <input  type="text" name="<?php echo $row[0]; ?>" class="form-control"  placeholder="Ex:84"> 
                         </div>
                </div>
                <?php } ?>
                <h5>&nbsp;</h5>
                <?php   $row1=mysqli_fetch_row($result_pso)    ?>
                <h5><?php echo $row1[0]; ?></h5>
                <div class="form-group">
                        <p style="background-color:white;padding:4px;border-radius:4px"><?php echo $row1[1]; ?></p>
                        <input  type="text" name="<?php echo $row1[0] ?>" class="form-control"  placeholder="Ex:84"> 
                </div>
                <?php   $row1=mysqli_fetch_row($result_pso)    ?>
                <h5><?php echo $row1[0]; ?></h5>
                <div class="form-group">
                        <p style="background-color:white;padding:4px;border-radius:4px"><?php echo $row1[1]; ?></p>
                        <input  type="text" name="<?php echo $row1[0] ?>" class="form-control"  placeholder="Ex:84"> 
                </div>
            </div>
        </div>     

        <div class="form-group">
                <input type="submit" class="btn  btn-success">
        </div>  
            <?php
          }
          else{
                echo "<p>PO and PSO not entered. Plz contact admin..</p>";
          }
        }   
      }
      else{
        echo '<div class="container">
        <div class="row">
            <div class="co-md-8">
                    <p>Already entered data!</p>
                    <h4>&nbsp;</h4>
                    <h4>&nbsp;</h4>
                  
            </div> 
        </div>
        </div>';
      } 
     }else{
        echo '<div class="container">
    <div class="row">
        <div class="co-md-8">
                <p>SomeThing went worng! plz refresh the page and retry! </p>
                <h4>&nbsp;</h4>
                <h4>&nbsp;</h4>
        </div> 
    </div>
    </div>';
     }
//     }
//     else{
//         echo '<div class="container">
//     <div class="row">
//         <div class="co-md-8">
//         <p style="color:red">CourseCode :'.$courseCode.' is a '.$finaltype.' Course.  </p>
//         <p style="">Click <a href="mapping.php">Here</a> for Intergated Course Course.</p>
//         <p style="">Click <a href="theorymappingcos.php">Here</a> for Theory Course.</p>
//         </div> 
//    </div>
//     </div>';
 
//     }
// }
// else{ 
// echo '<div class="container">
//     <div class="row">
//         <div class="co-md-8">
//                 <p>CourseCode :'.$courseCode.' has no entry in articulation.  </p>
//                 <p>first enter data in articulation.</p>
//         </div> 
//     </div>
// </div>';
 
// }

}
?>
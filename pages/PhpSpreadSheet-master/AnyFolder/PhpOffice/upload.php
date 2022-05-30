
<?php

include '../../../common/connection.php';
use PhpOffice\PhpSpreadsheet\Shared\JAMA\QRDecomposition;
$branch="";




class Student{
     private $rollno;
     private $marks;

    function __construct($rno)
    {
        $this->rollno=$rno;
        $this->marks=array();        
    }
    public function set_marks($id,$val){
        $this->marks[$id]=$val;
    } 
    public function get_marks(){
        return $this->marks;
    }
    public function  get_rollno(){
        return $this->rollno;
    }
}
class PaperStruct{
    private $noofQ;
    private $maxMarks;
    private $courseOutcomes;
    private $QuestionName;
    private $rubricdesc;
    private $rubricno;
    public function __construct()
    {
        $this->maxMarks=array();
        $this->courseOutcomes=array();
        $this->QuestionName=array();
        $this->rubricdesc=array();
        $this->rubricno=array();
    }

    public function get_maxMarks(){
        return $this->maxMarks;
    }
    public function get_courseoutcomes(){
        return $this->courseOutcomes;
    }
    public function get_QustionName(){
        return $this->QuestionName;
    }
    public function get_Rubric_description(){
        return $this->rubricdesc;
    }
    public function get_noofQ(){
        return $this->noofQ;
    }
    public function assign_rubrics($valArrM,$valdesc){
        // print_r($valArrM);
        // print_r($valdesc);
        $flage_c=true;
        for($i=1;$i<count($valdesc);$i++){
              if( ( !empty($valdesc[$i]) && !empty($valArrM[$i]))|| (empty($valdesc[$i]) && empty($valArrM[$i]) )  ){
              }                            
              else{
                $flage_c=false;
                break;
              }
        }
        if($flage_c){
        for($i=1;$i<count($valdesc);$i++){ 
            if(  ( !empty($valdesc[$i]) && !empty($valArrM[$i])) ){
                $this->rubricdesc[$i]=$valdesc[$i];
                $this->maxMarks[$i]=$valArrM[$i];
            }
        }
            // $this->rubricdesc
            return true;
        }
        else{
            return false;
        }
        


    }
    public function assign_Questions($valArrQ,$valArrM,$valArrC){ 
        $flage_c=true;
        // print_r($valArrQ);
        // print_r($valArrM);
        // print_r($valArrC);exit();
        $noArray=array("total","grand_total","status");
        for($i=1;$i<count($valArrQ);$i++){
            $flage=true;
            foreach($noArray as $k=>$v){
             if(strpos($valArrQ[$i],$v) !== false){
               $flage=false;
               break;
             }
            }
          if($flage){
            if( ( !empty($valArrM[$i]) && !empty($valArrC[$i]) && !empty($valArrQ[$i]) ) || ( empty($valArrM[$i]) && empty($valArrC[$i]) && empty($valArrQ[$i]) ) ){ 

            }  
            else{
                $flage_c=false;
                break;
            }
          }
        }
    
        if($flage_c){
         for($i=1;$i<count($valArrQ);$i++){
             $flage=true;
             foreach($noArray as $k=>$v){
              if(strpos($valArrQ[$i],$v) !== false){
                $flage=false;
                break;
              }
            }
            if($flage){
               if(!empty($valArrM[$i]) && !empty($valArrC[$i])){ 
                   $this->QuestionName[$i]=$valArrQ[$i];
                   $this->maxMarks[$i]=$valArrM[$i];
                   $this->courseOutcomes[$i]= str_replace(',','',$valArrC[$i]);
                }
            }

         }
        }
        
         if(count($this->QuestionName)!=0){
             $this->noofQ=count($this->QuestionName);
             return true;
         }
         else{
             return false;
         }

     
    }

}

class StudentMarks{
    private $regulation;
    private $academicYear;
    private $branch;
    private $semesterNo;
    private $courseName;
    private $studentArray;
    private $paperStruct;
    private $totalAttampted;
    private $aboveSixty;
    private $per;
    private $inputmar;
    private $etype;
    private $coid;
    private $csid;
    private $maxMarksRow;
    private $isdefault;
    private $ishaverubrics;
    private $courseCode;

    public function __construct($mar,$etype,$cc,$coid)
    {
        global $con;
        $this->studentArray=array();
        $this->totalAttampted=array();
        $this->aboveSixty=array();
        $this->per=array();
        $this->paperStruct=new PaperStruct();
        $this->inputmar=$mar;
        $this->etype=$etype;
        $this->coid=$coid;
        $retrive_csid="SELECT regulation,academicYear,branch,semesterNo,courseCode,courseName,c.csid,isdefault,ishaverubrics from coursedetails c, coursestructure1 cs where c.csid=cs.csid and c.coid=$this->coid"; 
        $result=mysqli_query($con,$retrive_csid) or die(mysqli_error($con)); 
        if(mysqli_num_rows($result)>0){
             $row=mysqli_fetch_row($result);
             $this->regulation=$row[0];
             $this->academicYear=$row[1];
             $this->branch=$row[2];
             $this->semesterNo=$row[3];
             $this->courseCode=$row[4];
             $this->courseName=$row[5];

             $this->csid=$row[6];
             $this->isdefault=$row[7];
             $this->ishaverubrics=$row[8];

        }
        $this->courseCode=$cc;
    }
    public function get_totalAttempted(){
        return $this->totalAttampted;
    }
    public function get_aboveSixty(){
        return $this->aboveSixty;
    }
    public function get_per(){
        return $this->per;
    }
    public function get_studentMarks(){
        return $this->studentArray;
    }
    public function get_paperStruct(){
        return $this->paperStruct;
    }
    public function assign_studentMarks(){
        global $con;
        $rows=0;
        $cols=0;

        if($this->ishaverubrics==0){
            if($this->etype==="AAT"){
                 $selectQuery="SELECT atid from alternativetest where coid=?";       
            }else{
                $selectQuery="select mid from mappingcos where coid=?  and  examType=?";
            }
        }
        else{
            if($this->isdefault==0){
                $selectQuery="SELECT c.coid from coursedetails c,rubricdescription rd,rubricmapping rm where c.coid=rd.coid and rd.rid=rm.rno and c.coid=? and rm.type=?";
            }
            else{
                $selectQuery="SELECT c.coid from coursedetails c,comappingrubrics cm, courserubricsmapping cr where c.coid=cm.coid and cm.cmid=cr.cmid and c.coid=? and cr.type=?";    
            }
        }

        $stmt=$con->prepare($selectQuery);
        if($this->etype==="AAT"){
            $stmt->bind_param("i",$this->coid);   
        }
        else{
            $stmt->bind_param("is",$this->coid,$this->etype);
        }
        $stmt->execute();
        $result=$stmt->get_result();
         if($result->num_rows >0 ){   // $result->num_rows >0        
                // return "Already Entered the data!";
                if($this->ishaverubrics==0){
                    if($this->etype=="AAT"){
                        $result_ids=array();
                        $retrive_ids="SELECT atid from alternativetest where coid=$this->coid order by aatno";
                        $re=mysqli_query($con,$retrive_ids) or die(mysqli_error($con));
                        while($r=mysqli_fetch_row($re)){
                            array_push($result_ids,$r[0]);
                        }
                        // print_r($result_ids); exit();
                        foreach($result_ids as $k=>$id){
                            $del="DELETE FROM alternativetest WHERE atid=$id";
                            $res=mysqli_query($con,$del) or die(mysqli_error($con));
                        }
                    }
                    else{
                        $result_ids=array();
                        $retrive_ids="select mid from mappingcos where coid=$this->coid  and  examType='$this->etype' order by question";
                        $re=mysqli_query($con,$retrive_ids) or die(mysqli_error($con));
                        while($r=mysqli_fetch_row($re)){
                            array_push($result_ids,$r[0]);
                        }
                        // print_r($result_ids); exit();
                        foreach($result_ids as $k=>$id){
                            $del="DELETE FROM mappingcos WHERE mid=$id";
                            $res=mysqli_query($con,$del) or die(mysqli_error($con));
                        }
                    }
                }
                else{
                    if($this->isdefault==0){
                        $result_ids=array();
                        $retrive_ids="SELECT rmid from coursedetails c,rubricdescription rd,rubricmapping rm where c.coid=rd.coid and rd.rid=rm.rno and c.coid=$this->coid and rm.type='$this->etype'";
                        $re=mysqli_query($con,$retrive_ids) or die(mysqli_error($con));
                        while($r=mysqli_fetch_row($re)){
                            array_push($result_ids,$r[0]);
                        }

                        // print_r($result_ids); exit();
                        foreach($result_ids as $k=>$id){
                            $del="DELETE FROM rubricmapping WHERE rmid=$id";
                            $res=mysqli_query($con,$del) or die(mysqli_error($con));
                        }
                    }
                    else{
                        $result_ids=array();
                        $retrive_ids="SELECT cr.crid from coursedetails c,comappingrubrics cm, courserubricsmapping cr where c.coid=cm.coid and cm.cmid=cr.cmid and c.coid=$this->coid and cr.type='$this->etype'";
                        $re=mysqli_query($con,$retrive_ids) or die(mysqli_error($con));
                        while($r=mysqli_fetch_row($re)){
                            array_push($result_ids,$r[0]);
                        }
                        // print_r($result_ids); exit();
                        foreach($result_ids as $k=>$id){
                            $del="DELETE FROM courserubricsmapping WHERE crid=$id";
                            $res=mysqli_query($con,$del) or die(mysqli_error($con));
                        }
                    }
                }
                // return "removed";
        }   
        // else{
    
        if( ((strtolower($this->inputmar[$rows][$cols++])==="regulation") && ($this->inputmar[$rows++][$cols--]=== $this->regulation) && (strtolower($this->inputmar[$rows][$cols++])==="academic year") &&  ($this->inputmar[$rows++][$cols--]===$this->academicYear) 
        && (strtolower($this->inputmar[$rows][$cols++])==="branch") && ($this->inputmar[$rows++][$cols--]===$this->branch) && (strtolower($this->inputmar[$rows][$cols++])==="semesterno") && ($this->inputmar[$rows++][$cols--]==$this->semesterNo)  
        && (strtolower($this->inputmar[$rows][$cols++])==="coursecode") && ($this->inputmar[$rows++][$cols--]===$this->courseCode) && (strtolower($this->inputmar[$rows][$cols++])==="coursename")  && ($this->inputmar[$rows++][$cols--]===$this->courseName)
        && (strtolower($this->inputmar[$rows][$cols++])==="exam type") && ($this->inputmar[$rows++][$cols--]===$this->etype))
          ){
              $rows++;  
           if($this->ishaverubrics==0){
                if( ( (strtolower($this->inputmar[$rows++][$cols])==="max marks") && 
                    (strtolower($this->inputmar[$rows++][$cols])==="courseoutcomes") &&
                    (strtolower($this->inputmar[$rows++][$cols])==="questionno") &&
                    (strtolower($this->inputmar[$rows++][$cols])==="rollno")
                    ) 
                   ){
                    $this->maxMarksRow=$rows-=4;
                    if($this->paperStruct->assign_Questions($this->inputmar[$this->maxMarksRow+2],$this->inputmar[$this->maxMarksRow],$this->inputmar[$this->maxMarksRow+1])){
                        $this->maxMarksRow+=4;
                                for($row=$this->maxMarksRow;$row<count($this->inputmar);$row++){
                                        $student=new Student($this->inputmar[$row][0]);
                                        foreach($this->paperStruct->get_QustionName() as $k=>$v){
                                            // if(!empty($this->inputmar[$row][$k]) && $this->inputmar[$row][$k]!=-1 ){
                                                $student->set_marks($k,$this->inputmar[$row][$k]);
                                            // }
                                        }
                                        array_push($this->studentArray,$student);
                                }
                                return true;  
                    }
                    else{
                        return "Check the values of Max marks,Cos, Qno";
                    } 
                }
                else{
                    return "MisMatch of MaxMarks,Cos,QNo,Rollno order";
                }



           }
           else{
              if($this->isdefault==0){

                $rows=0;
                $cols=3;
                // echo "test= ".$this->inputmar[$rows][$cols];
                while(!empty($this->inputmar[$rows][$cols])){
                    $rows++;
                }

                $rows++;
                $cols=0;
                // echo "row= $rows";
                // exit();  Dr. Muni Sekhar Velpuru   Associate Professor & HOD  VCE296


                if( ( (strtolower($this->inputmar[$rows++][$cols])==="max marks") && 
                      (strtolower($this->inputmar[$rows++][$cols])==="rubric no") &&
                      (strtolower($this->inputmar[$rows++][$cols])==="rollno")
                ) 
               ){
                $this->maxMarksRow=$rows-=3;
                   if($this->paperStruct->assign_rubrics($this->inputmar[$this->maxMarksRow],$this->inputmar[$this->maxMarksRow+1])){
                      $this->maxMarksRow+=3;
                        for($row=$this->maxMarksRow;$row<count($this->inputmar);$row++){
                            $student=new Student($this->inputmar[$row][0]);
                            foreach($this->paperStruct->get_Rubric_description() as $k=>$v){
                                // if(!empty($this->inputmar[$row][$k]) && $this->inputmar[$row][$k]!=-1 ){
                                    $student->set_marks($k,$this->inputmar[$row][$k]);
                                // }
                            }
                            array_push($this->studentArray,$student);
                        }
                        return true;
                   }
                   else{
                    return "Check the values of Max Marks, Rubric no";
                   }
                }
                else{
                    return "MisMatch of MaxMarks,Rubricno,Rollno order";
                }     
              }
              else{

                if( ( (strtolower($this->inputmar[$rows++][$cols])==="max marks") && 
                (strtolower($this->inputmar[$rows++][$cols])==="rubric description") &&
                (strtolower($this->inputmar[$rows++][$cols])==="rollno")
                ) 
                ){
                    $this->maxMarksRow=$rows-=3;
                    if($this->paperStruct->assign_rubrics($this->inputmar[$this->maxMarksRow],$this->inputmar[$this->maxMarksRow+1])){
                        $this->maxMarksRow+=3;
                        for($row=$this->maxMarksRow;$row<count($this->inputmar);$row++){
                                $student=new Student($this->inputmar[$row][0]);
                                foreach($this->paperStruct->get_Rubric_description() as $k=>$v){
                                    // if(!empty($this->inputmar[$row][$k]) && $this->inputmar[$row][$k]!=-1 ){
                                        $student->set_marks($k,$this->inputmar[$row][$k]);
                                    // }
                                }
                                array_push($this->studentArray,$student);
                        }
                        return true;
                    }
                    else{
                        return "Check the values of Max Marks, Rubric description";
                    }
                }
                else{
                    return "MisMatch of MaxMarks,Rubric Description,Rollno order";
                }


              } 
           }


        }
        else{
            return  "Check The CourseDetails Heading and Values In Excel and ExamType Value Must Be $this->etype";
        }

    // }


    }

    private  function insert_a($coid,$per,$Q,$co){
        global $con;
        $insert_records="insert into alternativetest(coid,aatno,permarks,questionno,courseoutcomes) values($coid,'A_1',$per,'$Q','$co')";
        $result=mysqli_query($con,$insert_records) or die(mysqli_error($con));
    }

    private  function insert($coid,$examtype,$per,$Q,$co){
        global $con;
        $insert_records="insert into mappingcos(coid,examtype,noofStudents_A,question,courseoutcomes) values($coid,'$examtype',$per,'$Q','$co')";
        $result=mysqli_query($con,$insert_records) or die(mysqli_error($con));
    }
    private  function insert_cr($rid,$examtype,$per){
        global $con;
        $insert_records="insert into rubricmapping(rno,percal,type) values($rid,$per,'$examtype')";
        $result=mysqli_query($con,$insert_records) or die(mysqli_error($con));
    }

    private  function insert_fr($cmid,$examtype,$per){
        global $con;
        $insert_records="insert into courserubricsmapping(cmid,per,type) values($cmid,$per,'$examtype')";
        $result=mysqli_query($con,$insert_records) or die(mysqli_error($con));
    }
    
   


    public function insert_records(){
        global $con;

        if($this->ishaverubrics==0){
            foreach($this->paperStruct->get_QustionName() as $k=>$v ){
                 if($this->etype==="AAT"){
                    $this->insert_a($this->coid,$this->get_per()[$k],$this->paperStruct->get_QustionName()[$k],$this->paperStruct->get_courseoutcomes()[$k]);
                 }  
                 else{ 
                   $this->insert($this->coid,$this->etype,$this->get_per()[$k],$this->paperStruct->get_QustionName()[$k],$this->paperStruct->get_courseoutcomes()[$k]); 
                 }
            }
            return true;
        }
        else {
            if($this->isdefault==0){
                $rubrics_ids=array();
                $rubrics_type_ids=array();
                $get_rubrics="SELECT m.rid,courseCode,courseType,rno,rubricdes from coursedetails d,rubricdescription m where d.coid=m.coid and d.coid=$this->coid group by courseCode,rno";
                $result=mysqli_query($con,$get_rubrics) or die(mysqli_error($con));
                while($row=mysqli_fetch_row($result)){
                    $rubrics_ids[$row[3]]=$row[0];
                }
                $flage=true;
                foreach($this->paperStruct->get_Rubric_description() as $k=>$v){
                        if( ((int)$v[1])<=count($rubrics_ids) ){

                        }
                        else{
                            $flage=false;
                            break;
                        }
                }

                if($flage){
                    foreach($this->paperStruct->get_Rubric_description() as $k=>$v){
                        $temp=((int)$v[1]);
                        $this->insert_cr($rubrics_ids[$temp],$this->etype,$this->get_per()[$k]);
                    }
                    return true;
                }
                else{
                    return "rubric number Out Of Range";
                }

            }
            else{
                $rubrics_cmid=array();
                $insert_records="SELECT c.cmid,c.deid,cd.courseCode,cd.courseType,d.rno,d.description,c.courseoutcomes from coursedetails cd,comappingrubrics c,defaultrubricsdes d,defaultrubricmapping dm WHERE cd.coid=c.coid and c.deid=d.deid and d.deid=dm.deid and cd.coid=$this->coid and dm.reviewType='$this->etype'";
                $result=mysqli_query($con,$insert_records) or die(mysqli_error($con));
                while($row=mysqli_fetch_row($result)){
                    $rubrics_cmid[$row[5]]=$row[0];
                }
                $flage=true;
                foreach($this->paperStruct->get_Rubric_description() as $k=>$v){
                    if(in_array($v,array_keys($rubrics_cmid))){

                    }
                    else{
                        $flage=false;
                        break;
                    }
                }

                if($flage){
                     foreach($this->paperStruct->get_Rubric_description() as $k=>$v){
                        $this->insert_fr($rubrics_cmid[$v],$this->etype,$this->get_per()[$k]);
                     }
                     return true;
                }
                else{
                    return "Error in rubrics description check it out";
                }
                

                
                // print_r($rubrics_cmid);
                // exit();

            }

        }

    }

    public function calculate_per($branch){
        global $con;
        $retrive_tvalue="SELECT tvalue from batchweightage where branch ='$branch'";
        $res=mysqli_query($con,$retrive_tvalue) or die(mysqli_error($con));
        if(mysqli_num_rows($res)>0){
            $row=mysqli_fetch_row($res);
            $tvalue=$row[0];
        
            $Qarr=null;
           if($this->ishaverubrics==0){
                $Qarr=$this->paperStruct->get_QustionName() ;
           } 
           else{
               $Qarr=$this->paperStruct->get_Rubric_description(); 
           }

        //    print_r($Qarr); exit();
        foreach($Qarr as $k=>$v){
            $thresholdMarks=round((($this->paperStruct->get_maxMarks()[$k]*$tvalue)/100),2);
            $attempted=0;
            $above=0;
            //( $v1->get_marks()[$k]==0  or  !empty($v1->get_marks()[$k])  )  and 
            foreach($this->studentArray as $k1=>$v1){
                if( ( is_numeric($v1->get_marks()[$k])  )  and  $v1->get_marks()[$k]>=0){
                    if($v1->get_marks()[$k]>=$thresholdMarks){
                        $above++;
                    }
                    $attempted++;
                }
            }
            $this->totalAttampted[$k]=$attempted;
            $this->aboveSixty[$k]=$above;
            if($attempted!=0){
            $this->per[$k]=round((($above/$attempted)*100),2);
            }
            else{
                $this->per[$k]=0;
            }
        }   

            return true;
        }
        else{
            return "Contact Admin, Regrading Threshold Value";
        }

    }

    

    
}



include "autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

// print_r($_FILES); echo "<br><br>";
// print_r($_POST); exit();
$etype=$coid=$courseCode=null;
// print_r(!is_file($_FILES["select_excel"]["name"]));
// echo "<br><br>";
// exit(); 
if(isset($_SESSION['fid']) and !empty($_SESSION['fid'])){
    $branch=$_SESSION['department']; 

if(isset($_POST) and !empty($_POST)){
  if(isset($_POST['coid']) and !empty($_POST['coid']) ){ 
    if(isset($_POST['eType']) and !empty($_POST['eType']) ){
        if(isset($_POST['coursecode']) and !empty($_POST['coursecode'])){
        $etype=$_POST['eType'];
        $coid=$_POST['coid'];
        $courseCode=$_POST['coursecode'];

    if($_FILES["select_excel"]["name"] != '')
    {

 $allowed_extension = array('xls', 'xlsx','csv');
 $file_array = explode(".", $_FILES['select_excel']['name']);
 $file_extension = end($file_array);
 if(in_array($file_extension, $allowed_extension))
 {
    if($file_extension=="xlsx"){
    $reader = IOFactory::createReader('Xlsx');
    }
    else if($file_extension=="csv"){
        $reader = IOFactory::createReader('Csv');
    }
    else if($file_extension=="xls"){
        $reader = IOFactory::createReader('Xls');
    }
  $spreadsheet = $reader->load($_FILES['select_excel']['tmp_name']);
  $writer = IOFactory::createWriter($spreadsheet, 'Html');
     $mar=$spreadsheet->getActiveSheet()->toArray();
    // print_r($mar); exit();    
     if(count($mar)!=0){
        $studentMarks=new StudentMarks($mar,$etype,$courseCode,$coid);
        $ch_st=$studentMarks->assign_studentMarks();
        // echo $ch_st."<br>";
        // print_r($studentMarks); exit();
            if( is_bool($ch_st) ) {
               $ch_tvalue= $studentMarks->calculate_per($branch);
               if(is_bool($ch_tvalue)){
            //     print_r($studentMarks->get_paperStruct()->get_QustionName());
            // print_r($studentMarks->get_paperStruct()->get_courseoutcomes());
            // print_r($studentMarks->get_paperStruct()->get_Rubric_description());
            // print_r($studentMarks->get_totalAttempted());
            // print_r($studentMarks->get_aboveSixty());
            // print_r( $studentMarks->get_per() ); exit();
                $ch_re=$studentMarks->insert_records();
               if(is_bool($ch_re)){
            // print_r($studentMarks); exit();
           
                    // exit();

            $message = '<div class="alert alert-success">Successfully inserted data!!</div>';
            echo $message; 
                
                }
                else{
                    $message = '<div class="alert alert-danger">'.$ch_re.'</div>';
                    echo $message;
                }
            }
            else{
                $message = '<div class="alert alert-danger">'.$ch_tvalue.'</div>';
                echo $message;   
            }

            } else{
                $message = '<div class="alert alert-danger">'.$ch_st.'</div>';
                echo $message;
            }
        }else{
    
            $message = '<div class="alert alert-danger">Check the formate of the excel-2</div>';
            echo $message;      
        }
           
 }
 else
 {
  $message = '<div class="alert alert-danger">Only .xls or .xlsx file allowed</div>';
  echo $message;
 }
}
else
{
 $message = '<div class="alert alert-danger">Please Select File</div>';
 echo $message;
}

    // }
 }
 else{
    $message = '<div class="alert alert-danger">CourseCode is empty, Refresh and Retry</div>';
    echo $message;
 }

}
else{
    $message = '<div class="alert alert-danger">Exam Type is empty, Refresh and Retry</div>';
    echo $message;
}
}
else{
    $message = '<div class="alert alert-danger">coid is empty, Refresh and Retry</div>';
    echo $message;
}
}
else{
    $message = '<div class="alert alert-danger">Somthing Went Wrong!,Contact Developer/Admin</div>';
 echo $message;
}

}
else{
    $message = '<div class="alert alert-danger">Somthing Went Wrong!,Contact Developer/Admin - SESSION END</div>';
    echo $message;
}

?>
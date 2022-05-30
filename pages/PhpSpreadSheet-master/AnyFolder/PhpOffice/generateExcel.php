<?php

use PhpOffice\PhpSpreadsheet\Shared\JAMA\QRDecomposition;

include '../../../common/connection.php';
include "autoload.php";
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

Interface CreateExcel{
  public function assign_dropdown($sheet,$cell);
  public function generate_excel();
} 

// class ExcelStructure{
//     public $row;
//     public $col;
//     public $type;

//     public function __construct($r,$c,$t)
//     {
//       $this->row=$r;
//       $this->col=$c;
//       $this->type=$t;
//     }
//     public function get_row(){
//       return $this->row;
//     }
//     public function get_col(){
//       return $this->col;
//     }

//     private function assign_dropdown($sheet,$cell){
          
//           $validation=$sheet->getCell($cell)->getDataValidation();
//           $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            
//             //dropdown list options
//             $validation->setFormula1('"A, B, C, D"');
//             //do not allow empty value. 
//             $validation->setAllowBlank(false);
//             // show drop down
//             $validation->setShowDropDown(true);
//             // display a cell 'note' about the drop down list validation. 
//             $validation->setShowInputMessage(true);
//             //set the 'note' title 
//             $validation->setPromptTitle('Note');
//             // Describe the note
//             $validation->setPrompt('Must select one from the drop down options.');
//             //show the error message if data entered incorrect
//             $validation->setShowErrorMessage(true);
//             //don't allow any other data to be entered by setting the style to 'stop'
//             $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
//             //set description error title
//             $validation->setErrorTitle('Invalid option');
//             //set error message
//             $validation->setError('Select one from the drop down list.');
//     }

//     public function generate_excel(){
//           $spreadsheet=new Spreadsheet();
//           $sheet=$spreadsheet->getActiveSheet();
//           $sheet->setCellValue("$this->col$this->row",'Regulation');$this->row++;
//           $sheet->setCellValue("$this->col$this->row",'Academic Year');$this->row++;
//           $sheet->setCellValue("$this->col$this->row",'Branch');$this->row++;
//           $sheet->setCellValue("$this->col$this->row",'SemesterNo');$this->row++;
//           $sheet->setCellValue("$this->col$this->row",'CourseCode');$this->row++;
//           $sheet->setCellValue("$this->col$this->row",'CourseName');$this->row++;
//           $sheet->setCellValue("$this->col$this->row",'Exam Type');$this->row++;
//           $sheet->getColumnDimension('A')->setAutoSize(TRUE);
          
//           $this->col='B';
//           $this->row=1;

//           $sheet->setCellValue("$this->col$this->row",$this->regulation);$this->row++;
//           $sheet->setCellValue("$this->col$this->row",$this->academicYear);$this->row++;
//           $sheet->setCellValue("$this->col$this->row",$this->branch);$this->row++;
//           $sheet->setCellValue("$this->col$this->row",$this->semesterNo);$this->row++;
//           $sheet->setCellValue("$this->col$this->row",$this->courseCode);$this->row++;
//           $sheet->setCellValue("$this->col$this->row",$this->courseName);$this->row++;
//           $this->assign_dropdown($sheet,"$this->col$this->row");$this->row++;
//           $sheet->getColumnDimension('B')->setAutoSize(TRUE);
          
//           if($this->type==3){
//               $this->col='D';
//               $this->row=1;
//               $rub_desc=array('rubric-desc-1','rubric-desc-2','rubric-desc-3','rubric-desc-4','rubric-desc-5','rubric-desc-6','rubric-desc-7','rubric-desc-7');
//               $cos=array('CO1,CO2','CO4','CO5','CO3,CO4','CO3','CO2','CO4,CO5','CO1');
//               $sheet->setCellValue("$this->col$this->row",'Rubric No');$this->row++;
//               $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5'); 
//               for($i=1;$i<=8;$i++){
//               $sheet->setCellValue("$this->col$this->row","r$i");
//               $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
//               $this->row++;  
//             }
//               $sheet->getColumnDimension('D')->setAutoSize(TRUE);
              
//               $this->col='E';
//               $this->row=1;
//               $sheet->setCellValue("$this->col$this->row",'Rubric Description');$this->row++;
//               $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5'); 
//               foreach($rub_desc as $k=>$v){
//                 $sheet->setCellValue("$this->col$this->row",$v);
//                 $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
//                 $this->row++;
//               }
//               $sheet->getColumnDimension('E')->setAutoSize(TRUE);

//               $this->col='F';
//               $this->row=1;
//               $sheet->setCellValue("$this->col$this->row",'CourseOutcomes');$this->row++;
//               $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5'); 
//               foreach($cos as $k=>$v){
//                 $sheet->setCellValue("$this->col$this->row",$v);
//                 $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
//                 $this->row++;
//               }
//               $sheet->getColumnDimension('F')->setAutoSize(TRUE);

//           }

//           $this->col='A';
//           $this->row++;
//           $inital=$this->row;   
//           $sheet->setCellValue("$this->col$this->row",'Max Marks');$this->row++;
//           if($this->type==1){
//           $sheet->setCellValue("$this->col$this->row",'CourseOutcomes');$this->row++;
//           $sheet->setCellValue("$this->col$this->row",'QuestionNo');$this->row++;
//           }
//           else if($this->type==3){
//             $sheet->setCellValue("$this->col$this->row",'Rubric No');$this->row++;
//           }
//           else if($this->type==2){
//             $rub_desc=array('rubric_desc_1','rubric_desc_2','rubric_desc_3','rubric_desc_4','rubric_desc_5','rubric_desc_6');
//             $sheet->setCellValue("$this->col$this->row",'Rubric Description');
//             $this->col++;
//             foreach($rub_desc as $k=>$v){
//               $sheet->setCellValue("$this->col$this->row",$v);
//               $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
//               $sheet->getColumnDimension($this->col)->setAutoSize(TRUE);
//               $this->col++;     
//             }

//             $this->col='A';
//             $this->row++;
            
//           }
//           $sheet->setCellValue("$this->col$this->row",'Rollno');$this->row++;
//           $final=$this->row-1;


          


//           $spreadsheet->getActiveSheet()->getStyle('A1:A7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5');          
//           $spreadsheet->getActiveSheet()->getStyle('B1:B6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
//           $spreadsheet->getActiveSheet()->getStyle("A$inital:A$final")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5');          
//           $styleArray = array(
//             'borders' => array(
//                 'inside' => array(
//                     'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
//                     'color' => array('argb' => 'cccccc'),
//                 ),
//             ),
//         );
//           $sheet = $sheet ->getStyle('A1:F30')->applyFromArray($styleArray);
//         // $sheet = $sheet ->getStyle('B1:B6')->applyFromArray($styleArray);


      





//           header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//           header('Content-Disposition: attachment;filename="result.xlsx"');
//           // $writer=IOFactory::createWriter($spreadsheet,'Xlsx');
//           $writer=new Xlsx($spreadsheet);
//           $writer->save('php://output');

//     }

// }

class CourseDetails implements CreateExcel {
  private $regulation;
  private $academicYear;
  private $branch;
  private $semesterNo;
  private $courseCode;
  private $courseName;
  private $examType;
  private $coid;
  private $csid;
  private $row;
  private $col;
  private $type;
  private $noofcos;
  private $rubricdescription;
  private $rubricmapping;
  private $examTypeArray;

  function __construct($coid,$examType)
  { 
    global $con;
    
    $this->coid=$coid;
    $this->examType=$examType;
    $this->rubricdescription=array();
    $this->rubricmapping=array();
    $select_query="select regulation,academicYear,courseCode,branch,semesterNo,courseName,courseType,csid,no_of_cos from coursedetails where coid=?";
    $stmt=$con->prepare($select_query);
    $stmt->bind_param("i", $coid);
    $stmt->execute();
    if($result=$stmt->get_result()){
      $row=$result->fetch_row();
      $this->regulation=$row[0];
      $this->academicYear=$row[1];
      $this->branch=$row[3];
      $this->semesterNo=$row[4];
      $this->courseCode=$row[2];
      $this->courseName=$row[5];
      $this->csid=$row[7];
      $this->noofcos=$row[8];      
    }

    // $this->fetch_exam_types();

    
    $this->col='A';
    $this->row=1;

  }

  private function fetch_rubric_desc($isdefault){
    global $con;

  if($isdefault==0){ 
      $retrive_rubcricdesc="SELECT courseCode,courseType,rno,rubricdes from coursedetails d,rubricdescription m where d.coid=m.coid and d.coid=$this->coid group by courseCode,rno;";
  }
  else if($isdefault!=0){
      $retrive_rubcricdesc="SELECT cd.courseCode,cd.courseType,d.rno,d.description,c.courseoutcomes from coursedetails cd,comappingrubrics c,defaultrubricsdes d,defaultrubricmapping dm WHERE cd.coid=c.coid and c.deid=d.deid and d.deid=dm.deid and cd.coid=$this->coid and dm.reviewType='$this->examType' order by d.rno";
  }
  $result=mysqli_query($con,$retrive_rubcricdesc) or die(mysqli_error($con));
  while($row=mysqli_fetch_row($result)){
        $this->rubricdescription[$row[2]]=$row[3]; 
  }
  if($isdefault==0){
      $retrive_mapping="select rno,courseoutcomes from rubricdescription where coid=$this->coid";
  }
  else if($isdefault!=0){
      $retrive_mapping="SELECT d.rno,c.courseoutcomes from coursedetails cd,comappingrubrics c,defaultrubricsdes d,defaultrubricmapping dm WHERE cd.coid=c.coid and c.deid=d.deid and d.deid=dm.deid and cd.coid=$this->coid and dm.reviewType='$this->examType' order by d.rno ";    
  }
    $res=mysqli_query($con,$retrive_mapping) or die(mysqli_error($con));
    while($row=mysqli_fetch_row($res)){
      $this->rubricmapping[$row[0]]=$this->retrive_cos($this->noofcos,$row[1]);
    }
  
  }

  private function retrive_cos($noofcos,$val){
    $tem=array();
    for($i=1;$i<=$noofcos;$i++){
        $t="CO".$i;
        if(strpos($val,$t)!==false){
            array_push($tem,$t);
        }
    }
    return join(',',$tem);
  }

  public function fetch_exam_types(){
    global $con;
   if(!empty($this->noofcos)){
    $select_query1="SELECT csid,courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,int_par_short,int_par_long,int_proj_short,int_proj_long,ext_th_short,ext_th_long,ext_par_short,ext_par_long,ext_proj_short,ext_proj_long,isdefault from coursestructure1 where csid=?";
    $stmt=$con->prepare($select_query1);
    $stmt->bind_param("i",$this->csid);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=$result->fetch_row();
    $ishaveinternal=$row[3];
    $ishaveexternal=$row[4];
    $ishaveaat=$row[5];
    $type=$row[6];
    $isdefault=$row[19];
    $internal=array();
    $internal_s=array();
    $internal_f=array();
    $external_s=array();
    $external_f=array();

    if($type=="theoretical"){
        $this->type=1;

        if($ishaveinternal=="1"){
          $in_th_s=explode(",",$row[7]);
          $in_th_l=explode(",",$row[8]);

          $internal_s=$in_th_s;
          $internal_f=$in_th_l;

        }
        if($ishaveexternal=="1"){
            $ex_th_s=explode(",",$row[13]);
            $ex_th_l=explode(",",$row[14]);

            $external_s=$ex_th_s;
            $external_f=$ex_th_l;
        }

    }
    else if($type=="practical"){
      $this->type=1;
        if($ishaveinternal=="1"){
            $in_pa_s=explode(",",$row[9]);
            $in_pa_l=explode(",",$row[10]);

            $internal_s=$in_pa_s;
            $internal_f=$in_pa_l;

          }
          if($ishaveexternal=="1"){
              $ex_pa_s=explode(",",$row[15]);
              $ex_pa_l=explode(",",$row[16]);

              $external_s=$ex_pa_s;
              $external_f=$ex_pa_l;
          }

    }
    else if($type=="both"){
      $this->type=1;
        if($ishaveinternal=="1"){
            $in_th_s=explode(",",$row[7]);
            $in_th_l=explode(",",$row[8]);
            $in_pa_s=explode(",",$row[9]);
            $in_pa_l=explode(",",$row[10]);

            $internal_s=array_merge($in_th_s,$in_pa_s);
            $internal_f=array_merge($in_th_l,$in_pa_l);

          }
          if($ishaveexternal=="1"){
            $ex_th_s=explode(",",$row[13]);
            $ex_th_l=explode(",",$row[14]);
            $ex_pa_s=explode(",",$row[15]);
            $ex_pa_l=explode(",",$row[16]);

            $external_s=array_merge($ex_th_s,$ex_pa_s);
            $external_f=array_merge($ex_th_l,$ex_pa_l);
        }


    }
    else if($type=="project"){
      $this->fetch_rubric_desc($isdefault);

      if(count($this->rubricdescription)==0){
          return "Enter the CourseDetails and rubric description first";
      }

      if($isdefault!=0){
        $this->type=2;
      }
      else{
        $this->type=3;
      }

        if($ishaveinternal=="1"){
            $in_proj_s=explode(",",$row[11]);
            $in_proj_l=explode(",",$row[12]);

            $internal_s=$in_proj_s;
            $internal_f=$in_proj_l;

          }
          if($ishaveexternal=="1"){
              $ex_proj_s=explode(",",$row[17]);
              $ex_proj_l=explode(",",$row[18]);

              $external_s=$ex_proj_s;
              $external_f=$ex_proj_l;
          }

    }


    // print_r($internal_s);
    // print_r($external_f);
    if($ishaveinternal=="1"){
        foreach($internal_s as $key=>$val){
            array_push($internal,$val);
        }
    }
    if($ishaveaat=="1"){
        array_push($internal,"AAT");
    }
    if($ishaveexternal=="1"){
        foreach($external_s as $key=>$val){
            array_push($internal,$val);
        }
    }
    // print_r($internal);exit();
    $ishaverubric=$row[2];
    
    $this->examTypeArray=$internal;

    return true;
  }

    return false;

    
  }

  public function generate_excel(){
    $spreadsheet=new Spreadsheet();
    $sheet=$spreadsheet->getActiveSheet();
    $sheet->setCellValue("$this->col$this->row",'Regulation');$this->row++;
    $sheet->setCellValue("$this->col$this->row",'Academic Year');$this->row++;
    $sheet->setCellValue("$this->col$this->row",'Branch');$this->row++;
    $sheet->setCellValue("$this->col$this->row",'SemesterNo');$this->row++;
    $sheet->setCellValue("$this->col$this->row",'CourseCode');$this->row++;
    $sheet->setCellValue("$this->col$this->row",'CourseName');$this->row++;
    $sheet->setCellValue("$this->col$this->row",'Exam Type');$this->row++;
    $sheet->getColumnDimension('A')->setAutoSize(TRUE);
    
    $this->col='B';
    $this->row=1;

    $sheet->setCellValue("$this->col$this->row",$this->regulation);$this->row++;
    $sheet->setCellValue("$this->col$this->row",$this->academicYear);$this->row++;
    $sheet->setCellValue("$this->col$this->row",$this->branch);$this->row++;
    $sheet->setCellValue("$this->col$this->row",$this->semesterNo);$this->row++;
    $sheet->setCellValue("$this->col$this->row",$this->courseCode);$this->row++;
    $sheet->setCellValue("$this->col$this->row",$this->courseName);$this->row++;
    $sheet->setCellValue("$this->col$this->row",$this->examType);$this->row++;
    // $this->assign_dropdown($sheet,"$this->col$this->row");$this->row++;
    $sheet->getColumnDimension('B')->setAutoSize(TRUE);
    
    if($this->type==3){
        $this->col='D';
        $this->row=1;
        // $rub_desc=array('rubric-desc-1','rubric-desc-2','rubric-desc-3','rubric-desc-4','rubric-desc-5','rubric-desc-6','rubric-desc-7','rubric-desc-7');
        // $cos=array('CO1,CO2','CO4','CO5','CO3,CO4','CO3','CO2','CO4,CO5','CO1');
        
        $rub_desc=$this->rubricdescription;
        $cos=$this->rubricmapping;

        // print_r($rub_desc);
        // print_r($cos); exit();
        
        $sheet->setCellValue("$this->col$this->row",'Rubric No');$this->row++;
        $spreadsheet->getActiveSheet()->getStyle('D1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5'); 
        for($i=1;$i<=count($rub_desc);$i++){
        $sheet->setCellValue("$this->col$this->row","r$i");
        $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
        $this->row++;  
      }
        $sheet->getColumnDimension('D')->setAutoSize(TRUE);
        
        $this->col='E';
        $this->row=1;
        $sheet->setCellValue("$this->col$this->row",'Rubric Description');$this->row++;
        $spreadsheet->getActiveSheet()->getStyle('E1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5'); 
        foreach($rub_desc as $k=>$v){
          $sheet->setCellValue("$this->col$this->row",$v);
          $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
          $this->row++;
        }
        $sheet->getColumnDimension('E')->setAutoSize(TRUE);

        $this->col='F';
        $this->row=1;
        $sheet->setCellValue("$this->col$this->row",'CourseOutcomes');$this->row++;
        $spreadsheet->getActiveSheet()->getStyle('F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5'); 
        foreach($cos as $k=>$v){
          $sheet->setCellValue("$this->col$this->row",$this->retrive_cos($this->noofcos,$v));
          $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
          $this->row++;
        }
        $sheet->getColumnDimension('F')->setAutoSize(TRUE);

    }

    $this->col='A';
    $this->row++;
    $inital=$this->row;   
    $sheet->setCellValue("$this->col$this->row",'Max Marks');$this->row++;
    if($this->type==1){
    $sheet->setCellValue("$this->col$this->row",'CourseOutcomes');$this->row++;
    $sheet->setCellValue("$this->col$this->row",'QuestionNo');$this->row++;
    }
    else if($this->type==3){
      $sheet->setCellValue("$this->col$this->row",'Rubric No');$this->row++;
    }
    else if($this->type==2){
      // $rub_desc=array('rubric_desc_1','rubric_desc_2','rubric_desc_3','rubric_desc_4','rubric_desc_5','rubric_desc_6');
      
      $rub_desc=$this->rubricdescription;
      $sheet->setCellValue("$this->col$this->row",'Rubric Description');
      $this->col++;
      foreach($rub_desc as $k=>$v){
        $sheet->setCellValue("$this->col$this->row",$v);
        $spreadsheet->getActiveSheet()->getStyle("$this->col$this->row")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
        $sheet->getColumnDimension($this->col)->setAutoSize(TRUE);
        $this->col++;     
      }

      $this->col='A';
      $this->row++;
      
    }
    $sheet->setCellValue("$this->col$this->row",'Rollno');$this->row++;
    $final=$this->row-1;


    


    $spreadsheet->getActiveSheet()->getStyle('A1:A7')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5');          
    $spreadsheet->getActiveSheet()->getStyle('B1:B6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('8DB4E2');
    $spreadsheet->getActiveSheet()->getStyle("A$inital:A$final")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('538DD5');          
    $styleArray = array(
      'borders' => array(
          'inside' => array(
              'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_HAIR,
              'color' => array('argb' => 'cccccc'),
          ),
      ),
  );
    $sheet = $sheet ->getStyle('A1:F30')->applyFromArray($styleArray);
    
    $filename=$this->regulation.'_'.$this->academicYear.'_'.$this->branch.'_'.$this->courseCode.'_'.$this->examType;

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
    // $writer=IOFactory::createWriter($spreadsheet,'Xlsx');  not selected
    $writer=new Xlsx($spreadsheet);
    $writer->save('php://output');

    // header('location:facultyPage1.php');
    // $date = date('d-m-y-'.substr((string)microtime(), 1, 8));
    // $date = str_replace(".", "", $date);
    // $filename = "export_".$date.".xlsx";
    
    // try {
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save($filename);
    //     $content = file_get_contents($filename);
    // } catch(Exception $e) {
    //     exit($e->getMessage());
    // }
    
    // header("Content-Disposition: attachment; filename=".$filename);
    
    // unlink($filename);
    // exit($content);




    }

  public function assign_dropdown($sheet,$cell){
          
    $validation=$sheet->getCell($cell)->getDataValidation();
    $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
    $str1=join(",",$this->examTypeArray);
      // print_r($str1);
      // echo "<br>"; 
      // echo "'$str1'";
      // exit();
      //dropdown list options '"A,B,C,D"'
      $validation->setFormula1('"A,B,C,D"');
      //do not allow empty value. 
      $validation->setAllowBlank(false);
      // show drop down
      $validation->setShowDropDown(true);
      // display a cell 'note' about the drop down list validation. 
      $validation->setShowInputMessage(true);
      //set the 'note' title 
      $validation->setPromptTitle('Note');
      // Describe the note
      $validation->setPrompt('Must select one from the drop down options.');
      //show the error message if data entered incorrect
      $validation->setShowErrorMessage(true);
      //don't allow any other data to be entered by setting the style to 'stop'
      $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
      //set description error title
      $validation->setErrorTitle('Invalid option');
      //set error message
      $validation->setError('Select one from the drop down list.');
}


  public function get_excel(){
       return  $this->excelStruct; 
  }
  public function get_regulation(){
    return $this->regulation;
  }
  public function get_academicYear(){
    return $this->academicYear;
  }
  public function get_branch(){
    return $this->branch;
  }
  public function get_semesterNo(){
    return $this->semesterNo;
  }
  public function get_courseCode(){
    return $this->courseCode; 
  }
  public function get_courseName(){
    return $this->courseName;
  }
  public function get_examType(){
    return $this->examType;
  }


}


$coid=$examtype=null;
// print_r($_GET);exit();
// $course=new CourseDetails('R-18','2018-2022','IT',1,'A4603','programming in python');
// print_r($course);
// $course->get_excel()->generate_excel($course->get_regulation(),$course->get_academicYear(),$course->get_branch(),$course->get_semesterNo(),$course->get_courseCode(),$course->get_courseName());

if(isset($_GET) and !empty($_GET)){

  if(isset($_GET['coid']) and !empty($_GET['coid']) ){
      if(isset($_GET['examtype']) and !empty($_GET['examtype'])){
          $coid=$_GET['coid'];
          $examtype=$_GET['examtype'];
          $course=new CourseDetails($coid,$examtype);
          $ch_re=$course->fetch_exam_types();
          if(is_bool($ch_re)){
          // print_r($course);
          $course->generate_excel();
          // header('location:facultyPage1.php');
          // echo '<h5 class="color:green">download Successfully</h5>';
          }
          else{
            echo '<h5 class="color:red">'.$ch_re.'</h5>';       
          }
      }else{
        echo '<h5 class="color:red">coid is empty</h5>';
      }
  }
  else{
    echo '<h5 class="color:red">examType is empty</h5>'; 
  }
}
else{
  echo '<h5 class="color:red">SomeThing Went Wrong, Contact Admin</h5>';
}










?>
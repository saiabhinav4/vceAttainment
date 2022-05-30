<?php
include '../common/connection.php';
// print_r($_SESSION); exit();
// if(isset($_SESSION['fid']) and !empty($_SESSION['fid'])){
// }
// else{
//     // echo "inside redirect";
//     header('location:index.php');
// }
/*
Note: setY() before setX() (important);
      next heading gap: getY()+8;
(0,0)                                            
------------------------------------------------->X(max:(200,0))
|
|
|
|
|
|
|
|
Y(max: 1:(0,267), 2:(0,267))
*/
// function changeDepartment($in){
//     if($in=="IT"){
//          return "Information Technology";
//     } 
//     else if($in=="CSE"){
//          return "Computer Science And Engineering";
//     }
//     else if($in=="ECE"){
//          return "Electronics and Communication Engineering";
//     }
//     else if($in=="EEE"){
//          return "Electrical and Electronics Engineering";
//     }
//     else if($in=="MECH"){
//         return "Mechanical Engineering";
//     }
//     else if($in=="CIVIL"){
//          return "Civil Engineering";
//     }
// }
function customize($str){
 $str=trim($str);
 $result=preg_replace('/[ ]+/',',',$str);
 return $result;
}
function generateAcadYear($in2,$in1){
      $te=0;
      if($in1==1 or $in1==2){
         $te=0;
      }else if($in1==3 or $in1==4){
         $te=1;
      }else if($in1==5 or $in1==6){
         $te=2;
      }   
      else if($in1==7 or $in1==8){
         $te=3;
      }
      $in2=$in2+$te;
      return $in2."-".($in2+1);
}
function generateyear($in1){
 $te="";
 if($in1==1 or $in1==2){
    $te="1st Year ";
 }else if($in1==3 or $in1==4){
    $te="2nd Year ";
 }else if($in1==5 or $in1==6){
    $te="3rd Year ";
 }   
 else if($in1==7 or $in1==8){
    $te="4th Year ";
 }
 if($in1%2==0){
     $te=$te."II sem";
 }
 else{
     $te=$te."I sem";
 }
 return $te;
}


$regulation=$academicYear=$branch=$semesterNo=$coursecode=null;
$heading_gap=8;
$charray=array('PO1'=>'N','PO2'=>'N','PO3'=>'N','PO4'=>'N','PO5'=>'N','PO6'=>'N','PO7'=>'N','PO8'=>'N','PO9'=>'N','PO10'=>'N','PO11'=>'N','PO12'=>'N','PSO1'=>'N','PSO2'=>'N');
if(isset($_GET) and !empty($_GET)){
 if(isset($_GET['regulation']) and !empty($_GET['regulation'])){
    if(isset($_GET['academicYear']) and !empty($_GET['academicYear'])){
        if(isset($_GET['branch']) and !empty($_GET['branch'])){
            if(isset($_GET['semesterno']) and !empty($_GET['semesterno'])){
                if(isset($_GET['coursecode']) and !empty($_GET['coursecode'])){
                    if(isset($_GET['catw']) and !empty($_GET['catw'])){
                        if(isset($_GET['seew']) and !empty($_GET['seew'])){
                            if(isset($_GET['directCO']) and !empty($_GET['directCO'])){
                                if(isset($_GET['indirectCO']) and !empty($_GET['indirectCO'])){
                                    if(isset($_GET['targetA']) and !empty($_GET['targetA'])){
                                        if(isset($_GET['level1']) and !empty($_GET['level1'])){
                                            if(isset($_GET['level2']) and !empty($_GET['level2'])){
                                                if(isset($_GET['level3']) and !empty($_GET['level3'])){
                        $regulation=$_GET['regulation'];
                        $academicYear=$_GET['academicYear'];
                        $branch=$_GET['branch'];
                        $semesterNo=$_GET['semesterno'];
                        $coursecode=$_GET['coursecode'];
                        $ciew=$_GET['catw'];
                        $seew=$_GET['seew'];
                        $directw=$_GET['directCO'];
                        $indirectw=$_GET['indirectCO'];
                        $targetA=$_GET['targetA'];
                        $level1=$_GET['level1'];
                        $level2=$_GET['level2'];
                        $level3=$_GET['level3'];
                        $url="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regulation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&coursecode=".$coursecode."&catw=".$ciew."&seew=".$seew."&targetA=".$targetA."&directCO=".$directw."&indirectCO=".$indirectw."&level1=".$level1."&level2=".$level2."&level3=".$level3."&endpoint=COURSECOPDF";
                        $data=file_get_contents($url);
                        $decode_Data=json_decode($data,true);
                        if(isset($decode_Data['error'])){
                            echo '<p style="color:red;">'.$decode_Data['error'].'</p>';
                        }
                        else{
                            $pourl="http://localhost/templete/pages/scripts/simpleapi4.php?regulation=".$regulation."&academicYear=".$academicYear."&branch=".$branch."&semesterNo=".$semesterNo."&coursecode=".$coursecode."&catw=".$ciew."&seew=".$seew."&targetA=".$targetA."&directCO=".$directw."&indirectCO=".$indirectw."&level1=".$level1."&level2=".$level2."&level3=".$level3."&endpoint=DIRECTPOATTAINMENT";
                            $dataPO=file_get_contents($pourl);
                            $decode_DataPO=json_decode($dataPO,true);
                            if(isset($decode_DataPO['error'])){
                                echo '<p style="color:red;">'.$decode_DataPO['error'].'</p>';
                            }else{

                             $POArray=$decode_DataPO['directpoAttainment'][0]['pos'];
                            

                            $br=get_department($decode_Data['branch']);
                            $re=explode('-',$decode_Data['academicYear']);
                            $acd=generateAcadYear(((int)$re[0]),$decode_Data['semesterno']);
                            $batch=$re[0];
                            $ye=generateyear($decode_Data['semesterno']);
                            $coursedetails=$decode_Data['courselist']['coursedetails'][0];
                            // print_r($coursedetails); echo "<br>";
                            $fileName=$coursedetails['coursecode']."_Attainment";
                            
                            require_once('../tcpdf/tcpdf.php');
                            class MYPDF extends TCPDF {
                                public $departmentName;
                                public function __construct($arg1,$arg2,$arg3,$arg4,$arg5,$arg6,$na){
                                    TCPDF::__construct($arg1,$arg2,$arg3,$arg4,$arg5,$arg6);
                                       $this->departmentName=$na; 
                                }
                                    //Page header
                                    public function Header() {
                                    // Logo
                                    $image_file = '../../images/vcelogo.jpg';
                                    $this->Image($image_file, 10, 10, 15,'', 'JPG', '', 'M', false, 300, 'C', false, false, 0, false, false, false);
                                    // Set font
                                    $this->ln();
                                    // $this->ln();
                                    // $this->ln();
                                    $this->SetFont('helvetica', 'B', 12);
                                    // Title  
                                    $this->Cell(0, 15,'', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                                    $this->Cell(0, 0, 'VARDHAMAN COLLEGE OF ENGINEERING, HYDERABAD', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                                    $this->ln();
                                    $this->SetFont('', 'B', 10);
                                    $this->Cell(0, 0, 'Autonomous institute, affiliated to JNTUH', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                                    $this->ln();
                                    $this->Cell(0, 0, 'Department of '.$this->departmentName, 0, false, 'C', 0, '', 0, false, 'M', 'M');
                                    $this->ln();
                                    // $this->SetFont('', 'B', 10);
                                    // $this->Cell(0, 0, 'Semester: Jan - Jun 2015', 0, false, 'C', 0, '', 0, false, 'M', 'M');
                                    $this->ln();
                                }
                    
                                // Page footer
                                public function Footer() {
                                    // Position at 15 mm from bottom
                                    $this->SetY(-15);
                                    // Set font
                                    $this->SetFont('helvetica', 'I', 8);
                                    // Page number
                                    $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
                                }
                            }
                            

                            $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT,'A4', false, 'UTF-8', false,$br);

                            $pdf->SetCreator(PDF_CREATOR);
                            $pdf->SetAuthor('vardhaman college of engineering');
                            $pdf->SetTitle($coursedetails['coursecode']." CO Attainment");
                            $pdf->SetSubject('CO Attainment Description');
                            $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

                            // set default header data
                            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

                            // set header and footer fonts
                            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                            // set default monospaced font
                            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                            // set margins
                            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                            // set auto page breaks
                            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                            // set image scale factor
                            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                            // set some language-dependent strings (optional)
                            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                                require_once(dirname(__FILE__).'/lang/eng.php');
                                $pdf->setLanguageArray($l);
                            }

                            $pdf->AddPage();
                            $pdf->SetPrintHeader(false);
                            $pdf->SetPrintFooter(false);
                            // print_r($pdf->GetX());
                            // print_r($pdf->GetY());exit();
                            // echo "x=".$pdf->GetX()."  y=".$pdf->GetY()."<br>"; exit();
                            $pdf->Cell(0, 30,'', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                            $pdf->Cell(0, 0,'Course Outcome Attainment', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                            $pdf->SetFont('helvetica', '', 10);
                            $strSInfoName = array('Course Code:', 'Course Name:', 'Academic Year:', 'Year and Semester:', 'Regulation:', 'Batch:');
                            $strSInfoValue = array($coursedetails['coursecode'],$coursedetails['coursename'],$acd,$ye, $decode_Data['regulation'],$batch);
                            $pdf->ln();
                            //file_put_contents('./wtf.txt', $pdf->GetY());
                            foreach($strSInfoName as $key => $value)
                             {
                                $pdf->Cell(40, 5, $strSInfoName[$key], 0,  0, 'L', 0);
                                $pdf->Cell(75, 5, $strSInfoValue[$key], 0,  0, 'L', 0);
                                $pdf->ln();     
                             }
                             $x=$pdf->GetX();
                             $y=$pdf->GetY();
                            //  echo "x=".$x."  y=".$y."<br>"; exit();
                             $pdf->SetX($pdf->GetX());
                             $pdf->SetY(80+$heading_gap);


                             $pdf->SetFont('helvetica', 'B', 10);
                             $pdf->Cell(75, 5, 'Course Assessment Tools and Weightages', 0,  0, 'L', 0);

                             $pdf->SetY($pdf->GetY()+$heading_gap);
                             $pdf->SetFont('helvetica', 'B', 8);
                             $pdf->Cell(80, 8, 'Direct Assessment(DA)', 1,  0, 'C', 0);
                             $pdf->Cell(80, 8, 'Indirect Assessment(IA)', 1,  0, 'C', 0);
                             $pdf->ln();
                             $pdf->Cell(60, 7, 'Assessment Tool','LRB',  0, 'C', 0);
                             $pdf->Cell(20, 7, 'Weightage','B',  0, 'C', 0);
                             $pdf->Cell(60, 7, 'Assessment Tool','LBR',  0, 'C', 0);
                             $pdf->Cell(20, 7, 'Weightage','BR',  0, 'C', 0);
                             $pdf->ln();
                             $pdf->SetFont('helvetica', '', 8);
                             if($coursedetails['structure']['type']=="both"){
                                    $ith_c=0;
                                    $ipr_c=0;
                                    $eth_c=0;
                                    $epr_c=0;
                                    $IT=0;$IP=0;$ET=0;$EP=0;
                                    $cie=0;$see=0;
                                    if($coursedetails['structure']['ishaveinternal']){
                                        $ith_c=count($coursedetails['structure']['internal_theory_short']);
                                        $ipr_c=count($coursedetails['structure']['internal_practical_short']);
                                    }
                                    if($coursedetails['structure']['ishaveexternal']){
                                        $eth_c=count($coursedetails['structure']['external_theory_short']);
                                        $epr_c=count($coursedetails['structure']['external_practical_short']);
                                    }
                                     
                                    if($ith_c!=0){   $IT=$ith_c;   }else{  $IT=1;  }
                                    if($ipr_c!=0){   $IP=$ipr_c;   }else{  $IP=1;  }
                                    if($eth_c!=0){   $ET=$eth_c;   }else{  $ET=1;  }
                                    if($epr_c!=0){   $EP=$epr_c;   }else{  $EP=1;  }
                                    $cie= ($IT*5 ) + ($IP*5)+ (5*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                    $see=($ET*5) + ($EP*5);
                                    $x=$pdf->GetX();
                                    $y=$pdf->GetY();
                                    // x=15, y=111 echo "x= ".$x." y=".$y; exit();
                                    $pdf->Cell(15, $cie , 'CIE','LBR',  0, 'C', 0,1,1); $x+=15;
                                    $pdf->Cell(30, $IT*5, 'Theory','LBR',  0, 'C', 0,1,1); $x+=30;
                                    if(count($coursedetails['structure']['internal_theory_short'])!=0){
                                        foreach($coursedetails['structure']['internal_theory_short'] as $k=>$v){
                                            $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                            $pdf->SetY($y);
                                            $pdf->SetX($x);
                                        }
                                    }
                                    else
                                    {
                                        $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    //x=60  y=121
                                    //   echo "x=$x y=$y"; exit();
                                    // echo "x= ".$pdf->GetX()." y=". $pdf->GetY()."   xi=$x"; exit();
                                    $x=$x-30;
                                    $pdf->SetX($x);
                                    $pdf->Cell(30, $IP*5, 'Practical','LBR',  0, 'C', 0,1,1);
                                    $x=$x+30;
                                    if(count($coursedetails['structure']['internal_practical_short'])!=0){
                                        foreach($coursedetails['structure']['internal_practical_short'] as $k=>$v){
                                            $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5; //$x-=15; 
                                            $pdf->SetY($y);
                                            $pdf->SetX($x);
                                        }
                                    }else
                                    {
                                        $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5; //$x-=15; 
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    $x=$x-30;
                                    $pdf->SetX($x);
                                    $pdf->Cell(45, 5,'AAT','B',  0, 'C', 0,1,1);
                                    //x=30,y=131   echo "x=$x y=$y"; exit();
                                    $x=$x-15;
                                    $y=$y+5;
                                    $pdf->SetX($x);
                                    $pdf->SetY($y);
                                    $pdf->Cell(15, $see , 'SEE','LBR',  0, 'C', 0,1,1); $x+=15;
                                    $pdf->Cell(30, $ET*5, 'Theory','LBR',  0, 'C', 0,1,1); $x+=30;
                                    if( count($coursedetails['structure']['external_theory_short'])!=0){
                                        foreach($coursedetails['structure']['external_theory_short'] as $k=>$v){
                                            $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                            $pdf->SetY($y);
                                            $pdf->SetX($x);
                                        }
                                    }
                                    else{
                                        $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }

                                    $x=$x-30;
                                    $pdf->SetX($x);
                                    $pdf->Cell(30, $EP*5, 'Practical','LBR',  0, 'C', 0,1,1);
                                    $x=$x+30;
                                    if(count($coursedetails['structure']['external_practical_short'] )!=0){
                                        foreach($coursedetails['structure']['external_practical_short'] as $k=>$v){
                                            $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5; //$x-=15; 
                                            $pdf->SetY($y);
                                            $pdf->SetX($x);
                                        }
                                    }
                                    else{

                                        $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5; //$x-=15; 
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);

                                    }
                                    
                                    // $x=$x-45;
                                    // $pdf->SetX($x);
                                    //  echo "x= ".$pdf->GetX()." y=". $pdf->GetY()."   xi=$x"; exit();
                                    $y=$y-($cie+$see);
                                    $pdf->SetY($y);
                                    $x=$x+15;
                                    $pdf->SetX($x); 
                                    $pdf->Cell(20,$cie,$decode_Data['courselist']['CIEw']."%",'LBR',  0, 'C', 0,1,1);$y+=$cie;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->Cell(20,$see,$decode_Data['courselist']['SEEw']."%",'LBR',  0, 'C', 0,1,1);$y+=$see;

                                    //x= 95 y=136 xi=75   echo "x= ".$pdf->GetX()." y=". $pdf->GetY()."   xi=$x"; exit();
                                   
                                    $y=$y-($cie+$see);
                                    $pdf->SetY($y);
                                    $x=$x+20;
                                    $pdf->SetX($x); 
                                    // $pdf->Cell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)','BR',  0, 'L', 0,1,1);
                                    $pdf->MultiCell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)', 'BR', 'C', 0, 0, '', '', true,0,false,true,30,'M');
                                    $pdf->Cell(20,($cie+$see),'100%','BR',  0, 'C', 0,1,1);
                                    
                                    $y=$y+($cie+$see);
                                    $x=15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->Cell(60,6,'Total (CIE + SEE)','LBR',  0, 'C', 0,1,1);  
                                    $pdf->Cell(20,6,($decode_Data['courselist']['CIEw']+$decode_Data['courselist']['SEEw'])."%",'B',  0, 'C', 0,1,1);
                                    $pdf->Cell(60,6,'Total (CES)','LBR',  0, 'C', 0,1,1);
                                    $pdf->Cell(20,6,'100%','BR',  0, 'C', 0,1,1);

                                    $y=$y+6;
                                    $pdf->SetY($y);
                                    $x=15;
                                    $pdf->SetX($x);
                                    $pdf->Cell(80, 6, 'Weightage of Direct Assessment(DA) is '.$decode_Data['courselist']['codirectw'].'%','LBR',  0, 'C', 0,1,1);
                                    $pdf->Cell(80, 6, 'Weightage of InDirect Assessment(IA) is '.$decode_Data['courselist']['coindirectw'].'%','BR',  0, 'C', 0,1,1);

                                    $y=$y+6;
                                    $pdf->SetY($y);
                                    $x=15;
                                    $pdf->SetX($x);
                                    $pdf->Cell(160, 6, 'TOTAL = DA + IA = '.($decode_Data['courselist']['codirectw']+$decode_Data['courselist']['coindirectw']).'%','LBR',  0, 'C', 0,1,1);

                                    $y=$y+6;
                                    $pdf->SetY($y);
                                    $x=15;
                                    $pdf->SetX($x);

                                    

                             }
                             else if($coursedetails['structure']['type']=="theoretical"){
                                $ith_c=0;
                                $eth_c=0;
                                $IT=0;$ET=0;
                                $cie=0;$see=0;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $ith_c=count($coursedetails['structure']['internal_theory_short']);
                                }
                                if($coursedetails['structure']['ishaveexternal']){
                                    $eth_c=count($coursedetails['structure']['external_theory_short']);
                                }
                                if($ith_c!=0){   $IT=$ith_c;   }else{  $IT=1;  }
                                if($eth_c!=0){   $ET=$eth_c;   }else{  $ET=1;  }
                                $cie= ($IT*5 ) + (5*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $see=($ET*5);

                                $x=$pdf->GetX();
                                $y=$pdf->GetY();

                                $pdf->Cell(15, $cie , 'CIE','LBR',  0, 'C', 0,1,1); $x+=15;
                                $pdf->Cell(30, $IT*5, 'Theory','LBR',  0, 'C', 0,1,1); $x+=30;
                                if(count($coursedetails['structure']['internal_theory_short'])!=0){
                                    foreach($coursedetails['structure']['internal_theory_short'] as $k=>$v){
                                        $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                }else
                                {
                                    $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }

                                $x=$x-30;
                                $pdf->SetX($x);
                                $pdf->Cell(45, 5,'AAT','B',  0, 'C', 0,1,1);

                                $x=$x-15;
                                $y=$y+5;
                                $pdf->SetX($x);
                                $pdf->SetY($y);
                                $pdf->Cell(15, $see , 'SEE','LBR',  0, 'C', 0,1,1); $x+=15;
                                $pdf->Cell(30, $ET*5, 'Theory','LBR',  0, 'C', 0,1,1); $x+=30;
                                if(count($coursedetails['structure']['external_theory_short'])!=0){
                                    foreach($coursedetails['structure']['external_theory_short'] as $k=>$v){
                                        $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                }else
                                {
                                    $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }


                                $y=$y-($cie+$see);
                                $pdf->SetY($y);
                                $x=$x+15;
                                $pdf->SetX($x); 
                                $pdf->Cell(20,$cie,$decode_Data['courselist']['CIEw']."%",'LBR',  0, 'C', 0,1,1);$y+=$cie;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(20,$see,$decode_Data['courselist']['SEEw']."%",'LBR',  0, 'C', 0,1,1);$y+=$see;

                                $y=$y-($cie+$see);
                                $pdf->SetY($y);
                                $x=$x+20;
                                $pdf->SetX($x); 
                                // $pdf->Cell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)','BR',  0, 'L', 0,1,1);
                                $pdf->MultiCell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)', 'BR', 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                $pdf->Cell(20,($cie+$see),'100%','BR',  0, 'C', 0,1,1);
                                
                                $y=$y+($cie+$see);
                                $x=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(60,6,'Total (CIE + SEE)','LBR',  0, 'C', 0,1,1);  
                                $pdf->Cell(20,6,($decode_Data['courselist']['CIEw']+$decode_Data['courselist']['SEEw'])."%",'B',  0, 'C', 0,1,1);
                                $pdf->Cell(60,6,'Total (CES)','LBR',  0, 'C', 0,1,1);
                                $pdf->Cell(20,6,'100%','BR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);
                                $pdf->Cell(80, 6, 'Weightage of Direct Assessment(DA) is '.$decode_Data['courselist']['codirectw'].'%','LBR',  0, 'C', 0,1,1);
                                $pdf->Cell(80, 6, 'Weightage of InDirect Assessment(IA) is '.$decode_Data['courselist']['coindirectw'].'%','BR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);
                                $pdf->Cell(160, 6, 'TOTAL = DA + IA = '.($decode_Data['courselist']['codirectw']+$decode_Data['courselist']['coindirectw']).'%','LBR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);   

                             }
                             else if($coursedetails['structure']['type']=="practical"){
                                $ith_c=0;
                                $eth_c=0;
                                $IT=0;$ET=0;
                                $cie=0;$see=0;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $ith_c=count($coursedetails['structure']['internal_practical_short']);
                                }
                                if($coursedetails['structure']['ishaveexternal']){
                                    $eth_c=count($coursedetails['structure']['external_practical_short']);
                                }
                                if($ith_c!=0){   $IT=$ith_c;   }else{  $IT=1;  }
                                if($eth_c!=0){   $ET=$eth_c;   }else{  $ET=1;  }
                                $cie= ($IT*5 ) + (5*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $see=($ET*5);

                                $x=$pdf->GetX();
                                $y=$pdf->GetY();

                                $pdf->Cell(15, $cie , 'CIE','LBR',  0, 'C', 0,1,1); $x+=15;
                                $pdf->Cell(30, $IT*5, 'Practical','LBR',  0, 'C', 0,1,1); $x+=30;
                                if(count($coursedetails['structure']['internal_practical_short'])!=0){
                                    foreach($coursedetails['structure']['internal_practical_short'] as $k=>$v){
                                        $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                }else
                                {
                                    $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }

                                $x=$x-30;
                                $pdf->SetX($x);
                                $pdf->Cell(45, 5,'AAT','B',  0, 'C', 0,1,1);

                                $x=$x-15;
                                $y=$y+5;
                                $pdf->SetX($x);
                                $pdf->SetY($y);
                                $pdf->Cell(15, $see , 'SEE','LBR',  0, 'C', 0,1,1); $x+=15;
                                $pdf->Cell(30, $ET*5, 'Practical','LBR',  0, 'C', 0,1,1); $x+=30;
                                if(count($coursedetails['structure']['external_practical_short'])!=0){
                                    foreach($coursedetails['structure']['external_practical_short'] as $k=>$v){
                                        $pdf->Cell(15, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                }else
                                {
                                    $pdf->Cell(15, 5,'','B',  0, 'C', 0,1,1); $y+=5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }


                                $y=$y-($cie+$see);
                                $pdf->SetY($y);
                                $x=$x+15;
                                $pdf->SetX($x); 
                                $pdf->Cell(20,$cie,$decode_Data['courselist']['CIEw']."%",'LBR',  0, 'C', 0,1,1);$y+=$cie;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(20,$see,$decode_Data['courselist']['SEEw']."%",'LBR',  0, 'C', 0,1,1);$y+=$see;

                                $y=$y-($cie+$see);
                                $pdf->SetY($y);
                                $x=$x+20;
                                $pdf->SetX($x); 
                                // $pdf->Cell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)','BR',  0, 'L', 0,1,1);
                                $pdf->MultiCell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)', 'BR', 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                $pdf->Cell(20,($cie+$see),'100%','BR',  0, 'C', 0,1,1);
                                
                                $y=$y+($cie+$see);
                                $x=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(60,6,'Total (CIE + SEE)','LBR',  0, 'C', 0,1,1);  
                                $pdf->Cell(20,6,($decode_Data['courselist']['CIEw']+$decode_Data['courselist']['SEEw'])."%",'B',  0, 'C', 0,1,1);
                                $pdf->Cell(60,6,'Total (CES)','LBR',  0, 'C', 0,1,1);
                                $pdf->Cell(20,6,'100%','BR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);
                                $pdf->Cell(80, 6, 'Weightage of Direct Assessment(DA) is '.$decode_Data['courselist']['codirectw'].'%','LBR',  0, 'C', 0,1,1);
                                $pdf->Cell(80, 6, 'Weightage of InDirect Assessment(IA) is '.$decode_Data['courselist']['coindirectw'].'%','BR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);
                                $pdf->Cell(160, 6, 'TOTAL = DA + IA = '.($decode_Data['courselist']['codirectw']+$decode_Data['courselist']['coindirectw']).'%','LBR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);   

                             }   
                             else if($coursedetails['structure']['type']=="project"){
                                $ciew=$decode_Data['courselist']['CIEw'];
                                $seew=$decode_Data['courselist']['SEEw']; 
                                if($coursedetails['structure']['ishaveinternal'] and !$coursedetails['structure']['ishaveexternal']){
                                    $ciew+=$seew;
                                    $seew=0;
                                }
                                else if(!$coursedetails['structure']['ishaveinternal'] and $coursedetails['structure']['ishaveexternal']){
                                    $seew+=$ciew;
                                    $ciew=0;
                                }
                                $ip_c=0;
                                $ep_c=0;
                                $Ip=0;$Ep=0;
                                $cie=0;$see=0;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $ip_c=count($coursedetails['structure']['internal_project_short']);
                                }
                                if($coursedetails['structure']['ishaveexternal']){
                                    $ep_c=count($coursedetails['structure']['external_project_short']);
                                }
                                if($ip_c!=0){   $Ip=$ip_c;   }else{  $Ip=1;  }
                                if($ep_c!=0){   $Ep=$ep_c;   }else{  $Ep=1;  }
                                $cie= ($Ip*5 ) + (5*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $see=($Ep*5);

                                $x=$pdf->GetX();
                                $y=$pdf->GetY();

                                $pdf->Cell(15, $cie , 'CIE','LBR',  0, 'C', 0,1,1); $x+=15;
                                // $pdf->Cell(30, $IT*5, 'Practical','LBR',  0, 'C', 0,1,1); $x+=30;
                                if( $coursedetails['structure']['ishaveinternal'] ){ 
                                    foreach($coursedetails['structure']['internal_project_short'] as $k=>$v){
                                        $pdf->Cell(45, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                }
                                else{
                                    $pdf->Cell(45, 5,'-','B',  0, 'C', 0,1,1); $y+=5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x); 
                                }

                                $x=$x-15;
                                // $y=$y+5;
                                $pdf->SetX($x);
                                $pdf->SetY($y);
                                $pdf->Cell(15, $see , 'SEE','LBR',  0, 'C', 0,1,1); $x+=15;
                                // $pdf->Cell(30, $ET*5, 'Practical','LBR',  0, 'C', 0,1,1); $x+=30;
                                if( $coursedetails['structure']['ishaveexternal'] ){
                                  foreach($coursedetails['structure']['external_practical_short'] as $k=>$v){
                                    $pdf->Cell(45, 5,''.$v,'B',  0, 'C', 0,1,1); $y+=5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                  }
                                }
                                else{
                                    $pdf->Cell(45, 5,'','B',  0, 'C', 0,1,1); $y+=5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }


                                $y=$y-($cie+$see);
                                $pdf->SetY($y);
                                $x=$x+45;
                                $pdf->SetX($x); 
                                $pdf->Cell(20,$cie,$ciew."%",'LBR',  0, 'C', 0,1,1);$y+=$cie;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(20,$see,$seew."%",'LBR',  0, 'C', 0,1,1);$y+=$see;

                                $y=$y-($cie+$see);
                                $pdf->SetY($y);
                                $x=$x+20;
                                $pdf->SetX($x); 
                                // $pdf->Cell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)','BR',  0, 'L', 0,1,1);
                                $pdf->MultiCell(60,($cie+$see),'Course End Survey-CES (Feedback on course outcomes collected from students)', 'BR', 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                $pdf->Cell(20,($cie+$see),'100%','BR',  0, 'C', 0,1,1);
                                
                                $y=$y+($cie+$see);
                                $x=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(60,6,'Total (CIE + SEE)','LBR',  0, 'C', 0,1,1);  
                                $pdf->Cell(20,6,($decode_Data['courselist']['CIEw']+$decode_Data['courselist']['SEEw'])."%",'B',  0, 'C', 0,1,1);
                                $pdf->Cell(60,6,'Total (CES)','LBR',  0, 'C', 0,1,1);
                                $pdf->Cell(20,6,'100%','BR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);
                                $pdf->Cell(80, 6, 'Weightage of Direct Assessment(DA) is '.$decode_Data['courselist']['codirectw'].'%','LBR',  0, 'C', 0,1,1);
                                $pdf->Cell(80, 6, 'Weightage of InDirect Assessment(IA) is '.$decode_Data['courselist']['coindirectw'].'%','BR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);
                                $pdf->Cell(160, 6, 'TOTAL = DA + IA = '.($decode_Data['courselist']['codirectw']+$decode_Data['courselist']['coindirectw']).'%','LBR',  0, 'C', 0,1,1);

                                $y=$y+6;
                                $pdf->SetY($y);
                                $x=15;
                                $pdf->SetX($x);   

                             } 


                             $y=$y+$heading_gap;
                             $pdf->SetY($y);
                             $pdf->SetFont('helvetica', 'B', 10);
                             $pdf->Cell(75, 5, 'Course Outcomes (COs)', 0,  0, 'L', 0);
                             $y=$y+$heading_gap;
                             $pdf->SetY($y);
                             $pdf->SetFont('helvetica', 'B', 8);
                             $pdf->Cell(30,8, 'CO #', 1,  0, 'C', 0);
                             $pdf->Cell(120,8, 'CO Statement', 1,  0, 'C', 0);
                             $pdf->Cell(30,8, 'Boolm\'s Taxonomy', 1,  0, 'C', 0);
                             $pdf->SetFont('helvetica', '', 10);
                             $y=$y+8;
                             $pdf->SetY($y);

                             for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                $tem="CO".$i;
                                $pdf->Cell(30,10,$coursedetails['coursecode'].".".$i, 1,  0, 'C', 0);
                                $pdf->MultiCell(120, 10,$coursedetails['coursedescription'][$tem], 1, 'L', 0, 0, '', '', true);
                                // $pdf->MultiCell(120, 12, $decode_Data['codescription'][$tem], 1, 'L', 1, 1, 125, 145, true, 0, false, true, 60, 'M', true);
                                $pdf->Cell(30,10,$coursedetails['boomTaxonomy'][$tem], 1,  0, 'C', 0);
                                $y=$y+10;
                                $pdf->SetY($y);
                            }
                            $pdf->ln();
                            $y=$y+$heading_gap;
                            // $pdf->SetY($y);    //check Y=<270;

                           

                            if($coursedetails['structure']['ishaverubrics']){
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->SetFont('helvetica', 'B', 10);
                                $pdf->Cell(75, 5, 'Rubrics', 0,  0, 'L', 0);
                                $y=$y+5+$heading_gap;
                                $pdf->SetY($y);
                                $pdf->SetFont('helvetica', 'B', 8);
                                $pdf->Cell(30,8, 'Rubric No #', 1,  0, 'C', 0);
                                $pdf->Cell(120,8, 'Rubrics Description', 1,  0, 'C', 0);
                                $pdf->Cell(30,8, 'CO Mapped', 1,  0, 'C', 0);
                                $pdf->SetFont('helvetica', '', 10);
                                $y=$y+8;
                                $pdf->ln();
                                for($i=1;$i<=$coursedetails['noofrubrics'];$i++){
                                //    $tem="CO".$i;
                                   $pdf->Cell(30,10,"".$i, 1,  0, 'C', 0);
                                   $pdf->MultiCell(120, 10,$coursedetails['rubricsdesc'][$i], 1, 'L', 0, 0, '', '', true);
                                   // $pdf->MultiCell(120, 12, $decode_Data['codescription'][$tem], 1, 'L', 1, 1, 125, 145, true, 0, false, true, 60, 'M', true);
                                    $res=join(",",$coursedetails['rubricsmapping'][$i]);
                                   $pdf->Cell(30,10,$res, 1,  0, 'C', 0);
                                   $y=$y+10;
                                $pdf->ln();
                               }
                               $pdf->ln();
                               $y=$pdf->GetY();
                            //    $y=$y+$heading_gap;

                             }
                                

                             $totalLength=( $y+(5+$heading_gap+5+(5*$coursedetails['noofcos'])));  
                             if($totalLength>267){
                                // $y=271;
                                // $x=15;
                                $pdf->AddPage();
                                $x=15;
                                $y=15;
                            }
                            $pdf->SetY($y);
                            $pdf->SetX($x);

                            $pdf->SetFont('helvetica', 'B', 10);
                            $pdf->Cell(0, 5,'Course Articulation Matrix (CO-PO Mapping)', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            $y=$y+$heading_gap;
                            // $pdf->SetY($y);
                            $pdf->ln();
                            // $pdf->Cell(0, 8,'', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                            $pdf->Cell(20, 5, 'CO/PO', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO1', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO2', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO3', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO4', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO5', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO6', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO7', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO8', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO9', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO10', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO11', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO12', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PSO1', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PSO2', 1,  0, 'C', 0);
                            $pdf->SetFont('helvetica', '', 10);

                            $y=$y+5;
                            // $pdf->SetY($y);
                            $pdf->ln();
                            for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                $tem="CO".$i;
                                $pdf->Cell(20,5,$coursedetails['coursecode'].".".$i, 1,  0, 'C', 0);
                                for($j=1;$j<=14;$j++){
                                    $tpo="PO".$j;
                                    $val="";
                                    if($j==13){
                                        $tpo="PSO1";
                                    }
                                    else if($j==14){
                                        $tpo="PSO2"; 
                                    }
                                    if($coursedetails['articulation'][$tem][$tpo]!=0){
                                        $charray[$tpo]='Y';
                                        $val=$coursedetails['articulation'][$tem][$tpo];
                                    }
                                    else{
                                        $val="";
                                    }
                                    $pdf->Cell(11, 5,$val,'BR',  0, 'C', 0);
                                }
                                $y=$y+5;
                                // $pdf->SetY($y);
                                $pdf->ln();
                            }
                            $y=$pdf->GetY();
                            $y=$y+5;
                            $pdf->SetY($y);
                            $pdf->SetFont('helvetica', 'B', 10);
                            $pdf->Cell(0, 8,'', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                            $pdf->Cell(0, 0,'Program Outcomes (POs) And Program Specific Outcomes (PSOs) ', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            $pdf->Cell(0, 8,'', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
                            $pdf->Cell(15, 6, 'PO #', 1,  0, 'C', 0);
                            $pdf->Cell(150, 6, 'PO Description', 1,  0, 'C', 0);
                            $pdf->SetFont('helvetica', '', 10);
                            for($i=1;$i<=14;$i++){
                                $tem="PO".$i;
                                if($i==13){
                                    $tem="PSO1";
                                }
                                else if($i==14){
                                    $tem="PSO2";
                                }

                                if($charray[$tem]=="Y"){
                                    $pdf->ln();
                                    $pdf->Cell(15,18,$tem, 1,  0, 'C', 0);
                                    $pdf->MultiCell(150, 18,$decode_Data['pooutcomes'][$tem], 1, 'L', 0, 0, '', '', true);
                                }
                                // $pdf->MultiCell(60,30,'Course End Survey-CES (Feedback on course outcomes collected from students)', 'BR', 'C', 0, 0, '', '', true,0,false,true,30,'M');
                            }
                            $pdf->ln();
                            $y=$pdf->GetY();
                            $y=round($y+8);
                            $pdf->SetY($y);
                            //heading cel;   
                            $TotalL= ( $y+(5+8+20+(15*$coursedetails['noofcos'] )) );
                            if($TotalL>267){
                                $pdf->AddPage();
                                $x=15;
                                $y=15;
                            }
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            $pdf->SetFont('helvetica', 'B', 10);
                            if(!$coursedetails['structure']['ishaverubrics']){
                            $pdf->Cell(0,5,'Questions Mapping with Course Outcomes in each Assessment Tool ', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            }
                            else{
                                $pdf->Cell(0,5,'Rubrics Mapping with Course Outcomes in each Assessment Tool ', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            }
                            $y=$y+8;
                            $pdf->SetY($y);

                            if($coursedetails['structure']['type']=="theoretical"){
                                $ciew=$decode_Data['courselist']['CIEw'];
                                $seew=$decode_Data['courselist']['SEEw'];
                                if($coursedetails['structure']['ishaveinternal'] && ! $coursedetails['structure']['ishaveexternal']){
                                    $ciew=$ciew+$seew;
                                    $seew=0;
                                }
                                if(!$coursedetails['structure']['ishaveinternal'] && $coursedetails['structure']['ishaveexternal']){
                                    $seew=$seew+$ciew;
                                    $ciew=0;
                                }
                                $ith_c=0;
                                $eth_c=0;
                                $IT=0;$ET=0;
                                $cie=0;$see=0;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $ith_c=count($coursedetails['structure']['internal_theory_short']);
                                }
                                if($coursedetails['structure']['ishaveexternal']){
                                    $eth_c=count($coursedetails['structure']['external_theory_short']);
                                }
                                if($ith_c!=0){   $IT=$ith_c;   }else{  $IT=0;  }
                                if($eth_c!=0){   $ET=$eth_c;   }else{  $ET=0;  }
                                $cie= ($IT*20 ) + (20*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $see=($ET*25);

                                $cieb= ($IT*10 ) + (10*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $seeb=($ET*15);
                                
                                $pdf->Cell(20,20, 'CO #', 1,  0, 'C', 0);$x=$x+20;
                                //internal  
                             if($coursedetails['structure']['ishaveinternal']){
                                $pdf->Cell($cie,5, 'CIE', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(($IT*20),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                                foreach($coursedetails['structure']['internal_theory_short'] as $k=>$v){
                                    $pdf->Cell(20,10, ''.$v, 1,  0, 'C', 0);$x=$x+20;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                if($coursedetails['structure']['ishaveaat']){
                                    $pdf->Cell(20,15, 'AAT', 1,  0, 'C', 0);$x=$x+20;
                                }
                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                            }
                            if($coursedetails['structure']['ishaveexternal']){

                                $pdf->Cell($see,5, 'SEE', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(($ET*25),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['external_theory_short'] as $k=>$v){
                                    $pdf->Cell(25,10, ''.$v, 1,  0, 'C', 0);$x=$x+25;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $y=$y-10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                            }
                                $y=$y+20;
                                $x=$x-($cie+$see+20);
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->SetFont('helvetica', '', 10);

                                for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                    $tem="CO".$i;
                                    $val="";
                                    $pdf->MultiCell(20,15,$coursedetails['coursecode'].'.'.$i, 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                 if($coursedetails['structure']['ishaveinternal']){
                                    foreach($coursedetails['internal_QNO'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->MultiCell(20,15,customize($val[$tem]), 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                        }
                                        else{
                                            $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                        }
                                    }
                                 }
                                    // if($coursedetails['structure']['ishaveaat']){
                                    //     $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');     
                                    // }
                                 if($coursedetails['structure']['ishaveexternal']){
                                    foreach($coursedetails['external_QNO'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->MultiCell(25,15,customize($val[$tem]), 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                        }
                                        else{
                                            $pdf->MultiCell(25,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                        }
                                    }
                                }

                                    $y=$y+15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);    
                                }
                                
                                $y=$y+$heading_gap;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                                $TotalLB= ( $y + (5 + $heading_gap+ 20 + (12*($coursedetails['noofcos']))));
                                if($TotalLB>267){
                                    $pdf->AddPage();
                                    $x=15;
                                    $y=15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $pdf->SetFont('helvetica', 'B', 10);
                                $pdf->Cell(0, 5,'Attainment of Course Outcomes (COs) through Direct Assessment (DA) Tools', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                                $y=$y+$heading_gap;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                                $pdf->Cell(15,20, 'CO #', 1,  0, 'C', 0);$x=$x+15;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $pdf->Cell($cieb,5, 'CIE', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->Cell(($IT*10),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    foreach($coursedetails['structure']['internal_theory_short'] as $k=>$v){
                                        $pdf->Cell(10,10, ''.$v, 1,  0, 'C', 0);$x=$x+10;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 10);
                                    if($coursedetails['structure']['ishaveaat']){
                                        $pdf->Cell(10,15, 'AAT', 1,  0, 'C', 0);$x=$x+10;
                                    }
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                if($coursedetails['structure']['ishaveexternal']){

                                    $pdf->Cell($seeb,5, 'SEE', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->Cell(($ET*15),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    foreach($coursedetails['structure']['external_theory_short'] as $k=>$v){
                                        $pdf->Cell(15,10, ''.$v, 1,  0, 'C', 0);$x=$x+15;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    $y=$y-10;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
    
                                }
                                $pdf->SetFont('helvetica', 'B', 10);
                              if($coursedetails['structure']['ishaveinternal']){
                                $pdf->MultiCell(20,20,'Average of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+20;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->MultiCell(15,20,$ciew.'% of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                              }
                              if($coursedetails['structure']['ishaveexternal']){
                                $pdf->MultiCell(15,20,$seew.'% of SEE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                              }
                                $pdf->MultiCell(25,20,'Total Attainment through DA (100%)', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+25;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                // $x=$x-($cieb+$seeb+15+20+15+15+25);
                                $x=15;
                                $y=$y+20;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->SetFont('helvetica', '', 10);

                                for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                    $tem="CO".$i;
                                    $val="";
                                    $pdf->Cell(15, 12,$coursedetails['coursecode'].".".$i, 'LBR',  0, 'C', 0);
                              if($coursedetails['structure']['ishaveinternal']){
                                    foreach($coursedetails['internal'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell(10, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell(10, 12,'', 'BR',  0, 'C', 0);          
                                        }
                                    }
                                 }
                                 if($coursedetails['structure']['ishaveexternal']){
                                    foreach($coursedetails['external'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell(15, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell(15, 12,'', 'BR',  0, 'C', 0);
                                        }
                                    }
                                }
                            if($coursedetails['structure']['ishaveinternal']){  
                                if( array_key_exists($tem,$coursedetails['coattainment']['cie'])){
                                    $pdf->Cell(20, 12,$coursedetails['coattainment']['cie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(20, 12,"", 'BR',  0, 'C', 0);
                                }

                                if( array_key_exists($tem,$coursedetails['coattainment']['xcie'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xcie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }
                            }
                            if($coursedetails['structure']['ishaveexternal']){
                                if( array_key_exists($tem,$coursedetails['coattainment']['xsee'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xsee'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }
                            }
                                if( array_key_exists($tem,$coursedetails['coattainment']['direct'])){
                                    $pdf->Cell(25, 12,$coursedetails['coattainment']['direct'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(25, 12,"", 'BR',  0, 'C', 0);
                                }

                                    $y=$y+12;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);    
                                }










                                







                            }
                            else if($coursedetails['structure']['type']=="practical"){
                                $ciew=$decode_Data['courselist']['CIEw'];
                                $seew=$decode_Data['courselist']['SEEw'];
                                if($coursedetails['structure']['ishaveinternal'] && ! $coursedetails['structure']['ishaveexternal']){
                                    $ciew=$ciew+$seew;
                                    $seew=0;
                                }
                                if(!$coursedetails['structure']['ishaveinternal'] && $coursedetails['structure']['ishaveexternal']){
                                    $seew=$seew+$ciew;
                                    $ciew=0;
                                }
                                $ip_c=0;
                                $ep_c=0;
                                $Ip=0;$Ep=0;
                                $cie=0;$see=0;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $ip_c=count($coursedetails['structure']['internal_practical_short']);
                                }
                                if($coursedetails['structure']['ishaveexternal']){
                                    $ep_c=count($coursedetails['structure']['external_practical_short']);
                                }
                                if($ip_c!=0){   $Ip=$ip_c;   }else{  $Ip=0;  }
                                if($ep_c!=0){   $ET=$ep_c;   }else{  $Ep=0;  }
                                $cie= ($Ip*20 ) + (20*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $see=($Ep*25);

                                $cieb= ($Ip*10 ) + (10*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $seeb=($Ep*15);

                                $pdf->Cell(20,20, 'CO #', 1,  0, 'C', 0);$x=$x+20;
                             if($coursedetails['structure']['ishaveinternal']){
                                $pdf->Cell($cie,5, 'CIE', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(($Ip*20),5, 'Practical', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['internal_practical_short'] as $k=>$v){
                                    $pdf->Cell(20,10, ''.$v, 1,  0, 'C', 0);$x=$x+20;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                if($coursedetails['structure']['ishaveaat']){
                                    $pdf->Cell(20,15, 'AAT', 1,  0, 'C', 0);$x=$x+20;   
                                }
                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                             }  
                             if($coursedetails['structure']['ishaveexternal']){
                                $pdf->Cell($see,5, 'SEE', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->Cell(($Ep*25),5, 'Practical', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['external_practical_short'] as $k=>$v){
                                    $pdf->Cell(25,10, ''.$v, 1,  0, 'C', 0);$x=$x+25;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $y=$y-10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                             }    
                                $y=$y+20;
                                $x=$x-($cie+$see+20);
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->SetFont('helvetica', '', 10);

                                for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                    $tem="CO".$i;
                                    $val="";
                                    $pdf->MultiCell(20,15,$coursedetails['coursecode'].'.'.$i, 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                 if($coursedetails['structure']['ishaveinternal']){
                                    foreach($coursedetails['internal_QNO'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->MultiCell(20,15,customize($val[$tem]), 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                        }
                                        else{
                                            $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                        }
                                    }
                                  }
                                    // if($coursedetails['structure']['ishaveaat']){
                                    //     $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');     
                                    // }
                                 if($coursedetails['structure']['ishaveinternal']){
                                    foreach($coursedetails['external_QNO'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->MultiCell(25,15,customize($val[$tem]), 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                        }
                                        else{
                                            $pdf->MultiCell(25,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                        }
                                    }
                                 }
                                    $y=$y+15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                  
                                }


                                $y=$y+$heading_gap;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                                $TotalLB= ( $y + (5 + $heading_gap+ 20 + (12*($coursedetails['noofcos']))));
                                if($TotalLB>267){
                                    $pdf->AddPage();
                                    $x=15;
                                    $y=15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $pdf->SetFont('helvetica', 'B', 10);
                                $pdf->Cell(0, 5,'Attainment of Course Outcomes (COs) through Direct Assessment (DA) Tools', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                                $y=$y+$heading_gap;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                                $pdf->Cell(15,20, 'CO #', 1,  0, 'C', 0);$x=$x+15;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $pdf->Cell($cieb,5, 'CIE', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->Cell(($IT*10),5, 'Practical', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    foreach($coursedetails['structure']['internal_practical_short'] as $k=>$v){
                                        $pdf->Cell(10,10, ''.$v, 1,  0, 'C', 0);$x=$x+10;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 10);
                                    if($coursedetails['structure']['ishaveaat']){
                                        $pdf->Cell(10,15, 'AAT', 1,  0, 'C', 0);$x=$x+10;
                                    }
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                if($coursedetails['structure']['ishaveexternal']){

                                    $pdf->Cell($seeb,5, 'SEE', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->Cell(($ET*15),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    foreach($coursedetails['structure']['external_practical_short'] as $k=>$v){
                                        $pdf->Cell(15,10, ''.$v, 1,  0, 'C', 0);$x=$x+15;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    $y=$y-10;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
    
                                }
                                $pdf->SetFont('helvetica', 'B', 10);
                               if($coursedetails['structure']['ishaveinternal']){
                                $pdf->MultiCell(20,20,'Average of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+20;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->MultiCell(15,20,$ciew.'% of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                               }
                               if($coursedetails['structure']['ishaveexternal']){
                                $pdf->MultiCell(15,20,$seew.'% of SEE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                               }
                                $pdf->MultiCell(25,20,'Total Attainment through DA (100%)', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+25;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                // $x=$x-($cieb+$seeb+15+20+15+15+25);
                                $x=15;
                                $y=$y+20;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->SetFont('helvetica', '', 10);

                                for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                    $tem="CO".$i;
                                    $val="";
                                    $pdf->Cell(15, 12,$coursedetails['coursecode'].".".$i, 'LBR',  0, 'C', 0);
                              if($coursedetails['structure']['ishaveinternal']){
                                    foreach($coursedetails['internal'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell(10, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell(10, 12,'', 'BR',  0, 'C', 0);          
                                        }
                                    }
                                 }
                                 if($coursedetails['structure']['ishaveexternal']){
                                    foreach($coursedetails['external'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell(15, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell(15, 12,'', 'BR',  0, 'C', 0);
                                        }
                                    }
                                }
                            if($coursedetails['structure']['ishaveinternal']){  
                                if( array_key_exists($tem,$coursedetails['coattainment']['cie'])){
                                    $pdf->Cell(20, 12,$coursedetails['coattainment']['cie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(20, 12,"", 'BR',  0, 'C', 0);
                                }

                                if( array_key_exists($tem,$coursedetails['coattainment']['xcie'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xcie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }

                            }
                            if($coursedetails['structure']['ishaveexternal']){
                                if( array_key_exists($tem,$coursedetails['coattainment']['xsee'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xsee'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }
                            }
                                if( array_key_exists($tem,$coursedetails['coattainment']['direct'])){
                                    $pdf->Cell(25, 12,$coursedetails['coattainment']['direct'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(25, 12,"", 'BR',  0, 'C', 0);
                                }

                                    $y=$y+12;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);    
                                }









                                
                            }
                            else if($coursedetails['structure']['type']=="both"){
                                $ciew=$decode_Data['courselist']['CIEw'];
                                $seew=$decode_Data['courselist']['SEEw'];
                                if($coursedetails['structure']['ishaveinternal'] && ! $coursedetails['structure']['ishaveexternal']){
                                    $ciew=$ciew+$seew;
                                    $seew=0;
                                }
                                if(!$coursedetails['structure']['ishaveinternal'] && $coursedetails['structure']['ishaveexternal']){
                                    $seew=$seew+$ciew;
                                    $ciew=0;
                                }
                                $ith_c=0;$ip_c=0;
                                $eth_c=0;$ep_c=0;
                                $IT=0;$ET=0;$IP=0;$EP=0;
                                $cie=0;$see=0;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $ith_c=count($coursedetails['structure']['internal_theory_short']);
                                    $ip_c=count($coursedetails['structure']['internal_practical_short']);
                                }
                                if($coursedetails['structure']['ishaveexternal']){
                                    $eth_c=count($coursedetails['structure']['external_theory_short']);
                                    $ep_c=count($coursedetails['structure']['external_practical_short']);
                                }
                            if($ith_c!=0){   $IT=$ith_c;   }else{  $IT=0;  }
                            if($eth_c!=0){   $ET=$eth_c;   }else{  $ET=0;  }
                            if($ip_c!=0){    $IP=$ip_c;    }else{  $IP=0;  }
                            if($ep_c!=0){    $EP=$ep_c;    }else{  $EP=0;  }

                                $cie=($IT*20 )+($IP*20) + (20*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $see=($ET*25 + $EP*25 );
                                    $IPS=($IP==1)? ($IP*15):($IP*10);
                                $cieb=($IT*10 )+($IPS) + (10*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $seeb=($ET*15 + $EP*15 );
                                $pdf->Cell(20,20, 'CO #', 1,  0, 'C', 0);$x=$x+20; //internal
                              if($coursedetails['structure']['ishaveinternal']){
                                $pdf->Cell($cie,5, 'CIE', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                if(count($coursedetails['structure']['internal_theory_short'] )!=0){
                                $pdf->Cell(($IT*20),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['internal_theory_short'] as $k=>$v){
                                    $pdf->Cell(20,10, ''.$v, 1,  0, 'C', 0);$x=$x+20;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                    //}   
                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                               }

                                   if(count($coursedetails['structure']['internal_practical_short'])!=0){
                                $pdf->Cell(($IP*20),5, 'Practical', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['internal_practical_short'] as $k=>$v){
                                    $pdf->Cell(20,10, ''.$v, 1,  0, 'C', 0);$x=$x+20;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                    }

                                if($coursedetails['structure']['ishaveaat']){
                                    $pdf->Cell(20,15, 'AAT', 1,  0, 'C', 0);$x=$x+20;
                                }
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                
                              // external
                             }
                             if($coursedetails['structure']['ishaveexternal']){
                                $pdf->Cell($see,5, 'SEE', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                if(count($coursedetails['structure']['external_theory_short'])!=0){
                                $pdf->Cell(($ET*25),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['external_theory_short'] as $k=>$v){
                                    $pdf->Cell(25,10, ''.$v, 1,  0, 'C', 0);$x=$x+25;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }

                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                    }
                                
                                  if(count($coursedetails['structure']['external_practical_short'])!=0){  
                                $pdf->Cell(($EP*25),5, 'Practical', 1,  0, 'C', 0);$y=$y+5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['external_practical_short'] as $k=>$v){
                                    $pdf->Cell(25,10, ''.$v, 1,  0, 'C', 0);$x=$x+25;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                
                                }
                                $y=$y-5;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                  }

                                  $y=$y-5;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);

                              } 

                                $y=$y+20;
                                $x=$x-($cie+$see+20);
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                $pdf->SetFont('helvetica', '', 9);

                                for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                    $tem="CO".$i;
                                    $val="";
                                    $pdf->MultiCell(20,15,$coursedetails['coursecode'].'.'.$i, 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');//height 15 start
                                  if($coursedetails['structure']['ishaveinternal']){ 
                                    foreach($coursedetails['internal_QNO'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->MultiCell(20,15,customize($val[$tem]), 1, 'L', 0, 0, '', '', true,0,false,true,20,'M');
                                        }
                                        else{
                                            $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                        }
                                      
                                    }
                                   }
                                    // if($coursedetails['structure']['ishaveaat']){
                                    //     $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');     
                                    // }
                                  if($coursedetails['structure']['ishaveexternal']){
                                    foreach($coursedetails['external_QNO'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->MultiCell(25,15,customize($val[$tem]), 1, 'L', 0, 0, '', '', true,0,false,true,20,'M');
                                        }
                                        else{
                                            $pdf->MultiCell(25,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                        }
                                    }
                                  }
                                    
                                    $y=$y+15; //height is end
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    
                                }

                                $y=$y+$heading_gap;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                                $TotalLB= ( $y + (5 + $heading_gap+ 20 + (12*($coursedetails['noofcos']))));
                                if($TotalLB>267){
                                    $pdf->AddPage();
                                    $x=15;
                                    $y=15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $pdf->SetFont('helvetica', 'B', 10);
                                $pdf->Cell(0, 5,'Attainment of Course Outcomes (COs) through Direct Assessment (DA) Tools', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                                $y=$y+$heading_gap;
                                $pdf->SetY($y);
                                $pdf->SetX($x);

                                $pdf->Cell(15,20, 'CO #', 1,  0, 'C', 0);$x=$x+15;

                                if($coursedetails['structure']['ishaveinternal']){
                                    $pdf->Cell($cieb,5, 'CIE', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);

                                    if(count($coursedetails['structure']['internal_theory_short'])!=0){
                                    $pdf->Cell(($IT*10),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    foreach($coursedetails['structure']['internal_theory_short'] as $k=>$v){
                                        $pdf->Cell(10,10, ''.$v, 1,  0, 'C', 0);$x=$x+10;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                   
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    }
                                    $pdf->SetFont('helvetica', 'B', 10);

                                    if(count($coursedetails['structure']['internal_practical_short'])!=0){
                                    $pdf->Cell(($IPS),5, 'Practical', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    $cace_p="";
                                    foreach($coursedetails['structure']['internal_practical_short'] as $k=>$v){
                                        if($IP==1){$cace_p=$v;}
                                        $pdf->Cell((($IP==1)?15:10) ,10, ''.$v, 1,  0, 'C', 0); $x=($IP==1)?($x+15):($x+10);      //$x=$x+10;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);

                                    }

                                    $pdf->SetFont('helvetica', 'B', 10);
                                    if($coursedetails['structure']['ishaveaat']){
                                        $pdf->Cell(10,15, 'AAT', 1,  0, 'C', 0);$x=$x+10;
                                    }
                                        $y=$y-5;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    
                                  // external
                                 }
                                 if($coursedetails['structure']['ishaveexternal']){
                                    $pdf->Cell($seeb,5, 'SEE', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);

                                    if(count($coursedetails['structure']['external_theory_short'])!=0){
                                    $pdf->Cell(($ET*15),5, 'Theory', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    foreach($coursedetails['structure']['external_theory_short'] as $k=>$v){
                                        $pdf->Cell(15,10, ''.$v, 1,  0, 'C', 0);$x=$x+15;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    }
                                    
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    }

                                    $pdf->SetFont('helvetica', 'B', 10);

                                    if(count($coursedetails['structure']['external_practical_short'])!=0){
                                    $pdf->Cell(($EP*15),5, 'Practical', 1,  0, 'C', 0);$y=$y+5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    $pdf->SetFont('helvetica', 'B', 8);
                                    foreach($coursedetails['structure']['external_practical_short'] as $k=>$v){
                                        $pdf->Cell(15,10, ''.$v, 1,  0, 'C', 0);$x=$x+15;
                                        $pdf->SetY($y);
                                        $pdf->SetX($x);
                                    
                                    }
                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                    }

                                    $y=$y-5;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);

                                  }
                                  $pdf->SetFont('helvetica', 'B', 10);
                                 if($coursedetails['structure']['ishaveinternal']){
                                  $pdf->MultiCell(20,20,'Average of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+20;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                  $pdf->MultiCell(15,20,$ciew.'% of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                 }
                                 if($coursedetails['structure']['ishaveexternal']){
                                  $pdf->MultiCell(15,20,$seew.'% of SEE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                 }
                                  $pdf->MultiCell(25,20,'Total Attainment through DA (100%)', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+25;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                //   $x=$x-($cieb+$seeb+15+20+15+15+25);
                                    $x=15;
                                  $y=$y+20;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                  $pdf->SetFont('helvetica', '', 10);

                                  for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                    $tem="CO".$i;
                                    $val="";
                                    $pdf->Cell(15, 12,$coursedetails['coursecode'].".".$i, 'LBR',  0, 'C', 0);
                              if($coursedetails['structure']['ishaveinternal']){
                                    foreach($coursedetails['internal'] as $key=>$val ){
                                        $s=10;
                                        if( $IP==1 and $key==$cace_p){
                                            $s=15;
                                       } 
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell($s, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell($s, 12,'', 'BR',  0, 'C', 0);          
                                        }
                                    }
                                 }
                                 if($coursedetails['structure']['ishaveexternal']){
                                    foreach($coursedetails['external'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell(15, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell(15, 12,'', 'BR',  0, 'C', 0);
                                        }
                                    }
                                }
                              if($coursedetails['structure']['ishaveinternal']){
                                if( array_key_exists($tem,$coursedetails['coattainment']['cie'])){
                                    $pdf->Cell(20, 12,$coursedetails['coattainment']['cie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(20, 12,"", 'BR',  0, 'C', 0);
                                }

                                if( array_key_exists($tem,$coursedetails['coattainment']['xcie'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xcie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }
                               }
                               if($coursedetails['structure']['ishaveexternal']){
                                if( array_key_exists($tem,$coursedetails['coattainment']['xsee'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xsee'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }
                               }
                                if( array_key_exists($tem,$coursedetails['coattainment']['direct'])){
                                    $pdf->Cell(25, 12,$coursedetails['coattainment']['direct'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(25, 12,"", 'BR',  0, 'C', 0);
                                }

                                    $y=$y+12;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);    
                                }
                                  










                            }
                            else if($coursedetails['structure']['type']=="project"){
                                $ciew=$decode_Data['courselist']['CIEw'];
                                $seew=$decode_Data['courselist']['SEEw'];
                                if($coursedetails['structure']['ishaveinternal'] && ! $coursedetails['structure']['ishaveexternal']){
                                    $ciew=$ciew+$seew;
                                    $seew=0;
                                }
                                if(!$coursedetails['structure']['ishaveinternal'] && $coursedetails['structure']['ishaveexternal']){
                                    $seew=$seew+$ciew;
                                    $ciew=0;
                                }
                                $ip_c=0;
                                $ep_c=0;
                                $Ip=0;$Ep=0;
                                $cie=0;$see=0;
                                if($coursedetails['structure']['ishaveinternal']){
                                    $ip_c=count($coursedetails['structure']['internal_project_short']);
                                }
                                if($coursedetails['structure']['ishaveexternal']){
                                    $ep_c=count($coursedetails['structure']['external_project_short']);
                                }
                                if($ip_c!=0){   $Ip=$ip_c;   }else{  $Ip=0;  }
                                if($ep_c!=0){   $Ep=$ep_c;   }else{  $Ep=0;  }
                                $cie= ($Ip*20 );// + (20*(($coursedetails['structure']['ishaveaat']==true) ? 1:0 ));
                                $see=($Ep*25);
                                
                                $cieb= ($Ip*10 );
                                $seeb=($Ep*15);

                                $pdf->Cell(20,20, 'CO #', 1,  0, 'C', 0);$x=$x+20;
                              if($coursedetails['structure']['ishaveinternal']){
                                $pdf->Cell($cie,10, 'Internal', 1,  0, 'C', 0);$y=$y+10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['internal_project_short'] as $k=>$v){
                                    $pdf->Cell(20,10, ''.$v, 1,  0, 'C', 0);$x=$x+20;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $y=$y-10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                               }
                               if($coursedetails['structure']['ishaveexternal']){
                                $pdf->Cell($see,10, 'External', 1,  0, 'C', 0);$y=$y+10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['external_project_short'] as $k=>$v){
                                    $pdf->Cell(20,10, ''.$v, 1,  0, 'C', 0);$x=$x+20;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                               }

                               $y=$y+20;
                               $x=$x-($cie+$see+20);
                               $pdf->SetY($y);
                               $pdf->SetX($x);
                               $pdf->SetFont('helvetica', '', 10);

                               for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                $tem="CO".$i;
                                $val="";
                                $pdf->MultiCell(20,15,$coursedetails['coursecode'].'.'.$i, 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                              if($coursedetails['structure']['ishaveinternal']){  
                                foreach($coursedetails['internal_QNO'] as $key=>$val ){
                                    if(array_key_exists($tem,$val)){
                                    $pdf->MultiCell(20,15,customize($val[$tem]), 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                    }
                                    else{
                                        $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                    }
                                }
                              }
                                // if($coursedetails['structure']['ishaveaat']){
                                //     $pdf->MultiCell(20,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');     
                                // }
                              if($coursedetails['structure']['ishaveexternal']){  
                                foreach($coursedetails['external_QNO'] as $key=>$val ){
                                    if(array_key_exists($tem,$val)){
                                    $pdf->MultiCell(25,15,customize($val[$tem]), 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');
                                    }
                                    else{
                                        $pdf->MultiCell(25,15,'', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');          
                                    }
                                }
                              }

                                $y=$y+15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                               }
                               $y=$y+$heading_gap;
                               $pdf->SetY($y);
                               $pdf->SetX($x);

                               $TotalLB= ( $y + (5 + $heading_gap+ 20 + (12*($coursedetails['noofcos']))));
                               if($TotalLB>267){
                                   $pdf->AddPage();
                                   $x=15;
                                   $y=15;
                                   $pdf->SetY($y);
                                   $pdf->SetX($x);
                               }
                               $pdf->SetFont('helvetica', 'B', 10);
                               $pdf->Cell(0, 5,'Attainment of Course Outcomes (COs) through Direct Assessment (DA) Tools', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                               $y=$y+$heading_gap;
                               $pdf->SetY($y);
                               $pdf->SetX($x);

                               $pdf->Cell(15,20, 'CO #', 1,  0, 'C', 0);$x=$x+15;
                               if($coursedetails['structure']['ishaveinternal']){
                                $pdf->Cell($cieb,10, 'Internal', 1,  0, 'C', 0);$y=$y+10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['internal_project_short'] as $k=>$v){
                                    $pdf->Cell(10,10, ''.$v, 1,  0, 'C', 0);$x=$x+10;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                                $y=$y-10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                               }
                               if($coursedetails['structure']['ishaveexternal']){
                                $pdf->Cell($seeb,10, 'External', 1,  0, 'C', 0);$y=$y+10;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                                foreach($coursedetails['structure']['external_project_short'] as $k=>$v){
                                    $pdf->Cell(15,10, ''.$v, 1,  0, 'C', 0);$x=$x+15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                }
                               }
                               $pdf->SetFont('helvetica', 'B', 10);
                               if($coursedetails['structure']['ishaveinternal']){  
                                    $pdf->MultiCell(20,20,'Average of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+20;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                 
                                    $pdf->MultiCell(15,20,$ciew.'% of CIE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);
                                  }
                                  if($coursedetails['structure']['ishaveexternal']){
                                  $pdf->MultiCell(15,20,$seew.'% of SEE', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+15;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                  }
                                  $pdf->MultiCell(25,20,'Total Attainment through DA (100%)', 1, 'C', 0, 0, '', '', true,0,false,true,20,'M');$x=$x+25;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                //   $x=$x-($cieb+$seeb+15+  20+15+15   +25);
                                  $x=15;
                                  $y=$y+20;
                                  $pdf->SetY($y);
                                  $pdf->SetX($x);
                                  $pdf->SetFont('helvetica', '', 10);

                                  for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                    $tem="CO".$i;
                                    $val="";
                                    $pdf->Cell(15, 12,$coursedetails['coursecode'].".".$i, 'LBR',  0, 'C', 0);
                              if($coursedetails['structure']['ishaveinternal']){
                                    foreach($coursedetails['internal'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell(10, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell(10, 12,'', 'BR',  0, 'C', 0);          
                                        }
                                    }
                                 }
                                 if($coursedetails['structure']['ishaveexternal']){
                                    foreach($coursedetails['external'] as $key=>$val ){
                                        if(array_key_exists($tem,$val)){
                                        $pdf->Cell(15, 12,$val[$tem], 'BR',  0, 'C', 0);
                                        }
                                        else{
                                            $pdf->Cell(15, 12,'', 'BR',  0, 'C', 0);
                                        }
                                    }
                                }
                             if($coursedetails['structure']['ishaveinternal']){
                                if( array_key_exists($tem,$coursedetails['coattainment']['cie'])){
                                    $pdf->Cell(20, 12,$coursedetails['coattainment']['cie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(20, 12,"", 'BR',  0, 'C', 0);
                                }

                                if( array_key_exists($tem,$coursedetails['coattainment']['xcie'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xcie'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }
                              }
                              if($coursedetails['structure']['ishaveexternal']){
                                if( array_key_exists($tem,$coursedetails['coattainment']['xsee'])){
                                    $pdf->Cell(15, 12,$coursedetails['coattainment']['xsee'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(15, 12,"", 'BR',  0, 'C', 0);
                                }
                               }
                                if( array_key_exists($tem,$coursedetails['coattainment']['direct'])){
                                    $pdf->Cell(25, 12,$coursedetails['coattainment']['direct'][$tem], 'BR',  0, 'C', 0);
                                }
                                else{
                                    $pdf->Cell(25, 12,"", 'BR',  0, 'C', 0);
                                }

                                    $y=$y+12;
                                    $pdf->SetY($y);
                                    $pdf->SetX($x);    
                                }
     
                            }

                            $y=$y+$heading_gap;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            // $pdf->Cell(10, 12,"YO", 'BR',  0, 'C', 0);
                            $TotalILB=( $y +(5+$heading_gap+8+ (9*$coursedetails['noofcos'])) );
                            if($TotalILB>267){
                                $pdf->AddPage();
                                $x=15;
                                $y=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                            } 
                            $pdf->SetFont('helvetica', 'B', 10);
                            $pdf->Cell(0, 5,'Attainment of Course Outcomes (CO) through Indirect Assessment(IA) Tools', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            $y=$y+$heading_gap;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            $pdf->SetFont('helvetica', 'B', 8);
                            $pdf->Cell(30,8, 'CO #', 1,  0, 'C', 0);
                            $pdf->Cell(110,8, 'CO Statement', 1,  0, 'C', 0);
                            $pdf->Cell(30,8, 'Course End Survey', 1,  0, 'C', 0);
                            $pdf->SetFont('helvetica', '', 10);
                            $y=$y+8;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                $tem="CO".$i;
                                $val="";
                                $pdf->Cell(30,9,$coursedetails['coursecode'].".".$i, 1,  0, 'C', 0);
                                $pdf->MultiCell(110, 9,$coursedetails['coursedescription'][$tem], 1, 'L', 0, 0, '', '', true);
                                if( array_key_exists($tem,$coursedetails['indirect']) ){
                                    $val=$coursedetails['indirect'][$tem];
                                }
                                else{ $val="";}
                                $pdf->Cell(30,9,$val, 1,  0, 'C', 0);
                                $y=$y+9;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                            }
                            $y=$y+$heading_gap;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            $pdf->SetFont('helvetica', 'B', 10);

                            $TotalCB=( $y + ( 5 + $heading_gap + 17 + (8* $coursedetails['noofcos']) ));
                            if($TotalCB>267){
                                $pdf->AddPage();
                                $x=15;
                                $y=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                            }
                            $pdf->Cell(0, 5,'Overall Attainment of Course Outcomes (CO) through Direct and Indirect Assessment Tools:', 0, 1, 'L', 0, '', 0, false, 'M', 'M'); 
                            $y=$y+$heading_gap;
                            $pdf->SetY($y);
                            $pdf->SetX($x);

                            $pdf->Cell(0, 10,'', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            $pdf->SetFont('helvetica', 'B', 8);
                            $pdf->MultiCell(15, 12,"CO #", 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(30, 12,"CO Attainment through Direct Assessment(DA)", 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(12, 12,$decode_Data['courselist']['codirectw']."% of DA", 1, 'C', 0, 0, '', '', true);    
                            $pdf->MultiCell(30, 12,"CO Attainment through Indirect Assessment(IA)", 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(12, 12,$decode_Data['courselist']['coindirectw']."% of IA", 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 12,"Total CO Attainment", 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(12, 12,"Target", 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 12,"Attainment Level", 1, 'C', 0, 0, '', '', true);
                            $pdf->MultiCell(20, 12,"Attainment (YES/NO)", 1, 'C', 0, 0, '', '', true);
                            $pdf->SetFont('helvetica', '', 10);
                            $y=$y+17;
                            $pdf->SetY($y);
                            $pdf->SetX($x);

                            for($i=1;$i<=$coursedetails['noofcos'];$i++){
                                $tem="CO".$i;
                                $val="";
                                $pdf->Cell(15, 8,$coursedetails['coursecode'].".".$i, 'LBR',  0, 'C', 0);
                                if( array_key_exists($tem,$coursedetails['coattainment']['direct']) ){
                                    $val=$coursedetails['coattainment']['direct'][$tem];
                                }
                                else{ $val="";}
                                $pdf->Cell(30, 8,$val, 'BR',  0, 'C', 0);

                                if(array_key_exists($tem,$coursedetails['coattainment']['xdirect'])){
                                    $val=$coursedetails['coattainment']['xdirect'][$tem];
                                }
                                else{ $val="";}
                                $pdf->Cell(12, 8,$val, 'BR',  0, 'C', 0);
                                if( array_key_exists($tem,$coursedetails['indirect']) ){
                                    $val=$coursedetails['indirect'][$tem];
                                }
                                else{ $val="";}
                                $pdf->Cell(30, 8,$val, 'BR',  0, 'C', 0);
                                if(array_key_exists($tem,$coursedetails['coattainment']['yindirect'])){
                                    $val=$coursedetails['coattainment']['yindirect'][$tem];
                                }
                                else{ $val="";}
                                $pdf->Cell(12, 8,$val, 'BR',  0, 'C', 0);
                                if(array_key_exists($tem,$coursedetails['coattainment']['totalattainment'])){
                                    $val=$coursedetails['coattainment']['totalattainment'][$tem];
                                }
                                else{ $val="";}
                                $pdf->Cell(20, 8,$val, 'BR',  0, 'C', 0);
                                $pdf->Cell(12, 8,$decode_Data['courselist']['targetattainment'], 'BR',  0, 'C', 0);
                                if(array_key_exists($tem,$coursedetails['coattainment']['levels'])){
                                    $pdf->Cell(20, 8,$coursedetails['coattainment']['levels'][$tem], 'BR',  0, 'C', 0);
                                 }
                                 else{
                                    $pdf->Cell(20, 8,"", 'BR',  0, 'C', 0);
                                 }
                                 if(array_key_exists($tem,$coursedetails['coattainment']['attain_Y_N'])){
                                    $pdf->Cell(20, 8,$coursedetails['coattainment']['attain_Y_N'][$tem], 'BR',  0, 'C', 0);
                                 } 
                                 else{
                                    $pdf->Cell(20, 8,"", 'BR',  0, 'C', 0);
                                 }
                                 $y=$y+8;
                                 $pdf->SetY($y);
                                 $pdf->SetX($x);
                            }

                            $y=$y+$heading_gap;
                            $pdf->SetY($y);
                            $pdf->SetX($x);

                            $totalGH=$y+100;
                            if($totalGH>267){
                                $pdf->AddPage();
                                $x=15;
                                $y=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                            }

                            
                            $query=http_build_query(array('cParm'=> $coursedetails['coattainment']['totalattainment']));
                            $query=$query."&targetA=".$decode_Data['courselist']['targetattainment'];
                            $query=$query."&noofcos=".$coursedetails['noofcos'];
                            $query=$query."&coursecode=".$coursedetails['coursecode'];
                            // print_r($query); exit();
                            $html=file_get_contents("http://localhost/templete/pages/scripts/pdfgraph.php?".$query);
                            if(!empty($html)){
                                    $pdf->ImageSVG('@'.$html,$x=35,$y=$pdf->GetY(),$w="130",$h="100",$link="",$align="",$palign="",$border=0,$fitonpage=false);
                            }
                            

                            $y=$y+100;
                            $x=15;
                            $pdf->SetY($y);
                            $pdf->SetX($x);

                            $totalLength_PO=( $y+(5+5+10+(5*2)));  
                            if($totalLength_PO>=267){
                                $pdf->AddPage();
                                $x=15;
                                $y=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                            }

                            $pdf->SetFont('helvetica', 'B', 10);
                            $pdf->Cell(0, 5,'Direct Program Outcomes and Program-Specific Outcome Attainment', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            $y=$y+10;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            $pdf->Cell(11, 5, 'PO1', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO2', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO3', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO4', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO5', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO6', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO7', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO8', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO9', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO10', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO11', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PO12', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PSO1', 1,  0, 'C', 0);
                            $pdf->Cell(11, 5, 'PSO2', 1,  0, 'C', 0);
                            $pdf->SetFont('helvetica', '', 10);

                            $y=$y+5;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            for($i=1;$i<=14;$i++){
                                $tem="PO".$i;
                                if($i==13){  $tem="PSO1";}
                                else if($i==14){ $tem="PSO2";}
                                if( array_key_exists($tem,$POArray) ){
                                    $pdf->Cell(11, 5,$POArray[$tem],'LBR',  0, 'C', 0);
                                }else{
                                    $pdf->Cell(11, 5,'','LBR',  0, 'C', 0);
                                }
                            }

                            $y=$y+15;
                            $x=15;
                            $pdf->SetY($y);
                            $pdf->SetX($x);


                            $checkto=$y+100;
                            if($checkto>=267){
                                $pdf->AddPage();
                                $x=15;
                                $y=15;
                                $pdf->SetY($y);
                                $pdf->SetX($x);
                            }
                            $pdf->SetFont('helvetica', 'B', 10);
                            $pdf->Cell(0, 5,'COMMENTS', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            $x=20;
                            $y=264;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            $pdf->Cell(0, 5,'COURSE LEAD', 0, 1, 'L', 0, '', 0, false, 'M', 'M');
                            $x=150;
                            $y=263;
                            $pdf->SetY($y);
                            $pdf->SetX($x);
                            $pdf->Cell(0, 5,'PROGRAM CO-ORDINATOR', 0, 1, 'L', 0, '', 0, false, 'M', 'M');

                            
                            



                           
                            



                        
                           








                            
                             
                           
                              
                                


                             $pdf->Output($fileName.'.pdf', 'I');

                                    }   

                             }
                        }
                        else{
                            echo '<p style="color:red">Enter proper level3 value</p>';
                        }
                      }
                      else{
                        echo '<p style="color:red">Enter proper level2 value</p>';
                      } 
                      }
                      else{
                        echo '<p style="color:red">Enter proper level1 value</p>';
                      }
                    }
                    else{
                        echo '<p style="color:red">Enter proper target Attainment </p>';
                    }
                  }
                  else{
                    echo '<p style="color:red">Enter proper indirect CO weightage value</p>';
                  }
                }
                else{
                    echo '<p style="color:red">Enter proper direct CO Weightage value</p>';
                }
            }
            else{
                echo '<p style="color:red">Enter proper see weightage value</p>';
            }
        }
        else{
            echo '<p style="color:red">Enter proper cie weightage value</p>';
        }
                    }
                    else{
                        echo '<p style="color:red">Enter proper courseCode</p>';
                    }
                }
                else{
                    echo '<p style="color:red">Enter proper semesterno</p>';
                }
            }
            else{
                echo '<p style="color:red">Enter proper branch</p>';
            }
        }
        else{
            echo '<p style="color:red">Enter proper academicYear</p>';
        }
    }
    else{
        echo '<p style="color:red">Enter proper Regulation</p>';
    }
}
else{
    header('location:../../index.php');
}





























?>
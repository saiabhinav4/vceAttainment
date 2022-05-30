<?php

include "../common/connection.php";
class CourseDetails{
    private $courseName;
    private $coursecode;
    private $courseType;
    private $no_of_cos;
    private $articulationMatrix;
    private $coDescription;
    private $rubricdescription;
    private $rubricmapping;
    private $bool_tax;
    private $checkstruct;
    private $QuestionsNo;
    private $PerOfMarks;
    private $indirect;
    private $noofrubrics;
    private $checkStatus;
    private $csid;
    private $coid;
    private $coattainment;
    private $poattainment;

    public function get_courseCode(){
        return $this->coursecode;
    }

    public function get_courseName(){
        return $this->courseName;
    }
    public function get_articulationMatrix(){
       return $this->articulationMatrix;
    }
    public function set_poattainment($val){
        $this->poattainment=$val;
    }
    public function get_poattainment(){
        return $this->poattainment;
    }
    public function get_indirect(){
        return $this->indirect;
    }
    public function get_struct(){
        return $this->checkstruct;
    }
    public function get_marksPer(){
        return $this->PerOfMarks;
    }
    public function get_noofcos(){
        return $this->no_of_cos;
    }
    public function set_coattainment($val){
        $this->coattainment=$val;
    }
    public function get_coattainment(){
        return $this->coattainment;
    }

    public function get_checkStatus(){
       return $this->checkStatus;
    }

    public function __construct($coid)
    {         
            $this->coid=$coid;
            global $con;
            $retrive_course="SELECT regulation,academicYear,courseCode,branch,semesterNo,courseName,no_of_cos,courseType,no_of_rubrics,csid from coursedetails where coid=$coid";
            $res=mysqli_query($con,$retrive_course) or die(mysqli_error($con));
            $row=mysqli_fetch_row($res);
            $this->courseName=$row[5];
            $this->coursecode=$row[2];
            $this->courseType=$row[7];
            $this->no_of_cos=$row[6];
            $this->noofrubrics=$row[8];
            $this->csid=$row[9];
            $this->checkstruct=new CheckStructure($this->csid);
            for($i=1;$i<=$this->no_of_cos;$i++){
                $tem="CO".$i;
                $this->coDescription[$tem]="";
                $this->bool_tax[$tem]="";
            }
            $this->assign_Codescription();

            $this->PerOfMarks=array();
            $this->checkStatus=array();
            $this->indirect=array();
            $this->assign_types();
            $this->QuestionsNo=$this->PerOfMarks;
            $this->assign_check_types();

            $this->articulationMatrix=new Articulation($this->no_of_cos,12,2);  
            $this->assign_Articulation();

            if($this->checkstruct->get_ishaverubrics()){
                $this->rubricdescription=array();
                for($i=1;$i<=$this->noofrubrics;$i++){
                    $this->rubricdescription[$i]="";
                }
                $this->assign_rubricdescription();
            }
           $this->assign_internal_external();
           $this->assign_indirect();

    }

    public function get_courseColevels(){
            $course=array(
                'noofCos'=>$this->no_of_cos
            );
            $course['result']=$this->coattainment->get_coattain_Y_N();
        return $course;
    }

    public function get_coursedetails_json(){
            $coursedetails=array(
                'coursename'=>$this->courseName,
                'coursecode'=>$this->coursecode,
                'coursetype'=>$this->courseType,
                'noofcos'=>$this->no_of_cos,
                'coursedescription'=>$this->coDescription,
                'boomTaxonomy'=>$this->bool_tax,
                'articulation'=>$this->articulationMatrix->get_PSO(),
                'structure'=>array( 
                                  'ishaveinternal'=>$this->checkstruct->get_ishaveinternal(),
                                  'ishaveexternal'=>$this->checkstruct->get_ishaveexternal(),
                                  'ishaveaat'=>$this->checkstruct->get_ishaveaat(),
                                  'ishaverubrics'=>$this->checkstruct->get_ishaverubrics(),
                                  'type'=> $this->checkstruct->get_type(),
                                  'internal'=>$this->checkstruct->get_internal(),
                                  'external'=>$this->checkstruct->get_external()
                                    ),
                 'indirect'=>$this->indirect,
                 'coattainment'=>$this->coattainment->get_coattainment_json()                   
            );

            if($this->checkstruct->get_ishaveinternal()){
                $coursedetails['internal']=$this->PerOfMarks['internal'];
                $coursedetails['internal_QNO']=$this->QuestionsNo['internal'];
            }
            if($this->checkstruct->get_ishaveexternal()){
                $coursedetails['external']=$this->PerOfMarks['external'];
                $coursedetails['external_QNO']=$this->QuestionsNo['external'];
            }

            if($this->checkstruct->get_ishaverubrics()){
                $coursedetails['noofrubrics']=$this->noofrubrics;
                $coursedetails['rubricsdesc']=$this->rubricdescription;
                $coursedetails['rubricsmapping']=$this->rubricmapping;
            }

          if($this->checkstruct->get_type()=="theoretical"){  
         
            if($this->checkstruct->get_ishaveinternal()){
                $coursedetails['structure']['internal_theory_short']=$this->checkstruct->get_internal_theory_short();
            }
            if($this->checkstruct->get_ishaveexternal()){
                $coursedetails['structure']['external_theory_short']=$this->checkstruct->get_external_theory_short();
            }
        }
        else if($this->checkstruct->get_type()=="practical"){
            if($this->checkstruct->get_ishaveinternal()){
                $coursedetails['structure']['internal_practical_short']=$this->checkstruct->get_internal_pratical_short();
            }
            if($this->checkstruct->get_ishaveexternal()){
                $coursedetails['structure']['external_practical_short']=$this->checkstruct->get_external_pratical_short();
            }
        }
        else if($this->checkstruct->get_type()=="both"){
            if($this->checkstruct->get_ishaveinternal()){
                $coursedetails['structure']['internal_theory_short']=$this->checkstruct->get_internal_theory_short();
                $coursedetails['structure']['internal_practical_short']=$this->checkstruct->get_internal_pratical_short();
            }
            if($this->checkstruct->get_ishaveexternal()){
                $coursedetails['structure']['external_theory_short']=$this->checkstruct->get_external_theory_short();
                $coursedetails['structure']['external_practical_short']=$this->checkstruct->get_external_pratical_short();
            }           
        }
        else if($this->checkstruct->get_type()=="project"){
            if($this->checkstruct->get_ishaveinternal()){
                $coursedetails['structure']['internal_project_short']=$this->checkstruct->get_internal_project_short();
            }
            if($this->checkstruct->get_ishaveexternal()){
                $coursedetails['structure']['external_project_short']=$this->checkstruct->get_external_project_short();
            }   
        }

        return $coursedetails;
    } 


    public function assign_indirect(){
        global $con;
        $retrive_survey="select f.coid,f.cono,d.courseCode,c.courseoutcome,f.feedbackvalue from coursedetails d,courseoutcomes c, feedback f where d.coid=c.coid and c.cono=f.cono and d.coid=$this->coid GROUP by d.courseCode,c.courseoutcome;";
        $res=mysqli_query($con,$retrive_survey) or die(mysqli_error($con));
        if(mysqli_num_rows($res)>0){
            while($row=mysqli_fetch_row($res)){
                   $this->indirect[$row[3]]=$row[4]; 
            }
            $this->checkStatus['indirect']=true;
            return true;
        }
        return false;
    }

    private function formatQuestionnormal($val){
      if(strpos($val,"_")!=false){   
        $arr=explode("_",$val);
        if(is_numeric($arr[0])){
            return $arr[0]."".$arr[1];
        }
        else{
            return $arr[1]; 
        }
      }
      return $val;
    }

    public function assign_internal_external(){
        global $con;
        if($this->checkstruct!=null){
            if(!$this->checkstruct->get_ishaverubrics()){

                if($this->checkstruct->get_ishaveinternal()){
                    foreach(array_keys($this->PerOfMarks['internal']) as $key => $val){
                        if($val=="aat"){
                            for($i=1;$i<=$this->no_of_cos;$i++){
                                   $tem="CO".$i;
                                   $retrive_aat="select d.coid,d.courseCode,ROUND(AVG(permarks),2) from coursedetails d,alternativetest a where d.coid=a.coid and d.coid=$this->coid and courseoutcomes like '%$tem%' group by d.courseCode;";
                                   $res=mysqli_query($con,$retrive_aat) or die(mysqli_error($con));
                                   if(mysqli_num_rows($res)==1){
                                       $row=mysqli_fetch_row($res);
                                       $this->PerOfMarks['internal'][$val][$tem]=$row[2];
                                   }
                                //    else{
                                //     $this->PerOfMarks['internal'][$val][$tem]="";
                                //    }      
                            }
                        }
                        else{
                            for($i=1;$i<=$this->no_of_cos;$i++){
                                $tem="CO".$i;
                                $retrive_internal="select d.coid,courseCode,examtype,round(AVG(noofStudents_A),2) from coursedetails d,mappingcos m where d.coid=m.coid and d.coid=$this->coid and  examtype='$val' and  courseoutcomes like '%$tem%'   group by coid,examtype;";
                                $res=mysqli_query($con,$retrive_internal) or die(mysqli_error($con));
                                if(mysqli_num_rows($res)==1){
                                       $row=mysqli_fetch_row($res);
                                       $this->PerOfMarks['internal'][$val][$tem]=$row[3];
                                }
                                
                                $retrive_QuestionNo="select m.coid,d.courseCode,m.examtype,question from coursedetails d,mappingcos m where d.coid=m.coid and courseoutcomes like '%$tem%' and  d.coid=$this->coid and examtype='$val' GROUP by d.courseCode,m.examtype,question";
                                $result=mysqli_query($con,$retrive_QuestionNo) or die(mysqli_error($con));
                                if(mysqli_num_rows($result)>0){
                                    $insert="";
                                    while($row=mysqli_fetch_row($result)){
                                        $insert=$insert.$this->formatQuestionnormal($row[3])." ";
                                    }
                                    $this->QuestionsNo['internal'][$val][$tem]=$insert;
                                }

                            }
                        }
                            if(count($this->PerOfMarks['internal'][$val])!=0){
                                $this->checkStatus['internal'][$val]=true;
                            }
                    }
                }
                if($this->checkstruct->get_ishaveexternal()){
                    foreach(array_keys($this->PerOfMarks['external']) as $key => $val){
                        for($i=1;$i<=$this->no_of_cos;$i++){
                            $tem="CO".$i;
                            $retrive_external="select d.coid,courseCode,examtype,round(AVG(noofStudents_A),2) from coursedetails d,mappingcos m where d.coid=m.coid and d.coid=$this->coid and  examtype='$val' and  courseoutcomes like '%$tem%'   group by coid,examtype;";
                            $res=mysqli_query($con,$retrive_external) or die(mysqli_error($con));
                            if(mysqli_num_rows($res)==1){
                                   $row=mysqli_fetch_row($res);
                                   $this->PerOfMarks['external'][$val][$tem]=$row[3]; 
                            }
                            
                            $retrive_QuestionNo="select m.coid,d.courseCode,m.examtype,question from coursedetails d,mappingcos m where d.coid=m.coid and courseoutcomes like '%$tem%' and  d.coid=$this->coid and examtype='$val' GROUP by d.courseCode,m.examtype,question";
                            $result=mysqli_query($con,$retrive_QuestionNo) or die(mysqli_error($con));
                            if(mysqli_num_rows($result)>0){
                                $insert="";
                                while($row=mysqli_fetch_row($result)){
                                    $insert=$insert.$this->formatQuestionnormal($row[3])." ";
                                }
                                $this->QuestionsNo['external'][$val][$tem]=$insert;
                            }
                        }
                        if(count($this->PerOfMarks['external'][$val])!=0){
                            $this->checkStatus['external'][$val]=true;
                        }   
                    }
                }
                return true;
            }  
            else{

                if($this->checkstruct->get_ishaveinternal()){
                  
                    foreach(array_keys($this->PerOfMarks['internal']) as $key => $val){
                        for($i=1;$i<=$this->no_of_cos;$i++){
                            $tem="CO".$i;
                            if($this->checkstruct->get_isdefault()==0){
                              $retrive_internal="SELECT d.coid,d.courseCode,rm.type,ROUND(AVG(percal),2) from coursedetails d,rubricdescription rd,rubricmapping rm where d.coid=rd.coid and rd.rid=rm.rno and  d.coid=$this->coid and rm.type='$val' and rd.courseoutcomes like '%$tem%' GROUP by d.courseCode,rm.type;";
                            }
                            else  if($this->checkstruct->get_isdefault()!=0){ 
                                $retrive_internal="SELECT cd.coid,cd.courseCode,cr.type,ROUND(AVG(per),2) from coursedetails cd,comappingrubrics c,courserubricsmapping cr WHERE cd.coid=c.coid and c.cmid=cr.cmid and cd.coid=$this->coid and type='$val' and courseoutcomes like '%$tem%' group by cd.courseCode,cr.type";
                            }
                            $res=mysqli_query($con,$retrive_internal) or die(mysqli_error($con));
                            if(mysqli_num_rows($res)==1){
                                $row=mysqli_fetch_row($res);
                                $this->PerOfMarks['internal'][$val][$tem]=$row[3];
                            }
                            if($this->checkstruct->get_isdefault()==0){
                            $retrive_QuestionNo="SELECT d.coid,rm.type,rd.rno from coursedetails d,rubricdescription rd,rubricmapping rm where d.coid=rd.coid and rd.rid=rm.rno and d.coid=$this->coid and rm.type='$val' and rd.courseoutcomes like '%$tem%'";
                            }
                            else if($this->checkstruct->get_isdefault()!=0){
                                $retrive_QuestionNo="SELECT cd.coid,cr.type,d.rno from coursedetails cd,comappingrubrics c,courserubricsmapping cr,defaultrubricsdes d WHERE cd.coid=c.coid and c.cmid=cr.cmid and c.deid=d.deid and cd.coid=$this->coid and type='$val' and courseoutcomes like '%$tem%'";
                            }
                            $result=mysqli_query($con,$retrive_QuestionNo) or die(mysqli_error($con));
                            if(mysqli_num_rows($result)>0){
                                $insert="";
                                while($row=mysqli_fetch_row($result)){
                                    $insert=$insert.$row[2]." ";
                                }
                                $this->QuestionsNo['internal'][$val][$tem]=$insert;
                            }

                        }
                        if(count($this->PerOfMarks['internal'][$val])!=0){
                            $this->checkStatus['internal'][$val]=true;
                        } 
                    }
                }

                if($this->checkstruct->get_ishaveexternal()){
                    foreach(array_keys($this->PerOfMarks['external']) as $key => $val){
                        for($i=1;$i<=$this->no_of_cos;$i++){
                            $tem="CO".$i;
                            if($this->checkstruct->get_isdefault()==0){
                                $retrive_internal="SELECT d.coid,d.courseCode,rm.type,ROUND(AVG(percal),2) from coursedetails d,rubricdescription rd,rubricmapping rm where d.coid=rd.coid and rd.rid=rm.rno and  d.coid=$this->coid and rm.type='$val' and rd.courseoutcomes like '%$tem%' GROUP by d.courseCode,rm.type;";
                            }
                            else  if($this->checkstruct->get_isdefault()!=0){ 
                                $retrive_internal="SELECT cd.coid,cd.courseCode,cr.type,ROUND(AVG(per),2) from coursedetails cd,comappingrubrics c,courserubricsmapping cr WHERE cd.coid=c.coid and c.cmid=cr.cmid and cd.coid=$this->coid and type='$val' and courseoutcomes like '%$tem%' group by cd.courseCode,cr.type";
                            }
                            $res=mysqli_query($con,$retrive_internal) or die(mysqli_error($con));
                            if(mysqli_num_rows($res)==1){
                                $row=mysqli_fetch_row($res);
                                $this->PerOfMarks['external'][$val][$tem]=$row[3];
                            }

                            if($this->checkstruct->get_isdefault()==0){
                                $retrive_QuestionNo="SELECT d.coid,rm.type,rd.rno from coursedetails d,rubricdescription rd,rubricmapping rm where d.coid=rd.coid and rd.rid=rm.rno and d.coid=$this->coid and rm.type='$val' and rd.courseoutcomes like '%$tem%'";
                            }
                            else if($this->checkstruct->get_isdefault()!=0){
                                $retrive_QuestionNo="SELECT cd.coid,cr.type,d.rno from coursedetails cd,comappingrubrics c,courserubricsmapping cr,defaultrubricsdes d WHERE cd.coid=c.coid and c.cmid=cr.cmid and c.deid=d.deid and cd.coid=$this->coid and type='$val' and courseoutcomes like '%$tem%'";
                            }
                            $result=mysqli_query($con,$retrive_QuestionNo) or die(mysqli_error($con));
                            if(mysqli_num_rows($result)>0){
                                $insert="";
                                while($row=mysqli_fetch_row($result)){
                                    $insert=$insert.$row[2]." ";
                                }
                                $this->QuestionsNo['external'][$val][$tem]=$insert;
                            }
                        }
                        if(count($this->PerOfMarks['external'][$val])!=0){
                            $this->checkStatus['external'][$val]=true;
                        } 
                    }
                }
                

                return true;

            }

        }   
        else{
            return false;
        } 
    }

    public function assign_rubricdescription(){
        global $con;
        if($this->checkstruct->get_isdefault()==0){
            $retrive_rubcricdesc="SELECT courseCode,courseType,rno,rubricdes from coursedetails d,rubricdescription m where d.coid=m.coid and d.coid=$this->coid group by courseCode,rno;";
        }
        else if($this->checkstruct->get_isdefault()!=0){
            $retrive_rubcricdesc="SELECT cd.courseCode,cd.courseType,d.rno,d.description from coursedetails cd,comappingrubrics c,defaultrubricsdes d WHERE cd.coid=c.coid and c.deid=d.deid and cd.coid=$this->coid order by d.rno";
        }
        $result=mysqli_query($con,$retrive_rubcricdesc) or die(mysqli_error($con));
        while($row=mysqli_fetch_row($result)){
              $this->rubricdescription[$row[2]]=$row[3]; 
        }
        if($this->checkstruct->get_isdefault()==0){
            $retrive_mapping="select rno,courseoutcomes from rubricdescription where coid=$this->coid";
        }
        else if($this->checkstruct->get_isdefault()!=0){
            $retrive_mapping="SELECT d.rno,c.courseoutcomes from coursedetails cd,comappingrubrics c,defaultrubricsdes d WHERE cd.coid=c.coid and c.deid=d.deid and cd.coid=$this->coid order by d.rno";    
        }
        $res=mysqli_query($con,$retrive_mapping) or die(mysqli_error($con));
        while($row=mysqli_fetch_row($res)){
            $this->rubricmapping[$row[0]]=$this->retrive_cos($this->no_of_cos,$row[1]);
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
            return $tem;
    }
    public function assign_Articulation(){
              global $con;
              if($this->articulationMatrix!=null){
                $retrive_pos="SELECT d.coid,c.courseoutcome,d.courseCode,a.programOutcomes,a.weight as Average from coursedetails d,courseoutcomes c,articulation a where d.coid=c.coid and c.cono=a.cono and d.coid=$this->coid and a.programOutcomes <>'' order by d.courseCode,c.courseoutcome,a.programOutcomes";
                $result_pos=mysqli_query($con,$retrive_pos) or die(mysqli_error($con));
                while($row=mysqli_fetch_row($result_pos)){
                    $this->articulationMatrix->update_PO($row[1],$row[3],$row[4]);
                }
                $retrive_psos="SELECT d.coid,c.courseoutcome,d.courseCode,a.programSpecificOutcome,a.weight as Average from coursedetails d,courseoutcomes c,articulation a where d.coid=c.coid and c.cono=a.cono and d.coid=$this->coid and a.programSpecificOutcome <>'' order by d.courseCode,c.courseoutcome,a.programSpecificOutcome";
                $result_psos=mysqli_query($con,$retrive_psos) or die(mysqli_error($con));
                while($row=mysqli_fetch_row($result_psos)){
                    $this->articulationMatrix->update_PO($row[1],$row[3],$row[4]);
                }
              }
              else{
                  return false;
              } 
    }
    public function assign_Codescription(){
            global $con;
                $retrive_codescription="SELECT courseCode,courseDescription,courseoutcome,bt from coursedetails d,courseoutcomes c where d.coid=c.coid and d.coid=$this->coid group by courseCode,courseoutcome";
                $result_codesc=mysqli_query($con,$retrive_codescription) or die(mysqli_error($con));
                while($row=mysqli_fetch_row($result_codesc)){
                    $this->coDescription[$row[2]]=$row[1];
                    $this->bool_tax[$row[2]]=$row[3];
                }
                return true;
    }
    public function assign_types(){
        if($this->checkstruct!=null){
            if($this->checkstruct->get_ishaveinternal()){
                foreach($this->checkstruct->get_internal() as $key=>$val){
                    $this->PerOfMarks['internal'][$val]=array();
                }
            }
            if($this->checkstruct->get_ishaveaat()){
                $this->PerOfMarks['internal']['aat']=array();
            }
            if($this->checkstruct->get_ishaveexternal()){
                foreach($this->checkstruct->get_external() as $key=>$val){
                $this->PerOfMarks['external'][$val]=array();
                }
            }

            return true;
        }
        else{
            return false;
        }
    }

    public function assign_check_types(){
        if($this->checkstruct!=null){
            if($this->checkstruct->get_ishaveinternal()){
                foreach($this->checkstruct->get_internal() as $key=>$val){
                    $this->checkStatus['internal'][$val]=false;
                }
            }
            if($this->checkstruct->get_ishaveaat()){
                $this->checkStatus['internal']['aat']=false;
            }
            if($this->checkstruct->get_ishaveexternal()){
                foreach($this->checkstruct->get_external() as $key=>$val){
                $this->checkStatus['external'][$val]=false;
                }
            }
            $this->checkStatus['indirect']=false;

            return true;
        }
        else{
            return false;
        }
    }

}

class CheckStructure {
    private $ishaverubrics;
    private $ishaveinternal;
    private $ishaveexternal;
    private $ishaveaat;
    private $type;
    private $isdefault;
    private $internal_theory_short;
    private $internal_theory_long;
    private $internal_practical_short;
    private $internal_practical_long;
    private $internal_project_short;
    private $internal_project_long; 
    private $external_theory_short;
    private $external_theory_long;
    private $external_practical_short;
    private $external_practical_long;
    private $external_project_short;
    private $external_project_long;    
    private $internal;
    private $external;
    public function get_isdefault(){
        return $this->isdefault;
    }
    public function get_internal_theory_short(){
        return $this->internal_theory_short;
    }   
    public function get_internal_pratical_short(){
        return $this->internal_practical_short;
    } 
    public function get_internal_project_short(){
        return $this->internal_project_short;
    }
    public function get_external_theory_short(){
        return $this->external_theory_short;
    }   
    public function get_external_pratical_short(){
        return $this->external_practical_short;
    } 
    public function get_external_project_short(){
        return $this->external_project_short;
    }
    private function formate_input($row_s){
        if(!empty($row_s)){
            return explode(",",$row_s);
        } 
     return array();
    }
    public function __construct($csid)
    {
        global $con;
        // $select_qy="select csid,courseType,ishaveinternal,ishaveexternal,ishaveaat,ishaverubrics,internalTypes_s,internalTypes_f,externalTypes_s,externalTypes_f from coursestructure where csid=$csid";
        $select_query1="SELECT csid,courseType,ishaverubrics,ishaveinternal,ishaveexternal,ishaveaat,type,int_th_short,int_th_long,int_par_short,int_par_long,int_proj_short,int_proj_long,ext_th_short,ext_th_long,ext_par_short,ext_par_long,ext_proj_short,ext_proj_long,isdefault from coursestructure1 where csid=$csid"; 
        $result=mysqli_query($con,$select_query1) or die(mysqli_error($con));
        $row=mysqli_fetch_row($result);
        $this->ishaverubrics=($row[2]=="1")?true:false;
        $this->ishaveinternal=($row[3]=="1")?true:false;
        $this->ishaveexternal=($row[4]=="1")?true:false;
        $this->ishaveaat=($row[5]=="1")?true:false;
        $this->type=$row[6];
        $this->isdefault=$row[19];
        $this->internal_theory_short=$this->formate_input($row[7]);
        $this->internal_theory_long=$this->formate_input($row[8]);
        $this->internal_practical_short=$this->formate_input($row[9]);
        $this->internal_practical_long=$this->formate_input($row[10]);
        $this->internal_project_short=$this->formate_input($row[11]);
        $this->internal_project_long=$this->formate_input($row[12]);
        
        $this->external_theory_short=$this->formate_input($row[13]);
        $this->external_theory_long=$this->formate_input($row[14]);
        $this->external_practical_short=$this->formate_input($row[15]);
        $this->external_practical_long=$this->formate_input($row[16]);
        $this->external_project_short=$this->formate_input($row[17]);
        $this->external_project_long=$this->formate_input($row[18]);
        $internal_s=array();
        $internal_f=array();
        $external_s=array();
        $external_f=array();

        if($this->type=="theoretical"){

            if($this->ishaveinternal){
              $in_th_s=$this->formate_input($row[7]);
              $in_th_l=$this->formate_input($row[8]);

              $internal_s=$in_th_s;
              $internal_f=$in_th_l;

            }
            if($this->ishaveexternal){
                $ex_th_s=$this->formate_input($row[13]);
                $ex_th_l=$this->formate_input($row[14]);

                $external_s=$ex_th_s;
                $external_f=$ex_th_l;
            }

        }
        else if($this->type=="practical"){
            if($this->ishaveinternal){
                $in_pa_s=$this->formate_input($row[9]);
                $in_pa_l=$this->formate_input($row[10]);

                $internal_s=$in_pa_s;
                $internal_f=$in_pa_l;

              }
              if($this->ishaveexternal){
                  $ex_pa_s=$this->formate_input($row[15]);
                  $ex_pa_l=$this->formate_input($row[16]);

                  $external_s=$ex_pa_s;
                  $external_f=$ex_pa_l;
              }

        }
        else if($this->type=="both"){
            if($this->ishaveinternal){
                $in_th_s=$this->formate_input($row[7]);
                $in_th_l=$this->formate_input($row[8]);
                $in_pa_s=$this->formate_input($row[9]);
                $in_pa_l=$this->formate_input($row[10]);

                $internal_s=array_merge($in_th_s,$in_pa_s);
                $internal_f=array_merge($in_th_l,$in_pa_l);

              }
              if($this->ishaveexternal){
                $ex_th_s=$this->formate_input($row[13]);
                $ex_th_l=$this->formate_input($row[14]);
                $ex_pa_s=$this->formate_input($row[15]);
                $ex_pa_l=$this->formate_input($row[16]);

                $external_s=array_merge($ex_th_s,$ex_pa_s);
                $external_f=array_merge($ex_th_l,$ex_pa_l);
            }


        }
        else if($this->type=="project"){

            if($this->ishaveinternal){
                $in_proj_s=$this->formate_input($row[11]);
                $in_proj_l=$this->formate_input($row[12]);

                $internal_s=$in_proj_s;
                $internal_f=$in_proj_l;

              }
              if($this->ishaveexternal){
                  $ex_proj_s=$this->formate_input($row[17]);
                  $ex_proj_l=$this->formate_input($row[18]);

                  $external_s=$ex_proj_s;
                  $external_f=$ex_proj_l;
              }

        }



        $this->internal=$internal_s;
        $this->external=$external_s;

    }

    public function get_ishaverubrics(){
        return $this->ishaverubrics;
    }
    public function get_ishaveinternal(){
        return $this->ishaveinternal;
    } 
    public function get_ishaveexternal(){
        return $this->ishaveexternal;
    }
    public function get_ishaveaat(){
        return $this->ishaveaat;
    }
    public function get_internal(){
        return $this->internal;
    }
    public function get_external(){
        return $this->external;
    }
    public function get_type(){
        return $this->type;
    }

}

class POAttainment{

        private $directPO;

        public function __construct()
        {
               $this->directPO=array(); 
        }
        
        public function update_directpo($po,$val){
            $this->directPO[$po]=$val;
        }
        public function get_directpo(){
            return $this->directPO;
        }

}


class COAttainment{

        private $CIE;
        private $SEE;
        private $xcie;
        private $xsee;
        private $direct;
        private $xdirect;
        private $yindirect;
        private $totalattainment;
        private $attain_y_n;
        private $levels;
        
        public function __construct()
        {
            $this->CIE=array();
            $this->SEE=array();
            $this->xcie=array();
            $this->xsee=array();
            $this->direct=array();
            $this->xdirect=array();
            $this->yindirect=array();
            $this->totalattainment=array();
            $this->attain_y_n=array();
            $this->levels=array();
        }
        public function get_coattain_Y_N(){
            return $this->attain_y_n;
        }
        public function get_coattainment_json(){
            $coattainment=array(
                'cie'=>$this->CIE,
                'see'=>$this->SEE,
                'xcie'=>$this->xcie,
                'xsee'=>$this->xsee,
                'direct'=>$this->direct,
                'xdirect'=>$this->xdirect,
                'yindirect'=>$this->yindirect,
                'totalattainment'=>$this->totalattainment,
                'attain_Y_N'=>$this->attain_y_n,
                'levels'=>$this->levels
            );
            return $coattainment;
        }

        public function update_level($co,$val){
            $this->levels[$co]=$val;
        }
        public function get_level(){
            return $this->levels;
        }

        public function update_attain_y_n($co,$val){
            $this->attain_y_n[$co]=$val;
        }
        public function get_attain_y_n(){
            return $this->attain_y_n;
        }
        public function update_totalattainment($co,$val){
            $this->totalattainment[$co]=$val;
        }
        public function get_totalattainment(){
            return $this->totalattainment;
        }
        public function update_yindirect($co,$val){
            $this->yindirect[$co]=$val;
        }
        public function get_yindirect(){
            return $this->yindirect;
        }

        public function update_xdirect($co,$val){
            $this->xdirect[$co]=$val;
        }
        public function get_xdirect(){
            return $this->xdirect;
        }
        public function update_direct($co,$val){
            $this->direct[$co]=$val;
        }
        public function get_direct(){
            return $this->direct;
        }

        public function update_xsee($co,$val){
            $this->xsee[$co]=$val;
        }
        public function get_xsee(){
            return $this->xsee;
        }
        public function update_xcie($co,$val){
            $this->xcie[$co]=$val;
        }
        public function get_xcie(){
            return $this->xcie;
        }

        public function update_CIE($co,$val){
            $this->CIE[$co]=$val;
        }
        public function get_CIE(){
            return $this->CIE;
        }

        public function update_SEE($co,$val){
            $this->SEE[$co]=$val;
        }
        public function get_SEE(){
            return $this->SEE;
        }




}


class Articulation{
    private $no_of_cos;
    private $no_of_pos;
    private $no_of_psos;
    private $PSO;
    public function __construct($nocos,$nopos,$nopsos)
    {
       $this->no_of_cos=$nocos; 
       $this->no_of_pos=$nopos;
       $this->no_of_psos=$nopsos;
       $this->PSO=array();
      for($j=1;$j<=$this->no_of_cos;$j++){
          $temc="CO".$j; 
          $this->PSO[$temc]=array();
         for($i=1;$i<=$this->no_of_pos;$i++){
                $tem="PO".$i;
                $this->PSO[$temc][$tem]=0;
            } 
        for($i=1;$i<=$this->no_of_psos;$i++){
                $tem="PSO".$i;
                $this->PSO[$temc][$tem]=0;
            } 
      }
    }
    public function get_pos(){
        return $this->no_of_pos;
    }
    public function get_psos(){
        return $this->no_of_psos;
    }
    public function get_PSO(){
       return  $this->PSO;
    }
    public function update_PO($co,$po,$val){
        $this->PSO[$co][$po]=$val;
    }
}

class Main{

    private $courselist;
    private $cie_weightage;
    private $see_weightage;
    private $target_attainment;
    private $directCO_weightage;
    private $indirectCO_weightage;
    private $podirect_weightage;
    private $poindirect_weightage;
    private $potarget_attainment;
    private $level1;
    private $level2;
    private $level3;
    private $co_curricular;
    private $extra_curricular;
    private $student_exit;
    private $co_curricular_levels;
    private $extra_curricular_levels;
    private $student_exit_levels;
    private $total_indirect_levels;
    private $overalldirectpo;
    private $directpo;
    private $directpo_x;
    private $indirectpo;
    private $indirectpo_y;
    private $overallpo;
    private $attainpo_y_n;
    private $podescription;

    public function __construct()
    {
        $this->directpo=array();
        $this->indirectpo=array();
        $this->directpo_x=array();
        $this->indirectpo_y=array();
        $this->overallpo=array();
        $this->attainpo_y_n=array();
        $this->overalldirectpo=array();
        $this->courselist=array();
        $this->co_curricular=array();
        $this->extra_curricular=array();
        $this->student_exit=array();
        $this->co_curricular_levels=array();
        $this->extra_curricular_levels=array();
        $this->student_exit_levels=array();
        $this->total_indirect_levels=array(); 
        $this->podescription=array();   
    }

    public function get_podescription(){
        return $this->podescription;
    }
    public function set_podirect_weightage($val){
        $this->podirect_weightage=$val;
    }
    public function set_poindirect_weightage($val){
        $this->poindirect_weightage=$val;
    }
    public function set_potarget_attainment($val){
        $this->potarget_attainment =$val;
    }
    public function set_cie_weight($val){
        $this->cie_weightage=$val;
    }
    public function get_cie_weightage(){
        $this->cie_weightage;
    }
    public function set_see_weight($val){
        $this->see_weightage=$val;
    }
    public function get_see_weightage(){
        $this->see_weightage;
    }
    public function set_target_attainment($val){
        $this->target_attainment=$val;
    }
    public function get_target_attainment(){
        $this->target_attainment;
    }
    public function set_directCO_weight($val){
        $this->directCO_weightage=$val;
    }
    public function get_directCO_weightage(){
        $this->directCO_weightage;
    }
    public function set_indirectCO_weight($val){
        $this->indirectCO_weightage=$val;
    }
    public function get_indirectCO_weightage(){
        $this->indirectCO_weightage;
    }
    public function set_level1($val){
        $this->level1=$val;
    }
    public function set_level2($val){
        $this->level2=$val;
    }
    public function set_level3($val){
        $this->level3=$val;
    }

    public function assign_po_description($branch){
        global $con;
        $flage=true;
        $retrive_podesc="select programoutcome,poDescription from programoutcomes where department='$branch' or  department='overall' group by programoutcome";
        $res=mysqli_query($con,$retrive_podesc) or die(mysqli_error($con));
        if(mysqli_num_rows($res)>0){
              while($row=mysqli_fetch_row($res)){
                  $this->podescription[$row[0]]=$row[1];
              }  
             for($i=1;$i<=14;$i++){
                 $tem="PO".$i;
                 if($i==13){
                     $tem="PSO1";
                 }
                 else if($i==14){
                     $tem="PSO2";
                 }

                 if( array_key_exists($tem,$this->podescription)==false ){
                     $flage=false;
                 }
             }
             
             if($flage){
                return true;
             }
             else{
                return false;
             }
        }
        else{
            return false;
        }
    }
    public function get_COLevels_json($val){
        $levels=array();
        foreach($this->courselist as $key=>$course){
            $levels['courseoutcomes'][$key]=$course->get_courseColevels();
        }
        $levels['poerror']=$val;
        return $levels;
    }
    public function get_COAttainments_json(){
        $attainments=array(
            'CIEw'=>$this->cie_weightage,
            'SEEw'=>$this->see_weightage,
            'targetattainment'=>$this->target_attainment,
            'codirectw'=>$this->directCO_weightage,
            'coindirectw'=>$this->indirectCO_weightage
        );
        $attainments['coursedetails']=array();
        foreach($this->courselist as $key=>$course){
            $attainments['coursedetails'][$key]=$course->get_coursedetails_json();
        }

        return $attainments;

    }
    public function get_directpo_json(){
        $directpo=array();
        foreach($this->courselist as $key=>$course){
            $directpo['directpoAttainment'][$key]=array(
                'coursename'=>$course->get_courseName(),
                'coursecode'=>$course->get_courseCode(),
                'pos'=>$course->get_poattainment()->get_directpo()
            );
        }
        $directpo['overall']=$this->overalldirectpo;

        return $directpo;

    }
    public function get_indirectpo_json(){
        $indirectpo=array();
        $indirectpo['co_curricular']=$this->co_curricular_levels;
        $indirectpo['extra_curricular']=$this->extra_curricular_levels;
        $indirectpo['student_exit']=$this->student_exit_levels;
        $indirectpo['total']=$this->total_indirect_levels;

        return $indirectpo;
    }
    public function get_overallPO_Dashboard_json(){
        $levels=array();
        foreach($this->courselist as $key=>$course){
            $levels['courseoutcomes'][$key]=$course->get_courseColevels();
        }
        $levels['programOutcomes']['attained']=$this->attainpo_y_n;
        $levels['programOutcomes']['overall']=$this->overallpo;
        return $levels;
    }
    public function get_overallPO_json(){
        $overallpo=array();
        $overallpo['target']=$this->potarget_attainment;
        $overallpo['directw']=$this->podirect_weightage;
        $overallpo['indirectw']=$this->poindirect_weightage;
        $overallpo['direct_assessment']=$this->directpo;
        $overallpo['xdirect_assessment']=$this->directpo_x;
        $overallpo['indirect_assessment']=$this->indirectpo;
        $overallpo['ydirect_assessment']=$this->indirectpo_y;
        $overallpo['overall_assessment']=$this->overallpo;
        $overallpo['attainmed']=$this->attainpo_y_n;

        return $overallpo;

    }

    public function calculate_overallPOs(){
        $this->potarget_attainment=round((($this->potarget_attainment*3)/100),2);

        for($i=1;$i<=14;$i++){
             $tem="PO".$i;
             if($i==13){
                $tem="PSO1";
             }else if($i==14){
                $tem="PSO2";
             }
           
         if( array_key_exists($tem,$this->overalldirectpo)){  
           $this->directpo[$tem]=$this->overalldirectpo[$tem];
         }
         if( array_key_exists($tem,$this->directpo) ){
           $this->directpo_x[$tem]=  round(( ( $this->directpo[$tem] *  $this->podirect_weightage )/100 ),2);
         }
         if( array_key_exists($tem,$this->total_indirect_levels) ){
           $this->indirectpo[$tem]= $this->total_indirect_levels[$tem];
         }
         if( array_key_exists($tem, $this->indirectpo) ){
           $this->indirectpo_y[$tem]=round(( (   $this->indirectpo[$tem] *  $this->poindirect_weightage )/100 ),2);
         }
         if( array_key_exists($tem,$this->directpo_x) and array_key_exists($tem,$this->indirectpo_y) ){
            $this->overallpo[$tem]=round( ( $this->directpo_x[$tem]+ $this->indirectpo_y[$tem]),2);
         }
         else if(array_key_exists($tem,$this->directpo_x)){
            $this->overallpo[$tem]=round( ( $this->directpo_x[$tem]),2);
         }
         else if(array_key_exists($tem,$this->indirectpo_y)){
            $this->overallpo[$tem]=round( ($this->indirectpo_y[$tem]),2);
         }
          
        if( array_key_exists($tem,$this->overallpo) ){  
           if( $this->overallpo[$tem]>=$this->potarget_attainment){
                    $this->attainpo_y_n[$tem]="YES";
           }
           else{
                    $this->attainpo_y_n[$tem]="NO";
           }   
        }
    
        }
        return true;
    }     
        
    

    public function calculate_PO(){

        foreach($this->courselist as $k=>$course){
            $wt=0;$sum=0;
            for($i=1;$i<=12;$i++){
                $po="PO".$i;$wt=0;$sum=0;
                for($j=1;$j<=$course->get_noofcos();$j++){
                   $co="CO".$j;
                   $v=$course->get_articulationMatrix()->get_PSO()[$co][$po];
                   $wt+=$v;
                   if( array_key_exists($co,$course->get_coattainment()->get_level()) ){
                   $sum+=($v*$course->get_coattainment()->get_level()[$co]);
                    }
                
                }
                $f=0;
                if($wt!=0){
                $f=round(($sum/$wt),2);
                $course->get_poattainment()->update_directpo($po,$f);
                }
            }
            for($i=1;$i<=2;$i++){
             $pso="PSO".$i;$wt=0;$sum=0;
             for($j=1;$j<=$course->get_noofcos();$j++){
                $co="CO".$j;
                $v=$course->get_articulationMatrix()->get_PSO()[$co][$pso];
                $wt+=$v;
                if( array_key_exists($co,$course->get_coattainment()->get_level()) ){
                    $sum+=($v*$course->get_coattainment()->get_level()[$co]);
                 }
             }
             $f=0;
             if($wt!=0){
                 $f=round(($sum/$wt),2);
                 $course->get_poattainment()->update_directpo($pso,$f);
             }
            
         }
        
        }

        for($i=1;$i<=14;$i++){
            $tem="PO".$i;
            if($i==13){
              $tem="PSO1";
            }
            else if($i==14){
                $tem="PSO2";
            }
            $dsum=0;
            $dc=0;
            foreach($this->courselist as $key => $course){
                if( array_key_exists($tem,$course->get_poattainment()->get_directpo())  and  $course->get_poattainment()->get_directpo()[$tem]!=0){
                 $dsum+=$course->get_poattainment()->get_directpo()[$tem];
                 $dc++;
                }
            }
            if($dc!=0){
                $this->overalldirectpo[$tem]= round(($dsum/$dc),2);
            }
            
        }


    } 

    public function retrive_indirectPO($regulation,$academicYear,$branch){
            global $con;
            $select_po="SELECT ipno from indirectpodetails where regulation='$regulation' and academicYear='$academicYear' and branch='$branch'";
            $result_po=mysqli_query($con,$select_po) or die(mysqli_error($con));
            if(mysqli_num_rows($result_po)>0){
                $row=mysqli_fetch_row($result_po);       
                $ipno=$row[0];
                for($i=1;$i<=14;$i++){
                $tem="PO".$i;
                if($i==13){
                    $tem="PSO1";
                    }
                else if($i==14){
                    $tem="PSO2";
                    }
                $select_stm="select ROUND(avg(per),2),type from pomapping where ipno=$ipno and programoutcomes like '%$tem,%' group by type order by type";
                $select_result=mysqli_query($con,$select_stm) or die(mysqli_error($con));
            while($row=mysqli_fetch_row($select_result)){
                if($row[1]=="co_curricular"){
                    $this->co_curricular[$tem]=$row[0];
                }
                else if($row[1]=="extra_curricular"){
                    $this->extra_curricular[$tem]=$row[0];
                }
                else if($row[1]=="exit_survey"){
                    $this->student_exit[$tem]=$row[0];   
                }
            }   
          }
             // 
             if(count($this->co_curricular)!=0 and count($this->extra_curricular)!=0 and count($this->student_exit)!=0){

                for($i=1;$i<=14;$i++){
                    $tem="PO".$i;
                    $base=0;$sum=0;
                    if($i==13){
                        $tem="PSO1";
                        }
                    else if($i==14){
                        $tem="PSO2";
                        }

                    if( array_key_exists($tem,$this->co_curricular)){
                          $te=$this->assign_level($this->co_curricular[$tem]);  
                          $this->co_curricular_levels[$tem]=$te;
                          $sum+=$te;
                          $base++;  
                    } 
                    if( array_key_exists($tem,$this->extra_curricular)){
                        $te=$this->assign_level($this->extra_curricular[$tem]); 
                        $this->extra_curricular_levels[$tem]=$te;
                        $sum+=$te;
                        $base++;
                    }
                    if( array_key_exists($tem,$this->student_exit)){
                        $te=$this->assign_level($this->student_exit[$tem]); 
                        $this->student_exit_levels[$tem]=$te;
                        $sum+=$te; 
                        $base++;
                    }    
                    if($base!=0){
                        $this->total_indirect_levels[$tem]=round(($sum/$base),2);
                    }


                }


                return true;

             }
             else{
                 return false;
             }
          
        }
            else{
                return false;
            }
    }

    public function calculate_coattainments(){
        if($this->check_data_complete()){
            foreach($this->courselist as $k => $course){
                $mark=$course->get_marksPer();
                if($course->get_struct()->get_ishaveinternal()){
                    for($i=1;$i<=$course->get_noofcos();$i++){
                            $tem="CO".$i;
                            $base=0;$sum=0;
                            foreach($mark['internal'] as $k1=>$arr){
                                if(array_key_exists($tem,$arr)){
                                    $sum=$sum+$arr[$tem];
                                    $base++;
                                }
                            }
                            if($base!=0){
                                $course->get_coattainment()->update_CIE($tem,round(($sum/$base),2));    
                            }
                    }
                }
                if($course->get_struct()->get_ishaveexternal()){
                    for($i=1;$i<=$course->get_noofcos();$i++){
                            $tem="CO".$i;
                            $base=0;$sum=0;
                            foreach($mark['external'] as $k1=>$arr){
                                if(array_key_exists($tem,$arr)){
                                    $sum=$sum+$arr[$tem];
                                    $base++;
                                }
                            }
                            if($base!=0){
                                $course->get_coattainment()->update_SEE($tem,round(($sum/$base),2));    
                            }
                    }

                }

                for($i=1;$i<=$course->get_noofcos();$i++){
                    $tem="CO".$i;
                    //1
                    if(array_key_exists($tem,$course->get_coattainment()->get_CIE())){
                        if($course->get_struct()->get_ishaveexternal()){
                            $course->get_coattainment()->update_xcie( $tem,round( ( $course->get_coattainment()->get_CIE()[$tem])*($this->cie_weightage)/100,2) );
                        }
                        else{
                            $course->get_coattainment()->update_xcie( $tem,round( ($course->get_coattainment()->get_CIE()[$tem]),2) );
                        }
                    }
                    //2
                    if(array_key_exists($tem,$course->get_coattainment()->get_SEE())){
                        if($course->get_struct()->get_ishaveinternal()){
                            $course->get_coattainment()->update_xsee( $tem,round( ( $course->get_coattainment()->get_SEE()[$tem])*($this->see_weightage)/100,2) );
                        }
                        else{
                            $course->get_coattainment()->update_xsee( $tem,round( ( $course->get_coattainment()->get_SEE()[$tem]),2));
                        }
                    }
                    //3
                    if( array_key_exists($tem,$course->get_coattainment()->get_xcie()) && array_key_exists($tem,$course->get_coattainment()->get_xsee()) ){
                        $course->get_coattainment()->update_direct($tem,($course->get_coattainment()->get_xcie()[$tem]+$course->get_coattainment()->get_xsee()[$tem]));
                    }
                    else if( array_key_exists($tem,$course->get_coattainment()->get_xcie())){
                        $course->get_coattainment()->update_direct($tem,$course->get_coattainment()->get_xcie()[$tem]);
                    }
                    else if(array_key_exists($tem,$course->get_coattainment()->get_xsee())){
                        $course->get_coattainment()->update_direct($tem,$course->get_coattainment()->get_xsee()[$tem]);
                    }
                    //4
                    if( array_key_exists($tem,$course->get_coattainment()->get_direct())){
                        $course->get_coattainment()->update_xdirect($tem,round((( $course->get_coattainment()->get_direct()[$tem])*($this->directCO_weightage/100)),2));
                    }
                    //5
                    if( array_key_exists($tem,$course->get_indirect())){
                        $course->get_coattainment()->update_yindirect($tem, round( ( ($course->get_indirect()[$tem]) *($this->indirectCO_weightage/100) ),2));
                    }
                    //6
                    if( array_key_exists($tem,$course->get_coattainment()->get_xdirect()) and array_key_exists($tem,$course->get_coattainment()->get_yindirect())){
                        $course->get_coattainment()->update_totalattainment($tem,($course->get_coattainment()->get_xdirect()[$tem]+$course->get_coattainment()->get_yindirect()[$tem]));    
                    }
                    else if( array_key_exists($tem,$course->get_coattainment()->get_xdirect()) ){
                        $course->get_coattainment()->update_totalattainment($tem,($course->get_coattainment()->get_xdirect()[$tem]));  
                    }
                    else if(array_key_exists($tem,$course->get_coattainment()->get_yindirect())){
                        $course->get_coattainment()->update_totalattainment($tem,($course->get_coattainment()->get_yindirect()[$tem])); 
                    }
                    //7
                    
                    if(array_key_exists($tem,$course->get_coattainment()->get_totalattainment())){
                        if( $course->get_coattainment()->get_totalattainment()[$tem]>=$this->target_attainment ){
                            $course->get_coattainment()->update_attain_y_n($tem,"YES");
                        }
                        else{
                            $course->get_coattainment()->update_attain_y_n($tem,"NO");
                        }
                    }
                    //8
                    if(array_key_exists($tem,$course->get_coattainment()->get_totalattainment())){
                        $course->get_coattainment()->update_level($tem,$this->assign_level($course->get_coattainment()->get_totalattainment()[$tem]));
                    }

                }

            }
            return true;
        }
        else{
            return false;
        }
    }

    private function assign_level($val){
            $ar1=explode("-",$this->level1);
            $min_1=(int)$ar1[0];$max_1=(int)$ar1[1];
            $ar2=explode("-",$this->level2);
            $min_2=(int)$ar2[0];$max_2=(int)$ar2[1];
            $ar3=explode("-",$this->level3);
            $min_3=(int)$ar3[0];$max_3=(int)$ar3[1];

            if($val>=$min_3 and $val<=$max_3){
                return 3;
            }else if($val>=$min_2 and $val<$max_2){
                return 2;
            }
            else if($val>=$min_1 and $val<$max_1){
                return 1;
            }
            return 0;
    }

    public function get_check_status_json(){
           $checkStatus=array(); 
        foreach($this->courselist as $key=>$course){
               $checkStatus['courses'][$key]=array(
                    'courseName'=>$course->get_courseName(),
                    'courseCode'=>$course->get_courseCode(),
                    'status'=>$course->get_checkStatus()
               ); 
        }
        return $checkStatus;
    }

    public function check_data_complete(){
        $check=true;
        if(count($this->courselist)!=0){
            foreach($this->courselist as $key=>$val){
                $temp=$val->get_checkStatus();
                // echo "first<br>";
                // print_r($temp);
                foreach(array_keys($temp) as $k=> $v){
                    if($v=="indirect"){
                        if($temp[$v]==false){
                        $check=false;
                        return $check;
                        }
                    }
                    else{
                        // echo "$v<br>";
                        foreach($temp[$v] as $k1 => $v1){
                            if($v1==false){
                               $check=false;
                               return $check;   
                            }
                        }
                    }

                } 
            }
            return $check;
        }
        else{
            return false;
        }
    }



    public function update_course($val){
         array_push($this->courselist,$val);
    }
    public function get_courselist(){
        return $this->courselist;
    }

}


$regulation=$academicYear=$branch=$semesterNo=$ischeck=$endpoint=$type=$coursecode=null;
$bundle=new Main();
if(isset($_GET) and !empty($_GET)){
    if(isset($_GET['regulation']) and !empty($_GET['regulation'])){
        if(isset($_GET['academicYear']) and !empty($_GET['academicYear'])){
            if(isset($_GET['branch']) and !empty($_GET['branch'])){
                if(isset($_GET['endpoint']) and !empty($_GET['endpoint'])){
                    if(isset($_GET['semesterNo']) and !empty($_GET['semesterNo'])){
                    $regulation=$_GET['regulation'];
                    $academicYear=$_GET['academicYear'];
                    $branch=$_GET['branch'];
                    $semesterNo=$_GET['semesterNo'];
                    $endpoint=$_GET['endpoint'];
                        if(isset($_GET['coursecode'])){
                            if(!empty($_GET['coursecode'])){
                                $coursecode=$_GET['coursecode'];
                            }
                            else{
                                $result=json_encode(array('error'=>'coursecode error'));
                                header('Content-Type:application/json');
                                echo $result; exit();            
                            }
                        }
                    if(!empty($coursecode)){  
                        $select_courses="select DISTINCT d.coid from coursedetails d,courseoutcomes c where d.coid=c.coid and d.regulation='$regulation' and d.academicYear='$academicYear' and d.branch='$branch' and d.semesterNo=$semesterNo and courseCode='$coursecode'";
                    }
                    else if($endpoint=="DASHBOARD"){
                        $select_courses="select DISTINCT d.coid from coursedetails d,courseoutcomes c where d.coid=c.coid and d.regulation='$regulation' and d.academicYear='$academicYear' and d.branch='$branch' and iscomplete=1 ";
                    }
                    else{
                        $select_courses="select DISTINCT d.coid from coursedetails d,courseoutcomes c where d.coid=c.coid and d.regulation='$regulation' and d.academicYear='$academicYear' and d.branch='$branch' and d.semesterNo=$semesterNo ";
                    }
                        $result_courses=mysqli_query($con,$select_courses) or die(mysqli_error($con));
                        if(mysqli_num_rows($result_courses)>0){
                             while($row=mysqli_fetch_row($result_courses)){
                                    $bundle->update_course(new CourseDetails($row[0]));
                             }
                        

                            if($endpoint=="CheckStatus"){
                                   $json_array=$bundle->get_check_status_json();
                                   $result=json_encode($json_array);
                                   header('Content-Type:application/json');
                                   echo $result;exit();   
                            }

                             if($bundle->check_data_complete()){
                                if(isset($_GET['catw']) and !empty($_GET['catw'])){
                                    if(isset($_GET['seew']) and !empty($_GET['seew'])){
                                        if(isset($_GET['targetA']) and !empty($_GET['targetA'])){
                                            if(isset($_GET['directCO']) and !empty($_GET['directCO'])){
                                                if(isset($_GET['indirectCO']) and !empty($_GET['indirectCO'])){
                                                    if(isset($_GET['level1']) and !empty($_GET['level1'])){
                                                        if(isset($_GET['level2']) and !empty($_GET['level2'])){
                                                            if(isset($_GET['level3']) and !empty($_GET['level3'])){
                            
                                                                       $bundle->set_cie_weight($_GET['catw']);
                                                                       $bundle->set_see_weight($_GET['seew']);
                                                                       $bundle->set_directCO_weight($_GET['directCO']);
                                                                       $bundle->set_indirectCO_weight($_GET['indirectCO']);
                                                                       $bundle->set_level1($_GET['level1']);
                                                                       $bundle->set_level2($_GET['level2']);
                                                                       $bundle->set_level3($_GET['level3']); 
                                                                       $bundle->set_target_attainment($_GET['targetA']);

                                                                       foreach($bundle->get_courselist() as $key => $course){
                                                                            $course->set_coattainment(new COAttainment());
                                                                       }
                                                                       $bundle->calculate_coattainments();
                                                                    //    print_r($bundle->get_courselist()); exit();//

                                                                                                // if($endpoint=="DASHBOARD"){
                                                                                                //     //get_COLevels_json
                                                                                                //     $json_array=$bundle->get_COLevels_json();
                                                                                                //     $result=json_encode($json_array);
                                                                                                //     header('Content-Type:application/json');
                                                                                                //     echo $result; exit();
                                                                                                // }

                                                                                                if($endpoint=="COATTAINMENT"){
                                                                                                    $json_array=$bundle->get_COAttainments_json();
                                                                                                    $result=json_encode($json_array);
                                                                                                    header('Content-Type:application/json');
                                                                                                    echo $result; exit();
                                                                                                }
                                                                                                else if($endpoint=="COURSECOPDF"){
                                                                                                   if($bundle->assign_po_description($branch)){ 
                                                                                                    $json_array=array();
                                                                                                    $json_array['regulation']=$regulation;
                                                                                                    $json_array['academicYear']=$academicYear;
                                                                                                    $json_array['branch']=$branch;
                                                                                                    $json_array['semesterno']=$semesterNo;
                                                                                                    // $json_array['CIEw']=$bundle->get_cie_weightage();
                                                                                                    // $json_array['SEEw']=$bundle->get_see_weightage();
                                                                                                    // $json_array['targetattainment']=$bundle->get_target_attainment();
                                                                                                    // $json_array['codirectw']=$bundle->get_directCO_weightage();
                                                                                                    // $json_array['coindirectw']=$bundle->get_indirectCO_weightage();
                                                                                                    $json_array['pooutcomes']=$bundle->get_podescription();
                                                                                                    $json_array['courselist']=$bundle->get_COAttainments_json();
                                                                                                    $result=json_encode($json_array);
                                                                                                    header('Content-Type:application/json');
                                                                                                    echo $result; exit();    
                                                                                                   
                                                                                                  }
                                                                                                  else{
                                                                                                    $result=json_encode(array('error'=>'PO description not entered , Contact Admin'));
                                                                                                    header('Content-Type:application/json');
                                                                                                    echo $result; exit();
                                                                                                  }

                                                                                                }


                                                                       if($endpoint=="INDIRECTPOATTAINMENT" or $endpoint=="OVERALLPOATTAINMENT" or $endpoint=="DIRECTPOATTAINMENT" or $endpoint=="DASHBOARD"){
                                                                                foreach($bundle->get_courselist() as $k => $course){
                                                                                    $course->set_poattainment(new POAttainment());
                                                                                }
                                                                                $bundle->calculate_PO();
                                                                            if($endpoint=="DIRECTPOATTAINMENT" ){
                                                                                $json_array=$bundle->get_directpo_json();
                                                                                $result=json_encode($json_array);
                                                                                header('Content-Type:application/json');
                                                                                echo $result; exit();
                                                                            } 
                                                                            
                                                                            if($endpoint=="DASHBOARD"){
                                                                                if($bundle->retrive_indirectPO($regulation,$academicYear,$branch)){
                                                                                    if(isset($_GET['directw']) and !empty($_GET['directw'])){
                                                                                        if(isset($_GET['indirectw']) and !empty($_GET['indirectw'])){
                                                                                            if(isset($_GET['target']) and !empty($_GET['target'])){
                                                                                                $bundle->set_podirect_weightage($_GET['directw']);
                                                                                                $bundle->set_poindirect_weightage($_GET['indirectw']);
                                                                                                $bundle->set_potarget_attainment($_GET['target']);

                                                                                                $bundle->calculate_overallPOs();
                                                                                                // $json_array=$bundle->get_COLevels_json();
                                                                                                $json_array=$bundle->get_overallPO_Dashboard_json();
                                                                                                $result=json_encode($json_array);
                                                                                                header('Content-Type:application/json');
                                                                                                echo $result; exit();

                                                                                            }
                                                                                            else{
                                                                                                    $json_array=$bundle->get_COLevels_json("PO Target Empty, Contact Developer");
                                                                                                    $result=json_encode($json_array);
                                                                                                    header('Content-Type:application/json');
                                                                                                    echo $result; exit();
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                                    $json_array=$bundle->get_COLevels_json("PO indirect Weightage Empty, Contact Developer");
                                                                                                    $result=json_encode($json_array);
                                                                                                    header('Content-Type:application/json');
                                                                                                    echo $result; exit();
                                                                                        }
                                                                                    }
                                                                                    else{
                                                                                                $json_array=$bundle->get_COLevels_json("PO direct Weightage Empty, Contact Developer");
                                                                                                $result=json_encode($json_array);
                                                                                                header('Content-Type:application/json');
                                                                                                echo $result; exit();
                                                                                    }
                                                                                }
                                                                                else{
                                                                                                $json_array=$bundle->get_COLevels_json("PO Indirect Assessment Not Entred, Contact Developer");
                                                                                                $result=json_encode($json_array);
                                                                                                header('Content-Type:application/json');
                                                                                                echo $result; exit();
                                                                                }
                                                                            }

                                                                        if($bundle->retrive_indirectPO($regulation,$academicYear,$branch)){

                                                                                if($endpoint=="INDIRECTPOATTAINMENT"){
                                                                                        $json_array=$bundle->get_indirectpo_json();
                                                                                        $result=json_encode($json_array);
                                                                                        header('Content-Type:application/json');
                                                                                        echo $result; exit();
                                                                                }
                                                                               
                                                                                
                                                                                if($endpoint=="OVERALLPOATTAINMENT"){
                                                                                    if(isset($_GET['directw']) and !empty($_GET['directw'])){
                                                                                        if(isset($_GET['indirectw']) and !empty($_GET['indirectw'])){
                                                                                            if(isset($_GET['target']) and !empty($_GET['target'])){
                                                                                                $bundle->set_podirect_weightage($_GET['directw']);
                                                                                                $bundle->set_poindirect_weightage($_GET['indirectw']);
                                                                                                $bundle->set_potarget_attainment($_GET['target']);
                                                                                                
                                                                                                // foreach($bundle->get_courselist() as $k => $course){
                                                                                                //     $course->set_poattainment(new POAttainment());
                                                                                                // }
                                                                                               
                                                                                                // $bundle->calculate_PO();
                                                                                                
                                                                                                //
                                                                                                // if($endpoint=="DIRECTPOATTAINMENT" ){
                                                                                                //     $json_array=$bundle->get_directpo_json();
                                                                                                //     $result=json_encode($json_array);
                                                                                                //     header('Content-Type:application/json');
                                                                                                //     echo $result; exit();
                                                                                                // }else
                                                                                                 if($endpoint=="OVERALLPOATTAINMENT"){
                                                                                                    $bundle->calculate_overallPOs();
                                                                                                    $json_array=$bundle->get_overallPO_json();
                                                                                                    $result=json_encode($json_array);
                                                                                                    header('Content-Type:application/json');
                                                                                                    echo $result; exit();    

                                                                                                }

                                                                                                
                                                                                            }
                                                                                            else{
                                                                                                $result=json_encode(array('error'=>'PO target Attainment empty'));
                                                                                                header('Content-Type:application/json');
                                                                                                echo $result; exit();
                                                                                            }
                                                                                        }
                                                                                        else{
                                                                                            $result=json_encode(array('error'=>'PO indirect weightage empty'));
                                                                                            header('Content-Type:application/json');
                                                                                            echo $result; exit();
                                                                                        }
                                                                                    }
                                                                                    else{
                                                                                        $result=json_encode(array('error'=>'PO direct weightage empty'));
                                                                                        header('Content-Type:application/json');
                                                                                        echo $result; exit();
                                                                                    }
                                                                                }
                                                                            



                                                                            }else{
                                                                                $result=json_encode(array('error'=>'POindirect Data Not Entered, Check status or Contact Admin'));
                                                                                header('Content-Type:application/json');
                                                                                echo $result;  exit();
                                                                            }
                                                                       }
                                                            }
                                                            else{
                                                                $result=json_encode(array('error'=>'level-3 weightage range empty'));
                                                                header('Content-Type:application/json');
                                                                echo $result; exit();
                                                            }
                                                        }
                                                        else{
                                                                $result=json_encode(array('error'=>'level-2 weightage range empty'));
                                                                header('Content-Type:application/json');
                                                                echo $result;  exit();  
                                                        }
                                                    }
                                                    else{
                                                        $result=json_encode(array('error'=>'level-1 weightage range empty'));
                                                        header('Content-Type:application/json');
                                                        echo $result; exit();
                                                    }
                                                }
                                                else{
                                                    $result=json_encode(array('error'=>'indirect weightage empty'));
                                                    header('Content-Type:application/json');
                                                    echo $result; exit();
                                                }
                                            }
                                            else{
                                                $result=json_encode(array('error'=>'direct weightage empty'));
                                                header('Content-Type:application/json');
                                                echo $result; exit();
                                            }
                                        }
                                        else{
                                            $result=json_encode(array('error'=>'CO target Attainment empty'));
                                            header('Content-Type:application/json');
                                            echo $result; exit();
                                        }
                                    }
                                    else{
                                        $result=json_encode(array('error'=>'see weightage empty'));
                                        header('Content-Type:application/json');
                                        echo $result; exit();

                                    }
                                }
                                else{
                                    $result=json_encode(array('error'=>'cat weightage empty'));
                                    header('Content-Type:application/json');
                                    echo $result; exit();
                                }
                             }
                             else{
                                $result=json_encode(array('error'=>'Data incomplete, Check status'));
                                header('Content-Type:application/json');
                                echo $result;  exit();
                             }
                        }   
                        else{
                            $result=json_encode(array('error'=>'Data Not Yet Started Filling!'));
                            header('Content-Type:application/json');
                            echo $result; exit();
                        }     
                    }
                    else{
                        $result=json_encode(array('error'=>'semester error'));
                        header('Content-Type:application/json');
                        echo $result;  exit();
                    }
                }
                else{
                    $result=json_encode(array('error'=>'endpoint error'));
                    header('Content-Type:application/json');
                    echo $result; exit();
                }
            }
            else{
                $result=json_encode(array('error'=>'branch error'));
                header('Content-Type:application/json');
                echo $result; exit();
            }
        }
        else{
            $result=json_encode(array('error'=>'academicYear error'));
            header('Content-Type:application/json');
            echo $result; exit();
        }
    }
    else{
        $result=json_encode(array('error'=>'regulation error'));
        header('Content-Type:application/json');
        echo $result; exit();
    }
}
else{
    $result=json_encode(array('error'=>'contact admin error'));
        header('Content-Type:application/json');
        echo $result; exit();
}




// $c1=new CourseDetails(7);
    // $c1=new CourseDetails(8);
// print_r($c1);

?>
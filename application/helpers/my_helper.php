<?php

require_once APPPATH.'third_party/vendor/autoload.php';
require 'vendor/autoload.php';
use \Firebase\JWT\JWT;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


function _checkAuth() {
	$header = getallheaders();
	
	if(!empty($header) && array_key_exists("token", $header)){    
	    $key = "hp1234";
	    $token = $header['token'];
        
        if ($token == "") {
        	$data['status'] = false;
	        $data['msg'] = "Token is required.";
	        $data['result'] =  array();
        }else{
            try{
			  $decoded = (array) JWT::decode($token, $key, array('HS256'));
		      $data['status'] = true;
		      $data['msg'] = "Jwt verified.";
		      $data['result'] =  $decoded; 	
			}catch(\Exception $e){
				$message = $e->getMessage();
			    $data['status'] = false;
		        $data['msg'] = $message;
		        $data['result'] =  array();
			}
        }	
	}else{
		    $data['status'] = false;
	        $data['msg'] = "Auth Failed";
	        $data['result'] =  array();
	}
    
    
    return $data; 
}

function unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
} 

function _isAdminLoggedIn($thisObj){
	if(!$thisObj->session->userdata('admin')){
		return redirect(site_url());
	}
}


function _genExcel($header_row, $data, $data_key_array, $gen_file_name){
	$letterArr = array();

	for($i ='A'; $i <= 'Z'; $i++){		
			$letterArr[sizeof($letterArr)] = $i;
	}

	$objPHPExcel = new Spreadsheet();
			$Excel_writer = new Xlsx($objPHPExcel);  /*----- Excel (Xls) Object*/

			$objPHPExcel->getActiveSheet()->getStyle('A1:Az1')->getFont()->setBold(true);
			$objPHPExcel->getActiveSheet()->getStyle('A1:Az1')->getFont()->setSize(11);

			for($i=0; $i<sizeof($header_row); $i++){
				$objPHPExcel->getActiveSheet()->setCellValue($letterArr[$i].'1',$header_row[$i]); 
			}	

			for ($i=0; $i <sizeof($data); $i++){     
	            for($j=0; $j<sizeof($data_key_array); $j++){
	                if($data[$i][$data_key_array[$j]]){
	                    $objPHPExcel->getActiveSheet()->setCellValue($letterArr[$j].($i+2),$data[$i][$data_key_array[$j]]); 
	                }
	            }           
     		}   		
		
			ob_end_clean();
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="'.$gen_file_name.'.xlsx"');
			header('Cache-Control: max-age=0');     		
			$Excel_writer->save('php://output');
}

function _lgnChk($thisObj,$session){
	if(!$thisObj->session->userdata($session)){
		return redirect(site_url("login"));
	}

	if($thisObj->session->userdata($session)['is_admin'] == 0) {
		_userAccessControl($thisObj);
	}
}


function _getUserAccess($thisObj){

	$userID = $thisObj->session->userdata('admin')['employee_id'];
	
	$res = $thisObj->misc->getAllAccessRoutsId($userID);
	
	$accessRoutsArry = $res;
	$data = array();

	for($i=0; $i <sizeof($accessRoutsArry) ; $i++){ 
	    array_push($data,$accessRoutsArry[$i]['module_id']);		
	}
	
	return $data;
}

function _userAccessControl($thisObj){

	$routsName = $thisObj->uri->segment(1);

	if ($routsName == 'dashboard') {
		return true;
	}

	if ($routsName == 'logout') {
		return true;
	}

	if ($routsName == 'access') {
		return true;
	}
	
	$userID = $thisObj->session->userdata('admin')['employee_id'];
	
	$res = $thisObj->misc->getAllAccessRouts($userID);
	
	$accessRoutsArry = $res;
	
	$isAccess = false;
	$data = array();
	for($i=0; $i <sizeof($accessRoutsArry) ; $i++){ 		
		if($accessRoutsArry[$i]['module_route'] == $routsName) {
			$isAccess = true;
		}
	}

	// _d($_SERVER['REQUEST_METHOD']);
	// _dx($isAccess);

	if ($_SERVER['REQUEST_METHOD'] == 'GET' && $isAccess == '') {
		redirect('access');
		die();
	}

	if ($_SERVER['REQUEST_METHOD'] == 'POST' && $isAccess == '') {
		$data['status'] = 'ERR';
		$data['msg'] 	= '! Opps you have unable to access';
		echo json_encode($data);
		die();
	}
	

}



function _userAccessControlLeftSide($thisObj,$routsName){	
	
	if ($routsName == 'dashboard') {
		return true;
	}

	$userID = $thisObj->session->userdata('admin')['employee_id'];
	
	$res = $thisObj->misc->getAllAccessRouts($userID);
    //_dx($res);
	$accessRoutsArry = $res;

	$isAccess = false;

	for($i=0; $i <sizeof($accessRoutsArry) ; $i++) { 		
		if($accessRoutsArry[$i]['module_route'] == $routsName) {
			$isAccess = true;
		}
	}	
	
	if(!$isAccess){

		return false;

	}else{

		return true;

	}
}


function _lgback($thisObj,$session){
	if($thisObj->session->userdata($session)){
		return redirect(site_url("dashboard"));
	}
}


function _showMsg($thisObj, $msg, $cls, $url){
	$thisObj->session->set_flashdata('class',$cls);
	$thisObj->session->set_flashdata('msg',$msg);
	return redirect(site_url($url));
}

function compressImage($source, $destination, $quality) {

		$info = getimagesize($source);

		if ($info['mime'] == 'image/jpeg') 
			$image = imagecreatefromjpeg($source);

		elseif ($info['mime'] == 'image/gif') 
			$image = imagecreatefromgif($source);

		elseif ($info['mime'] == 'image/png') 
			$image = imagecreatefrompng($source);

		imagejpeg($image, $destination, $quality);

		return $destination;
	}

function _uploadImg($img, $path, $name){
		 

		if($img['error']>0){
			$message['has_error'] 	= '1';
			$message['err']			= "NOT_ALLOWED_TYPE";
			$message['msg']			= "Only Images are allowed";			
			return $message;
		}

		$allowedType	 	= array('jpg','jpeg','png','JPG','JPEG','PNG');
		$maxAllowedSize		= 3145728;
		$message 			= array();

		$imgTmpName 		= $img['tmp_name'];
		$type 				= strtolower(explode('/', $img['type'])[1]);
		$size 				= $img['size'];
		$savePath 			= $path."\\".$name.".".$type;
		$movePath = $path;

		$path 				= './'.$movePath.'/'.$name.".".$type;
	    // $path 				= str_replace(" ", "", $path);

		$savePath 			= (explode('\\',$savePath)[1]);
		
		if(!in_array($type, $allowedType)){
			$message['has_error'] 	= '1';
			$message['err']			= "NOT_ALLOWED_TYPE";
			$message['msg']			= "Only Images are allowed";			
			return $message;
		}

		if($maxAllowedSize < $size){
			$message['has_error'] 	= '1';
			$message['err']			= "MAX_ALLOWED_SIZE_EXCEED";
			$message['msg']			= "Maximum allowed size is ".$maxAllowedSize." bytes.";			
			return $message;
			return "";
		}		

		// _d($imgTmpName);
		// _d($movePath);
		// _d($path);
		// _dx($savePath);
		//$isMoved = move_uploaded_file($imgTmpName, $path);
		
		$isMoved = compressImage($imgTmpName, $path, 70);

		
		if($isMoved){
			$message['has_error'] 	= '0';
			$message['err']			= "SUCCESS";
			$message['msg']			= "Image Successfully Uploaded";	
			$message['path']		= $savePath;
			return $message;
		}else{
			$message['has_error'] 	= '1';
			$message['err']			= "FAILED";
			$message['msg']			= "Some PHP Error Occured While Uploading the Image";			
			return $message;
		}

}
function _uploadMultipalImg($imgArray, $path,$limit){

		 $images =	$imgArray;	



		 // _dx($imgArray)		 ;

		 $message = [];		 



		for ($i=0; $i < sizeof($imgArray['name']); $i++) {

			



		 	$success = [];

			$isError = [];	





			if ($i > $limit-1){	

				$isError['has_error'] 	= '2';

				$isError['err']			= "ONLY_". $limit."_ALLOWED";

				$isError['msg']			= "Only". $limit." Images are allowed";

				array_push($message,$isError);					

			 	break;

			} 



			if($imgArray['error'][$i]>0){

				$isError['has_error'] 	= '1';

				$isError['err']			= "NOT_ALLOWED_TYPE";

				$isError['msg']			= "Only Images are allowed";			

				$isError['imgname']		= $imgArray['name'][$i];			

				array_push($message,$isError);

				continue;

			}



			$allowedType	 	= array('jpg','jpeg','png','JPG','JPEG','PNG');

			$maxAllowedSize		= 3145728;			



			$imgTmpName 		= $imgArray['tmp_name'][$i];

			$type 				= strtolower(explode('/', $imgArray['type'][$i])[1]);

			$size 				= $imgArray['size'][$i];


			$savePath 			= $path."\\".$imgArray['name'][$i].".".$type;
			$movePath 			= './assets/uploaded/courses_img/';
			$path 				= $movePath.$imgArray['name'][$i].".".$type;
		    $path 				= str_replace(" ", "", $path);

			$path				=	'.'.(explode('.',$path)[1]).'.jpg';

			$savePath 			= (explode('\\',$savePath)[1]);
			$savePath 			= (explode('.',$savePath)[0]).'.jpg';


			if(!in_array($type, $allowedType)){

				$isError['has_error'] 	= '1';

				$isError['err']			= "NOT_ALLOWED_TYPE";

				$isError['msg']			= "Only Images are allowed";

				$isError['imgname']		= $imgArray['name'][$i];			

				array_push($message,$isError);

				continue;

			}



			if($maxAllowedSize < $size){

				$isError['has_error'] 	= '1';

				$isError['err']			= "MAX_ALLOWED_SIZE_EXCEED";

				$isError['msg']			= "Maximum allowed size is ".$maxAllowedSize." bytes.";	

				array_push($message,$isError);

				continue;				

			}		



			//$isMoved = move_uploaded_file($imgTmpName, $path);
			
			$isMoved = compressImage($imgTmpName, $path, 70);

			if($isMoved){

				$success['has_error'] 	= '0';

				$success['err']			= "SUCCESS";

				$success['msg']			= "Image Successfully Uploaded";	

				$success['path']		= (explode('.',$savePath)[0]).'.jpg';

				$success['imgname']		= strtoupper(explode('.', $imgArray['name'][$i])[0]).'.jpg';				

				continue;

			}else{

				$isError['has_error'] 	= '1';

				$isError['err']			= "FAILED";

				$isError['msg']			= "Some PHP Error Occured While Uploading the Image";	

				$isError['imgname']		= $imgArray['name'][$i];			

				array_push($message,$isError);

				continue;

			}





		}



		return $message;



}

function _d($data){
	echo "<pre>",print_r($data);
}

function _dx($data){	
	echo "<pre>",print_r($data);
	die();
}

function _timetableArrayQuery($weekdayId, $scheduleId, $timetableData){	
	$teacherArr = array();
	$subjectArr  =array();
	$teacher = '';
	foreach ($timetableData as $row) {
		if($row['weekday_id'] == $weekdayId && $row['schedule_id']==$scheduleId){
			array_push($teacherArr, $row['employee_fname']." ".$row['employee_mname']." ".$row['employee_lname']);
			array_push($subjectArr, $row['subject_name']);
		}
	}

	foreach ($teacherArr as $ind => $name) {
		$teacher.=$name."<br>";
	}
	
			if(!empty($subjectArr)){
				return $teacher."<br>".$subjectArr[0];
			}else{
				return '';
			}

}

function _teacherTimetableArrayQuery($weekdayId, $scheduleId, $timetableData){
	foreach ($timetableData as $row) {
		if($row['weekday_id'] == $weekdayId && $row['schedule_id']==$scheduleId){
			return $row['course_name']."-".$row['batch_name']."<br>".$row['subject_name'];
		}
	}	
}

function _showSelection($allData, $selectedDataVal, $allDataKey, $allDataShow){
 		foreach ($allData as $data) {
 			if($allData[$allDataKey] == $selectedDataVal){
 				echo "<option value='".$allData[$allDataKey]."' selected>".$allData[$allDataShow]."</option>";
 			}else{
 				echo "<option value='".$allData[$allDataKey]."' >".$allData[$allDataShow]."</option>";
 			}
 		}
}

function _getSeperateArray($extSep, $intSep, $string){
	$dataToReturn = array();
	$extArray = explode($extSep, $string);
	for ($i=0; $i < sizeof($extArray); $i++) { 
		$data = explode($intSep, $extArray[$i]);
		$dataToReturn[$data[0]] = $data[1];		
	}
	return $dataToReturn;
}


function _getCourseBatchByUsercode($thisObj, $userName, $insDetails){	
	$schoolCode 	= $insDetails['institute_code'];
	$courseBatch 	= substr($userName, strlen($schoolCode));		
	$batchName  	= substr($courseBatch, strlen($courseBatch)-1);
	//_dx($batchName);
	$courseName 	= substr($courseBatch, 0,strlen($courseBatch)-1);

	$courseDetails	= $thisObj->course->getCourseByCourseName($courseName, $insDetails['institute_id']);	
	$courseId 		= empty($courseDetails[0]) ? '0' : $courseDetails[0]['course_id'];
	$batchDetails	= $thisObj->batch->getBatchByCourseName($courseId, $batchName, $insDetails['institute_id']);	
	$batchId 		= empty($batchDetails[0]) ? '0' : $batchDetails[0]['batch_id'];


	$dataToReturn = array(
							'schoole_code' 	=> $schoolCode,							
							'course_id'		=> $courseId,
							'course_code'	=> strtoupper($courseName),							
							'batch_id'		=> $batchId,
							'batch_name'	=> strtoupper($batchName),
						);
	return $dataToReturn;
}

function _del($thisObj, $tblName, $foreignKey, $foreignKeyVal, $redirect = false){
	$data = array(
		'key'	=>	$foreignKey,
		'val'	=>	$foreignKeyVal,
		'table'	=>	$tblName		
		);	
	
	$res = $thisObj->misc->del($data);
	if($redirect){
		if($res){
			_showMsg($thisObj, 'Successfully Deleted', 'top-center-margin scs', $redirect);
		}else{
			_showMsg($thisObj, 'Opps! something went wrong try again', 'top-center-margin err', $redirect);
		}	
	}else{
		if($res){
			return $res = 'true';
		}else{
			return $res = 'fasle';
		}	
	}


	
}


function _calc($thisObj, $number, $maxMarks, $subjectType, $instid){
	if($subjectType == 'M' || !is_numeric($number)){
		return $number;
	}	


	if($maxMarks == 0){
		return '';
	}
		$allData = $thisObj->grade->getAllGradeConfig($subjectType, $instid);
		$per = ($number*100)/$maxMarks;
		$grade = '';
		
		foreach($allData as $data){
			//echo $data['min_marks']." ".$data['max_marks']." ".$data['grade_name']."<br>";
			if($data['min_marks'] <= $per && $data['max_marks'] >= $per){
				$grade =  $data['grade_name'];
				break;
			}
		}		
		return $grade;
		
	}

	function isSerialized($str) {
    	$res =  ($str == serialize(false) || @unserialize($str) !== false);    	
    	return $res;

	}

	function _selectedPayheds($all, $selected){
		$allPayheadsSep = explode(",", $all);
		$payheads = array();
		$selectedArray =  isSerialized($selected) ? unserialize($selected) : array() ;				
		$stringToReturn = "";
		
		foreach ($allPayheadsSep as $key => $value) {
			$tmp = explode(":", $value);
			array_push($payheads, $tmp);
		}		

		foreach ($payheads as $key => $value) {		
		
			if(in_array($value[0], $selectedArray)){
				$stringToReturn .= "<input type='checkbox' name='payhead' class='payhead-chk' value='".$value[0]."' checked='checked'>".$value[1]."<br>";
			}else{
				$stringToReturn .= "<input type='checkbox' name='payhead' class='payhead-chk' value='".$value[0]."' >".$value[1]."<br>";
			}
		}

		return $stringToReturn;

	}

	function _seperatePosNegHeads($heads){
		$posHeads = array();
		$negHeads = array();
		foreach ($heads as $value) {
			if($value['pay_head_sign'] == 'POSITIVE'){
				array_push($posHeads, $value);
			}else{
				array_push($negHeads, $value);
			}
		}

		return array(
				'posHeads'=>$posHeads,
				'negHeads'=>$negHeads
			);
	}

	function _calcSal($thisObj, $payhead, $baseSalary){		
			if(empty($payhead)){
				return "";
			}
			if($payhead['pay_head_type'] == 'ABSOLUTE'){
				return $payhead['pay_head_amount'];
			}elseif($payhead['pay_head_type'] == 'PERCENT'){
				if($payhead['percent_of'] == 'BASESALARY'){
					return ($baseSalary*$payhead['pay_head_amount'])/100;
				}else{
					$res = $thisObj->payroll->getPayheadById($payhead['percent_of']);
					return ($res['pay_head_amount']*$payhead['pay_head_amount'])/100;
				}
			}
			
	}



function _convert_number_to_words($num){  
	$number = $num;
	$sign = '';
	if($num < 0){
		$sign = 'Minus ';
		$number = -1*($num);
	}

	$no = floor($number);
   $point = round($number-$no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);

  $points = ($point) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10] : '';
  
  if($points){
  	$res =  $result . "Rupees  " . $points . " Paise";
  }else{
  	$res =  $result . "Rupees  ";
  }
  return $sign.$res;

}
	
function _mapSujectExamMarks($subjectName, $examName, $data){	
	
	$marksToReturn = 0;
	foreach ($data as  $value) {
		if($value['subject_name'] == $subjectName && $value['exam_name'] == $examName){
			if($value['is_abs']==1){
				$marksToReturn = 'ab';
			}elseif($value['is_gen_abs']==1){
				$marksToReturn = 'ab';
			}else{
				$marksToReturn = $value['obtain_marks'];
			}
			
			break;
		}	
	}
	
	return $marksToReturn;
}

function _mapExamAttendance($egid ,$examData ){	
		foreach ($examData as $exam) {				
			if($exam['exam_group_id'] == $egid ){				
				return $exam['attendance'];
			}
		}
}

function _mapExamAttendanceBulk($egid ,$student,$examData ){		
		foreach ($examData as $exam) {				
			if($exam['exam_group_id'] == $egid && $exam['student_id'] == $student){				
				return $exam['attendance'];
			}
		}
}

function _groupByKey($data, $key){	
	
	$groupedKey = array();
	$groupedArray = array();
	$grpKeyCount = 0;

	foreach ($data as $val) {
		if(!in_array($val[$key], $groupedKey)){
			$groupedKey[$grpKeyCount++] = $val[$key];
		}
	}
	
	for ($i=0; $i < $grpKeyCount; $i++) { 
		$groupedArray[$groupedKey[$i]] = array();
	}

	foreach ($data as $val) {
		array_push($groupedArray[$val[$key]], $val);
	}
	
	return $groupedArray;	

}


function _isExist($data, $key, $val){
	foreach ($data as $d) {
		if($d[$key] == $val){
			return true;
			break;
		}
	}
	return false;	
}

function _formatDate($dateToFormat, $format){
	if($dateToFormat == ''){
		return '';
	}
      $date  = date_create($dateToFormat);
      return date_format($date, $format);
            
}




function _dfetch($mdl,$tbl){
	return $this->$mdl->get('$tbl')->result_array();
}

function _mapRemark($remarks, $stdId){
	$remarkToReturn  = array(
							'student_remark_midterm'=>'',
							'student_remark_annual'=>''
							);
	foreach ($remarks as $remark) {
			if($remark['student_id']==$stdId){
				$remarkToReturn = $remark;
				break;
			}		
	}
return $remarkToReturn;
}


function _getSubModules($moduleId, $submodules){
	$dataToReturn = array();
}


function _mapSerializedData($allData, $key1, $val1, $key2, $val2, $keyToReturn){

	foreach ($allData as $data){
		if($data[$key1] == $val1 && $data[$key2] == $val2){
			if(isSerialized($data[$keyToReturn])){
				return unserialize($data[$keyToReturn]);
			}
		}
	}
}

function _isExistinDB($data,$table,$thisObj){
	$numrows = $thisObj->misc->checkIsExist($data, $table);
	if($numrows > 0){
		return $res = 'true';
	}
	return $res = 'false';
}

function _searchInArray($data, $key, $val, $returnKey){
	foreach ($data as $d) {
		if($d[$key] == $val){
			return $d[$returnKey];
			break;			
		}
	}
}

function _mapData($allData, $key, $value, $returnKey){
	$returnVal = '';
	foreach ($allData as $data) {
		if($data[$key] == $value){
			return $data[$returnKey];
		}	
	}
	return $returnVal;
}



function _mapExamId($data, $mathcData){
	
	foreach ($data as $d) {
		if($d['subject_name'] == $mathcData['subject_name'] && $d['exam_name']==$mathcData['exam_name']){		
			return $d['exam_id'];
		}
	}
}


function _uploadFile($file, $path, $name){	
	
	$message 			= array();

	$fileTmpName 		= $file['tmp_name'];
	$explodedArr 		= explode('.', $file['name']);
	$type 				= strtolower($explodedArr[sizeof($explodedArr)-1]);
	$size 				= $file['size'];
	$maxAllowedSize		= 5145728;
	$savePath 			= $path."/".$name.time().".".$type;
	$movePath 			= realpath(APPPATH."..\\")."/".$savePath;
	if($maxAllowedSize < $size){
		$message['has_error'] 	= '1';
		$message['err']			= "MAX_ALLOWED_SIZE_EXCEED";
		$message['path']		= "";
		$message['msg']			= "Maximum allowed size is ".$maxAllowedSize." bytes.";			
		return $message;
	}	
	$isMoved = move_uploaded_file($fileTmpName, $movePath);
	if($isMoved){
		$message['has_error'] 	= '0';
		$message['err']			= "SUCCESS";
		$message['msg']			= "Successfully Uploaded";	
		$message['path']		= $savePath;
		return $message;
	}else{
		$message['has_error'] 	= '1';
		$message['err']			= "FAILED";
		$message['msg']			= "Some PHP Error Occured While Uploading";			
		return $message;
	}

}


function _getTime($date){
		$strtotime 					= 	strtotime($date);
		$dateAssign 				=  	date('y-m-d h:i:s', $strtotime);
		return $dateAssign;
}

function _getMonthDate($date){
	$myDateTime         =   DateTime::createFromFormat('Y-m-d h:i:s', $date);
	
    $leaveDate          =   $myDateTime->format('d M Y');
    return $leaveDate;
}


function _randStr($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


function _mapDataMultiKey($allData, $keys, $values, $keyToReturn){

	foreach ($allData as $data) {
		$currentData = true;
		$i = 0;

		foreach($keys as $key){
		//_d($data)			;
			if($data[$key] != $values[$i++]){
				$currentData = false;
				break;
			}
		}

		if($currentData){
			return $data[$keyToReturn];
			break;
		}
	}
}

function _uploadImgAWS($img, $path, $name,$thisObj){

		$allowedType	 	= array('jpg','jpeg','png');
		$maxAllowedSize		= 3145728;
		$message 			= array();

		$imgTmpName 		= $img['tmp_name'];
		$type 				= strtolower(explode('/', $img['type'])[1]);
		$size 				= $img['size'];
		$content 			= $img['type'];
		$savePath 			= $path."\\".$name.".".$type;
		$movePath 			= realpath(APPPATH."..\\")."\\".$savePath;
		
		if(!in_array($type, $allowedType)){
			$message['has_error'] 	= '1';
			$message['err']			= "NOT_ALLOWED_TYPE";
			$message['msg']			= "Only Images are allowed";			
			return $message;
		}

		if($maxAllowedSize < $size){
			$message['has_error'] 	= '1';
			$message['err']			= "MAX_ALLOWED_SIZE_EXCEED";
			$message['msg']			= "Maximum allowed size is ".$maxAllowedSize." bytes.";			
			return $message;
			return "";
		}		

		$buket_name 	= 'czsimages1';
		$object_name 	= $name.'.jpg';		
		$isExist 		= $thisObj->aws3->isOjectExist($buket_name,$object_name);
		$deleteImage 	=	array();
		if ($isExist['status']) {
			$object 		=	array($object_name);
			$deleteImage 	=	$thisObj->aws3->delete($buket_name,$object);
			if (empty($deleteImage)) {
				$message['has_error'] 	= '1';
				$message['err']			= "FAILED";
				$message['msg']			= "Some PHP Error Occured While Uploading the Image";			
				return $message;
			}
		}

		$isMoved 	=	$thisObj->aws3->sendFile($buket_name,$imgTmpName,$object_name,$content);
		if($isMoved){
			$message['has_error'] 	= '0';
			$message['err']			= "SUCCESS";
			$message['msg']			= "Image Successfully Uploaded";	
			$message['path']		= $isMoved;
			return $message;
		}else{
			$message['has_error'] 	= '1';
			$message['err']			= "FAILED";
			$message['msg']			= "Some PHP Error Occured While Uploading the Image";			
			return $message;
		}

}

function _generateOTP($thisObj){
	if(!$thisObj->session->userdata('otp')){
		$otp = rand(111111, 999999);
		$thisObj->session->set_userdata('otp', $otp);

	}

	return $thisObj->session->userdata('otp');
}

function _emailValid($email){
	$returnVal 	=	false;
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$returnVal  = true;
	}

   return $returnVal;
}

function _makeKey($dataArr, $keyName, $valKey){	
	$dataToReturn = array();

	foreach ($dataArr as $data) {
		foreach ($data as $key => $value) {
			if($key == $keyName){
				$dataToReturn[$value] = $data[$valKey];
			}
	}
	}

	return $dataToReturn;
}



function _langaugeSerialize($dataArr,$thisObj){

	 $data = unserialize($dataArr);
	 $res = $thisObj->misc->getAllLangauge($data);
	 return $res;
}

function _getDiscount($mrp,$sp){
	$mrp   = intval($mrp);
	$sp    = intval($sp);
	if ($mrp <= 0) {
		$discount  =  '';
	}else{
		$discount 		=	round((($mrp-$sp)*100)/$mrp);
	}
	return $discount;
}


function _uploadExcel($file, $path){
		$path = $path."/".$file['name'];		
		move_uploaded_file($file['tmp_name'], $path);
		return $path;
}


//function defination to convert array to xml
function array_to_xml($array, &$xml_user_info) {
    foreach($array as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_user_info->addChild("$key");
                array_to_xml($value, $subnode);
            }else{
                $subnode = $xml_user_info->addChild("item");
                array_to_xml($value, $subnode);
            }
        }else {
            $xml_user_info->addChild("$key",htmlspecialchars("$value"));
        }
    }
}




// AWS upoload image



function getAwsCred(){
	$cred = new Aws\Credentials\Credentials(' AKIAVNHFJMTBQDIVIJM5', '2B5fVzFt6DovmZ3sBhGDL+GcapvrMzrCgNvTeLuU');
	$credentials = [
		'version'     => '2006-03-01',
		'region'      => 'ap-south-1',
		'credentials' => $cred
	];
	return $credentials;
 }
if(!function_exists('uploadS3Image')) {
    // abhifolder1
    function uploadS3Image($tar_file='',$imagename="",$s3_name='codiotic-uat-01-public') {
        if($tar_file!=''){
            // $seg = explode("/", $tar_file);
            $bucket = $s3_name;
            // $file_name = basename($tar_file);
        //   _dx($imagename);
            // $file_path = $seg[1]."/".$file_name;
            $file_path = $tar_file;
          
             $content_type = mime_content_typealways($imagename);
            //  _dx($content_type);
            if(is_array($content_type)){
                $content_type = $content_type[0];
            }
            $file_resource = fopen($file_path, 'r');
            $key =$imagename;
            try{
               
              
                $credentials = getAwsCred();
                $s3Client = new Aws\S3\S3Client($credentials);
                $params = [
                    'Bucket'        => $bucket,
                    'Key'           => $key,
                    'Body'          => $file_resource,
                    'ContentType'   => $content_type,
                    'CacheControl'  => 'max-age=3600',
                    'ACL'        => 'public-read',  
                ];
                $result = $s3Client->putObject($params);
                //   _dx($result);
                fclose($file_resource);
                unlink($file_path);
               
                 return $result['@metadata']['effectiveUri'];
                 
            } catch (Exception $e) {
                return $e->getMessage() . "\n";
            }          
        } else {
            return 0;
        }
    }
}
if(!function_exists('mime_content_typealways')) {
    function mime_content_typealways($filename) {

        $mime_types = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',
            'csv' => array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain'),
            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc'   =>  array('application/msword', 'application/vnd.ms-office','text/plain'),
            'docx'  =>  array('application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/msword', 'application/x-zip','text/plain'),
            'rtf' => 'application/rtf',
            'xls' => array('application/vnd.ms-excel', 'application/msexcel', 'application/x-msexcel', 'application/x-ms-excel', 'application/x-excel', 'application/x-dos_ms_excel', 'application/xls', 'application/x-xls', 'application/excel', 'application/download', 'application/vnd.ms-office', 'application/msword'),
            'xlsx' => array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'),
            'ppt' => 'application/vnd.ms-powerpoint',
            'xlsb'=>'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
            'xlsm'=>'application/vnd.ms-excel.sheet.macroEnabled.12',
            'xlam'=>'application/vnd.ms-excel.addin.macroEnabled.12',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
        $exploded = explode('.', $filename);
        
        $array_pop = array_pop($exploded);
        $ext = strtolower($array_pop);
        if (array_key_exists($ext, $mime_types)) {
            return $mime_types[$ext];
        } elseif (function_exists('finfo_open')) {
            $finfo = finfo_open(FILEINFO_MIME);
            $mimetype = finfo_file($finfo, $filename);
            finfo_close($finfo);
            return $mimetype;
        } else {
            return 'application/octet-stream';
        }
    }
}
//function end



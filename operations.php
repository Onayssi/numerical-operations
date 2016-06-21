<?php
/*
File Name: operations.php
Description: PHP Script concerning the subject requested [using cli]
*/

// check if script is runnin from the command line or from a web browser
// prompt message describing the issue
ini_set('register_argc_argv', 0);  
if (!isset($argc) || is_null($argc)){ 
    print "
	<p align=\"center\">
	<h3 align=\"center\">Not in CLI Mode!</h3>
	<h4 align=\"center\">Script must running from Command Line Interface...</h4>
	<h5 align=\"center\">e.g: php [PHP_FILE_NAME].php --file=[TXT_FILE_NAME].txt</h5>
	</p>";
	exit();
}

// get the script name (first argument)
$phpscript_name = @$argv[0];

// get the second argument i.e. the text file name
$filename_cmd = @$argv[1];

// check the argument 1 (text input file must be provided)
if(!$filename_cmd){
 print "\tMissing Argument 1! <FILE_NAME>.txt\n\tCommand format:\t--file=<FILE_NAME>.txt";
 exit(0);	
}

// command line concerning the provided text input file must be respecting the syntax below: --file=<FILE_NAME>.txt
// Error Example: --file
if(!preg_match("/\=/i",$filename_cmd)){
 print "* Syntax Error!\n* Argument 1 must respect the format of command below:\n\t--file=<FILE_NAME>.txt";
 exit(0);	
}

// check if the command line respects the syntax --file=<FILE_NAME>.txt including the "=" operande which be the main issue for the extraction of command
// Error Example: any other command excepting the "--file" word
$filename_cmd_path = explode("=",$filename_cmd);
$cmd_cli = $filename_cmd_path[0];
if($cmd_cli!="--file"){
 print "* Syntax Error!\n* Missing file command word!\n* The format of command must be like the below:\n\t--file=<FILE_NAME>.txt";
 exit(0);	
}

// check if the text input file is provided (not empty syntax)
// Error Example: --file=
$filename = $filename_cmd_path[1];
if(empty($filename)){
 print "* Missing Text File Name!\n* The format of command must be like the below:\n\t--file=<FILE_NAME>.txt";
 exit(0);	
}

// check the syntax of the input file
// must include the "." character at the end
// Error Example: --file=<FILE_NAME>
$file_name_ext = explode(".",$filename);
if(count($file_name_ext)!=2 || empty($file_name_ext[0])){
 print "* Syntax Error!\n* Extension file entered without the name!\n* The format of command must be like the below:\n\t--file=<FILE_NAME>.txt";
 exit(0);	
}

// check the type (extension) of the input file
// must be a text file
// Error Example: --file=<FILE_NAME>.pdf
$file_ext = @end($file_name_ext);
if($file_ext!="txt"){
 print "* Invalid File Format!\n* Please, Provide a Text File!\n* The format of command must be like the below:\n\t--file=<FILE_NAME>.txt";
 exit(0);	
}

// check if the input file provided exists in the destination folder i.e. data folder
// Error Example: --file=<FILE_NAME>.txt with FILE_NAME is not exist in the data directory
// this condition or rule is enough for testing the availability of the file, without using the previous one.
if(!file_exists("data/$filename")){
  print "* Invalid Source File!\n* File name provided is not exist!\n* Please, Provide an existing Text File in the \"data\" directory.";
 exit(0);	
}
// just for buffer reading as screen view
print "Reading \"$filename\" File...";
// sleep for 1 second to provide a handling code line by line
sleep(1);
// any way, we commented this line to reserve time when reading from the text file
$i = 0;
$fp = fopen("data/".$filename, "r") or die("Unable to open file!");
// implement the pdo connection to save data into database "globecomm"
require("query.php");
// start reading the text file 
while(!feof($fp)) {
$i++;	
// read line by line
$line = trim(fgets($fp,1024));
print "\n\nLine $i: \n\tInstruction = [".$line."]";
// check if syntax command is right [including ':']
if(!preg_match("/\:/i",$line)){
 	print "\nSyntax Error!\nCommand must be like the below: [instruction name]: [list of integers].";	
}else{
$extract_line = explode(":",$line);
$instruction = reset($extract_line);
// check if the instruction name is valid / must be one of the list [min|max|sum|avg|p90]
if(!in_array($instruction,array("min","max","sum","avg","p90"))){
  	print "\nError: Invalid Instruction Name \"$instruction\"!\n- Instruction should be one from the list [min|max|sum|avg|p90].";		
}else{
	// check if instruction name respects the syntax below <instruction_name>:<space>
if(!preg_match('/\s/', $extract_line[1])) {	
 print "\nSyntax Error!\nMissing white space between instruction name and the list of integers.\nCommand must be like the below: [instruction name]: [list of integers].";	
}else{
	// extract the list of provided values, remove the white space separating command
  $list_trim = trim($extract_line[1]);	
  $list = explode(",",$list_trim);
  // check if the list contains an empty values
  if(in_array("",$list)){
	print "\nSyntax Input Error!\nList of provided values must not contains an empty values.";  
  }else{
	  // assure that there is no empty value
  $parameters = array_filter($list);
  // check the syntax of separated values (must be integers with comma separated)
  if(!preg_match("/\,/i",$line)){
 	print "\nSyntax Error!\nList of provided values must be an integers comma separated values.";
  }else{
	  // check if all values in the provided list (per line) are integers 
	  if(!isNumricArray($parameters)){
	 	 print "\nSemantic Error!\nProvided list must including an integers values only.";
         // debug, display the values to distinguish which values are not integer type
		 foreach ($parameters as $value) {
    	 print "\n\t$value => ".(ctype_digit($value)?"Integer":"Not Integer");
}
	  }else{
		  // call the instructions function using the instruction name and the list of integer values
 		 $result = instructions($instruction,$parameters);
  		 print "\n\tResult = ".($result);
		 // sql query for saving operation
		 $sql = "INSERT INTO `operations` (`instruction`, `result`) VALUES ('$instruction', '$result')";
		 // execute query
		 $dbh->query($sql);
 	 }
  }
  }
}
}
}
}
// unset the pdo object
$dbh = null;
print "\n\nClosing \"$filename\" File...\n";
// sleep for 1 second to provide a handling code for end script
sleep(1);
print "\nEnd script. Copyright ".date("Y").".";
fclose($fp);

// check if all values into an array are integers
function isNumricArray($array){
  foreach($array as $val){
    if(!is_numeric($val) || !ctype_digit($val)){
      return false;
    }
  }
  return true;
}
// call instructions method using the list of integers and the instraction name
function instructions($operation,$array){
	switch($operation):
	case "min":
	return min($array);
	break;
	case "max":
	return max($array);
	break;
	case "sum":
	return array_sum($array);
	break;
	case "avg":
	return array_sum($array) / count($array);
	break;
	case "p90";
	return percentile_pN($array,90);
	break;
	endswitch;
}
// percentile function taking the list of integers and the ration p value 
function percentile_pN($array, $percentile){
    sort($array);
    $index = ($percentile/100) * count($array);
    if (floor($index) == $index) {
         $result = ($array[$index-1] + $array[$index])/2;
    }
    else {
        $result = $array[floor($index)];
    }
    return $result;
}
?>
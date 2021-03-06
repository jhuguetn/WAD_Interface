<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");


$table_resultaten_object='resultaten_object';



$v=$_GET['v'];

if (!empty($_GET['object_type']))
{
  $object_type=$_GET['object_type'];
}

$pk=0;
if (!empty($_GET['pk']))
{
  $pk=$_GET['pk'];
}



$results_object_Stmt="SELECT  $table_resultaten_object.object_naam_pad as 'object_naam_pad', $table_resultaten_object.omschrijving as 'omschrijving' from  $table_resultaten_object
where $table_resultaten_object.pk=$pk";



// Connect to the Database
$link = new mysqli($hostName, $userName, $password, $databaseName);

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}

if (!($result_object= $link->query($results_object_Stmt))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $results_object_Stmt)) ;
   DisplayErrMsg(sprintf("error: %s", $link->error)) ;
   exit() ;
}



$table_resultaten_object='';
$name_row='';
$picture_row='';

$field_results = $result_object->fetch_object();

$picture = new Smarty_NM();
$description_name = new Smarty_NM();
 


$file_name=$field_results->object_naam_pad;



// Special handling of jpeg images
if ($object_type=="image/jpeg")
{
    $action_object=sprintf("show_results.php?resultaten_object.pk=%d&t=%d",$field_results->pk,time()); 

    list($width, $height) = getimagesize($field_results->object_naam_pad);     
    $picture_src=sprintf("image_resize.php?f_name=$field_results->object_naam_pad&height=%s",$height);

    $picture->assign("picture_src",$picture_src);

    $picture->assign("picture_action",$action_object);
    $picture_row.=$picture->fetch("insert_picture_row_object.tpl");
    
    $description_name->assign("picture_name",$field_results->omschrijving);
    $name_row.=$description_name->fetch("insert_picture_name_row_object.tpl");

    $table_resultaten_object.=sprintf("<tr>%s</tr>",$picture_row);
    $table_resultaten_object.=sprintf("<tr>%s</tr>",$name_row);

    $result_object->close(); 

    $data = new Smarty_NM();
    $data->assign("Title","Results");
    $data->assign("header_result","Object file");
    $data->assign("header_object","Resultaten Object");
    $data->assign("resultaten_object_list",$table_resultaten_object);

    $data->display("resultaten_result.tpl");
}
else
{

 if (!file_exists($file_name)) { die("<b>Fout: object file niet aanwezig.</b>"); }
   
    $file_extension = strtolower(substr(strrchr($file_name,"."),1));
    $file_size = filesize($file_name);
    $md5_sum = md5_file($file_name);
   
    //This will set the Content-Type to the appropriate setting for the file
    //~ switch($file_extension) {
        //~ case "exe": $ctype="application/octet-stream"; break;
        //~ case "zip": $ctype="application/zip"; break;
        //~ case "mp3": $ctype="audio/mpeg"; break;
        //~ case "mpg": $ctype="video/mpeg"; break;
        //~ case "avi": $ctype="video/x-msvideo"; break;
        //~ case "txt": $ctype="text/plain"; break;
        //~ case "pdf": $ctype="application/pdf"; break;

        //~ //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
        //~ case "php":
        //~ case "htm":
        //~ case "html":
        //~ //case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;

        //~ default: $ctype="application/force-download";
    //~ }
   
    if (isset($_SERVER['HTTP_RANGE'])) {
        $partial_content = true;
        $range = explode("-", $_SERVER['HTTP_RANGE']);
        $offset = intval($range[0]);
        $length = intval($range[1]) - $offset;
    }
    else {
        $partial_content = false;
        $offset = 0;
        $length = $file_size;
    }
   
    //read the data from the file
    $handle = fopen($file_name, 'r');
    $buffer = '';
    fseek($handle, $offset);
    $buffer = fread($handle, $length);
    $md5_sum = md5($buffer);
    if ($partial_content) $data_size = intval($range[1]) - intval($range[0]);
    else $data_size = $file_size;
    fclose($handle);
   
    // send the headers and data
    header("Content-Length: " . $data_size);
    header("Content-md5: " . $md5_sum);
    header("Accept-Ranges: bytes");   
    if ($partial_content) header('Content-Range: bytes ' . $offset . '-' . ($offset + $length) . '/' . $file_size);
    header("Connection: close");
    //header("Content-type: " . $ctype);
    header("Content-type: " . $object_type);

    //if($file_extension!='txt'){
    //	header('Content-Disposition: attachment; filename=' . $file_name);
    //}
    
    echo $buffer;
    flush();




}



?>
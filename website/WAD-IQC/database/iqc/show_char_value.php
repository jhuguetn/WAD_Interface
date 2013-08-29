<?php
require("../globals.php") ;
require("./common.php") ;
require("./php/includes/setup.php");

$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';


$v=$_GET['v'];
$selector_fk=0;
if (!empty($_GET['selector_fk']))
{
  $selector_fk=$_GET['selector_fk'];
}


$omschrijving_char="%";
if (!empty($_GET['omschrijving_char']))
{
  $omschrijving_char=$_GET['omschrijving_char'];
}



$analyse_level='';
if (!empty($_GET['analyse_level']))
{
  $analyse_level=$_GET['analyse_level'];
}

if (!empty($_GET['status']))
{
  $status=$_GET['status'];
}
if (!empty($_POST['status']))
{
  $status=$_POST['status'];
}

  
$results_char_Stmt="SELECT  * from $table_gewenste_processen inner join $table_resultaten_char on $table_gewenste_processen.pk=$table_resultaten_char.gewenste_processen_fk 
where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.status in ($status)
and $table_resultaten_char.omschrijving like '$omschrijving_char'
order by $table_gewenste_processen.pk, $table_resultaten_char.volgnummer";



$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

$gewenste_processen_Stmt="SELECT * from $table_gewenste_processen
where $table_gewenste_processen.selector_fk=$selector_fk
order by $table_gewenste_processen.pk";

// Connect to the Database
if (!($link=mysql_pconnect($hostName, $userName, $password))) {
   DisplayErrMsg(sprintf("error connecting to host %s, by user %s",
                             $hostName, $userName)) ;
   exit();
}


// Select the Database
if (!mysql_select_db($databaseName, $link)) {
   DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}




if (!($result_char= mysql_query(sprintf($results_char_Stmt,$gewenste_processen_id), $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", sprintf($results_char_Stmt,$gewenste_processen_id)) );
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


if (!($result_selector= mysql_query($selector_Stmt, $link))) {
   DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
   DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
   exit() ;
}


$field_results = mysql_fetch_object($result_selector);
$header_result=sprintf("Selector: %s, analyse level: %s",$field_results->name,$field_results->analyselevel);
mysql_free_result($result_selector);  







$table_resultaten_char='';


$j=0;
while (($field_results = mysql_fetch_object($result_char)))
{
  
   $b=($j%2);
   $bgcolor=''; 
   if ($b==0)
   {
     $bgcolor='#B8E7FF';
   }   

   $table_data = new Smarty_NM();
   
   if ($j==0) //define header data
   {
     $table_resultaten_char=$table_data->fetch("resultaten_char_header.tpl");
   }

   //$action_char=sprintf("show_results.php?selector_fk=%d&gewenste_processen_id=0&omschrijving_char=%s&t=%d",$selector_fk,$field_results->omschrijving,time()); 

     
   $table_data->assign("bgcolor",$bgcolor);
   $table_data->assign("datum",$field_results->creation_time);
   $table_data->assign("omschrijving",$field_results->omschrijving);
   $table_data->assign("waarde",$field_results->waarde);
   
         
   $table_resultaten_char.=$table_data->fetch("resultaten_char_value_row.tpl");

   $j++;
}




$data = new Smarty_NM();
$data->assign("Title","results Results");

$data->assign("header_result",$header_result);


if ($table_resultaten_char!='')
{
  $data->assign("header_value","Resultaten char");
  $data->assign("resultaten_value_list",$table_resultaten_char);
}

//$action_result=sprintf("show_results.php?selector_fk=%d&analyse_level=%s&t=%d",$selector_fk,$analyselevel,time()); 
//$data->assign("action_result",$action_result);

$data->display("resultaten_result_value.tpl");







?>

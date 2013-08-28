<?php 

require("../globals.php") ;
require("./common.php") ;
require("./selector_function.php") ;

require("./php/includes/setup.php");


$table_study='study';
$table_series='series';
$table_instance='instance';



$table_resultaten_floating='resultaten_floating';
$table_resultaten_char='resultaten_char';
$table_resultaten_boolean='resultaten_boolean';
$table_resultaten_object='resultaten_object';
$table_gewenste_processen='gewenste_processen';
$table_selector='selector';
$table_resultaten_status='resultaten_status';










  //Selector
  if (!empty($_GET['selector_fk']))
  {
    $selector_fk=$_GET['selector_fk'];
  }
  if (!empty($_GET['analyse_level']))
  {
    $analyse_level=$_GET['analyse_level'];
  }
  if (!empty($_GET['gewenste_processen_id']))
  {
    $gewenste_processen_id=$_GET['gewenste_processen_id'];
  }
  if (!empty($_POST['gewenste_processen_id']))
  {
    $gewenste_processen_id=$_POST['gewenste_processen_id'];
  }
  if (!empty($_GET['v']))
  {
    $v=$_GET['v'];
  }
  
  if (!empty($_POST['action_result']))
  {
    $action_result=$_POST['action_result'];
  }


printf("actie = %s ",$action_result);
exit();




$year_Stmt_study="SELECT $table_gewenste_processen.pk as 'pk', $table_study.study_datetime as 'date_time' from $table_gewenste_processen inner join $table_study on $table_gewenste_processen.study_fk=$table_study.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%d'";

$year_Stmt_series="SELECT $table_gewenste_processen.pk as 'pk', $table_series.pps_start as 'date_time' from $table_gewenste_processen inner join $table_series on $table_gewenste_processen.series_fk=$table_series.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%d'";

$year_Stmt_instance="SELECT $table_gewenste_processen.pk as 'pk', $table_instance.content_datetime as 'date_time' from $table_gewenste_processen inner join $table_instance on $table_gewenste_processen.study_fk=$table_instance.pk where $table_gewenste_processen.selector_fk=$selector_fk
and $table_gewenste_processen.pk='%d'";

$selector_Stmt="SELECT * from $table_selector
where $table_selector.pk=$selector_fk"; 

$update_Stmt="update $table_gewenste_processen set status='%d' where $table_gewenste_processen.pk='%d'";

$add_Stmt = "Insert into $table_resultaten_status(gewenste_processen_fk,gebruiker,omschrijving) 
values ('%d','%s','%s')";



// Connect to the Database
  if (!($link=mysql_pconnect($hostName, $userName, $password))) {
     DisplayErrMsg(sprintf("error connecting to host %s, by user %s",$hostName, $userName)) ;
     exit() ;
  }

// Select the Database
  if (!mysql_select_db($databaseName, $link)) {
    DisplayErrMsg(sprintf("Error in selecting %s database", $databaseName)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
  }











  
  //description
  $delete_description='';
  if (!empty($_POST['delete_description']))
  {
    $delete_description=$_POST['delete_description'];
  }

  if ($delete_description=='')
  {

    if ($analyse_level=='study')
    {
      if (!($result_year= mysql_query(sprintf($year_Stmt_study,$gewenste_processen_id), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
    }
    if ($analyse_level=='series')
    {
      if (!($result_year= mysql_query(sprintf($year_Stmt_series,$gewenste_processen_id), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
    } 
    if ($analyse_level=='instance')
    {
      if (!($result_year= mysql_query(sprintf($year_Stmt_instance,$gewenste_processen_id), $link))) {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $year_Stmt)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
      }
    }

    $field = mysql_fetch_object($result_year);
    $date_result=$field->date_time;
    mysql_free_result($result_year);

    if (!($result_selector= mysql_query($selector_Stmt, $link))) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $selector_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }


    $field_results = mysql_fetch_object($result_selector);
    $header_delete_result=sprintf("Verwijderen resultaat van Selector: %s, analyse level: %s datum: %s",$field_results->name,$field_results->analyselevel,$date_result);
    mysql_free_result($result_selector);  

    $data= new Smarty_NM();
    $data->assign("header_delete_result",$header_delete_result);
    $data->assign("action_delete_results",sprintf("delete_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=%d&v=%d&t=%d",$selector_fk,$analyse_level,$gewenste_processen_id,$v,time()) );
    $data->assign("submit_value","Delete");
    $data->display("delete_results.tpl");
    exit();
  }
 
  if ($delete_description!='')
  {
    $status=20;
    
    //update 
    if (!mysql_query(sprintf($update_Stmt,$status,$gewenste_processen_id),$link)) {
    DisplayErrMsg(sprintf("Error in executing %s stmt", $update_Stmt)) ;
    DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
    exit() ;
    }
    //add
    if(!mysql_query(sprintf($add_Stmt,$gewenste_processen_id,$user,$delete_description),$link)) 
    {
      DisplayErrMsg(sprintf("Error in executing %s stmt", $addStmt_class)) ;
      DisplayErrMsg(sprintf("error:%d %s", mysql_errno($link), mysql_error($link))) ;
      exit() ;
    } 

    $executestring = sprintf("Location: http://%s%s/",$_SERVER['HTTP_HOST'],dirname($_SERVER['PHP_SELF']));

    $executestring.= sprintf("show_results.php?selector_fk=%d&analyse_level=%s&gewenste_processen_id=-1&v=%d&t=%d",$selector_fk,$analyse_level,$v,time());
    header($executestring);
    exit();

  }   
?>
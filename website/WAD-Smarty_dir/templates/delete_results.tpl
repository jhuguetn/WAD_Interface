<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>New Selector</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff" link="blue" alink="blue" vlink="red">

<form action="{$action_delete_results}" method="POST" >

<font class="table_data_blue_header">{$header_delete_result}</font>
<hr>
<table>
  <tr>
    <td class="table_data_blue"> Geef omschrijving waarom resultaat wordt verwijderd </td>
    <td class="table_data">
      <input   name="delete_description" type="text" value="{$default_delete_description}" size="100"> </input>
    </td>
  </tr>
  <tr>
</table>

<input type="submit" name="action" value="{$submit_value}">

</form>
</body>
</HTML>



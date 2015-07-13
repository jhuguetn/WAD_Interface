<!-- source template: wad_about.tpl -->
<!DOCTYPE public "-//w3c//dtd html 4.01 transitional//en"
		"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head >
  <link   rel="StyleSheet" href="./css/styles.css" type="text/css">
  <title>WAD-QC</title>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="GENERATOR" content="Quanta Plus">
</head>
<body bgcolor="#f3f6ff">

<table cellspacing="0" cellpadding="0" align="left" width="100%">
  <tr>
    <td> <img src="{$main_logo}" align="left" border="0" > </td>
  </tr>
  <tr>
    <td class="table_data_blue_header">
      <br>WAD-QC
    </td>
  </tr>
  <tr>
    <td class="table_data">
      The WAD-QC software is an initiative from the Dutch Society for Clinical Physics <a href="http://www.nvkf.nl" target="_blank" class="table_data_select" type="text/html">(NVKF)</a> Equipment in Diagnostics Working Group (WAD) for automating quality control (QC) of medical imaging equipment. WAD-QC software is designed to receive DICOM imaging data, perform fully automatic QC analysis and make the results available to the user.
	  
	  <br>This web interface enables connecting QC-related analysis modules and DICOM imaging data sets, and also review the results of the performed analysis. The analysis modules are not strictly part of the WAD-QC software.	  	  
    </td>
  </tr>
  <tr>
    <td class="table_data_blue_header">
      <br>Disclaimer
    </td>
  </tr>
  <tr>
    <td class="table_data">
      The usage of this software platform and/or the information hereby generated is solely and fully responsibility of the user. The NVKF accepts no liability for any direct or indirect damages howsoever caused as a result of the usage of the software.	  
    </td>
  </tr>

  <tr>
    <td class="table_data_blue_header">
      <br>WAD-QC - Copyright (C) 2012-2015 - NVKF Werkgroep Apparatuur in de Diagnostiek
    </td>
  </tr>
  <tr>
    <td class="table_data">
      WAD Initiative: KlaasJan Renema, Jurgen Mourik and Arjen Becht
      <br>WAD Software Developers: Ralph Berendsen, Anne Talsma, Tim de Wit, Bart Titulaer, Joost Kuijer.
      <br>WAD Software Members: Niels Matheijssen, Leo Romijn, Bart van Rooijen, Michiel Sinaasappel.
      <br>
    </td>
  </tr>
  <tr>
    <td class="table_data">
      This program is free software; you can redistribute it and / or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.
	  
	  <br>This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FOR A PARTICULAR PURPOSE. See the <a href="http://www.gnu.org/licenses/">GNU General Public License</a> for more details.
    </td>
  </tr>
</table>

<br>

<table cellspacing="0" cellpadding="0" align="left">
  <tr>
    <td class="table_data_blue_header" colspan="3">
      <br>{$versions_title}
    </td>
  </tr>
  <tr><td colspan="3">&nbsp;</td></tr>

{$versions_list}
</table>
   
</body>
</html>

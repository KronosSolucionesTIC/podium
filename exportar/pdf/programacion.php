<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];

$codigoHTML='
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../../css/styles.css" rel="stylesheet" type="text/css">
<title>PROGRAMACION DEL '.$fec_ini.' AL '.$fec_fin.'</title>
</head>
<body>
<table width="90%" cellpadding="2" cellspacing="1" class="tabla_prog" align="center">
  <tr>
    <td colspan="9" align="center"><img width="710" align="center" src="../../imagenes/cabezera.png" ></td>
  </tr>
  <tr>
    <td class="ctablasup" align="center" colspan="9">PROGRAMACION DEL '.$fec_ini.' AL '.$fec_fin.'</td>
  </tr>
  <tr>
    <td class="ctablasup" align="center">CATEGORIA</td>
    <td class="ctablasup" align="center">FASE</td>
    <td class="ctablasup" align="center">FECHA</td>
    <td class="ctablasup" align="center">EQUIPO A</td>
    <td class="ctablasup" align="center">VS</td>
    <td class="ctablasup" align="center">EQUIPO B</td>
    <td class="ctablasup" align="center">DIA</td>
    <td class="ctablasup" align="center">HORA</td>
    <td class="ctablasup" align="center">LUGAR</td>
  </tr>';

  $db = new database();
  $sql = "SELECT * FROM m_programacion
  INNER JOIN d_programacion ON d_programacion.cod_prog = m_programacion.cod_pro
  INNER JOIN categoria ON  categoria.cod_cat = d_programacion.cat_dprog
  INNER JOIN parque ON parque.cod_par = m_programacion.lug_pro
  WHERE estado_pro = 1 AND (fec_pro >= '$fec_ini' AND fec_pro <= '$fec_fin') ORDER BY fec_pro,hora_dprog ASC";
  $db->query($sql);
  while($db->next_row()){

  $codigoHTML.='<tr>
    <td>'.$db->nom_cat.'</td>';


  $dbf = new database();
  $sqlf = "SELECT * FROM fase
  WHERE cod_fase = $db->fase_dprog";
  $dbf->query($sqlf);
  $dbf->next_row();

  $codigoHTML.='<td>'.$dbf->nom_fase.'</td>';
  
  $dbfe = new database();
  $sqlfe = "SELECT * FROM fecha
  WHERE cod_fec = $db->nom_fec";
  $dbfe->query($sqlfe);
  $dbfe->next_row();
 
  $codigoHTML.='<td>'.$dbfe->nom_fec.'</td>';
  
  $dbe1 = new database();
  $sqle1 = "SELECT * FROM equipo
  WHERE cod_equi = $db->equi1_dprog";
  $dbe1->query($sqle1);
  $dbe1->next_row();
  
  $codigoHTML.='<td align="center">'.$dbe1->nom_equi.'</td>
    <td align="center">VS</td>';
  
  $dbe2 = new database();
  $sqle2 = "SELECT * FROM equipo
  WHERE cod_equi = $db->equi2_dprog";
  $dbe2->query($sqle2);
  $dbe2->next_row();
  
  $codigoHTML.='<td align="center">'.$dbe2->nom_equi.'</td>
    <td align="center">'.$db->fec_pro.'</td>
    <td align="center">'.$db->hora_dprog.'</td>
    <td align="center">'.$db->nom_par.'</td>
  </tr>';
	
	}

  $codigoHTML.='
  <tr>
    <td colspan="9" align="center"><img width="710" align="center" src="../../imagenes/pie.png" ></td>
  </tr>
</table>
</body>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Progamacion_del_".$fec_ini."_al_".$fec_fin.".pdf");
?>
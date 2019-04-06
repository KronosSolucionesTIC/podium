<?php require_once("../../lib/dompdf/dompdf_config.inc.php");?>
<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$cod_afi = $_REQUEST['cod_afi'];
$cod_cat = $_REQUEST['cod_cat'];

$codigoHTML='
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../../css/styles.css" rel="stylesheet" type="text/css">
<title>PROGRAMACION DEL '.$fec_ini.' AL '.$fec_fin.'</title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan="4">PLANILLA INSCRIPCION</td>
  </tr>
  <tr>
    <td align="center">NOMBRE COMPLETO</td>
    <td align="center">No IDEN</td>
    <td align="center">TELEFONO</td>
    <td align="center">CELULAR 1</td>
  </tr>';

  //VALIDO LOS CAMPOS
  if($cod_afi != 0){
    $where = "AND cod_afi = $cod_afi";
  }

  if($cod_cat != 0){
    $where2 ="AND cat_afi = $cod_cat";
  } 
  //CONSULTO LOS AFILIADOS
  $tot_afi = 0;
  $db = new database();
  $sql = "SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM afiliado
  WHERE estado_afi = 1 $where $where2 
  ORDER BY nombre";
  $db->query($sql);
  while($db->next_row()){

  $codigoHTML.='<tr>
    <td>'.$db->nombre.'</td>
    <td align="center">'.$db->id_afi.'</td>
    <td align="center">'.$db->tel_afi.'</td>
    <td align="center">'.$db->cel1_afi.'</td>
  </tr>';

  $tot_afi++;
  }
  
  $codigoHTML.='<tr>
      <td align="center" colspan="4">Total afiliados:'.$tot_afi.'</td>
    </tr>
</table>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("Planilla_inscripcion.pdf");
?>
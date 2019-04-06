<?php 
include("../lib/database.php");
include("../js/funciones.php");
?>
<?php
//RECIBE LAS VARIABLES
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>INFORME TORNEOS CERRADOS</title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='11'>INFORME TORNEOS CERRADOS</td>
  </tr>
  <tr>
    <td align="center">TORNEO</td>
    <td align="center">VERSION</td>
    <td align="center">CATEGORIA</td>
    <td align="center">RESE&Ntilde;A</td>
    <td align="center">FECHA DE CIERRE</td>
  </tr>
  <?php 
  $db = new database();
  $sql = "SELECT * FROM campeonato 
  INNER JOIN localidad ON localidad.cod_loc = campeonato.loc_cam
  INNER JOIN cierre ON cierre.torneo_cierre = campeonato.cod_cam
  INNER JOIN categoria ON categoria.cod_cat = campeonato.cat_cam
  WHERE (fecha_cierre >= '$fec_ini' AND fecha_cierre <= '$fec_fin') ";
  $db->query($sql);
  while($db->next_row()){
  ?>
  <tr>
    <td><?php echo $db->nom_cam ?></td>
    <td><?php echo $db->ver_cam ?></td>
    <td><?php echo $db->nom_cat ?></td>
    <td><?php echO $db->rese_cierre?></td>
    <td><?php echO $db->fecha_cierre?></td>
  </tr>
  <?php 
	}
  ?>
    <tr>
      <td align="center" colspan='11'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" /><input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" /></td>
    </tr>
</table>
</body>
</html>
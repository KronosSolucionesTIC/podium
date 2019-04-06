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
<title>INFORME ASISTENCIA ENTRENAMIENTOS</title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='3'>INFORME ASISTENCIA ENTRENAMIENTOS</td>
  </tr>
  <tr>
    <td align="center">AFILIADO</td>
    <td align="center">CANT. ENTRENAMIENTOS</td>
    <td align="center">CANT. ASISTENCIAS</td>
  </tr>
  <?php
  $db = new database();
  $sql = "SELECT cod_afi,cat_afi,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM afiliado
  WHERE estado_afi = 1
  ORDER BY nombre";
  $db->query($sql);
  while($db->next_row()){
  ?>
   <tr>
    <td><?php echo $db->nombre?></td>
    <?php
    $dbe = new database();
  	$sqle = "SELECT COUNT(*) AS tot_ent FROM m_entrenamiento
  	WHERE estado_ent = 1 and (fec_ent >='$fec_ini' and fec_ent <='$fec_fin') and cat_ent = $db->cat_afi";
  	$dbe->query($sqle);
  	$dbe->next_row();
    ?>
    <td align="center"><?php echo $dbe->tot_ent?></td>
    <?php
    $dba = new database();
  	$sqla = "SELECT COUNT(*) AS tot_asis FROM d_entrenamiento
  	INNER JOIN m_entrenamiento ON m_entrenamiento.cod_ent = d_entrenamiento.cod_ment 
  	WHERE cod_afi = $db->cod_afi and estado_ent = 1 and (fec_ent >='$fec_ini' and fec_ent <='$fec_fin')";
  	$dba->query($sqla);
  	$dba->next_row();
    ?>
    <td align="center"><?php echo $dba->tot_asis?></td>
  </tr>
  <?php
	}
  ?>
    <tr>
      <td align="center" colspan='3'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" />
        <input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" />
        <input type="hidden" name="mapa" value="<?php echo $mapa?>"></td>
    </tr>
</table>
</body>
</html>
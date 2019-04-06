<?php 
include("../lib/database.php");
include("../js/funciones.php");
?>
<?php
//RECIBE LAS VARIABLES
$campeonato = $_REQUEST['codigo'];
?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>INFORME ARBITRAJES</title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='11'>INFORME ARBITRAJES</td>
  </tr>
  <tr>
    <td align="center">TORNEO</td>
    <td align="center">AFILIADO</td>
    <td align="center">FECHA PARTIDO</td>
    <td align="center">ARBITRAJE</td>
    <td align="center">INSCRIPCION</td>
  </tr>
  <?php 
  //CONSULTA LA NOMINA
  $tot_afi = 0;
  $db = new database();
  $sql = "SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM m_nomina
  INNER JOIN d_nomina ON m_nomina.cod_nom = d_nomina.cod_nom
  INNER JOIN afiliado ON afiliado.cod_afi = d_nomina.cod_afi
  INNER JOIN campeonato ON campeonato.cod_cam = m_nomina.cam_nom
  WHERE cam_nom = $campeonato";
  $db->query($sql);
  while($db->next_row()){
  ?>
   <tr>
    <td><?php echo $db->nom_cam?></td>
    <td><?php echo $db->nombre?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
  $tot_afi++;
	}
  ?>
    <tr>
      <td align="center" colspan='11'>Total afiliados:<?=$tot_afi?></td>
    </tr>
    <tr>
      <td align="center" colspan='11'>&nbsp;</td>
    </tr>
  <tr>
    <td align="center">TORNEO</td>
    <td align="center">AFILIADO</td>
    <td align="center">FECHA PARTIDO</td>
    <td align="center">ARBITRAJE</td>
    <td align="center">INSCRIPCION</td>
  </tr>
  <?php 
  //CONSULTA LA NOMINA
  $tot_afi = 0;
  $db = new database();
  $sql = "SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM m_nomina
  INNER JOIN d_nomina ON m_nomina.cod_nom = d_nomina.cod_nom
  INNER JOIN afiliado ON afiliado.cod_afi = d_nomina.cod_afi
  INNER JOIN campeonato ON campeonato.cod_cam = m_nomina.cam_nom
  WHERE cam_nom = $campeonato";
  $db->query($sql);
  while($db->next_row()){
  ?>
   <tr>
    <td><?php echo $db->nom_cam?></td>
    <td><?php echo $db->nombre?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <?php 
  $tot_afi++;
  }
  ?>
    <tr>
      <td align="center" colspan='11'>Total afiliados:<?=$tot_afi?></td>
    </tr>
     <tr>
      <td align="center" colspan='5'><a href="../exportar/word/planilla.php?cod_afi=<?=$cod_afi?>&cod_cat=<?=$cod_cat?>"><img src='../imagenes/word.png'></a><a href="../exportar/excel/planilla.php?cod_afi=<?=$cod_afi?>&cod_cat=<?=$cod_cat?>"><img src='../imagenes/excel.png'></a><a href="../exportar/pdf/planilla.php?cod_afi=<?=$cod_afi?>&cod_cat=<?=$cod_cat?>"><img src='../imagenes/pdf.png'></a></td>
    </tr>
    <tr>
      <td align="center" colspan='11'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" /><input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" /></td>
    </tr>
</table>
</body>
</html>
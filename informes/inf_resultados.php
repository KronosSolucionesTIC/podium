<?php 
include("../lib/database.php");
include("../js/funciones.php");
?>
<?php
//RECIBE LAS VARIABLES
$categoria = $_REQUEST['categoria'];
$campeonato = $_REQUEST['campeonato'];
?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>INFORME DE RESULTADOS</title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='11'>INFORME DE RESULTADOS</td>
  </tr>
  <tr>
    <td align="center">TORNEO</td>
    <td align="center">VERSION</td>
    <td align="center">CATEGORIA</td>
    <td align="center">EQUIPO A</td>
    <td align="center">VS</td>
    <td align="center">EQUIPO B</td>
    <td align="center">RESULTADO</td>
  </tr>
  <?php 
  $db = new database();
  $sql = "SELECT * FROM m_resultado 
  INNER JOIN campeonato ON campeonato.cod_cam = m_resultado.cod_cam
  INNER JOIN localidad ON localidad.cod_loc = campeonato.loc_cam
  INNER JOIN categoria ON categoria.cod_cat = campeonato.cat_cam
  WHERE campeonato.cod_cam = $campeonato";
  $db->query($sql);
  while($db->next_row()){
    //VALIDA RESULTADO 
    if($db->equi1_mar == $db->equi2_mar){
      $resultado = 'EMPATE';
    } 

    if($db->equi1_mar > $db->equi2_mar){
      $resultado = 'GANADOR';
    } 

    if($db->equi1_mar < $db->equi2_mar){
      $resultado = 'PERDEDOR';
    }
  ?>
  <tr>
    <td><?php echo $db->nom_cam ?></td>
    <td><?php echo $db->ver_cam ?></td>
    <td><?php echo $db->nom_cat ?></td>
  <?php 
  $dbe1 = new database();
  $sqle1 = "SELECT * FROM equipo
  WHERE cod_equi = $db->equi1_enc";
  $dbe1->query($sqle1);
  $dbe1->next_row();
  ?>
    <td align="center"><?php echo $dbe1->nom_equi?><BR><div align="center"><?php echo $db->equi1_mar?></div></td>
  <?php 
  $dbe2 = new database();
  $sqle2 = "SELECT * FROM equipo
  WHERE cod_equi = $db->equi2_enc";
  $dbe2->query($sqle2);
  $dbe2->next_row();
  ?>
    <td align="center">VS</td>
    <td align="center"><?php echo $dbe2->nom_equi?><BR><div align="center"><?php echo $db->equi2_mar?></div></td>
    <td align="center"><?php echo $resultado ?></td>
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
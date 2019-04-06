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
<title>PROGRAMACION DEL <?php echo $fec_ini?> AL <?php echo $fec_fin?></title>
<script type="text/javascript">
function imprimir(){
  document.getElementById('botones').style.display = 'none';
  window.print();
}
</script>
</head>
<body>
<table width="100%" cellpadding="2" cellspacing="1"   class="tabla_prog" align="center">
  <tr>
    <td colspan='9'><img width='100%' align='center' src="../imagenes/cabezera.png" ></td>
  </tr>
  <tr>
    <td class="ctablasup" align="center" colspan='9'>PROGRAMACION DEL <?php echo $fec_ini?> AL <?php echo $fec_fin?></td>
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
  </tr>
  <?php 
  $db = new database();
  $sql = "SELECT * FROM m_programacion
  INNER JOIN d_programacion ON d_programacion.cod_prog = m_programacion.cod_pro
  INNER JOIN categoria ON  categoria.cod_cat = d_programacion.cat_dprog
  INNER JOIN parque ON parque.cod_par = m_programacion.lug_pro
  WHERE estado_pro = 1 AND (fec_pro >= '$fec_ini' AND fec_pro <= '$fec_fin') ORDER BY fec_pro,hora_dprog ASC";
  $db->query($sql);
  while($db->next_row()){
  ?>
   <tr>
    <td><?php echo $db->nom_cat?></td>
    <?php 
  $dbf = new database();
  $sqlf = "SELECT * FROM fase
  WHERE cod_fase = $db->fase_dprog";
  $dbf->query($sqlf);
  $dbf->next_row();
  ?>
    <td><?php echo $dbf->nom_fase?></td>
    <?php 
  $dbfe = new database();
  $sqlfe = "SELECT * FROM fecha
  WHERE cod_fec = $db->nom_fec";
  $dbfe->query($sqlfe);
  $dbfe->next_row();
  ?>
    <td><?php echo $dbfe->nom_fec?></td>
  <?php 
  $dbe1 = new database();
  $sqle1 = "SELECT * FROM equipo
  WHERE cod_equi = $db->equi1_dprog";
  $dbe1->query($sqle1);
  $dbe1->next_row();
  ?>
    <td align="center"><?php echo $dbe1->nom_equi?></td>
    <td align="center">VS</td>
  <?php 
  $dbe2 = new database();
  $sqle2 = "SELECT * FROM equipo
  WHERE cod_equi = $db->equi2_dprog";
  $dbe2->query($sqle2);
  $dbe2->next_row();
  ?>
    <td align="center"><?php echo $dbe2->nom_equi?></td>
    <td align="center"><?php echo $db->fec_pro?></td>
    <td align="center"><?php echo $db->hora_dprog?></td>
    <td align="center"><?php echo $db->nom_par?></td>
  </tr>
  <?php 
	}
  ?>
  <tr>
    <td colspan='9'><img width='100%' align='center' src="../imagenes/pie.png" ></td>
  </tr>
     <tr>
      <td align="center" colspan='9'><a href="../exportar/pdf/programacion.php?fec_ini=<?=$fec_ini?>&fec_fin=<?=$fec_fin?>"><img src='../imagenes/pdf.png'></a></td>
    </tr>
    <tr>
      <td align="center" colspan='9'><div id='botones'><input name="button" type="button" class="botones"  onClick="imprimir()" value="Imprimir" />
        <input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" />
        <input type="hidden" name="mapa" value="<?php echo $mapa?>"></div></td>
    </tr>
</table>
</body>
</html>
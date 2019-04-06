<?php
include("../lib/database.php");
include("../js/funciones.php");

//RECIBE LAS VARIABLES
$cod_afi = $_REQUEST['cod_afi'];
$cod_cat = $_REQUEST['cod_cat'];
$fec_ini = $_REQUEST['fec_ini'];
$fec_fin = $_REQUEST['fec_fin'];
?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>INFORME ESTADO DE CUENTA</title>
</head>
<body>
<table width="731" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='9'>INFORME ESTADO DE CUENTA</td>
  </tr>
  <tr>
    <td class="ctablasup" align="center" colspan='9'>COSTOS</td>
  </tr>
  <tr>
    <td align="center">NOMBRE COMPLETO</td>
    <td align="center">TIPO DE IDEN</td>
    <td align="center">No IDEN</td>
    <td align="center">CATEGORIA</td>
    <td align="center">FECHA</td>
    <td align="center">COSTO</td>
    <td align="center">VALOR COSTO</td>
  </tr>
  <? 
  //VALIDO LOS CAMPOS
  if($cod_afi != 0){
    $where = "AND cod_afi = $cod_afi";
  }
  else{
    $where = "AND estado_afi = 1";
  }

  //CONSULTO LOS AFILIADOS
  $tot_costos = 0;
  $db = new database();
  $sql = "SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM m_costos
  INNER JOIN d_costos ON d_costos.cod_mcosto = m_costos.cod_mcosto
  INNER JOIN afiliado ON afiliado.cod_afi = m_costos.afi_mcosto
  WHERE estado_mcosto = 1 $where AND (fec_dcosto >= '$fec_ini' AND fec_dcosto <= '$fec_fin') 
  ORDER BY fec_dcosto ASC";
  $db->query($sql);
  while($db->next_row()){
  ?>
   <tr>
    <td><?=$db->nombre?></td>
    <? 
    //CONSULTA EL TIPO DE IDENTIFICACION
    $dbti = new database();
    $sqlti = "SELECT * FROM tipo_identificacion
    WHERE estado_tiden = 1 AND cod_tiden = $db->tiden_afi";
    $dbti->query($sqlti);
    $dbti->next_row();
    ?>
    <td><?=$dbti->nom_tiden?></td>
    <td align="center"><?=$db->id_afi?></td>
    <? 
    //CONSULTA LA CATEGORIA
    $dbc = new database();
    $sqlc = "SELECT * FROM categoria
    WHERE estado_cat = 1 AND cod_cat = $db->cat_afi";
    $dbc->query($sqlc);
    $dbc->next_row();
    ?>
    <td><?=$dbc->nom_cat?></td>
    <td align="center"><?=$db->fec_dcosto?></td>
    <? 
    //CONSULTA EL TIPO COSTO
    $dbt = new database();
    $sqlt = "SELECT * FROM costos
    WHERE cod_costo = $db->tipo_dcosto";
    $dbt->query($sqlt);
    $dbt->next_row();
    ?>
    <td><?=$dbt->nom_costo?></td>
    <td align="right"><?=number_format($db->val_dcosto,0,'.','.')?></td>
  </tr>
  <? 
  $tot_costos = $tot_costos + $db->val_dcosto;
	}
  ?>
    <tr>
      <td align="right" colspan='6'>Total costos:</td>
      <td align="right"><?=number_format($tot_costos,0,'.','.')?></td> 
    </tr>
  <tr>
    <td align="center" colspan='7'>&nbsp;</td>
  </tr>
  <tr>
    <td class="ctablasup" align="center" colspan='9'>ABONOS</td>
  </tr>
  <tr>
    <td align="center">NOMBRE COMPLETO</td>
    <td align="center">TIPO DE IDEN</td>
    <td align="center">No IDEN</td>
    <td align="center">CATEGORIA</td>
    <td align="center">FECHA</td>
    <td align="center">INGRESO</td>
    <td align="center">VALOR INGRESO</td>
  </tr>
  <?php
  //VALIDO LOS CAMPOS
  if($cod_afi != 0){
    $where = "AND afi_ing = $cod_afi";
  }

  //CONSULTO LOS AFILIADOS
  $tot_ingresos = 0;
  $db = new database();
  $sql = "SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) AS nombre FROM ingresos
  INNER JOIN afiliado ON afiliado.cod_afi = ingresos.afi_ing
  WHERE estado_ing = 1 $where AND (fec_ing >= '$fec_ini' AND fec_ing <= '$fec_fin') 
  ORDER BY fec_ing ASC";
  $db->query($sql);
  while($db->next_row()){
  ?>
  <tr>
    <td><?=$db->nombre?></td>
    <? 
    //CONSULTA EL TIPO DE IDENTIFICACION
    $dbti = new database();
    $sqlti = "SELECT * FROM tipo_identificacion
    WHERE estado_tiden = 1 AND cod_tiden = $db->tiden_afi";
    $dbti->query($sqlti);
    $dbti->next_row();
    ?>
    <td><?=$dbti->nom_tiden?></td>
    <td align="center"><?=$db->id_afi?></td>
    <? 
    //CONSULTA LA CATEGORIA
    $dbc = new database();
    $sqlc = "SELECT * FROM categoria
    WHERE estado_cat = 1 AND cod_cat = $db->cat_afi";
    $dbc->query($sqlc);
    $dbc->next_row();
    ?>
    <td><?=$dbc->nom_cat?></td>
    <td align="center"><?=$db->fec_ing?></td>
    <? 
    //CONSULTA EL TIPO INGRESO
    $dbt = new database();
    $sqlt = "SELECT * FROM tipo_ingresos
    WHERE cod_ting = $db->tipo_ing";
    $dbt->query($sqlt);
    $dbt->next_row();
    ?>
    <td><?=$dbt->nom_ting?></td>
    <td align="right"><?=number_format($db->val_ing,0,'.','.')?></td>
  </tr>
  <? 
  $tot_ingresos = $tot_ingresos + $db->val_ing;
  }

  $dif = $tot_costos - $tot_ingresos;
  ?>
    <tr>
      <td align="right" colspan='6'>Total ingresos:</td>
      <td align="right"><?=number_format($tot_ingresos,0,'.','.')?></td> 
    </tr>
  <tr>
    <td align="center" colspan='7'>&nbsp;</td>
  </tr>
  <tr>
    <td class="ctablasup" align="center" colspan='9'>ESTADO DE CUENTA</td>
  </tr>
   <tr>
      <td align="right" colspan='6'>DIFERENCIA:</td>
      <td align="right"><? if($dif > 0){?><span class='textorojo'><?=number_format($dif,'0',',','.')?></span><? } else {?><span class='textoverde'><?=number_format($dif,'0',',','.')?></span><? } ?></td> 
   </tr>
    <tr>
      <td align="center" colspan='9'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" /><input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" /></td>
    </tr>
</table>
</body>
</html>
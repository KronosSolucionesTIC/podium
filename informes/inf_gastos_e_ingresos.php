<?
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
<title>INFORME GASTOS E INGRESOS</title>
</head>
<body>
<table width="731" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='4'>INFORME GASTOS E INGRESOS</td>
  </tr>
  <tr>
    <td align="center">FECHA</td>
    <td align="center">AFILIADO</td>
    <td align="center">TIPO INGRESO</td>
    <td align="center">VALOR</td>
  </tr>
  <?php 
  //CONSULTA LOS INGRESOS
  $tot_ing = 0;
  $dbi = new database();
  $sqli = "SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) as afi  FROM ingresos
  INNER JOIN tipo_ingresos ON tipo_ingresos.cod_ting = ingresos.tipo_ing
  INNER JOIN afiliado ON afiliado.cod_afi = ingresos.afi_ing
  WHERE estado_ing = 1 AND (fec_ing >= '$fec_ini' AND fec_ing <= '$fec_fin')";
  $dbi->query($sqli);
  while($dbi->next_row()){
  ?>
   <tr>
    <td align="center"><?php echo $dbi->fec_ing?></td>
    <td><?php echo $dbi->afi?></td>
    <td><?php echo $dbi->nom_ting?></td>
    <td align="right"><?php echo number_format($dbi->val_ing,'0',',','.')?></td>
  </tr>
  <?php 
  $tot_ing = $tot_ing + $dbi->val_ing;
  } 
  ?>
  <tr>
    <td align="right" colspan='3'>Total ingresos:</td>
    <td align="right"><?php echo number_format($tot_ing,'0',',','.')?></td>
  </tr>
  <tr>
    <td align="right" colspan='4'>&nbsp;</td>
  </tr>
    <tr>
    <td align="center">FECHA</td>
    <td align="center">PROVEEDOR</td>
    <td align="center">TIPO GASTO</td>
    <td align="center">VALOR</td>
  </tr>
  <?php 
  //CONSULTA LOS GASTOS
  $tot_gas = 0;
  $dbg = new database();
  $sqlg = "SELECT *,CONCAT(nom1_prov,' ',nom2_prov,' ',apel1_prov,' ',apel2_prov) as prov FROM gastos
  INNER JOIN tipo_gastos ON tipo_gastos.cod_gas = gastos.tipo_gasto
  INNER JOIN proveedor ON proveedor.cod_prov = gastos.prov_gasto
  WHERE estado_gasto = 1 AND (fecha_gasto >= '$fec_ini' AND fecha_gasto <= '$fec_fin')";
  $dbg->query($sqlg);
  while($dbg->next_row()){
  ?>
   <tr>
    <td align="center"><?php echo $dbg->fecha_gasto?></td>
    <td><?php echo $dbg->prov?></td>
    <td><?php echo $dbg->nom_gas?></td>
    <td align="right"><?php echo number_format($dbg->valor_gasto,'0',',','.')?></td>
  </tr>
  <?php 
  $tot_gas = $tot_gas + $dbg->valor_gasto;
  } 

  $dif = $tot_ing - $tot_gas;
  ?>
  <tr>
    <td align="right" colspan='3'>Total gastos:</td>
    <td align="right"><?php echo number_format($tot_gas,'0',',','.')?></td>
  </tr>
   <tr>
    <td align="right" colspan='3'>DIFERENCIA:</td>
    <td align="right"><?php if($dif < 0){?><span class='textorojo'><?php echo number_format($dif,'0',',','.')?></span><?php } else {?><?php echo number_format($dif,'0',',','.')?><?php } ?></td>
  </tr> 
    <tr>
      <td align="center" colspan='4'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" />
        <input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" />
        <input type="hidden" name="mapa" value="<?php echo $mapa?>"></td>
    </tr>
</table>
</body>
</html>
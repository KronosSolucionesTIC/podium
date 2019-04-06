<?php 
include("../lib/database.php");
include("../js/funciones.php");
?>
<?php
//RECIBE LAS VARIABLES
$cod_afi = $_REQUEST['cod_afi'];
$cod_cat = $_REQUEST['cod_cat'];
?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>INFORME CIERRE DE CAJA</title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='11'>INFORME AFILIADOS</td>
  </tr>
  <tr>
    <td align="center">NOMBRE COMPLETO</td>
    <td align="center">TIPO DE IDEN</td>
    <td align="center">No IDEN</td>
    <td align="center">CATEGORIA</td>
    <td align="center">FECHA DE NACIMIENTO</td>
    <td align="center">EDAD</td>
    <td align="center">TELEFONO</td>
    <td align="center">EPS</td>
    <td align="center">COPIA EPS</td>
    <td align="center">COPIA DOC</td>
    <td align="center">FOTO</td>
  </tr>
  <?php 
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
  ?>
   <tr>
    <td><?=$db->nombre?></td>
    <?php 
    //CONSULTA EL TIPO DE IDENTIFICACION
    $dbti = new database();
    $sqlti = "SELECT * FROM tipo_identificacion
    WHERE estado_tiden = 1 AND cod_tiden = $db->tiden_afi";
    $dbti->query($sqlti);
    $dbti->next_row();
    ?>
    <td><?=$dbti->nom_tiden?></td>
    <td align="center"><?=$db->id_afi?></td>

    <?php 
    //CONSULTA LA CATEGORIA
    $dbc = new database();
    $sqlc = "SELECT * FROM categoria
    WHERE estado_cat = 1 AND cod_cat = $db->cat_afi";
    $dbc->query($sqlc);
    $dbc->next_row();
    ?>

    <td><?=$dbc->nom_cat?></td>
    <td><?php echo $db->fnac_afi?></td>

    <?php 
    //CALCULA LA EDAD
    $dbed = new database();
    $sqled = "SELECT DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(`fnac_afi`)), '%Y')+0 AS edad FROM afiliado
    WHERE cod_afi = $db->cod_afi";
    $dbed->query($sqled);
    $dbed->next_row();
    ?>

    <td align="center"><?=$dbed->edad?></td>

    <?php 
    //CONSULTA LA EPS
    $dbe = new database();
    $sqle = "SELECT * FROM eps
    WHERE estado_eps= 1 AND cod_eps = $db->eps_afi";
    $dbe->query($sqle);
    $dbe->next_row();
    ?>

    <td><?php echo $db->cel1_afi?></td>
    <td><?=$dbe->nom_eps?></td>
    <td align="center"><?php if($db->copia_eps == ""){?>Sin copia eps<?} else {?>OK<?php }?></td>
    <td align="center"><?php if($db->copia_doc == ""){?>Sin copia doc<?} else {?>OK<?php }?></td>
    <td align="center"><?php if($db->foto_afi == ""){?>Sin foto<?} else {?>OK<?php }?></td>
  </tr>
  <?php 
  $tot_afi++;
	}
  ?>
    <tr>
      <td align="center" colspan='11'>Total afiliados:<?=$tot_afi?></td>
    </tr>
    <tr>
      <td align="center" colspan='11'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" /><input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" /></td>
    </tr>
</table>
</body>
</html>
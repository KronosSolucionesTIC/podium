<?php 
include("../lib/database.php");
include("../js/funciones.php");
?>
<?php
//RECIBE LAS VARIABLES
$cod_afi = $_REQUEST['codigo'];
//

//CONSULTA LA INFORMACION
$db = new database();
$sql = "SELECT * FROM afiliado
WHERE cod_afi = $cod_afi";
$db->query($sql);
$db->next_row();
//

?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>INFORME CIERRE DE CAJA</title>
</head>
<body>
<table width="500" border="1" cellpadding="2" cellspacing="1" class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='9'>CARNET DE AFILIACION</td>
  </tr>
  <tr>
    <th ROWSPAN='7'><img src="<?php echo '../'.$db->foto_afi?>" width='70%' height='auto'></th>
      <tr>    
        <td>NOMBRES</td>
        <td><?php echo $db->nom1_afi;?> <?php echo $db->nom2_afi; ?></td>
      </tr>
      <tr>
        <td>APELLIDOS</td>
        <td><?php echo $db->apel1_afi;?> <?php echo $db->apel2_afi; ?></td>
      </tr> 
      <tr> 
        <td>No IDENTIDAD</td>
        <td><?php echo $db->id_afi;?></td>
      </tr>
        <td>CATEGORIA</td>
        <?php
        //CONSULTA LA CATEGORIA
        $dbc = new database();
        $sqlc = "SELECT * FROM categoria
        WHERE cod_cat = $db->cat_afi";
        $dbc->query($sqlc);
        $dbc->next_row(); 
        //
        ?>
        <td><?php echo $dbc->nom_cat;?></td>
      <tr>
        <td>EPS</td>
        <?php
        //CONSULTA LA EPS
        $dbe = new database();
        $sqle = "SELECT * FROM eps
        WHERE cod_eps = $db->eps_afi";
        $dbe->query($sqle);
        $dbe->next_row(); 
        //
        ?>
        <td><?php echo $dbe->nom_eps;?></td>
      </tr>
      <tr>
        <td>RH</td>
        <td><?php echo $db->rh_afi;?></td>
      </tr>
  </tr>
    <tr>
      <td align="center" colspan='9' class='carnet'>ESTE DOCUMENTOS ES PERSONAL E INSTRANSFERIBLE, IDENTIFICA AL PROPIETARIO COMO AFILIADO A : METALICAS WILLIAM F.C., EN CASO DE PERDIDA COMUUNICARSE A LOS SIGUIENTES NUMEROS:</td>
    </tr>
    <tr>
      <td align="center" colspan='9'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" /><input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" /></td>
    </tr>
</table>
</body>
</html>
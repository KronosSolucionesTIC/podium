<?php include("../../lib/database.php");?>
<?php include("../../js/funciones.php");?>
<? 
//CODIGO PARA GUARDAR COMO WORD
header ( "Content-type: application/vnd.ms-word" );
header ( "Content-Disposition: attachment; filename=Planilla_inscripcion.doc" );
//

//RECIBE LAS VARIABLES
$cod_afi = $_REQUEST['cod_afi'];
$cod_cat = $_REQUEST['cod_cat'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=$nombre_aplicacion?></title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1"   class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='11'>PLANILLA INSCRIPCION</td>
  </tr>
  <tr>
    <td align="center">NOMBRE COMPLETO</td>
    <td align="center">No IDEN</td>
    <td align="center">TELEFONO</td>
    <td align="center">CELULAR 1</td>
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
    <td align="center"><?=$db->id_afi?></td>
    <td align="center"><?php echo $db->tel_afi?></td>
    <td align="center"><?php echo $db->cel1_afi?></td>
  </tr>
  <?php 
  $tot_afi++;
	}
  ?>
    <tr>
      <td align="center" colspan='11'>Total afiliados:<?=$tot_afi?></td>
    </tr>
</table>
</body>
</html>
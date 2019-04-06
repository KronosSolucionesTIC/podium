<?php 
include("../lib/database.php");
include("../js/funciones.php");
?>
<?php
//RECIBE LAS VARIABLES
$cod_ing = $_REQUEST['codigo'];
//

//CONSULTA LA INFORMACION
$db = new database();
$sql = "SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) as nombre FROM ingresos
INNER JOIN tipo_ingresos ON tipo_ingresos.cod_ting = ingresos.tipo_ing
INNER JOIN afiliado ON afiliado.cod_afi = ingresos.afi_ing
WHERE cod_ing = $cod_ing";
$db->query($sql);
$db->next_row();
//

//CONSULTA LOS DATOS DE LA ESCUELA
$dbe = new database();
$sqle = "SELECT * FROM rsocial";
$dbe->query($sqle);
$dbe->next_row();
//

?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<title>RECIBO INGRESO</title>
</head>
<body>
<table width="100%" border="1" cellpadding="2" cellspacing="1" class="textoproductos1" align="center">
  <tr>
    <td class="ctablasup" align="center" colspan='9'>RECIBO DE PAGO</td>
  </tr>
    <tr>
      <td colspan='2' class='enunciados'><?php echo  $dbe->nom_rso?><br>
        <?php echo  $dbe->nit_rso?><br>
        <?php echo  $dbe->dir_rso?><br>
        <?php echo  $dbe->tel_rso?><br>
        <?php echo  $dbe->email?><br>
      </td>
    </tr>
  <tr>   
    <td colspan='2' align='center'><span class='enunciados'>RECIBO DE PAGO No <?php echo $db->cod_ing?></span></td>
  </tr>
  <tr>
    <td width='50%'>FECHA INGRESO:</td>
    <td><div align='right'><?php echo $db->fec_ing?></div></td>
  </tr> 
  <tr> 
    <td>RECIBI(MOS) DE:</td>
    <td><div align='right'><?php echo $db->nombre?></div></td>
  </tr>
    <td>LA SUMA DE:</td>
    <td><div align='right'><?php echo number_format($db->val_ing,0,",",".")?></div></td>
  <tr>
    <td>POR CONCEPTO DE:</td>
    <td><div align='right'><?php echo $db->nom_ting?></div></td>
  </tr>
  <tr>
    <td>RECIBIDO POR:</td>
    <?php 
    //CONSULTA EL AFILIADO
    $dba = new database();
    $sqla = "SELECT CONCAT(nom1_pro,' ',nom2_pro,' ',apel1_pro,' ',apel2_pro) as nombre FROM profesor
    WHERE cod_pro = $db->pro_ing";
    $dba->query($sqla);
    $dba->next_row();
    // 
    ?>
    <td><div align='right'><?php echo $dba->nombre?></div></td>
  </tr>
  <tr>
    <td>OBSERVACIONES:</td>
    <td align='right'>FIRMA Y SELLO:</td>
  </tr>
  <tr>    
    <td>&nbsp;<br><br><br></td>
    <td>&nbsp;<br><br><br></td>
  </tr>
</tr>
    <tr>
      <td class='carnet' colspan='2'><div align='center'>COPIA AFILIADO</div></td>
    </tr>
    <tr>
      <td colspan='2'><hr style="border:1px dotted; width:100%" /></td>
    </tr>
    <tr>
      <td colspan='2' class='enunciados'><?php echo  $dbe->nom_rso?><br>
        <?php echo  $dbe->nit_rso?><br>
        <?php echo  $dbe->dir_rso?><br>
        <?php echo  $dbe->tel_rso?><br>
        <?php echo  $dbe->email?><br>
      </td>
    </tr>
  <tr>
      <tr>    
        <td colspan='2' align='center'><span class='enunciados'>RECIBO DE PAGO No <?php echo $db->cod_ing?></span></td>
      </tr
      <tr>
        <td>FECHA INGRESO:</td>
        <td><div align='right'><?php echo $db->fec_ing?></div></td>
      </tr> 
      <tr> 
        <td>RECIBI(MOS) DE:</td>
        <td><div align='right'><?php echo $db->nombre?></div></td>
      </tr>
        <td>LA SUMA DE:</td>
        <td><div align='right'><?php echo number_format($db->val_ing,0,",",".")?></div></td>
      <tr>
        <td>POR CONCEPTO DE:</td>
        <td><div align='right'><?php echo $db->nom_ting?></div></td>
      </tr>
      <tr>
        <td>RECIBIDO POR:</td>
        <?php 
        //CONSULTA EL AFILIADO
        $dba = new database();
        $sqla = "SELECT CONCAT(nom1_pro,' ',nom2_pro,' ',apel1_pro,' ',apel2_pro) as nombre FROM profesor
        WHERE cod_pro = $db->pro_ing";
        $dba->query($sqla);
        $dba->next_row();
        // 
        ?>
        <td><div align='right'><?php echo $dba->nombre?></div></td>
      </tr>
  <tr>
    <td>OBSERVACIONES:</td>
    <td align='right'>FIRMA Y SELLO:</td>
  </tr>
  <tr>    
    <td>&nbsp;<br><br><br></td>
    <td>&nbsp;<br><br><br></td>
  </tr>
  </tr>
    <tr>
      <td class='carnet' colspan='2'><div align='center'>COPIA ADMINISTRATIVA</div></td>
    </tr>
    <tr>
      <td align="center" colspan='9'><input name="button" type="button" class="botones"  onClick="window.print()" value="Imprimir" /><input name="button2" type="button" class="botones"  onClick="window.close()" value="Cerrar" /></td>
    </tr>
</table>
</body>
</html>
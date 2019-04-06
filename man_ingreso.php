<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!=0) {
$sql ="SELECT * FROM ingresos  WHERE cod_ing = $codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}

if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAT REGISTROS NUEVOS
  $compos="(tipo_ing,pro_ing,afi_ing,fec_ing,val_ing,obs_ing)";
  $valores="('".$_REQUEST['tipo_ingresos']."','".$_REQUEST['pro_ing']."','".$_REQUEST['afi_ing']."','".$_REQUEST['fecha']."','".$_REQUEST['valor_ing']."','".$_REQUEST['desc']."')" ;
  $error=insertar("ingresos",$compos,$valores); 
  if ($error==1) {
    header("Location: con_ingresos.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
  }
  else
    echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
  $compos="fec_ing='".$_REQUEST['fecha']."',tipo_ing='".$_REQUEST['tipo_ingresos']."',pro_ing='".$_REQUEST['pro_ing']."',afi_ing='".$_REQUEST['afi_ing']."',val_ing='".$_REQUEST['valor_ing']."',obs_ing='".$_REQUEST['desc']."'"; 
  $error=editar("ingresos",$compos,'cod_ing',$codigo); 
  if ($error==1) {
    header("Location: con_ingresos.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
  }
  else
    echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
body {
  margin-left: 0px;
  margin-top: 0px;
  margin-right: 0px;
  margin-bottom: 0px;
}
.Estilo1 {font-size: 12px}
</style> 

<?php inicio() ?>

<script language="javascript">
function datos_completos(){  
if (document.getElementById('fecha').value == "" && document.getElementById('valor_ing').value == "")
  return false;
else
  return true;
}
</script>

</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_ingreso.php"  method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF" >&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
        <td valign="middle" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
         <td width="5" height="19">&nbsp;</td>
        <td width="20" ><img src="imagenes/icoguardar.png" alt="Nueno Registro" width="16" height="16" border="0"  onclick="cambio_guardar()" style="cursor:pointer"/></td>
        <td width="61" class="ctablaform">Guardar</td>
        <td width="21" class="ctablaform"><a href="con_ingresos.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform"></td>
        <td width="70" class="ctablaform"></td>
        <td width="21" class="ctablaform"></td>
        <td width="60" class="ctablaform">&nbsp;</td>
        <td width="24" valign="middle" class="ctablaform">&nbsp;</td>
        <td width="193" valign="middle"><label>
          <input type="hidden" name="editar"   id="editar"   value="<?php echo $editar?>">
      <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
      <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
          <input type="hidden" name="codigo" id="codigo" value="<?php echo $codigo?>" />
        </label></td>
        <td width="67" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="4" valign="bottom"><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="textotabla1 Estilo1">INGRESOS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Fecha:</td>
        <td><input name="fecha" type="text" class="fecha" id="fecha" readonly="1" value="<?php echo $dbdatos->fec_ing?>"/><a href="#"><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario"/></a></td>
        <td><span class="textorojo">*</span></td>
        <td class="textotabla1">Tipo de ingreso:</td>
        <td><?php combo_evento("tipo_ingresos","tipo_ingresos","cod_ting","nom_ting", $dbdatos->tipo_ing,"","nom_ting");  ?><span class="textorojo">*</span></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Responsable:</td>
        <td><?php combo_evento_where("pro_ing","profesor","cod_pro","CONCAT(nom1_pro,' ',nom2_pro,' ',apel1_pro,' ',apel2_pro)",$dbdatos->pro_ing,""," where estado_pro = 1 order by nombre");?><span class="textorojo">*</span></td>
        <td><span class="textorojo">*</span></td>
        <td><span class="textotabla1">Afiliado: </span></td>
        <td><?php combo_evento_where("afi_ing","afiliado","cod_afi","CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi)",$dbdatos->afi_ing,""," where estado_afi = 1 ORDER BY nombre");  ?><span class="textorojo">*</span></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>    
     <tr>
        <td class="textotabla1">Valor:</td>
        <td><input name="valor_ing" id="valor_ing" type="text" class="textfield2"  value="<?php echo $dbdatos->val_ing?>"  onkeypress="  return validaInt()" /></td>
        <td><span class="textorojo">*</span></td>
        <td><span class="textotabla1">Observacion: </span></td>
        <td><textarea name="desc" cols="35" rows="4" class="textfield02"><?php echo $dbdatos->obs_ing?></textarea></td>
        <td class="textorojo">&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
    
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td class="textorojo">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  
  <tr>
    <td><div align="center"><img src="imagenes/spacer.gif" alt="." width="624" height="4" /></div></td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif"  width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
  </td>
  </tr>
</table>
</form> 
<script type="text/javascript">
      Calendar.setup(
        {
        inputField  : "fecha",      
        ifFormat    : "%Y-%m-%d",    
        button      : "calendario" ,  
        align       :"T3",
        singleClick :true
        }
      );
</script>
</body>
</html>
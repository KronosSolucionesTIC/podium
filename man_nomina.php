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

$sql ="SELECT * FROM m_nomina WHERE cod_nom = $codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$compos="(del_nom,cam_nom,cat_nom)";
	$valores="('".$_REQUEST['profesor']."','".$_REQUEST['campeonato']."','".$_REQUEST['categoria']."')" ;
	$ins_id =insertar_maestro("m_nomina",$compos,$valores); 

  if($ins_id > 0){

    for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_nom,cod_afi)";
      $valores="('".$ins_id."','".$_REQUEST['cod_afi_'.$ii]."')" ;
      $error = insertar("d_nomina",$compos,$valores); 
    }

    header("Location: con_nomina.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
  }

	else
		echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS

	$compos="del_nom='".$_REQUEST['profesor']."',cam_nom='".$_REQUEST['campeonato']."',cat_nom='".$_REQUEST['categoria']."'";
	$error=editar("m_nomina",$compos,'cod_nom',$codigo); 

  $error=eliminar("d_nomina",$codigo,"cod_nom");

  for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_nom,cod_afi)";
      $valores="('".$codigo."','".$_REQUEST['cod_afi_'.$ii]."')" ;
      $error = insertar("d_nomina",$compos,$valores); 
  }

	if ($error==1) {
		header("Location: con_nomina.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
<link href="css/styles.css" rel="stylesheet" type="text/css" /> 
<?php inicio() ?>
<script language="javascript">
function datos_completos(){  
if (document.getElementById('profesor').value == 0 || document.getElementById('campeonato').value == "" || document.getElementById('categoria').value == "")
	return false;
else
	return true;
}

function  adicion() 
{
  if(document.getElementById("afiliado").value>0) 
  {
    Agregar_html_afiliado();
    document.getElementById('afiliado').value = 0;  
  }
  else 
  {
    alert("Ingrese una Referencia Valida junto con los demas Valores")
  }

}

</script>
<script type="text/javascript" src="js/js.js"></script>
</head>
<body <?php echo $sis?>>
<form  name="forma" id="forma" action="man_nomina.php"  method="post">
<table width="624" border="0" cellspacing="0" cellpadding="0" align="center" >
  <tr>
    <td bgcolor="#FFF"><table width="100%" height="46" border="0" cellpadding="0" cellspacing="0">
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
        <td width="21" class="ctablaform"><a href="con_nomina.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
        <td width="22" class="ctablaform">&nbsp;</td>
        <td width="70" class="ctablaform">&nbsp;</td>
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
    <td class="textotabla2">NOMINA:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td class="tablacabezera" valign="top">
	<table width="629" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="textotabla1">Delegado:</td>
        <td><?php combo_evento_where("profesor","profesor","cod_pro","CONCAT(nom1_pro,' ',nom2_pro,' ',apel1_pro,' ',apel2_pro)",$dbdatos->del_nom,""," where estado_pro = 1 order by nombre");?></td>
        <td><span class="textorojo">*</span></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td class="textotabla1">Campeonato:</td>
        <td><?php combo_evento_where("campeonato","campeonato","cod_cam","nom_cam",$dbdatos->cam_nom,""," where estado_cam = 1 ORDER BY nom_cam")?></td>
        <td></td>
        <td><span class="textotabla1">Categoria:</span></td>
        <td><?php combo_evento_where("categoria","categoria","cod_cat","nom_cat",$dbdatos->cat_nom,""," where estado_cat = 1"); ?></td>
        <td class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <table width='100%'>
        <tr>
          <td class="ctablasup" width='70%'>Afiliado</td>
          <td class="ctablasup" align="center" width='30%'>Agregar:</td>
        </tr>
        <tr >
          <td ><?php combo_evento_where("afiliado","afiliado","cod_afi","CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi)","",""," where estado_afi = 1 ORDER BY nombre");  ?></td>
          <td align="center"><input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">      </td>
        </tr>
      </table>
      <table width="100%">
        <tr id="fila_0">
        <td  class="ctablasup" width='70%'>Afiliado</td>
          <td class="ctablasup" align="center" width='30%'>Borrar:</td>
        </tr>
        <?php
        if ($codigo!=0) { // BUSCAR DATOS
          $sql ="SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) as nombre FROM d_nomina
          INNER JOIN m_nomina ON m_nomina.cod_nom = d_nomina.cod_nom
          INNER JOIN afiliado ON afiliado.cod_afi = d_nomina.cod_afi
          where m_nomina.cod_nom = $codigo
          ORDER BY nombre";//=    
          $dbdatos_1= new  Database();
          $dbdatos_1->query($sql);
          $jj=1;
          //echo "<table width='100%'>";
          while($dbdatos_1->next_row()){ 
            echo "<tr id='fila_$jj'>";
            
            //cmarca
            echo "<td  ><INPUT type='hidden'  name='cod_afi_$jj' id='cod_afi_$jj' value='$dbdatos_1->cod_afi'><span class='textfield01'>$dbdatos_1->nombre</span> </td>"; 
                       
            //boton q quita la fila
            if ($codigo != 0) {
            echo "<td><div align='center'><INPUT type='button' class='botones' value='  -  ' onclick='removerFila_afiliado(\"fila_$jj\",\"val_inicial\",\"fila_\");'>
            </div></td>";
            }
            echo "</tr>";
            $jj++;
          }
        }
        ?>
        </table>               
      <tr>
    <td>
  <input type="text" name="val_inicial" id="val_inicial" value="<?php if($codigo!=0) echo $jj-1; else echo "0"; ?>" readonly='readonly'/>
     <?php  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
     <input type="hidden" id="valDoc_inicial" value="<?php echo $valueInicial?>"> 
     <input type="hidden" name="cant_items" id="cant_items" value=" <?php  if ($codigo!="") echo $aa; else echo "0"; ?>">
  </td>
  </tr>
  </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td height="30"  > <input type="hidden" name="guardar" id="guardar" />
	</td>
  </tr>
</table>
</form> 
</body>
</html>
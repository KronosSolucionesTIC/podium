<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?

//RECIBE LAS VARIABLES
$codigo = $_REQUEST['codigo'];
$guardar = $_REQUEST['guardar'];
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];

if ($codigo!=0) {

$sql ="SELECT *  FROM m_costos 
INNER JOIN d_costos ON d_costos.cod_mcosto = m_costos.cod_mcosto
WHERE m_costos.cod_mcosto=$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

  $compos="(tipo_baremos,genero_baremos,edad_baremos,valor_baremos,puntos_baremos)";
  for($ii=1; $ii <= $_REQUEST['val_inicial']; $ii++){
    $valores="('".$_REQUEST['tipo_'.$ii]."','".$_REQUEST['genero_'.$ii]."','".$_REQUEST['edad_'.$ii]."','".$_REQUEST['valor_'.$ii]."','".$_REQUEST['puntos_'.$ii]."')" ;
    $error=insertar("baremos",$compos,$valores);
  }

  if ($error==1) {
    header("Location: con_baremos.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
  }
  else
    echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
  $compos="afi_mcosto='".$_REQUEST['afiliado']."',tot_mcosto=".$_REQUEST['todocompra']."";
  $error=editar("m_costos",$compos,'cod_mcosto',$codigo); 

  $error=eliminar("d_costos",$codigo,"cod_mcosto");

  $compos="(cod_mcosto,val_dcosto,fec_dcosto,tipo_dcosto)";
  for($ii=1; $ii <= $_REQUEST['val_inicial']; $ii++){
    $valores="('".$codigo."','".$_REQUEST['valor_'.$ii]."','".$_REQUEST['fecha_'.$ii]."','".$_REQUEST['costos_'.$ii]."')" ;
    $error=insertar("d_costos",$compos,$valores);
  }

  if ($error==1) {
    header("Location: con_baremos.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
//if (document.getElementById('todocompra').value > 0 )
  //return false;
//else
  return true;
}

//LISTA LA OPCION
function  adicion() 
{
  if(document.getElementById("tipo_baremos").value>0) {
    Agregar_html_baremos();   
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
<form  name="forma" id="forma" action="man_baremos.php"  method="post">
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
        <td width="21" class="ctablaform"><a href="con_baremos.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
        <td width="65" class="ctablaform">Cancelar </td>
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
    <td class="textotabla1 Estilo1">BAREMOS:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td valign="top">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan='4' class="textotabla1">&nbsp;</td>
      </tr>
     <tr>
    <table  width="100%" border="1">        
      <tr >
        <td class="ctablasup">TIPO BAREMOS</td>
        <td class="ctablasup">GENERO</td>
        <td class="ctablasup">EDAD</td>
        <td class="ctablasup">VALOR</td>
        <td class="ctablasup">PUNTOS</td>
        <td width="4%" class="ctablasup" align="center">Agregar:</td>
      </tr>
      <tr >
        <td align="center"><?php combo_evento_where("tipo_baremos","tipo_baremos","cod_tipob","nom_tipob","",""," where estado_tipob = 1 ORDER BY nom_tipob");  ?></td>
        <td align="center"><?php combo_evento_where("genero","genero","cod_genero","nom_genero","",""," where estado_genero = 1 ORDER BY nom_genero");  ?></td>
        <td align="center"><input type='text' id='edad' name='edad' value='0'></td>
        <td align="center"><input type='text' id='valor' name='valor' value='0'></td>
        <td align="center"><input type='text' id='puntos' name='puntos' value='0'></td>
        <td align="center"><input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">      </td>
      </tr> 
      <tr >
      <td  colspan="9">
        <table width="100%">
        <tr id="fila_0">
        <td class="ctablasup">TIPO BAREMOS</td>
        <td class="ctablasup">GENERO</td>
        <td class="ctablasup">EDAD</td>
        <td class="ctablasup">VALOR</td>
        <td class="ctablasup">PUNTOS</td>
        <td width="4%" class="ctablasup" align="center">Borrar:</td>
        </tr>
        <?
        if ($codigo!="") { // BUSCAR DATOS
          $sql =" SELECT * FROM d_costos
          INNER JOIN m_costos ON m_costos.cod_mcosto = d_costos.cod_mcosto
          INNER JOIN costos ON costos.cod_costo = d_costos.tipo_dcosto
          WHERE m_costos.cod_mcosto = $codigo";//=    
          $dbdatos_1= new  Database();
          $dbdatos_1->query($sql);
          $jj=1;
          //echo "<table width='100%'>";
          while($dbdatos_1->next_row()){ 
            echo "<tr id='fila_$jj'>";
            
            //TIPO DE COSTO
            echo "<td  ><INPUT type='hidden'  name='costos_$jj' value='$dbdatos_1->tipo_dcosto'><span class='textfield01'> $dbdatos_1->nom_costo </span> </td>"; 
            
            //VALOR
            echo "<td><INPUT type='hidden'  name='valor_$jj' value='$dbdatos_1->val_dcosto'><span  class='textfield01'> $dbdatos_1->val_dcosto</span> </td>";
            
            //FECHA
            echo "<td  ><INPUT type='hidden'  name='fecha_$jj' value='$dbdatos_1->fec_dcosto'><span  class='textfield01'> $dbdatos_1->fec_dcosto</span> </td>";
            
            //boton q quita la fila
            echo "<td><div align='center'>  
<INPUT type='button' class='botones' value='  -  ' onclick='removerFila_costo(\"fila_$jj\",\"val_inicial\",\"fila_\",\"$dbdatos_1->val_dcosto\");'>
            </div></td>";

            echo "</tr>";
            $jj++;
          }
        }
        ?>
        </table>      </td>
      </tr>     
     <tr >
      <td  colspan="9">
        <table width="100%">
        <tr >
        <td  class="ctablasup"><div align="right">Resumen Entrada </div></td>
        </tr>
        <tr >
        <td ><div align="right" >Total:
            <input name="todocompra" id="todocompra" type="text" class="textfield01" readonly="1" value="<?php if($codigo !=0) echo $dbdatos->tot_mcosto; else echo "0"; ?>"/>
        </div>          </td>
        </tr>
        </table>      </td>
      </tr>
    </table>  
      </table>
      </td>
     </tr>
    </table></td>
  </tr>
  
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
  <input type="hidden" name="val_inicial" id="val_inicial" value="<?php if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
  <input type="hidden" name="guardar" id="guardar" />
     <?php  if ($codigo!="") $valueInicial = $aa; else $valueInicial = "1";?>
     <input type="hidden" id="valDoc_inicial" value="<?php echo $valueInicial?>"> 
     <input type="hidden" name="cant_items" id="cant_items" value=" <?php  if ($codigo!="") echo $aa; else echo "0"; ?>">
  </td>
  </tr>
</table>
</form> 
</body>
</html>
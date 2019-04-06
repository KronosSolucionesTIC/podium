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

$sql ="SELECT *  FROM m_programacion WHERE cod_pro =$codigo";
$dbdatos= new  Database();
$dbdatos->query($sql);
$dbdatos->next_row();
}


if($guardar==1 and $codigo==0) { // RUTINA PARA  INSERTAR REGISTROS NUEVOS

	$compos="(cam_pro,lug_pro,fec_pro)";
	$valores="('".$_REQUEST['campeonato']."','".$_REQUEST['parque']."','".$_REQUEST['fecha']."')" ;
	$ins_id = insertar_maestro("m_programacion",$compos,$valores); 

  if($ins_id > 0){

    for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_prog,cat_dprog,equi1_dprog,equi2_dprog,hora_dprog,nom_fec,fase_dprog)";
      $valores="('".$ins_id."','".$_REQUEST['cod_cat_'.$ii]."','".$_REQUEST['cod_equi1_'.$ii]."','".$_REQUEST['cod_equi2_'.$ii]."','".$_REQUEST['hora_'.$ii]."','".$_REQUEST['nom_fec_'.$ii]."','".$_REQUEST['cod_fase_'.$ii]."')" ;
      $error = insertar("d_programacion",$compos,$valores); 
    }

    header("Location: con_programacion.php?confirmacion=1&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
  }

  else
    echo "<script language='javascript'> alert('Hay un error en los Datos, Intente Nuevamente ') </script>" ; 
}

if($guardar==1 and $codigo!=0) { // RUTINA PARA  editar REGISTROS NUEVOS
	$compos="cam_pro='".$_REQUEST['campeonato']."',lug_pro='".$_REQUEST['parque']."',fec_pro='".$_REQUEST['fecha']."'";
	$error=editar("m_programacion",$compos,'cod_pro',$codigo); 

  $error=eliminar("d_programacion",$codigo,"cod_prog");

    for($ii = 1; $ii <= $_REQUEST['val_inicial']; $ii++){
      $compos="(cod_prog,cat_dprog,equi1_dprog,equi2_dprog,hora_dprog,nom_fec,fase_dprog)";
      $valores="('".$codigo."','".$_REQUEST['cod_cat_'.$ii]."','".$_REQUEST['cod_equi1_'.$ii]."','".$_REQUEST['cod_equi2_'.$ii]."','".$_REQUEST['hora_'.$ii]."','".$_REQUEST['nom_fec_'.$ii]."','".$_REQUEST['cod_fase_'.$ii]."')" ;
      $error = insertar("d_programacion",$compos,$valores); 
    }

	if ($error==1) {
		header("Location: con_programacion.php?confirmacion=2&editar=$editar&insertar=$insertar&eliminar=$eliminar"); 
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
if (document.getElementById('campeonato').value == 0 || document.getElementById('fecha').value == "" )
	return false;
else
	return true;
}

//CARGA LOS EQUIPOS SEGUN LA CATEGORIA
function cargar_equipo(equipo1,equipo2,categoria){
//EQUIPO 1
var combo1=document.getElementById(equipo1);
combo1.options.length=0;
var cant1=0;
combo1.options[cant1] = new Option('Seleccione...','0'); 
cant1++;

<?
    $i=0;
    $sqlc ="SELECT * FROM `equipo` ";   
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById(categoria).value==$dbc->cat_equi){ "; 
    echo "combo1.options[cant1] = new Option('$dbc->nom_equi','$dbc->cod_equi'); ";
    echo "cant1++; } ";
    }
?>

//EQUIPO 2
var combo2=document.getElementById(equipo2);
combo2.options.length=0;
var cant2=0;
combo2.options[cant2] = new Option('Seleccione...','0'); 
cant2++;

<?
    $i=0;
    $sqlc ="SELECT * FROM `equipo` ";   
    $dbc= new  Database();
    $dbc->query($sqlc);
    while($dbc->next_row()){ 
    echo "if(document.getElementById(categoria).value==$dbc->cat_equi){ "; 
    echo "combo2.options[cant2] = new Option('$dbc->nom_equi','$dbc->cod_equi'); ";
    echo "cant2++; } ";
    }
?>

}

function  adicion() 
{
  if(document.getElementById("categoria").value>0) 
  {
    Agregar_html_encuentro();
    document.getElementById('categoria').value = 0;  
    document.getElementById('equipo1').value = 0; 
    document.getElementById('equipo2').value = 0; 
    document.getElementById('HI').value = ""; 
    document.getElementById('MI').value = ""; 
    document.getElementById('SI').value = ""; 
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
<form  name="forma" id="forma" action="man_programacion.php"  method="post">
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
        <td width="21" class="ctablaform"><a href="con_programacion.php?confirmacion=0&editar=<?php echo $editar?>&insertar=<?php echo $insertar?>&eliminar=<?php echo $eliminar?>"><img src="imagenes/cancel.png" alt="Cancelar" width="16" height="16" border="0" /></a></td>
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
    <td class="textotabla1 Estilo1">PROGRAMACION:</td>
  </tr>
  <tr>
    <td><img src="imagenes/lineasup3.gif" alt="." width="100%" height="4" /></td>
  </tr>
  <tr>
    <td valign="top">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="78" class="textotabla1">Campeonato:</td>
        <td><?php combo_evento_where("campeonato","campeonato","cod_cam","nom_cam",$dbdatos->cam_pro,""," where estado_cam = 1 order by nom_cam"); ?></td>
        <td width="9"><span class="textorojo">*</span></td>
        <td width="64"><span class="textotabla1">Lugar:</span></td>
        <td><?php combo_evento_where("parque","parque","cod_par","nom_par",$dbdatos->lug_pro,""," where estado_par = 1 ORDER BY nom_par")?></td>
        <td></td>
        <td width="173" class="textorojo">&nbsp;</td>
      </tr>
      <tr>
        <td class="textotabla1">Fecha:</td>
        <td><input name="fecha" type="text" class="fecha" id="fecha" value="<?php echo $dbdatos->fec_pro ?>" /><img src="imagenes/date.png" alt="Calendario" name="calendario" width="16" height="16" border="0" id="calendario" style="cursor:pointer"/></td>
        <td><span class="textorojo">*</span></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td class="textotabla1">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
        <table width='100%'>
        <tr>
          <td  class="ctablasup">Categoria</td>
          <td  class="ctablasup">Fase</td>
          <td  class="ctablasup">No fecha</td>
          <td  class="ctablasup">Equipo A</td>
          <td  class="ctablasup">Equipo B</td>
          <td  class="ctablasup">HORA</td>
          <td class="ctablasup" align="center">Borrar:</td>
        </tr>
        <tr>
          <td><?php combo_evento_where("categoria","categoria","cod_cat","nom_cat",$dbdatos->cat_dpro,"onchange='cargar_equipo(\"equipo1\",\"equipo2\",\"categoria\")'"," where estado_cat = 1 ORDER BY nom_cat");  ?></td>
          <td><?php combo_evento_where("fase","fase","cod_fase","nom_fase",$dbdatos->fase_dprog,""," where estado_fase = 1 ORDER BY nom_fase")?></td>
          <td><?php combo_evento_where("nom_fecha","fecha","cod_fec","nom_fec",$dbdatos->nom_fec,""," where estado_fec = 1 ORDER BY nom_fec");  ?></td>
          <td><?php combo_evento_where("equipo1","equipo","cod_equi","nom_equi",$dbdatos->equi1_dprog,""," where estado_equi = 1 ORDER BY nom_equi");  ?></td>
          <td><?php combo_evento_where("equipo2","equipo","cod_equi","nom_equi",$dbdatos->equi2_dprog,""," where estado_equi = 1 ORDER BY nom_equi");  ?></td>
          <td><input name="HI" type="text" id="HI" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->HI?>"/>:<input name="MI" type="text" id="MI" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->MI?>"/>:<input name="SI" type="text" id="SI" onkeypress=" return validaInt()" size='2' value="<?php echo $dbdatos->SI?>"/></td>
          <td align="center"><input id="mas" type='button'  class='botones' value='  +  '  onclick="adicion()">      </td>
        </tr>
      </table>
      <table width="100%">
        <tr id="fila_0">
          <td  class="ctablasup">Categoria</td>
          <td  class="ctablasup">Fase</td>
          <td  class="ctablasup">No fecha</td>
          <td  class="ctablasup">Equipo A</td>
          <td  class="ctablasup">Equipo B</td>
          <td  class="ctablasup">HORA</td>
          <td class="ctablasup" align="center">Borrar:</td>
        </tr>
        <?
        if ($codigo!=0) { // BUSCAR DATOS
          $sql =" SELECT * FROM d_programacion
          INNER JOIN m_programacion ON m_programacion.cod_pro = d_programacion.cod_prog
          INNER JOIN categoria ON categoria.cod_cat = d_programacion.cat_dprog
          where cod_pro = $codigo";//=    
          $dbdatos_1= new  Database();
          $dbdatos_1->query($sql);
          $jj=1;
          //echo "<table width='100%'>";
          while($dbdatos_1->next_row()){ 
            echo "<tr id='fila_$jj'>";

            $sqlf =" SELECT * FROM fecha
            where cod_fec = $dbdatos_1->nom_fec";//=    
            $dbf= new  Database();
            $dbf->query($sqlf);
            $dbf->next_row();

            //fecha
            echo "<td  ><INPUT type='hidden'  name='nom_fec_$jj' id='nom_fec_$jj' value='$dbdatos_1->nom_fec'><span class='textfield01'>$dbf->nom_fec</span> </td>"; 

            //categoria
            echo "<td  ><INPUT type='hidden'  name='cod_cat_$jj' id='cod_cat_$jj' value='$dbdatos_1->cat_dprog'><span class='textfield01'>$dbdatos_1->nom_cat</span> </td>"; 
                       
            $sqle1 =" SELECT * FROM equipo
            where cod_equi = $dbdatos_1->equi1_dprog";//=    
            $dbe1= new  Database();
            $dbe1->query($sqle1);
            $dbe1->next_row();

            //equipo A
            echo "<td  ><INPUT type='hidden'  name='cod_equi1_$jj' id='cod_equi1_$jj' value='$dbdatos_1->equi1_dprog'><span class='textfield01'>$dbe1->nom_equi</span> </td>"; 

            $sqle2 =" SELECT * FROM equipo
            where cod_equi = $dbdatos_1->equi2_dprog";//=    
            $dbe2= new  Database();
            $dbe2->query($sqle2);
            $dbe2->next_row();

            //equipo B
            echo "<td  ><INPUT type='hidden'  name='cod_equi2_$jj' id='cod_equi2_$jj' value='$dbdatos_1->equi2_dprog'><span class='textfield01'>$dbe2->nom_equi</span> </td>"; 

            //hora
            echo "<td><INPUT type='hidden'  name='hora_$jj' id='hora_$jj' value='$dbdatos_1->hora_dprog'><span class='textfield01'>$dbdatos_1->hora_dprog</span></td>"; 

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
  <input type="hidden" name="val_inicial" id="val_inicial" value="<?php if($codigo!=0) echo $jj-1; else echo "0"; ?>" />
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
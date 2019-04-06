<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<?php 

//RECIBE LAS VARIABLES
$insertar = $_REQUEST['insertar'];
$eliminar = $_REQUEST['eliminar'];
$editar = $_REQUEST['editar'];
$eli_codigo = $_REQUEST['eli_codigo'];
$confirmacion = $_REQUEST['confirmacion'];
$busquedas = $_REQUEST['busquedas'];
$act_pag = $_REQUEST['act_pag'];
$cant_pag = $_REQUEST['cant_pag'];

if($_REQUEST['eliminacion']==1) {//confirmacion de eliminacion 
	$campos="estado_afi ='1'";
	$error=editar("afiliado",$campos,'cod_afi',$eli_codigo); 
	if ($error >=1)
	echo "<script language='javascript'> alert('Se modifico el registro Correctamente..') </script>" ;
	
}

#codigo para buscar 	
if(!empty($_REQUEST['busquedas'])) {
  if($_REQUEST['campo'] == 'nombre'){
    $busquedas=reemplazar_1($busquedas);
    $where="having $busquedas and estado_afi = 2";
  } 
  else{
    $busquedas=reemplazar_1($busquedas);
    $where="where $busquedas and estado_afi = 2";
  }
}
else{
	$where="where estado_afi = 2";
}

$sql="SELECT *,CONCAT(nom1_afi,' ',nom2_afi,' ',apel1_afi,' ',apel2_afi) as nombre FROM afiliado 
INNER JOIN tipo_identificacion ON tipo_identificacion.cod_tiden = afiliado.tiden_afi
INNER JOIN categoria ON categoria.cod_cat = afiliado.cat_afi
$where ORDER BY nombre";
#codigo para buscar 

$cantidad_paginas=paginar($sql);
$cant_pag=ceil($cantidad_paginas/$cant_reg_pag);

if(!empty($act_pag)) 
  $inicio=($act_pag -1)*$cant_reg_pag  ;
else { 
  $inicio =0;
  $act_pag=1;
  }
$paginar=" limit  $inicio, $cant_reg_pag";
$sql.=$paginar;
$busquedas=reemplazar($busquedas);
?>
<html >
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo$nombre_aplicacion?></title>
<script type="text/javascript">
var tWorkPath="menus/data.files/";
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
</script>
<script type="text/javascript" src="js/funciones.js"></script>
<script type="text/javascript" src="informes/inf.js"></script>
 <link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body  <?php echo$sis?> onLoad="cambio_1(<?php echo$cant_pag?>,<?php echo$act_pag?>);">
<table align="left" width='100%'>
<tr>
<td valign="top">
<form id="forma_total" name="forma_total" method="post" action="man_habilitar.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" >
                    <tr>
                      <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td> </td>
                          <td> 
                          </span></td>
                          <td class="ctablaform">Buscar: </td>
                          <td class="ctablaform"><input name="text" type="text" class="textfield" size="12" id="texto" /></td>
                          <td ><label> <span class="ctablaform">en</span></label></td>
                          <td class="ctablaform">
                            <select name="campos" class="textfieldlista" id="campos" >
                              <option value="0">SELECCION...</option>
                              <option value="nombre">NOMBRE</option>
                              <option value="nom_tiden">TIPO ID</option>
							                <option value="id_afi">ID</option>
                              <option value="nom_cat">CATEGORIA</option>
                              <option value="-1">LISTA COMPLETA</option>
                            </select>
                          </td>
                          <td width="41" valign="middle"><img src="imagenes/lupa.png" alt="Buscar" width="16" height="16" style="cursor:pointer"  onClick="buscar()"/></td>
                        
                        </tr>
                      </table></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0"  cellpadding="0">
                        <tr>
						              <td class="ctablasup">NOMBRE</td>
						              <td class="ctablasup">TIPO ID</td>
						              <td class="ctablasup">ID</td>
						              <td class="ctablasup">CATEGORIA</td>
                          <td class="ctablasup">OPCIONES</td>
                        </tr>
						<?php 
						
						echo "<tr style='display:none'><td ><form name='forma_0' action='man_habilitar.php'>";
						echo "  </form> </td></tr>  ";						  
						$estilo="ctablablanc";
						$estilo="ctablagris";
						
						//echo $sql;
						$db->query($sql);  #consulta paginada
						while($db->next_row()) {
							if ($aux==0) { $estilo="ctablablanc"; $aux=1; $cambio_celda=$celda_blanca; }else { $estilo="ctablagris";  $cambio_celda=$celda_gris; $aux=0;}
							echo "<tr class='$estilo' $cambio_celda> <form name='forma_$db->cod_afi' action='man_habilitar.php'>  ";
							echo "<td >$db->nombre</td>";
							echo "<td >$db->nom_tiden</td>";
							echo "<td >$db->id_afi</td>";
							echo "<td >$db->nom_cat</td>";
                            echo "<td aling='center' >"; 
							
							echo 	"<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
                            echo 	" <tr>  <td align='center'> <input type='hidden' name='codigo' value='$db->cod_afi'>";

							if ($editar==1)
								echo"<img src='imagenes/ok.png' width='16' alt='Eliminar Registro' height='16' style='cursor:pointer' onclick=confirmar($db->cod_afi) /></td> ";
							else
								echo"<img src='imagenes/e_icoeliminar.png' width='16' height='16'  /></td> ";


                            echo "  </tr> </table>  </td>  ";
							echo "<input type='hidden' name='editar' value=".$editar."> <input type='hidden' name='insertar' value=".$insertar."> <input type='hidden' name='eliminar' value=".$eliminar.">";
							echo "  </form></tr>  ";
						
						} ?>

                      </table ></td>
                    </tr>
                    
                    <tr>
                      <td><img src="imagenes/lineasup3.gif" width="100%" height="4" /></td>
                    </tr>
                    <tr>
                      <td height="30" align="center" valign="bottom"><table>
                        <tr>
                          <td> <span class="ctablaform" > <?php  if ($cant_pag>0) echo "Pagina ".$act_pag." de ".$cant_pag ; else echo "No hay Resultados"  ?> </span>
                            <img src="imagenes/primero.png" alt="Inicio" width="16" height="16" id="primero" style="cursor:pointer; display:inline"  onClick="cambio(1)"/> <img src="imagenes/regresar.png" alt="Anterior" width="16" height="16" id="regresar" style="cursor:pointer; display:inline" onClick="cambio(2)"/> <img src="imagenes/siguiente.png" alt="Siguiente" width="16" height="16"  id="siguiente" style="cursor:pointer; display:inline" onClick="cambio(3)"/> <img src="imagenes/ultimo.png" alt="Ultimo" width="16" height="16" id="ultimo" style="cursor:pointer; display:inline" onClick="cambio(4)"/> </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table>
      </form>
</td>
</tr>
</table>						
<form name="forma" method="post" action="con_habilitar.php">
  <input type="hidden" name="editar" id="editar" value="<?php echo $editar?>">
  <input type="hidden" name="insertar" id="insertar" value="<?php echo $insertar?>">
  <input type="hidden" name="eliminar" id="eliminar" value="<?php echo $eliminar?>">
  <input type="hidden" name="cant_pag"  id="cant_pag" value="<?php echo $cant_pag?>">
  <input type="hidden" name="act_pag"  id="act_pag" value="<?php if(!empty($act_pag)) echo $act_pag; else echo $pagina;?>">
  <input type="hidden" name="busquedas" id="busquedas" value="<?php echo $busquedas?>">
  <input type="hidden" name="campo" id="campo" value="<?php echo $campo?>">
   <input type="hidden" name="eliminacion" id="eliminacion" >
    <input type="hidden" name="eli_codigo" id="eli_codigo" >
</form>
</body>
</html>
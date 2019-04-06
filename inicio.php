<?php include("conf/clave.php");?>
<?php 
if(!isset($verifica_seg)) {
  setcookie("verifica_seg", "1", time() + 86400); 
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Podium</title>
<link rel="icon" type="image/png" href="imagenes/icono.png" />
</head>
<script language="javascript">
function DetectaBloqueoPops()
{
  var popup
  try
  {
    if(!(popup = window.open('about:blank','_blank','width=0,height=0')))
      throw "ErrPop"
    popup.close()
  }
  catch(err)
  {
    if(err=="ErrPop"){
      msj = "Esta Pagina funciona con ventanas emergentes recuerde habilitarlas"
       alert(msj);  
   }
    else
    {
      msj1="Hubo un erro en la página.nn"
      msj1+="Descripción del error: " + err.description + "nn"
     }
  } 
}
function salta(e)
{
tecla = (document.all) ? e.keyCode : e.which
  if(tecla==13)
  {
    //window.e.keyCode=0; 
    document.getElementById("txt_clave").focus();
  }
}

function enviar(e,conf)
{
tecla = (document.all) ? e.keyCode : e.which
if(tecla==13 || conf==1)
{

  if (document.getElementById("txt_usuario").value !="" & document.getElementById("txt_clave").value != "") {
    document.getElementById("confirmacion").value =1;
  document.forma.submit();
  }
  else 
  {
      alert("Datos Incompletos");
    document.getElementById("txt_usuario").focus();
  }
  return false;
}
}
<?php if ($confirmacion!=1 || $confirmacion!=1){ ?>
  DetectaBloqueoPops();
<?php } ?>
</script>
<style type="text/css">
td img {display: block;}
</style>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<body>
<?php 
if ($_POST['confirmacion']==1){
    include ("validar.php");
}

if ($usu_atu==1 && $_POST['confirmacion']==1){
  $usu_atu==0; 
  $confirmacion==0;
?>
<script type="text/javascript">
  menu=window.open('aplicacion.php','');
  menu.focus();
</script>
<?php 
}

//$refresca=1;

if($usu_atu==0 && $_POST['confirmacion']==1){
?>
<script type="text/javascript">
  alert('Usuario No Autorizado, Rectifique sus Datos ');
</script>
<?php 
}
?>
<form  action="inicio.php"  name="forma" method="post" >
<div class="fondo">
<table width="860"  border="0" align="center" cellpadding="0" cellspacing="0">  
  <tr>
    <td  align="center"><table width="88%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td><img src="imagenes/logo.png" align='center'></td>
    </tr>
      <tr>
        <!--TABLA INTERNA DE USUARIO Y CLAVE-->
        <td width="255" colspan="3" align="center"><table width="80%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="190" class="textotabla2"><div align="right">Usuario:</div></td>
            <td width="427" class="textotabla2"><div align="center">
              <input name="txt_usuario" id="txt_usuario" type="text" class="textotabla01" size="30" onKeyDown="salta(event)"/>
            </div></td>
            </tr>
          <tr>
            <td class="textotabla2"><div align="right">Clave:</div></td>
            <td class="textotabla2"><div align="center">
              <input name="txt_clave" id="txt_clave" type="password" class="textotabla01" size="30" onKeyDown="enviar(event,0)" />
              <input name="confirmacion" type="hidden" id="confirmacion" value="0" />
            </div></td>
            </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center"><img src="imagenes/entrar_boton.jpg" alt="" width="116" height="29" style="cursor:pointer" onClick="enviar(event,1)"></div></td>
          </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">Desarrollado por <strong><a href='http://www.dondealejosistemas.com' target='_blank'>www.dondealejosistemas.com</a></strong> copyright
              <?php echo date("Y");?>
              </STRONG></FONT></div></td>
            </tr>
          <tr>
            <td colspan="2" align="right"></td>
            </tr>
          </table></td>
        <!--FIN TABLA INTERNA DE USUARIO Y CLAVE-->
        </tr>
    </table></td>
    </tr>
  </table>
  </div>
</form>
<script language="javascript">
<?php 
if($refresca==1)
{
?>
document.forma.submit()

<?php 
}
else 
{
?>
document.forma.txt_usuario.focus();
<?php 
}
?>

</script>
</body>
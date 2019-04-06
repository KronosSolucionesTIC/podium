<?php include("lib/database.php");?>
<?php include("js/funciones.php");?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Podium</title>
<link href="imagenes/icono.png" type="image/x-icon" rel="shortcut icon">
<script type="text/javascript">var tWorkPath="menus/data.files/";</script>
<script type="text/javascript" src="menus/data.files/dtree.js"></script>
<link href="css/styles.css" rel="stylesheet" type="text/css">
<style type="text/css">
.principal {
  background-image: url("imagenes/fondo.png");
  background-repeat: no-repeat;
  background-position: 50% 50%;
}
</style>
<script language="JavaScript1.2">
<!--

window.moveTo(0,0);
if (document.all) {
	top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
	top.window.outerHeight = screen.availHeight;
	top.window.outerWidth = screen.availWidth;
}
}
//-->
</script>
<script language="javascript">

function cerrar() {
window.close();

}
</script>
</head>
<body  bgcolor="#FAFAFA" <?=$sis?> onLoad="window.focus();" >
<div class="inset">
<b class="top"><b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b></b>
<div class="boxcontent" align="center">
<table width="99%" height="99%" align="center" border="0" background="imagenes/fondo.png" class='principal'>
        <tr> 
          <td height="22" align="right" valign="middle" bgcolor="#1F6FC6" class="nombreusuario" style="height:19px">
            <span class="nombreusuario" style="height:19px"><span class="titulosup">USUARIO: </span>
              <?=$_SESSION['global_3']?>
              <span class="titulosup">FECHA: </span>
              <?=date("d/m/y")?>
              </span>	</td>
          </tr>
  <tr>
    <td valign="top">
      <table width="100%" height="100%" border="0">
        <tr>
          <td valign="top">
            <?php include("menu.php");?>         
            <iframe  frameborder="0" scrolling="auto"   src="interna.php" name="interna" width="99%" height="95%" bgcolor="#FAFAFA"> </iframe>    
          </td>
          </tr>
        </table>
      </td>
  </tr>
  <tr>
    <td width="100%" height="26" bgcolor="#1F6FC6" class="nombreusuario" align="right">Desarrollado por <a href="http://www.kronossolucionestic.com" target="_blank">
          Kronos Soluciones TIC
        </a></td>
  </tr>
  </td>
</tr>
</table>
</div>
<b class="bottom"><b class="b4b"></b><b class="b3b"></b><b class="b2b"></b><b class="b1b"></b></b>
</div>
</body>
</html>
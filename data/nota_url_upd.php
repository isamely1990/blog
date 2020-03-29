<? 		session_start();  ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> 
<html><!-- InstanceBegin template="/Templates/plantilla_admin.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<? 	require_once("./include.php"); 
	$conexion = new accesoBD(SERVIDORBD,USUARIOBD,CLAVEBD);
	$conexion->SeleccionBD(BASEDATOS);

	$SQL_constante = "SELECT * ";
	$SQL_constante .= " FROM rol ";
	$result_constante = $conexion->EjecutarQuery($SQL_constante,"búsqyeda de constantes",$errno);
	while ($fila_constante = mysql_fetch_assoc($result_constante)) {
		define($fila_constante['rol_nombre'],$fila_constante['rol_codigo']);
	}

	
	puedo_mostrar_pagina_admin($_SESSION['usu_codigo'],$_SESSION['rol_codigo']);
?>
<!-- InstanceBeginEditable name="doctitle" -->
<title>Panel de Administraci&oacute;n</title>
<!-- InstanceEndEditable -->
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/funcionesjs.js"></script>
<script type="text/javascript" src="coolmenu.js"></script>
<script type="text/javascript" src="menuitems_admin.js"></script>

<script type="text/javascript">new COOLjsMenu("menu1", MENU_ITEMS_MULTIPLE1)</script>

<!-- InstanceBeginEditable name="head" --><!-- InstanceEndEditable -->
<link href="estilos.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"><style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	background: #DDDDDD;
}
-->
</style></HEAD>
<? 
	if (isset($texto_libre)) { 
	echo "<body onLoad=\"initEditor()\"> ";
	} else { ?> 
	  <body>	  
<?	}	?>

<table width="800" border="1" align="left" cellpadding="0" cellspacing="0" class="TablaIndex">
  <tr> 
    <td> <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="tablaEncabezado">
        <tr> 
          <td  align="center">
		  <img src="images/banner_top.gif" width="800" height="120" alt="Panel de Administración"></td>
        </tr>
        <tr class="tablaTitulo">
          <td align="center"><div align="right"><? echo NOMBRE_CLIENTE." - ".NOMBRE_SISTEMA ?></div></td>
        </tr>
        <tr class="tablaTitulo">
          <td align="center"><div align="right" class="tablaEtiqueta">Usuario: <? echo $_SESSION['usu_nombre']." ".$_SESSION['usu_apellido'] ?></div></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0"  style="background-color:#FFF">
        <tr> 
          <td width="140" valign="top" class="tablaMenu"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="tablamenu">
              <tr>
                <td >&nbsp;</td>
              </tr>
              <tr>
                <td >&nbsp;</td>
              </tr>
              <tr> 
                <td ><!-- InstanceBeginEditable name="EditRegion5" --> 
                  <p>.</p>
                  <!-- InstanceEndEditable --></td>
              </tr>
          </table></td>
          <td valign="top"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr> 
                <td><blockquote>
					<!-- InstanceBeginEditable name="EditRegion3" --> 
						<br />
						<blockquote>
						  <p align="left" class="textoTitulo">Administrar Notas </p>
					  </blockquote>	
                    
					      <? 
						$oNoticia= new cNotaUrl($conexion); 

						if (!$_SESSION['carga_inicial']) {
								?> <div align="center" class="textoError">Esta intentando realizar una operaci�n ya efectuada.</div><?
						} else {

								switch ($_POST['operacion']) {
								
									// Alta
									case "A":
										
										if ($oNoticia->ValidarDatosNoticia($_POST,$datos_validos)){
										
											if ($oNoticia->AltaNoticia($datos_validos)) {
												?> <p align="center" class="textoExito">Se han agregado los datos correctamente.</p> <?
											} else {	
												?> <p align="center" class="textoError">Error al agregar los datos. Intente nuevamente</p> <?
											}	
											
										} else {
											?> <p align="center" class="textoError">Error los datos no son válidos. Intente nuevamente</p> <?
										}
																			
										break;
		
									// Baja
									case "B":
										if ($oNoticia->ValidarDatosBajaNoticia($_POST,$datos_validos)){
										
											if ($oNoticia->BajaNoticia($datos_validos)) {
												?> <p align="center" class="textoExito">Se han eliminado los datos correctamente.</p> <?
											} else {	
												?> <p align="center" class="textoError">Error al eliminar los datos. Intente nuevamente</p> <?
											}	

											$oNoticia->ConsultaTraerDatosFotoNoticia($datos_validos['noti_codigo'],$SQL_consulta);
											$result_archivo = $conexion->EjecutarQuery($SQL_consulta,"selecci�n de fotos noticias",$errno);
											while ($fila_archivo = mysql_fetch_assoc($result_archivo)) {
												if ($fila_archivo['foto_archivo'] != "") { 
													$borro_archivo_fisico = unlink("../".$oNoticia->ruta_archivo.$fila_archivo['foto_archivo']);
													if ($borro_archivo_fisico) {
														?> <p align="center" class="textoExito">Se ha eliminado el archivo <? echo $fila_archivo['foto_archivo'] ?></p> <?
													} else {	
														?> <p align="center" class="textoError">Error al eliminar el archivo <? echo $fila_archivo['foto_archivo'] ?></p> 
													<? 
													}																
																					
												}
												
												if ($oNoticia->BajaFotoNoticia($fila_archivo)) {
													?> <p align="center" class="textoExito">Se han eliminado las imágenes correctamente.</p> <?
												} else {	
													?> <p align="center" class="textoError">Error al eliminar las imágenes. Intente nuevamente</p> <?
												}	

											}	

										
											
											
										} else {
											?> <p align="center" class="textoError">Error los datos no son válidos. Intente nuevamente</p> <?
										}
										break;
									
									// Modificaci�n
									case "M":
		
										if ($oNoticia->ValidarDatosNoticia($_POST,$datos_validos)){
										
											if ($oNoticia->ModifNoticia($datos_validos)) {
												?> <p align="center" class="textoExito">Se han modificado los datos correctamente.</p> <?
											} else {	
												?> <p align="center" class="textoError">Error al modificar los datos. Intente nuevamente</p> <?
											}	
											
										} else {
											?> <p align="center" class="textoError">Error los datos no son válidos. Intente nuevamente</p> <?
										}
		
										break;
								}
								$_SESSION['carga_inicial']=false;
								
						} // if (!$_SESSION['carga_inicial']) {
						
					?>	
				<p align="center"><a href="nota_url_abm.php">Continuar</a></p>					      
					      
			                </div>
					<!-- InstanceEndEditable -->
				</blockquote>
				</td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td bgcolor="#2F36EC" class="textoTitulo">&nbsp;</td>
  </tr>

</table>



</BODY>
<!-- InstanceEnd --></html>
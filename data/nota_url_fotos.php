<? 		session_start();  ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN"> 
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="estilos.css" rel="stylesheet" type="text/css" >
<title>Panel de Administraci&oacute;n</title></head>
<script type="text/javascript" src="js/funcionesjs.js"></script>
<body>

	<? 
		require_once ("include.php");
		$conexion = new accesoBD(SERVIDORBD,USUARIOBD,CLAVEBD);
		$conexion->SeleccionBD(BASEDATOS);		
		
		$oNoticia= new cNotaUrl($conexion); 
?>
		<script type="text/javascript">
			<? $oNoticia->ValidarFormAltaFotoNoticia();?>
		</script>
<?
		if (isset($_POST['bot_agregar'])) {
		
			if ($_POST['operacion_archivo'] == "A") { 

				$archivo = $_FILES['foto_archivo']['tmp_name'];
				$foto_archivo = $_FILES['foto_archivo']['name'];
				
	
				if ($archivo !="") {
					$_POST['foto_archivo'] = $foto_archivo;
					if (move_uploaded_file($archivo, "../".$oNoticia->ruta_archivo.$foto_archivo)) {
					
						chmod("../".$oNoticia->ruta_archivo.$foto_archivo,0777);
					
						if ($oNoticia->ValidarDatosFotoNoticia($_POST,$datos_validos)){
						
							if ($oNoticia->AltaFotoNoticia($datos_validos)) {
								?> <p align="center" class="textoExito">Se ha actualziado el archivo correctamente.</p> <?
							} else {	
								?> <p align="center" class="textoError">Error al actualizar el archivo. Intente nuevamente</p> <?
								$error = true;
							}	
							
						} else {
							?> <p align="center" class="textoError">Error los datos no son válidos. Intente nuevamente</p> <?
								$error = false;						
						}
						$_SESSION['carga_inicial_archivo'] = false;		
						$noti_codigo  = $datos_validos['noti_codigo'];
					
					} else {
						?> <p align="center" class="textoError">Error al actualizar el archivo. Intente nuevamente</p> <?
					}
			
				}
			} else { 	// operacion_archivo = A
		
				if ($_POST['operacion_archivo'] == "M") { 
					
						if ($oNoticia->ValidarDatosFotoNoticia($_POST,$datos_validos)){
						
							if ($oNoticia->ModifFotoNoticia($datos_validos)) {
								?> <p align="center" class="textoExito">Se ha actualziado el archivo correctamente.</p> <?
							} else {	
								?> <p align="center" class="textoError">Error al actualizar el archivo. Intente nuevamente</p> <?
								$error = true;
							}	
							
						} else {
							?> <p align="center" class="textoError">Error los datos no son válidos. Intente nuevamente</p> <?
								$error = false;						
						}
						$_SESSION['carga_inicial_archivo'] = false;		
						$noti_codigo  = $datos_validos['noti_codigo'];
				
				}
				
			
			}
			
		
		} else { // 		if (isset($_POST['bot_agregar'])) {
		
				if (isset($_POST['bot_eliminar'])) {
					// borro todos los archivos seleccionados
					for ($c=1; $c <= $_POST['cantidad'];$c++){
						if (isset ($_POST['chk_'.$c])) {		
						
							// borro el archivo f�sico
							
							$oNoticia->ConsultaTraerDatosFotoNoticiaxFotoCodigo($_POST['chk_'.$c],$SQL_consulta);
							$result_archivo = $conexion->EjecutarQuery($SQL_consulta,"selecci�n de fotos noticias",$errno);
							$fila_archivo = mysql_fetch_assoc($result_archivo);
							if ($fila_archivo['foto_archivo'] != "") { 
								$borro_archivo_fisico = unlink("../".$oNoticia->ruta_archivo.$fila_archivo['foto_archivo']);
								if (true) {
									?> <p align="center" class="textoExito">Se ha eliminado el archivo <? echo $fila_archivo['foto_archivo'] ?></p> <?
										
										// borro el arvhido de la BD
										$datos = array ("foto_codigo"=>$_POST['chk_'.$c]);
										if ($oNoticia->ValidarDatosBajaNoticiaFoto($datos,$datos_validos)){
											if ($oNoticia->BajaFotoNoticia($datos_validos)) {
												?> <p align="center" class="textoExito">Se han eliminado los datos de la imagen.</p> <?
											} else {	
												?> <p align="center" class="textoError">Error al eliminar los datos de la imagen Intente nuevamente</p> <?
												$error = true;
											}	
											
										} else {
											?> <p align="center" class="textoError">Error los datos no son válidos. Intente nuevamente</p> <?
												$error = false;						
										}
								
								
								} else  {
									?> <p align="center" class="textoError">Error al eliminar el archivo <? echo $fila_archivo['foto_archivo'] ?></p> 
							
								<? }
							}
						}
					}
			
					$_SESSION['carga_inicial_archivo'] = false;		
					$noti_codigo  = $_POST['noti_codigo'];
					
				
				
				} else { 
						$noti_codigo  = $_GET['noti_codigo'];
				}
						
		
		} // if
		

		$oNoticia->ConsultaTraerDatosFotoNoticia($noti_codigo,$SQL_consulta);
		$result = $conexion->EjecutarQuery($SQL_consulta,"selecci�n de fotos noticias",$errno);
		if (mysql_num_rows($result) == 0) {
			?>
		<p align="left" class="textoNormal"> No hay imágenes para la noticia seleccionada</p>
	  <? } else { ?>
			<form name="formulario_modif" id="formulario_modif" method="post" action="<? echo $_SERVER['PHP_SELF']?>" >
			<table width="500" align="center" cellpadding="5" class="TablaMarco" >
			  <tr class="tablaTitulo">
				  <td width="<? echo $oNoticia->tamano_imagen_thumb?>"><div align="center">Imagen</div></td>
			      <td width="20"><div align="center">T&iacute;tulo</div></td>
	            <td width="10%"><div align="center">Modificar</div></td>
	            <td width="10%"><div align="center">Marcar</div></td>						
			  </tr>
			<? 
				$i=0;
				while ($fila_datos = mysql_fetch_assoc($result)) { 
				$i++;
				$clase =  ($i%2==0)?"TextoPar":"TextoImpar";
				
				
				?>	
				  <tr class="<? echo $clase?>">
					<td class="textoNormal"><img src="<? echo "../".$oNoticia->ruta_archivo.rawurlencode($fila_datos['foto_archivo'])?>" width="<? echo $oNoticia->tamano_imagen_thumb?>"></td>
					  <td><div align="left"><? echo $fila_datos['foto_nombre']?></div></td>
					  <td><div align="center"><a href="<? echo $_SERVER['PHP_SELF']?>?noti_codigo=<? echo $noti_codigo ?>&amp;foto_codigo=<? echo $fila_datos['foto_codigo']?>&amp;operacion=M#foto"><img src="images/ico_modificar.png" width="24" height="24" border="0" alt="Modificar" /></a></div></td>
					  <td><div align="center">
					    <input type="checkbox" name="<? echo "chk_".$i?>" value="<? echo $fila_datos['foto_codigo']?>">
				      </div></td>						
			  </tr>
			<? } ?>
				  <tr>
					<td colspan="4" class="textoNormal"><div align="center" class="textoCombo">
			          <div align="right">eliminar todos los marcados
			            <input type="image"  src="images/ico_borrar.png" onClick="formulario_modif.submit()">
			            <input type="hidden" name="bot_eliminar" id="bot_eliminar">
			            <input type="hidden" name="cantidad" value="<? echo $i?>">
						  <input type="hidden" name="noti_codigo" id="noti_codigo" value="<? echo $noti_codigo?>"/>
                        </div>
					</div></td>
					  </tr>
			</table>	
			</form>
		      <? 
			} ?>		
			
			<? if (isset($_GET['operacion']) && ($_GET['operacion']=="M")) { 
					
					$oNoticia->ConsultaTraerDatosFotoNoticiaxFotoCodigo($_GET['foto_codigo'],$SQL_consulta);
					$result_foto = $conexion->EjecutarQuery($SQL_consulta,"selecci�n de fotos noticias",$errno);
					$fila_foto = mysql_fetch_assoc($result_foto);
					$operacon = "M";
					$operacion_leyenda = "Actualizar";
					$titulo = "Actualizar datos";
				
				} else { 
					$operacon = "A";
					$operacion_leyenda = "Subir imagen";
					$titulo = "Nueva imagen";				
				}	
				
				?>					

				<a name="foto"></a>
				<form name="formulario" id="formulario" method="post" action="<? echo $_SERVER['PHP_SELF']?>" onSubmit=" return ValidarFormAltaFotoNoticia(formulario)" enctype="multipart/form-data">
					<table width="500" align="center" cellpadding="5" class="TablaMarco">
					<tr>
					<td colspan="2" class="tablaTitulo"><p><? echo $titulo?> </p>		  </td>
					</tr>
					<tr>
					  <td width="100" class="tablaEtiqueta">Archivo (*) </td>
					  <td class="tablaDato">
					<? if (isset($_GET['operacion']) && ($_GET['operacion']=="M")) { ?>
						<img src="<? echo "../".$oNoticia->ruta_archivo.rawurlencode($fila_foto['foto_archivo'])?>" width="<? echo $oNoticia->tamano_imagen_min?>">					  
					  <? } else { ?>
						  <input name="foto_archivo" type="file" class="textoCombo" id="foto_archivo" size="45">
						  
					<? } ?>
			  		  </td>
					</tr>
					<tr>
					  <td class="tablaEtiqueta">T&iacute;tulo</td>
					  <td class="tablaDato">			  
						  <input name="foto_nombre" type="text" class="textoCombo" id="foto_nombre" size="50" maxlength="255" value="<? echo (isset($_GET['operacion']) && ($_GET['operacion']=="M"))?$fila_foto['foto_nombre']:""?>">		  </td>
					  </tr>
					<tr>
					  <td class="tablaEtiqueta">Orden (*) </td>
					  <td class="tablaDato">			  
						  <input name="foto_orden" type="text" class="textoCombo" id="foto_orden" size="10" maxlength="4"  value="<? echo (isset($_GET['operacion']) && ($_GET['operacion']=="M"))?$fila_foto['foto_orden']:""?>">		  </td>
					  </tr>
					<tr>
					  <td colspan="2" class="textoNormal">(*) datos obligatorios </td>
					  </tr>
					<tr>
					  <td colspan="2"><div align="center">
						<input type="hidden" name="noti_codigo" id="noti_codigo" value="<? echo $noti_codigo?>"/>

					<? if (isset($_GET['operacion']) && ($_GET['operacion']=="M")) { ?>
						<input type="hidden" name="foto_codigo" id="foto_codigo" value="<? echo $_GET['foto_codigo']?>"/>
					<? } ?>
						
						<input type="hidden" name="operacion_archivo" id="operacion_archivo" value="<? echo $operacon?>"/>			
						<input name="bot_agregar" type="submit" class="boton" value="<? echo $operacion_leyenda?>" />
					  </div></td>
					</tr>
					<tr>
					  <td colspan="2">
						<div align="right">
						  <a href="javascript:window.close()">volver<img src="images/ico_volver.png" alt="Cerrar Ventana" border="0"></a>		    </div></td>
					  </tr>
				  </table>
					
			</form>
			

</body>
</html>
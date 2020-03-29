<?
class cNotaUrl
{
var $conexion;
var $tamano_pagina = 10;
var $tamano_pagina_publico = 10;
	
var $tabla = "nota_url";	
var $campo_codigo = "noti_codigo";	
var $campo_orden = "noti_orden";	
var $ruta_archivo = "images/notas_url/";	
var $tamano_imagen_min = 217;	
var $tamano_imagen_max = 350;
var $tamano_imagen_thumb = 70;	
	


	//-----------------------------------------------------------------------------------------------------	
	function cNotaUrl($conexion)
	{
		$this->conexion = &$conexion;
	}

	//-----------------------------------------------------------------------------------------------------	
	// Retorna la consulta de selección de todos los datos de la base	
	function ConsultaTraerDatos (&$SQL_consulta) {
		$SQL_consulta = "SELECT * ";
		$SQL_consulta .="   FROM  ".$this->tabla;
		$SQL_consulta .="   ORDER by ".$this->campo_orden;
		return true;

	}

	//-----------------------------------------------------------------------------------------------------	
	// Retorna la consulta de selección de todos los fotos de la noticia
	function ConsultaTraerDatosFotoNoticia ($noti_codigo,&$SQL_consulta) {
		$SQL_consulta = "SELECT * ";
		$SQL_consulta .="   FROM  foto_nota_url ";
		$SQL_consulta .="   WHERE noti_codigo = '".$noti_codigo."'";
		$SQL_consulta .="   ORDER BY foto_orden";
		return true;

	}

	//-----------------------------------------------------------------------------------------------------	
	// Retorna la consulta de selección de la otos por codigo
	function ConsultaTraerDatosFotoNoticiaxFotoCodigo ($foto_codigo,&$SQL_consulta) {
		$SQL_consulta = "SELECT * ";
		$SQL_consulta .="   FROM  foto_nota_url ";
		$SQL_consulta .="   WHERE foto_codigo = '".$foto_codigo."'";
		return true;

	}




	//-----------------------------------------------------------------------------------------------------	
	// Retorna un array con los datos del registroque corresponde al còdigo
	function BuscarDatos ($noti_codigo, &$fila_noticia) {

		$SQL_consulta = "SELECT * ";
		$SQL_consulta .="   FROM ".$this->tabla;
		$SQL_consulta .="   WHERE ".$this->campo_codigo." ='".$noti_codigo."'";
		$result = $this->conexion->EjecutarQuery($SQL_consulta,"Buscar Datos de noticias",$errno);
		
		if (mysql_num_rows($result)==1) {
			$fila_noticia = mysql_fetch_assoc($result);
			return true;
		} else {
			return false;
		}	

	}

	//-----------------------------------------------------------------------------------------------------	
	function TraerImagenPrincipal($noti_codigo,&$result)	{
	
		$SQL_consulta = "SELECT * ";
		$SQL_consulta .="   FROM foto_nota_url";
		$SQL_consulta .="   WHERE noti_codigo = '".$noti_codigo."'";
		$SQL_consulta .="   ORDER BY foto_orden ASC ";
		$SQL_consulta .="	LIMIT 1";
		$result = $this->conexion->EjecutarQuery($SQL_consulta,"Buscar foto principal",$errno);
		return true;
	}

	//-----------------------------------------------------------------------------------------------------	
	function TraerImagenSecundarias($noti_codigo, &$result)	{
	
		$SQL_consulta = "SELECT * ";
		$SQL_consulta .="   FROM foto_nota_url";
		$SQL_consulta .="   WHERE noti_codigo = '".$noti_codigo."'";
		$SQL_consulta .="   ORDER BY foto_orden ASC ";
		$SQL_consulta .="	LIMIT 1,1000000";
		$result = $this->conexion->EjecutarQuery($SQL_consulta,"Buscar fotos secundarias",$errno);
		
		return true;
	}



	//-----------------------------------------------------------------------------------------------------	
	function ValidarFormAltaNoticia()	{
	?>		
		function ValidarFormAltaNoticia(formulario) {


			if (document.formulario.noti_titulo.value =="") {
				alert ('Debe ingresar el título');
				document.formulario.noti_titulo.focus();
				return false;
			}


			if (document.formulario.noti_orden.value =="") {
				alert ('Debe ingresar el orden (numero entero)');
				document.formulario.noti_orden.focus();
				return false;
			}

			if (!ValidarContenido(document.formulario.noti_orden.value,'NumericoEntero')) {
				alert ('Debe ingresar el orden (numero entero)');
				document.formulario.noti_orden.focus();
				return false;
			}
			
			return true;			
		}
		
		
	<?	
	}
	
	//-----------------------------------------------------------------------------------------------------	
	function ValidarFormAltaFotoNoticia()	{
	?>		
		function ValidarFormAltaFotoNoticia(formulario) {


			if (document.formulario.foto_archivo.value =="") {
				alert ('Debe ingresar el archivo');
				document.formulario.foto_archivo.focus();
				return false;
			}

			if (document.formulario.foto_orden.value =="") {
				alert ('Debe ingresar el orden (numero entero)');
				document.formulario.foto_orden.focus();
				return false;
			}

			if (!ValidarContenido(document.formulario.foto_orden.value,'NumericoEntero')) {
				alert ('Debe ingresar el orden (numero entero)');
				document.formulario.foto_orden.focus();
				return false;
			}

			
			return true;			
		}
		
		
	<?	
	}	

	//-----------------------------------------------------------------------------------------------------	
	function ValidarDatosNoticia($datos, &$datos_validos)	{
		
		$datos_validos = array();
	
		// Orden				noti_orden
		if (trim($datos['noti_orden']) =="") {
			echo "Error. Debe ingresar el orden (número entero)";
			return false;			
		}
		if (!ValidarContenido(trim($datos['noti_orden']),"NumericoEntero")) {
			echo "Error. Debe ingresar el orden (número entero)";
			return false;			
		}
		
		$datos_validos['noti_orden'] = htmlspecialchars($datos['noti_orden'],ENT_QUOTES);


		// Título						noti_titulo
		if (trim($datos['noti_titulo']) =="") {
			echo "Error. Debe ingresar el título";
			return false;			
		}
		$datos_validos['noti_titulo'] = htmlspecialchars($datos['noti_titulo'],ENT_QUOTES);


		
		// sin validación
		$datos_validos['noti_url'] = htmlspecialchars($datos['noti_url'],ENT_QUOTES);
		$datos_validos['noti_codigo'] = htmlspecialchars($datos['noti_codigo'],ENT_QUOTES);
		$datos_validos['noti_copete'] = htmlspecialchars($datos['noti_copete'],ENT_QUOTES);
		$datos_validos['noti_texto'] = htmlspecialchars($datos['noti_texto'],ENT_QUOTES);
		$datos_validos['noti_orden'] = htmlspecialchars($datos['noti_orden'],ENT_QUOTES);
		
		
		return true;
	
	}
	

	//-----------------------------------------------------------------------------------------------------	
	function ValidarDatosFotoNoticia($datos, &$datos_validos)	{
		
		$datos_validos = array();
	

		// Orden				foto_orden
		if (trim($datos['foto_orden']) =="") {
			echo "Error. Debe ingresar el orden (número entero)";
			return false;			
		}
		if (!ValidarContenido(trim($datos['foto_orden']),"NumericoEntero")) {
			echo "Error. Debe ingresar el orden (número entero)";
			return false;			
		}
		
		$datos_validos['foto_orden'] = htmlspecialchars($datos['foto_orden'],ENT_QUOTES);

		// sin validación
		$datos_validos['noti_codigo'] = htmlspecialchars($datos['noti_codigo'],ENT_QUOTES);
		$datos_validos['foto_codigo'] = htmlspecialchars($datos['foto_codigo'],ENT_QUOTES);
		$datos_validos['foto_nombre'] = htmlspecialchars($datos['foto_nombre'],ENT_QUOTES);		
		$datos_validos['foto_archivo'] = htmlspecialchars($datos['foto_archivo'],ENT_QUOTES);
		
		return true;
	
	}	
	
		




	//-----------------------------------------------------------------------------------------------------	
	function ValidarDatosBajaNoticia($datos, &$datos_validos)	{
		
		$datos_validos = array();
		$datos_validos['noti_codigo'] = htmlspecialchars($datos['noti_codigo'],ENT_QUOTES);
		return true;
	
	}
	
		
		
	//-----------------------------------------------------------------------------------------------------	
	function ValidarDatosBajaNoticiaFoto($datos, &$datos_validos)	{
		
		$datos_validos = array();
		$datos_validos['foto_codigo'] = htmlspecialchars($datos['foto_codigo'],ENT_QUOTES);
		return true;
	
	}
	
	//-----------------------------------------------------------------------------------------------------	
	function AltaNoticia($datos)	{
	
		$SQL_consulta = " INSERT INTO ".$this->tabla;
		$SQL_consulta .= " (noti_orden, noti_copete, noti_titulo, noti_url, noti_texto, noti_ultimafecha)";
		$SQL_consulta .= " values (";
		$SQL_consulta .= " '".$datos['noti_orden']."',";
		$SQL_consulta .= " '".$datos['noti_copete']."',";
		$SQL_consulta .= " '".$datos['noti_titulo']."',";
		$SQL_consulta .= " '".$datos['noti_url']."',";
		$SQL_consulta .= " '".$datos['noti_texto']."',";
		$SQL_consulta .= " now() ";			
		$SQL_consulta .= " ) ";														
		$result_consulta = $this->conexion->EjecutarQuery($SQL_consulta,"Alta Noticia",$errno);	
		if ($errno !=0)
			return false;

		return true;	

	}



	//-----------------------------------------------------------------------------------------------------	
	function BajaNoticia($datos)	{
	
		$SQL_consulta = " DELETE FROM ".$this->tabla;
		$SQL_consulta .= " WHERE ".$this->campo_codigo." = '".$datos['noti_codigo']."'";
		$result_consulta = $this->conexion->EjecutarQuery($SQL_consulta,"Baja Noticias",$errno);	
		if ($errno !=0)
			return false;

		return true;	

	}

	//-----------------------------------------------------------------------------------------------------	
	function ModifNoticia($datos)	{
	
		$SQL_consulta = " UPDATE ".$this->tabla." SET ";
		$SQL_consulta .= " noti_orden = '".$datos['noti_orden']."',";
		$SQL_consulta .= " noti_titulo = '".$datos['noti_titulo']."',";
		$SQL_consulta .= " noti_url = '".$datos['noti_url']."',";
		$SQL_consulta .= " noti_copete = '".$datos['noti_copete']."',";
		$SQL_consulta .= " noti_texto = '".$datos['noti_texto']."',";
		$SQL_consulta .= " noti_ultimafecha = now()";
		$SQL_consulta .= " WHERE ".$this->campo_codigo." = '".$datos['noti_codigo']."'";
		$result_consulta = $this->conexion->EjecutarQuery($SQL_consulta,"Modif Noticia",$errno);	

		if ($errno !=0)
			return false;

		return true;	

	}

	


	//-----------------------------------------------------------------------------------------------------	
	function AltaFotoNoticia($datos)	{
	
		$SQL_consulta = " INSERT INTO foto_nota_url";
		$SQL_consulta .= " (foto_nombre, noti_codigo, foto_archivo, foto_esprincipal, foto_orden, foto_ultimafecha)";
		$SQL_consulta .= " values (";
		$SQL_consulta .= " '".$datos['foto_nombre']."',";
		$SQL_consulta .= " '".$datos['noti_codigo']."',";
		$SQL_consulta .= " '".$datos['foto_archivo']."',";
		$SQL_consulta .= " '".$datos['foto_esprincipal']."',";
		$SQL_consulta .= " '".$datos['foto_orden']."',";		
		$SQL_consulta .= " now() ";			
		$SQL_consulta .= " ) ";														
		$result_consulta = $this->conexion->EjecutarQuery($SQL_consulta,"Alta Foto Noticia",$errno);	
		if ($errno !=0)
			return false;

		return true;	

	}
	//-----------------------------------------------------------------------------------------------------	
	function ModifFotoNoticia($datos)	{
	
		$SQL_consulta = " UPDATE foto_nota_url SET ";
		$SQL_consulta .= " foto_nombre = '".$datos['foto_nombre']."',";
		$SQL_consulta .= " foto_orden = '".$datos['foto_orden']."',";
		$SQL_consulta .= " foto_ultimafecha = now()";
		$SQL_consulta .= " WHERE foto_codigo = '".$datos['foto_codigo']."'";
		$result_consulta = $this->conexion->EjecutarQuery($SQL_consulta,"Modif Foto Noticia",$errno);	

		if ($errno !=0)
			return false;

		return true;	

	}
	
	
	
	//-----------------------------------------------------------------------------------------------------	
	function BajaFotoNoticia($datos)	{
	
		$SQL_consulta = "DELETE ";
		$SQL_consulta .="   FROM foto_nota_url";
		$SQL_consulta .="   WHERE foto_codigo ='".$datos['foto_codigo']."'";
		$result = $this->conexion->EjecutarQuery($SQL_consulta,"Buscar Datos de fotos noticias",$errno);
		
		return true;
	
	}
	
	//--------------------------------------------------------------------------------------------------------
	
	function mostrarComentariosFacebookHeader ($datos) {
		$this->TraerImagenPrincipal($datos['noti_codigo'],$result_foto);
		$fila_foto = mysql_fetch_assoc($result_foto);	
	?>
        <meta property="og:url" content="<?php echo "http://" . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"] ?>"/>
        <meta property="og:site_name" content="<?php echo NOMBRE_CLIENTE;?>"/>
        <meta property="og:title" content="<?php echo $datos["noti_titulo"];?>"/>
        <meta property="og:description" content="<?php echo $datos["noti_copete"];?>"/>
        <meta property="og:type" content="article"/>
        <meta property="og:image" content="http://www.tarsis.com.ar/<?php echo $this->ruta_archivo.rawurlencode($fila_foto['foto_archivo']);?>"/>
	<?
	}	
	
	
	//-------------------------------------------------------------------------------------------------------
	function LimpioNombre($cadena)	{

			$cadena = strtolower($cadena);
			$buscar = array(".",",","?","?","?","?","?","?","?","?","?","?","?","?"," ","'","&","?","?","?","?","?","?","?","?"."?"."?");
			$reemplazar = array ("","","n","a","e","i","o","u","n","a","e","i","o","u","-","","y", "a","a","e","e","i","i","o","o","u","u");
			$cadena = str_replace($buscar,$reemplazar,$cadena);

			return $cadena;
		}

	//-----------------------------------------------------------------------------------------------------
    function armarUrl($titulo, $url)    {

        if ($url == "")
            $cadena = LimpioNombre($titulo);
        else
            $cadena = $url;

        return $cadena;
    }
	

}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editar Texto</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
</head>
<?php
function freeRTE_Preload($content) {
	// Strip newline characters.
	$content = str_replace(chr(10), " ", $content);
	$content = str_replace(chr(13), " ", $content);
	// Replace single quotes.
	$content = str_replace(chr(145), chr(39), $content);
	$content = str_replace(chr(146), chr(39), $content);
	// Return the result.
	return $content;
}
// Send the preloaded content to the function.
$content = freeRTE_Preload($_POST['texto_html']);
?>

<script type="text/javascript" language="javascript">
	function ActualizarTexto($texto) {
		window.opener.document.formulario.noti_texto.value = $texto
		window.opener.document.getElementById("divtexto").innerHTML = $texto
		window.close();
		return true; 
	
	}
</script>
<script src="richtext/js/richtext.js" type="text/javascript" language="javascript"></script>
<script src="richtext/js/richtextconfig.js" type="text/javascript" language="javascript"></script>
<form name="form_texto" id="form_texto" method="post" action="<? echo $_SERVER['PHP_SELF']?>">
<script>
initRTE(window.opener.document.formulario.noti_texto.value);

</script>
</form>
<a href="javascript:void(0)" class="textoNormal" onclick="javascript:rteFormHandler();ActualizarTexto(document.form_texto.texto_html.value)"><img src="images/ico_ok.png" border="0" />Actualizar</a>
<a href="javascript:void(0)" class="textoNormal" onclick="javascript:window.close()"><img src="images/ico_borrar.png" border="0" />Cerrar</a>
</body>
</html>

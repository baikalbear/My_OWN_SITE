<?//Система обработки ошибок

//Типы ошибок PHP
$errors = [1=>'E_ERROR', 2=>'E_WARNING', 4=>'E_PARSE', 8=>'E_NOTICE', 16=>'E_CORE_ERROR', 32=>'E_CORE_WARNING',
			64=>'E_COMPILE_ERROR', 128=>'E_COMPILE_WARNING', 256=>'E_USER_ERROR', 512=>'E_USER_WARNING', 1024=>'E_USER_NOTICE'];

function crash_without_exit($str, $style_no=1){
		echo "<link href=\"/assets/admin.css\" rel=\"stylesheet\">" . "<span class=\"msg-error-style{$style_no}\">" . $str . "</span>";
}

function crash($str, $style_no=1) {
	crash_without_exit($str, $style_no);
	exit;
}

ini_set("display_errors", "off");

error_reporting(E_ALL);

//Функция-обработчик ошибок
function handle_error($errno, $errstr, $errfile, $errline){
	$output = "Тип ошибки: #$errno ({$GLOBALS['errors'][$errno]})<br/>";
	$output .= " В файле '$errfile'<br/>";
	$output .= "На строке '$errline'<br/>";
	$output .= "Информация для отладки:<br/><br/><pre style='background:#FFFACD;'>" . print_r($errstr, true) . "</pre>";
	
	if($errno != E_NOTICE){
		echo "<div style='padding:10px;background:#F0E68C;display:inline-block;'><b>Системная ошибка</b><br/>" . $output . "</div";
	}
}

function handle_fatal_error(){
    $error = error_get_last();
	if ($error !== NULL){
		$errno   = $error["type"];
		$errfile = $error["file"];
		$errline = $error["line"];
		$errstr  = $error["message"];
		
		handle_error($errno, $errstr, $errfile, $errline);
	}
}

set_error_handler("handle_error");
register_shutdown_function("handle_fatal_error");
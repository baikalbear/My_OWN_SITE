<?php

function crash_without_exit($str, $style_no=1){
	echo "<link href=\"/assets/app.css\" rel=\"stylesheet\">" . "<span class=\"mys{$style_no}\">" . $str . "</span>";
}

function crash($str, $style_no=1) {
	crash_without_exit($str, $style_no);
	exit;
}

//mds - "My decoration system" или "Моя система декорирования"
function mds($command, $string=""){
	$command = "  " . $command . " ";
	$tag = "div";

	//тема
	if(strripos($command, " код ")){
			$style = "padding:4px 8px;background:#B0E0E6;font-size:11pt;font-style:italic;";
	}
	
	if(strripos($command, "предупреждение")){
		$style = "padding:4px 8px;background:#DDA0DD;font-size:11pt;";
	}

	if(strripos($command, " инфо-бледный-золотарник")){
		$style = "padding:4px 8px;background:#EEE8AA;font-size:11pt;";
	}

	if(strripos($command, " инфо-жёлто-зелёный")){
		$style = "padding:4px 8px;background:#9ACD32;font-size:11pt;";
	}
	
	//элемент/промежуток
	if(strripos($command, " блок ")){
		$style .= "display:block;";
		
	}elseif(strripos($command, " линейный ")){
		$style .= "display:inline;";
	}else{
		//линейный-блок
		$style .= "display:inline-block;vertical-align:top;";
	}
	
	//оформляю в html
	if(strripos($command, " открыть-тэг ")){
		$html = "<$tag style=\"{$style}\">";
	}elseif(strripos($command, " закрыть-тэг ")){
		$html = "</$tag>";
	}else{
		$html = "<$tag style=\"{$style}\">$string</$tag>";
	}
	
	if(strripos($command, " показать ")){
		echo $html;
	}
	
	return $html;
}
	
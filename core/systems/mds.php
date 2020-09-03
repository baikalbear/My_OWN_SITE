<?php

//mds - "My decoration system" или "Моя система декорирования"
function mds($command, $string=""){
	$command = "  " . $command . " ";
	$tag = "div";

	//тема
	if(strripos($command, " код ")){
			$style = "padding:4px 8px;background:#FFEFD5;font-size:11pt;font-style:italic;";
	}
	
	if(strripos($command, "предупреждение")){
		$style = "padding:4px 8px;background:#DDA0DD;font-size:11pt;";
	}
	
	if(strripos($command, " инфо-")){
		$style .= "padding:4px 8px;font-size:11pt;";
	}

	if(strripos($command, " инфо-бледный-золотарник")){
		$style .= "background:#EEE8AA;";
	}

	if(strripos($command, " инфо-жёлто-зелёный")){
		$style .= "background:#9ACD32;";
	}

	if(strripos($command, " инфо-зелёный-лайм")){
		$style .= "background:#32CD32;";
	}
	
	if(strripos($command, " инфо-умеренный-аквамарин")){
		$style .= "background:#66CDAA;";
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
	
	//Параграф
	if(strripos($command, " параграф ")){
		$paragraph_open_tag = "<p>";
		$paragraph_close_tag = "</p>";
	}
	
	//оформляю в html
	if(strripos($command, " открыть-тэг ")){
		$html = "$paragraph_open_tag<$tag style=\"{$style}\">";
	}elseif(strripos($command, " закрыть-тэг ")){
		$html = "</$tag>$paragraph_close_tag";
	}else{
		$html = "$paragraph_open_tag<$tag style=\"{$style}\">$string</$tag>$paragraph_close_tag";
	}
	
	if(strripos($command, " показать ")){
		echo $html;
	}
	
	return $html;
}
	
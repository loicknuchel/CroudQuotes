<?php

include_once $rel.'utils/checkVars.php';

function iptoint($ip){
	return bintodec(iptobin($ip));
}

function inttoip($int){
	return bintoip(dectobin((float) $int, 32));
}

function ipmasque($ip, $mask){
	return inttoip( floor(iptoint($ip) / pow(2, 32-$mask)) * pow(2, 32-$mask) );
}

function random_string($nb){
	$sid="";
	srand(time()); //initialisation du nombre semi aleatoire avec le timestamp
	$choix ="abcdefghijklmnopqrstuvwxyz";
	$choix.="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$choix.="01234567890123456789012345";
	$choix.="&#'{([-|_^@)]=}*%,?;.:/!+<";
	for($i=0;$i<$nb;$i++){
		$indice=rand()%strlen($choix);
		$sid.=substr($choix,$indice,1);
	}
	return $sid;
}


function iptobin($ip){
	if(is_ip($ip) == 1){
		$iparray = explode(".", $ip);
		return dectobin($iparray[0], 8).dectobin($iparray[1], 8).dectobin($iparray[2], 8).dectobin($iparray[3], 8);
	}
	else{
		return "";
	}
}

function bintoip($bin){
	$add = '';
	for($i=0; $i<32-strlen($bin); $i++){
		$add .= "0";
	}
	$bin = $bin.$add;
	
	$ip1 = bindec(substr($bin, 0, 8));
	$ip2 = bindec(substr($bin, 8, 8));
	$ip3 = bindec(substr($bin, 16, 8));
	$ip4 = bindec(substr($bin, 24, 8));
	
	return $ip1.'.'.$ip2.'.'.$ip3.'.'.$ip4;
}

function dectobin($int, $size=0){
	$bin = decbin((float) $int);
	if($size != 0 && $size > strlen($bin)){
		$add = "";
		for($i=0; $i<$size-strlen($bin); $i++){
			$add .= "0";
		}
		$bin = $add.$bin;
	}
	return $bin;
}

function bintodec($bin){
	return bindec($bin);
}




?>
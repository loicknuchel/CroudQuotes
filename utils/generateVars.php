<?php

function generateRandomString($lenght, $complexity = 2){
	if($complexity == 1){$max = 10; $chars = "0123456789";}
	if($complexity == 2){$max = 26; $chars = "abcdefghijklmnopqrstuvwxyz";}
	if($complexity == 3){$max = 36; $chars = "0123456789abcdefghijklmnopqrstuvwxyz";}
	if($complexity == 4){$max = 62; $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";}
	if($complexity == 5){$max = 96; $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ&~#'{([-|`_^@)]=}+*<>,?;.:/!§%£€¨µ";}
	else {$max = 36; $chars = "0123456789abcdefghijklmnopqrstuvwxyz";}
	
	$ret = '';
	for($i=0; $i<$lenght; $i++){
		$ret .= $chars[mt_rand(0,($max-1))];
	}
	
	return $ret;
}

?>
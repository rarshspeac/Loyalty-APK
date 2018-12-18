<?php
function isi($acak = true){
	if($acak){
		$randProp = "abcdefghijklmnopqrstuvwxyz1234567890";
		$container = "";
		for($i = 1; $i <= 8; $i++){
			$container .= $randProp[rand(0, strlen($randProp) - 1)];
		}
	}else{
		$randProp = "abcdefghijklmnopqrstuvwxyz";
		$container = "";
		for($i = 1; $i <= 8; $i++){
			$container .= $randProp[rand(0, strlen($randProp) - 1)];
		}
	}
	return $container;
}
echo "Powered by @rvvrivai ".date("Y")."\n";
$getSocks = file_get_contents("socks.txt");
$explodeSocks = explode("\n", $getSocks);
echo "Direkomendasikan Looping : ".count($explodeSocks)."\n";
echo "Masukkan REFFERAL Anda\nInput : ";
$reff = trim(fgets(STDIN));
$k = 0;
for($i = 1; $i <= count($explodeSocks); $i++){
	$nama = "isi";
	$nama = $nama(false);
	$password = "isi";
	$password = $password();
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://indonesiareward.com/api/v3/account.signUp.php");
	curl_setopt($ch, CURLOPT_USERAGENT, "Dalvik/2.1.0 (Linux; U; Android 8.1.0; MI 6X MIUI/V10.0.3.0.ODCCNFH)");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "password={$password}&clientId=1&fullname={$nama}&email={$nama}%40gmail.com&username={$nama}&");
	curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
    curl_setopt($ch, CURLOPT_PROXY, $explodeSocks[$k]);
    $result = curl_exec($ch);
    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$headers = substr($result, 0, $header_size);
	$body = substr($result, $header_size);
    curl_close($ch);
    $decodeResult = json_decode($body, true);
    if($decodeResult['error'] === false && $decodeResult['error_code'] === 0){
    	echo "Sukses Regist => username : ".$decodeResult['account'][0]['username'].", Password : ".$password."\n";
    	$fopen = fopen("akun.txt", "a");
    	fwrite($fopen, $decodeResult['account'][0]['username']."|".$password."\n");
    	fclose($fopen);
    	$accID = $decodeResult['accountId'];
    	$atok = $decodeResult['accessToken'];
    	$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://indonesiareward.com/api/v3/account.Refer.php");
		curl_setopt($ch, CURLOPT_USERAGENT, "Dalvik/2.1.0 (Linux; U; Android 8.1.0; MI 6X MIUI/V10.0.3.0.ODCCNFH)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "data=%7B%22clientId%22%3A%221%22%2C%22accountId%22%3A%22{$accID}%22%2C%22accessToken%22%3A%22{$atok}%22%2C%22user%22%3A%22{$nama}%22%2C%22name%22%3A%22refer%22%2C%22value%22%3A%22{$reff}%22%2C%22dev_name%22%3A%22MI+6X%22%2C%22dev_man%22%3A%22Xiaomi%22%2C%22ver%22%3A%223.0%22%2C%22pckg%22%3A%22com.loyaltyreward.application%22%7D&");
		curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, true);
	    curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS4);
	    curl_setopt($ch, CURLOPT_PROXY, $explodeSocks[$k]);
	    $result = curl_exec($ch);
	    $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
		$headers = substr($result, 0, $header_size);
		$body = substr($result, $header_size);
	    curl_close($ch);
	    $decodeResult = json_encode($body, true);
	    if($decodeResult['error'] === false && $decodeResult['error_code'] === 0){
	    	echo $decodeResult['response_title']." => ".$decodeResult['response_message']."\n";
	    }else{
	    	if($decodeResult == null || empty($decodeResult)){
    			echo "DIE SOCKS / TIMEOUT";
    		}else{
	    		echo $decodeResult['response_title']." => ".$decodeResult['response_message']."\n";
	    	}
	    }
    }else{
    	if($decodeResult == null || empty($decodeResult)){
    		echo "DIE SOCKS / TIMEOUT";
    	}else{
    		echo $decodeResult['error_code']." => ".$decodeResult['error_description']."\n";
    	}
    	$k++;
    }
}
?>
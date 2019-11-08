<?php
 
require_once('color.php');

function nama()
	{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://ninjaname.horseridersupply.com/indonesian_name.php");
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$ex = curl_exec($ch);
	// $rand = json_decode($rnd_get, true);
	preg_match_all('~(&bull; (.*?)<br/>&bull; )~', $ex, $name);
	return $name[2][mt_rand(0, 14) ];
	}
function register($no)
	{
	$nama = nama();
	$nama1 = "Ibnu";
	$email = str_replace(" ", "", $nama) . mt_rand(100, 999);
	$data = '{"name":"' . $nama1 . '","email":"' . $email . '@gmail.com","phone":"+' . $no . '","signed_up_country":"ID"}';
	$register = request("/v5/customers", "", $data);
	//print_r($register);
	if ($register['success'] == 1)
		{
		return $register['data']['otp_token'];
		}
	  else
		{
      save("error_log.txt", json_encode($register));
		return false;
		}
	}
function verif($otp, $token)
	{
	$data = '{"client_name":"gojek:cons:android","data":{"otp":"' . $otp . '","otp_token":"' . $token . '"},"client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e"}';
	$verif = request("/v5/customers/phone/verify", "", $data);
	if ($verif['success'] == 1)
		{
		return $verif['data']['access_token'];
		}
	  else
		{
      save("error_log.txt", json_encode($verif));
		return false;
		}
	}
	function login($no)
	{
	$nama = nama();
	$email = str_replace(" ", "", $nama) . mt_rand(100, 999);
	$data = '{"phone":"+'.$no.'"}';
	$register = request("/v4/customers/login_with_phone", "", $data);
	//print_r($register);
	if ($register['success'] == 1)
		{
		return $register['data']['login_token'];
		}
	  else
		{
      save("error_log.txt", json_encode($register));
		return false;
		}
	}
function veriflogin($otp, $token)
	{
	$data = '{"client_name":"gojek:cons:android","client_secret":"83415d06-ec4e-11e6-a41b-6c40088ab51e","data":{"otp":"'.$otp.'","otp_token":"'.$token.'"},"grant_type":"otp","scopes":"gojek:customer:transaction gojek:customer:readonly"}';
	$verif = request("/v4/customers/login/verify", "", $data);
	if ($verif['success'] == 1)
		{
		return $verif['data']['access_token'];
		}
	  else
		{
      save("error_log.txt", json_encode($verif));
		return false;
		}
	}
function claim($token)
	{
	$data = '{"promo_code":"COBAINGOJEK"}';
	$claim = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim['success'] == 1)
		{
		return $claim['data']['message'];
		}
	  else
		{
      save("error_log.txt", json_encode($claim));
		return false;
		}
	}

function claim2($token)
	{
	$data = '{"promo_code":"AYOCOBAGOJEK"}';
	$claim2 = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim2['success'] == 1)
		{
		return $claim2['data']['message'];
		}
	  else
		{
      save("error_log.txt", json_encode($claim2));
		return false;
		}
	}

function claim3($token)
	{
	$data = '{"promo_code":"GOFOODBOBA07"}';
	$claim3 = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim3['success'] == 1)
		{
		return $claim3['data']['message'];
		}
	  else
		{
      save("error_log.txt", json_encode($claim3));
		return false;
		}
	}

	function claim4($token)
	{
	$data = '{"promo_code":"GOFOODBOBA10"}';
	$claim4 = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim4['success'] == 1)
		{
		return $claim4['data']['message'];
		}
	  else
		{
      save("error_log.txt", json_encode($claim4));
		return false;
		}
	}

	function claim5($token)
	{
	$data = '{"promo_code":"GOFOODBOBA19"}';
	$claim5 = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	if ($claim5['success'] == 1)
		{
		return $claim5['data']['message'];
		}
	  else
		{
      save("error_log.txt", json_encode($claim5));
		return false;
		}
	}

$banner = "
=========================================
[+] Auto Create GOJEK + Claim Voucher [+]
=========================================
\n\n";

echo $banner;
echo "1. Daftar \n";
echo "2. Login \n";
echo "Masukan Pilihan : ";
$type = trim(fgets(STDIN));

//				DAFTAR
if($type == 1){
echo "\n";
echo Console::blue("          Kamu Memilih Daftar\n");
echo "========================================\n";
echo "INFO :Awali 0 untuk Indo dan 1 untuk US\n";
echo "========================================\n";
echo "Masukan Nomer : ";
$nope = trim(fgets(STDIN));
$numbers = $nope[0].$nope[1];
if($numbers == "08") { 
	$nope = str_replace("08","+628",$nope);
}
$register = register($nope);
if ($register == false)
	{
	echo "\n";
	echo Console::red("Gagal Ngambil OTP\n");
	}
  else
	{
	echo "Masukan Kode OTP : ";
	// echo "Enter Number: ";
	$otp = trim(fgets(STDIN));
	$verif = verif($otp, $register);
	if ($verif == false)
		{
		echo "\n";
		sleep(1);
		echo Console::red("[-] Gagal Daftarin nomer kamu!\n");
		}
	  else
		{
		echo "\n";
		sleep(1);
		echo Console::light_green("[+] Pendaftaran Akun Berhasil");
		echo "\n\n";

		sleep(5);

		// CLAIM VOUCHER PERTAMA
		$claim = claim($verif);
		if ($claim == false)
			{
			echo Console::red("[-] Gagal Claim Voucher Go-Ride 10K Pertama\n");
			}
		  else
			{
			echo Console::light_green("[+] Berhasil Claim Voucher Go-Ride 10K Pertama\n");
		}

		sleep(5);
		$claim2 = claim2($verif);
			if ($claim2 == false)
			{
				echo Console::red("[-] Gagal Claim Voucher Go-Ride 10K Kedua\n");
			}
		  	else
			{
				echo Console::light_green("[+] Berhasil Claim Voucher Go-Ride 10K Kedua \n");
			}

		sleep(5);
		$claim3 = claim3($verif);
			if ($claim3 == false)
			{
				echo Console::red("[-] Gagal Claim Voucher Go-Food 20K\n");
			}
		  	else
			{
				echo Console::light_green("[+] Berhasil Claim Voucher Go-Food 20K \n");
			}

			sleep(5);
		$claim4 = claim4($verif);
			if ($claim4 == false)
			{
				echo Console::red("[-] Gagal Claim Voucher Go-Food 15K\n");
			}
		  	else
			{
				echo Console::light_green("[+] Berhasil Claim Voucher Go-Food 15K \n");
			}

			sleep(5);
		$claim5 = claim5($verif);
			if ($claim5 == false)
			{
				echo Console::red("[-] Gagal Claim Voucher Go-Food 10K\n");
			}
		  	else
			{
				echo Console::light_green("[+] Berhasil Claim Voucher Go-Food 10K \n");
			}
		}
	}
}
else if($type == 2){
echo "\n";
echo Console::blue("          Kamu Memilih Login\n");
echo "========================================\n";
echo "INFO :Awali 62 untuk Indo dan 1 untuk US\n";
echo "========================================\n";
echo "Masukan Nomer : ";
$nope = trim(fgets(STDIN));
$numbers = $nope[0].$nope[1];
if($numbers == "08") { 
	$nope = str_replace("08","+628",$nope);
}
$login = login($nope);
if ($login == false)
	{
	echo "\n";
	echo Console::red("Gagal Ngambil OTP \n");
	}
  else
	{
	echo "Masukan Kode OTP : ";
	// echo "Enter Number: ";
	$otp = trim(fgets(STDIN));
	$verif = veriflogin($otp, $login);
	if ($verif == false)
		{
		sleep(1);
		echo Console::red("> Gagal Login dengan nomer kmu!\n");
		}
	  else
		{
		echo "\n";
		sleep(1);
		echo Console::light_green("> Login Berhasil");
		echo "\n";

		// CLAIM VOC GO-FOOD
		sleep(2);
		echo "> Sedang Claim Voucher Go-Food...\n";
		$claim = claim($verif);
		if ($claim == false)
			{
			sleep(3);
			echo Console::red("> Gagal Claim Voucher\n");
			}
		  else
			{
			sleep(3);
			echo Console::light_green("> Berhasil Claim Voucher Go-Food\n");
			sleep(1);
			echo $claim . "\n\n";

			// CLAIM VOUCHER GO-RIDE
			sleep(1);
			echo "> Mencoba Claim Voucher Ke-2...\n";
			sleep(2);
			echo "> Mohon Tunggu Sebentar...\n\n";

			sleep(5);
			echo "> Sedang Claim Voucher Go-Ride...\n";
			$claim2 = claim2($verif);
		if ($claim2 == false)
			{
			sleep(3);
			echo Console::red("> Gagal Claim Voucher\n");
			}
		  else
			{
			sleep(3);
			echo Console::light_green("> Berhasil Claim Voucher Go-Ride \n");
			sleep(1);
			echo $claim . "\n\n";

			// CLAIM VOUCHER CB 100%
			sleep(1);
			echo "> Mencoba Claim Voucher Ke-3...\n";
			sleep(2);
			echo "> Mohon Tunggu Sebentar...\n\n";

			sleep(5);
			echo "> Sedang Claim Voucher CB 100%...\n";
			$claim3 = claim3($verif);
		if ($claim3 == false)
			{
			sleep(3);
			echo Console::red("> Gagal Claim Voucher\n");
			}
		  else
			{
			sleep(3);
			echo Console::light_green("> Berhasil Claim Voucher CB 100% \n");
			sleep(1);
			echo $claim . "\n\n";

			sleep(1);
			echo Console::light_green("        Happy Nuyul ^_^\n");
					}
				}
			}
		}
	}
}

function request($url, $token = null, $data = null, $pin = null){

$header[] = "Host: api.gojekapi.com";
$header[] = "User-Agent: okhttp/3.10.0";
$header[] = "Accept: application/json";
$header[] = "Accept-Language: en-ID";
$header[] = "Content-Type: application/json; charset=UTF-8";
$header[] = "X-AppVersion: 3.30.2";
$header[] = "X-UniqueId: ".time()."57".mt_rand(1000,9999);
$header[] = "Connection: keep-alive";
$header[] = "X-User-Locale: en_ID";
//$header[] = "X-Location: -6.3894201,106.0794195";
//$header[] = "X-Location-Accuracy: 3.0";
if ($pin):
$header[] = "pin: $pin";
    endif;
if ($token):
$header[] = "Authorization: Bearer $token";
endif;
$c = curl_init("https://api.gojekapi.com".$url);
    curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
    if ($data):
    curl_setopt($c, CURLOPT_POSTFIELDS, $data);
    curl_setopt($c, CURLOPT_POST, true);
    endif;
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_HEADER, true);
    curl_setopt($c, CURLOPT_HTTPHEADER, $header);
    $response = curl_exec($c);
    $httpcode = curl_getinfo($c);
    if (!$httpcode)
        return false;
    else {
        $header = substr($response, 0, curl_getinfo($c, CURLINFO_HEADER_SIZE));
        $body   = substr($response, curl_getinfo($c, CURLINFO_HEADER_SIZE));
    }
    $json = json_decode($body, true);
    return $json;
}
function save($filename, $content)
{
	$save = fopen($filename, "a");
	fputs($save, "$content\r\n");
	fclose($save);
}

?>
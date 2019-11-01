<?php
 
require_once('color.php');

// function lisensi($url){
//      $session = curl_init(); // buat session
//      // setting CURL
//      curl_setopt($session, CURLOPT_URL, $url);
//   curl_setopt($session, CURLOPT_RETURNTRANSFER, 1);
//      $hasil = curl_exec($session);
//      curl_close($session);
//      return $hasil;
// }

// $sumber =  lisensi('http://sma5purworejo.sch.id/lisensi.html');
// $ambil_kata = explode('<h1>', $sumber);
// $ambil_kata_lagi = explode('</h1>', $ambil_kata[2]);

// $liss = $ambil_kata_lagi[0];
// echo $liss;

// // $liss = licesnce();
// 	echo "\nMasukan Lisensi Anda : ";
// 	$lis = trim(fgets(STDIN));

// 	echo "Mengecek Lisensi Anda...\n";
// 	sleep(3);

// 	if ($lis == $liss) {
// 		echo "Lisensi Anda Aktif\n\n";
// 		sleep(3);
// 	}
// 	else{
// 		echo "Mikir BOSSS \n";
// 		exit();
// 	}

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
	$nama1 = "Nembi Ayu";
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
function claimm($token)
	{
	$data = '{"promo_code":"NO"}';
	$claimm = request("/go-promotions/v1/promotions/enrollments", $token, $data);
	save2("x.txt", ($token));
        echo $token."\n";
	if ($claimm['success'] == 1)
		{
		return $claimm['data']['message'];
		}
	  else
		{
      save("error_log.txt", json_encode($claimm));
		return false;
		}
	}

	function claim($token)
	{
	$data = '{"promo_code":"AYOCOBAGOJEK"}';
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
	$data = '{"promo_code":"COBAINGOJEK"}';
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
	$data = '{"promo_code":"GOFOODBOBA10"}';
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
	$data = '{"promo_code":"GOFOODBOBA07"}';
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

$banner = "
=========================================
[+] Auto Create GOJEK + Claim Voucher [+]

       Coded By : Verel Praditya
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
		echo Console::red("> Gagal Daftarin nomer kamu!\n");
		}
	  else
		{
		echo "\n";
		sleep(1);
		echo Console::light_green("[+] Pendaftaran Akun Berhasil\n");
                save("x.txt", ("+".$nope."|"));
                echo "\n";

                sleep(2);
                $claimm = claimm($verif);
                if ($claimm == false)
                        {
                        echo $token;
                        echo Console::light_green("[+] Token Berhasil Disimpan di x.txt");
                }
                 else
                        {
                        echo $token;
                        echo Console::light_green("[+] Token Berhasil Disimpan di x.txt");
                }
                sleep(1);
	        echo "\nApakah Mau Claim Voucher? (Y/T) : ";
		sleep(1);
                echo "y\n";
                $pilihan2 = 'y';

		if ($pilihan2 == "y" or $pilihan2 == "Y") {
		// CLAIM VOUCHER PERTAMA
		sleep(3);
	// 	$claim = claim($verif);
	// 	if ($claim == false)
	// 		{
	// 		sleep(1);
	// 		echo Console::red("[-] Gagal Claim Voucher\n");
	// 		}
	// 	  else
	// 		{
	// 		echo Console::light_green("[+] Berhasil Claim Voucher Go-Ride\n");
	// 		sleep(1);
	// }
}
		else{
			echo "Ok Program Akan Berhenti...\n";
			exit;
		}

			// CLAIM VOUCHER KEDUA

		// sleep(5);
		// $claim2 = claim2($verif);
		// 	if ($claim2 == false){
		// 		echo Console::red("[-] Gagal Claim Voucher Go-Ride 2\n");
		// 	}
		//   	else
		// 	{
		// 		echo Console::light_green("[+] Berhasil Claim Voucher Go-Ride 2\n");
		// 		sleep(1);
		// 	}

		 	// CLAIM VOUCHER KETIGA
		// sleep(5);
		// $claim3 = claim3($verif);
		// 	if ($claim3 == false){
		// 		echo Console::red("[-] Gagal Claim Voucher Go-Food 15K\n");
		// 	}
		//   	else
		// 	{
		// 		echo Console::light_green("[+] Berhasil Claim Voucher Go-Food 15K\n");
		// 		sleep(1);
		// 	}

		sleep(5);
		$claim4 = claim4($verif);
                	if ($claim4 == false){
				echo Console::red("[-] Gagal Claim Voucher Go-Food 20K\n");
			}
		  	else
			{
				echo Console::light_green("[+] Berhasil Claim Voucher Go-Food 20K\n");
				sleep(1);
			}
		}
	}
}

if($type == 2){
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
		echo Console::red("[-] Gagal Login dengan nomer kmu!\n");
		}
	  else
		{
		echo "\n";
		sleep(1);
		echo Console::light_green("[+] Login Berhasil");
		sleep(2);
		save("x.txt", ("+".$nope."|"));
		echo "\n";
	}

		sleep(2);
		$claimm = claimm($verif);
		if ($claimm == false)
			{
			echo Console::light_green("[+] Token Berhasil Di simpan di x.txt\n");
		}
		 else
			{
			echo Console::light_green("[+] Token Berhasil Di simpan di x.txt\n");
		}

		// $fileakun = x.txt;

		// for ($i=0; $i < 100; $i++) { 
		// 	count(explode("\n", str_replace("\r","",@file_get_contents($fileakun))))
		// }
		// 	sleep(1);
		// 	echo $claim . "\n\n";

		// 	// CLAIM VOUCHER GO-RIDE
		// 	sleep(1);
		// 	echo "> Mencoba Claim Voucher Ke-2...\n";
		// 	sleep(2);
		// 	echo "> Mohon Tunggu Sebentar...\n\n";

		// 	sleep(5);
		// 	echo "> Sedang Claim Voucher Go-Ride...\n";
		// 	$claim2 = claim2($verif);
		// if ($claim2 == false)
		// 	{
		// 	sleep(3);
		// 	echo Console::red("> Gagal Claim Voucher\n");
		// 	}
		//   else
		// 	{
		// 	sleep(3);
		// 	echo Console::light_green("> Berhasil Claim Voucher Go-Ride \n");
		// 	sleep(1);
		// 	echo $claim . "\n\n";

		// 	// CLAIM VOUCHER CB 100%
		// 	sleep(1);
		// 	echo "> Mencoba Claim Voucher Ke-3...\n";
		// 	sleep(2);
		// 	echo "> Mohon Tunggu Sebentar...\n\n";

		// 	sleep(5);
		// 	echo "> Sedang Claim Voucher CB 100%...\n";
		// 	$claim3 = claim3($verif);
		// if ($claim3 == false)
		// 	{
		// 	sleep(3);
		// 	echo Console::red("> Gagal Claim Voucher\n");
		// 	}
		//   else
		// 	{
		// 	sleep(3);
		// 	echo Console::light_green("> Berhasil Claim Voucher CB 100% \n");
		// 	sleep(1);
		// 	echo $claim . "\n\n";

		// 	sleep(1);
		// 	echo Console::light_green("        Happy Nuyul ^_^\n");
		// 			}
				// }
			// }
		// }
	}
}

function request($url, $token = null, $data = null, $pin = null){

$header[] = "Host: api.gojekapi.com";
$header[] = "User-Agent: okhttp/3.12.1";
$header[] = "Accept: application/json";
$header[] = "Accept-Language: en-ID";
$header[] = "Content-Type: application/json; charset=UTF-8";
$header[] = "X-PhoneModel: Realme,X_Linux_Version";
$header[] = "X-DeviceOS: Andoid,9.0.0";
$header[] = "X-AppVersion: 3.37.2";
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
	fputs($save, "\n$content");
	fclose($save);
}

function save2($filename, $content)
{
	$save2 = fopen($filename, "a");
	fputs($save2, "$content");
	fclose($save2);
}

?>

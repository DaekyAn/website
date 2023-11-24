<?php 
session_start();
date_default_timezone_set("Europe/Paris");

include('../settings.php');
include('functions.php');


class KillBot {
    private string $apiKey;
    private string $config;

    public function __construct($api_key, $config) {
        $this->apiKey = $api_key;
        $this->config = $config;
    }

    // Get the visitor's real-ip address, depending on whether you're using a service like Cloudflare or not.
    private function get_client_ip(): string {
        // Get real visitor IP behind CloudFlare network
        if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
            $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
            $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
        }
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = $_SERVER['REMOTE_ADDR'];

        if(filter_var($client, FILTER_VALIDATE_IP)) {
            $ip = $client;
        } elseif(filter_var($forward, FILTER_VALIDATE_IP)) {
            $ip = $forward;
        } else {
            $ip = $remote;
        }

        return $ip;
    }

    private function httpGet($url): string {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_USERAGENT, 'KillBot.to Blocker-PHP');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $response = curl_exec($ch);
        return $response;
    }

    public function check(): array {
        $ip = $this->get_client_ip();
        $response = $this->httpGet("https://killbot.to/api/antiBots/" . $this->apiKey . "/check?config=" . $this->config . "&ip=" . $ip  . "&ua=" . urlencode($_SERVER['HTTP_USER_AGENT']));
        if (!$response) {
            return ['block' => false];
        }
        $decodedResponse = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            return ['block' => false];
        }
        return $decodedResponse;
    }
}

$Killbot = new KillBot($killbotToken, $killbotConfig);
$check = $Killbot->check();
if($check["block"]){
    if($killbot404){
        header("HTTP/1.0 404 Not Found"); 
        die("<h1>404 Not Found</h1>The page that you have requested could not be found.");
    }else{
        die(header("location: ".$killbotRedirect));
    }
}
if(isset($check["error"])){
    die("<a href='//killbot.to'>Killbot.to</a> error: " . $check["error"]);
}
//Your web application here
$IPLocation = $check["IPlocation"] ?? null; // Geo location datas of the IP Address

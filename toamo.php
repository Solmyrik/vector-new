<?php 
header('Content-Type: text/html; charset=utf-8');
echo 'ok';
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
ini_set('log_errors', 'On');
ini_set('error_log', 'php_errors.txt');

$time = date("d.m H:i");

$data = $_POST;
file_put_contents("leads.txt", $time." ".print_r($data, true)."".PHP_EOL, FILE_APPEND);
require_once "ebAmocrmClient.php";

$resp_user = '9023134';
$status_id = '53747490';

define('AC_PHONE_CID', '376287');
define('AC_EMAIL_CID', '376289');

$config = array(
    'secret_key' => "75VVXxAsr0ahNChd3oLk9sZFXullosqlKTo6S3RWDRkReU4pfhZauiHsXpu22Ky5", 
    'intagration_id' => "3b4c59b6-8d86-4b9a-a72d-f8725168f8a0", 
    'client_domen' => "amosteklo", 
    'redirect_uri' => "https://vekal24.ru/amocrm/toamo.php",  
    'auth_token' => "def502001285540ebc7d6fef215fc5e01d5eeeef5b10dbbccf02263eb1e46f9059492217215338447c82504b2411131bac0f4da49d93d5d330ad9cba59311207768172bfeb2e891d1b5b1ab7a081273eb76557db8c7b9885c5317ff819c784fa2ceb71b82e365802a1f97d11a9a80f3dcc8248410c2108c975a82b2760405866c2137d375d46c5e3352a538a85329558d46607773b6a4e3099a2dde58ccffc7e7e3d244188c0a87aba47d4b884406669d308ccdf27bc5e2523ad29ed5cea7d18f3ae16c5733f0b9a5ee66953060150c70ed0831afdce47542560c5cf7768e5d6372d42a328160150a947a0e56e7eec0b183744741830bb27f0719597b622f2bf2cdcf3eede3a94e5c48cad844bc327f040a82bf66cf26bc374ba88f245a6e33aa469a72f77e0c3af8c2f464044eeed1e47989454ac4805ee03bb700299f9f73634d9ab498594c4b44a16b0b9215bc6d40dffe64f88c75a0bfccff5dc48e107f9791cab53db045ed4fbf5a563d378c892115d570c6ef241c13dac8f9528f60711bda723898e833b46d8561e4b07818a6ca8ac9394bead86f1725d7184932fb0164df3c0c1d9a7d2860b471679ecb80bd3a23366e9a00d64e26a5f27c9cff07efe993d43d0769e7a29ec6c4772329c0abcf00bb44cc5225dd7aa911d56c8cf20782dbac860" //auth токен    
);


$sitename = 'vekal24.ru';
if(isset($data['currentPhone']))$phone = $data['currentPhone'];
if(isset($data['currentPhone']))$email = $data['currentPhone'];
if(isset($data['Имя']))$name = $data['Имя'];




if($a=='1'){
    $phone = '351246575335353';
$email = '232@ds.sd';
$name ='test';
}

if (isset($_COOKIE['utm_source'])) {$utm_source = $_COOKIE['utm_source'];}
if (isset($_COOKIE['utm_medium'])) {$utm_medium = $_COOKIE['utm_medium'];}
if (isset($_COOKIE['utm_campaign'])) {$utm_campaign = $_COOKIE['utm_campaign'];}
if (isset($_COOKIE['utm_content'])) {$utm_content = $_COOKIE['utm_content'];}
if (isset($_COOKIE['utm_term'])) {$utm_term = $_COOKIE['utm_term'];} 
$amo = new EbClientAmocrm($config['secret_key'], $config['intagration_id'], $config['client_domen'], $config['redirect_uri'], $config['auth_token']);

if($phone||$email){
function get_contact(){
    // 143 - отказ   142 - успешно 
    global $amo, $phone, $name,$email,$resp_user,$openlead;
    $contact = $amo ->get_contacts_by_pnone($phone)[1]['_embedded']['items'][0]; //получаем контакт через телефон
   if(!$contact&&$email) $contact = $amo ->get_contacts_by_email($email)[1]['_embedded']['items'][0]; //получаем контакт через емайл

    if(!$contact){
        $contact_config = array(
            'name' => $name,
            'responsible_user_id' => $resp_user,
            'custom_fields' => [
                [
                    'id' => AC_PHONE_CID,
                    'value' => $phone,
                    'enum' => 'WORK'
                ],
                   [
                    'id' => AC_EMAIL_CID,
                    'value' => $email,
                    'enum' => 'WORK'
                ]
            ]
        );
        $c = $amo -> create_contact($contact_config);
        return $c[1]['_embedded']['items'][0]['id'];
    }else{

               $leads = $contact['leads']['id']; // все сделки контакта
               print_r($leads);
        $completed = true;
        foreach($leads as $i){
            $status = $amo->get_leads($i)[1]['_embedded']['items'][0]['status_id'];
            $foundlead = $amo->get_leads($i)[1]['_embedded']['items'][0]['id'];

             //'Статус ' .print_r($status)."<br>";
            if($status != '143' && $status != '142'){
                //сделка уже существует 
                $completed = false;
				$openlead = $foundlead;
                echo $status."<br>";
 				echo "Открытый лид ".$openlead."<br>";
            }
        }
        if($completed){ //если у контакта нет текущих сделок
            echo "1"; 
            return $contact['id'];
        }else{
            echo "2";
            return false;
        }
    }
}


echo "<pre>";
$contact_id = get_contact();


if($contact_id){

    $lead_config = array(
        'contacts_id' => array($contact_id),
        'name' => 'Заявка с сайта ' .$sitename,
        'responsible_user_id' => $resp_user,
        'status_id' => $status_id,
        'tags' => 'ЗАЯВКА С САЙТА',
        'custom_fields' => [
          
            ['id' => 376301,'value' => $utm_source],
            ['id' => 376297,'value' => $utm_medium],
            ['id' => 376299,'value' => $utm_campaign],
            ['id' => 376295,'value' => $utm_content],
            ['id' => 376303,'value' => $utm_term],
        ]
    );
    $lead = $amo->create_lead($lead_config);
    echo $newlead;
    //print_r($test->get_leads());

    //$lead = $amo ->get_contacts_by_pnone($phone)[1]['_embedded']['items'][0]['leads']['id'][0]; 
// 7. примечание

	$note['text'] = 'Заявка с сайта: '.$sitename."\n";
    	foreach ($data as $key => $value){
        $e = true;
        if ( $key=='ga' || $key=='visitor_uid' || $key=='client_uid' || $key=='subscribe')     { $e = false; }
        // 
        if ($e) {

		$note['text'].=$key.': '.$value."\n";
	}
}

    $amo->create_note($lead, $note['text']);

}else{
   // $lead = $amo ->get_contacts_by_pnone($phone)[1]['_embedded']['items'][0]['leads']['id'][0]; 
   // $new_lead_id_status =  AC_STATUS_CID; //id статуса новой сделки
   // $leads['update'] = array([
   //     'updated_at' => strtotime("now"),
   //     'id' => $lead,
   //     'status_id' => $new_lead_id_status,
   // ]);
   // $amo->update_lead($lead, $leads);
    $note['text'] .= 'Повторная заявка с сайта ' .$sitename."\r\n";
    	foreach ($data as $key => $value){
        $e = true;
        if ( $key=='ga' || $key=='visitor_uid' || $key=='client_uid' || $key=='subscribe')     { $e = false; }
        // 
        if ($e) {

		$note['text'].=$key.': '.$value."\n";
	}
}
    $amo->create_note($openlead, $note['text']);

    $tasks['add'] = array(
        #Привязываем к сделке
        array(
            'element_id' => $openlead, #ID сделки
            'element_type' => 2, #Показываем, что это - сделка, а не контакт
            'task_type' => 3, 
            'text' => 'Проверить повторную заявку'
        )
    );
    $amo->create_task($tasks);
}
}

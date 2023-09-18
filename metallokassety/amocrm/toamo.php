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
                 
$resp_user = '9831030';
$status_id = '7027558';
define('AC_PHONE_CID', '376287');
define('AC_EMAIL_CID', '376289');

$config = array(
    'secret_key' => "yiSEd6p278PYLcvL0pGMr6cuv8k0BCtVMZcX1vB6ZjNTxBPQ5i9Hr1a2X7KnM1FM", 
    'intagration_id' => "cfbf3188-96b1-4543-a5c7-36edad8b869f", 
    'client_domen' => "amosteklo", 
    'redirect_uri' => "https://vekal24.ru/met/amocrm/toamo.php",  
    'auth_token' => "def5020044d22ca69aca92e2b8845d209d08b34be50ed8cc0a22020b4e0088bc12c9c40d1ae619a8902ac8fe3538b60805cd58ada8fa60da50defc47d2c20c6ffba1c1cec71e716d76a7c5b3ff120531d1e0e59e22987c3f331310fa46ff1309591ab85376b35010113c83914c5b66d8ddfcddedd7d0521456b34de847add16f3e27f5a0c68b2f7ffc149f5732a53b69dd552ed27f3e10fc6a95b0c8b262f2c0ae66f7df288b7e471a6ebbe61666b509f93f1876459d7a12e62c0d2a716752f4c03dc964817339ec6f541b55b932d18af066224e46da6ef6f8ac6a177b2e6fa906110504ef20138b420d69fd98b40bfd260e465cce28c7d35ed53804e9b68b9697a292d35d61b7be76b60a42ad6b2621ecdbddbb096e200e9df4c2d7b9c16a952cffa1286e96bb855d26800a0c6903c28ffdf56972995042d062adb5f7f0d84e8f46b6ab26421f7861b3701e73a758f369f6b1a93b87f09c7f59a0c9ff84670241f44322e0e10512773f551573160744c6a188ff931d1c4d3f5044c84b5b793ffbe02ca0217bcf500a7d6e74daecb9628bee606ffd9dde059497a59ece6bedd268b7d59fd16c7ec4f5bc5b7e7392204f9f7fc9a0f32d07aff525cef0907663d0d20de1cdc615a8b493c111da2cbf50edcc7a141b74ff34c8404aab6b377c5933a79ca8416491c54299de4db6f656b138222b9cc2823bedb497ce" //auth токен    
);


$sitename = 'vekal24.ru';
if(isset($data['#1']))$phone = $data['#1'];
if(isset($data['currentEmail']))$email = $data['currentEmail'];
if(isset($data['#2']))$name = $data['#2'];



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
                    'id' => 1272949,
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
        'tags' => 'Leadgenerator',
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

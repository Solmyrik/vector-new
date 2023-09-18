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
$status_id = '7009678';
define('AC_PHONE_CID', '376287');
define('AC_EMAIL_CID', '376289');

$config = array(
    'secret_key' => "75VVXxAsr0ahNChd3oLk9sZFXullosqlKTo6S3RWDRkReU4pfhZauiHsXpu22Ky5", 
    'intagration_id' => "3b4c59b6-8d86-4b9a-a72d-f8725168f8a0", 
    'client_domen' => "amosteklo", 
    'redirect_uri' => "https://vekal24.ru/amocrm/toamo.php",  
    'auth_token' => "def50200e84c921c74740c9ed17a7d1ba4c014409bf0bcdcf492903832fb6e025cce79fbc9ab946158a12b889e2944e9db279e0f32c20741b3a66178143bc7f19e5932dd6c4f229d1145649415615156cde064862422c535bdf1b5aa579befe2d8818a9b0e494c69838ff51693a1b7b261c07ed712b0680402b025b456c83166a82d635a0b456b3ade185da5c21c9e51c0832010017c05a2f20e1637df2b1fb930fbb1307731710b8dea270e638312d56ea6a651186745e5b5e48b13f6e61801e887abe53f3ad6d9770aa30b0e0adccecb57009bc8b13dc09a4384faf80714e564181921532f11e0e9b0916463af30e9d09ffd2191888b4cd0714fde685b34377f125333b830e09c02c5769d531acc1e587fc7d301616b385535aa9ace8771db6390c9b94ba4a09d38b84ed1b8a423ba6a8b28db02e86101d92470815fbf4af32fe0a4f33791babcd519acae432fc22efaff960799e95386200bb44a057653831d20be63b366ed8e0852644c8f1edd9c3418b82ef1052fe253d7e80d1663e63d7018e14b986aa38502fd7e85ba680ea447524bacced1e90170a1cdf4d746252f285c165f014a965faa10fdee322082dbaffc6a85f1c237e9907a3d5165c1e5ba4cd6b5a5ddcef353ad77865eeaca2cc6ad59908f3acd9685462bff82d7eb0ff3cd8b736a9568" //auth токен    
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

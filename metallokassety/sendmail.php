<?php
//$a=1;
    if(isset($_POST['#1'])){
      $page = $_POST["страница"]; 
      $currentPhone = $_POST["#1"]; 
      $name = $_POST["#2"]; 
      $one = $_POST["#3"]; 
      $two = $_POST["#4"]; 
      $three = $_POST["#5"]; 
      $body = '[Имя]:' . ' ' . $name . "\r\n"
      . '[Номер телефона]:' . ' ' . $currentPhone .  "\r\n"
       . $page .  "\r\n"
       . $one .  "\r\n"
       . $two .  "\r\n"
       . $three .  "\r\n";

      $theme = '[Заявка c формы]:';
      }

$to = "ar-1004@bk.ru"; /*Укажите ваш адрес электоронной почты*/
$headers = "Content-type: text/plain; charset = utf-8"."\r\n". "From:info2@proviplati.ru";
$subject = "[Заявка c формы]:";
$message = $body;
$send=mail($to, $subject, $message, $headers);

require_once 'amocrm/toamo.php';

  
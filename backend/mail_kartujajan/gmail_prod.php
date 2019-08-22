<?php

$urlnya = 'https://kartujajan.co.id/SERVICE/list_message/EMAIL/piewuroijlkjdio3892iolkejwoi938iuewi/OK';
$ch = curl_init();

curl_setopt( $ch, CURLOPT_AUTOREFERER, TRUE );
curl_setopt( $ch, CURLOPT_HEADER, 0 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_URL, $urlnya );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, TRUE );
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
$data_email = curl_exec( $ch );
curl_close( $ch );
//die($data_email);
$json_data = json_decode($data_email);

if(isset($json_data[0]->id)){
    date_default_timezone_set('Etc/UTC');
    require 'PHPMailerAutoload.php';
    $mail = new PHPMailer;
    $mail->isSMTP();

    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "teknologikartuindonesia@gmail.com";
    $mail->Password = "sabarsyukurikhlas";
    $mail->setFrom('noreply@kartujajan.co.id', 'Registrasi KartuJajan');
    $mail->addReplyTo('noreply@kartujajan.co.id', 'Registrasi KartuJajan');
    foreach ($json_data as $fetch){
        $mail->addAddress($fetch->nohp_email, 'KartuJajan');
        $mail->Subject = 'Registrasi KartuJajan';
        $mail->msgHTML($fetch->msg);
        $mail->AltBody = 'body';
        if (!$mail->send()) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
            echo "Message sent!";
        }
    }
    //$mail->addAttachment('images/phpmailer_mini.png');
}

echo '';

<?php
        $nohp="087886554052";
        $text1="alo apa kabar";
	$text = str_replace(' ', '%20', $text1);
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "http://sms.myiios.net:3080/cgi/WebCGI?1500101=account=indotara&password=1nd0t4r4123&port=1&destination=$nohp&content=$text",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
	curl_close($curl);

        echo $response;
?>

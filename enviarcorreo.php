<?php

/*** Aquí va el bloque de variables ***/
//Aquí va el destinatario del mensaje 
$destinatario = "gabriel.martin@uteq.edu.mx";
//Aquí va el correo a donde quieres que te respondan del mensaje 
$respondera = "gabrielmartinv@gmail.com";
//Aquí va el asunto del mensaje que quieres mandar.
$asunto = "hola";
//Aquí va el mensaje que quieres mandar.
$cuerpo = "hola";


// *** Nada de esto se toca: 
// *** Nada dije !.  >:(
$url = 'http://dtai.uteq.edu.mx/~gmartin/mailservice/mailservice.php';
$data = array('destinatario' => $destinatario, 'cuerpo' => $cuerpo, 'asunto' => $asunto, 'respondera' => $respondera, 'token' => "86ac4061879fcb180e7fefba0c21121d");
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data),
    ),
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);

if (strpos($result, "OKK200") !== false) {
    echo "Correo enviado exitosamente";
} else {
    echo $result;
}

<?php

$url = "https://publica.cnpj.ws/cnpj/07993973000118";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Para debug apenas!
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

$resp = curl_exec($curl);
curl_close($curl);

// Decodifica o JSON para um array associativo
$data = json_decode($resp, true);

// Verifica se a decodificação foi bem-sucedida
if ($data !== null) {
    // Obtém os valores de CNPJ, email e razão social
    $cnpj = $data['estabelecimento']['cnpj'];
    $razaoSocial = $data['razao_social'];
    $email = $data['estabelecimento']['email'];

    // Exibe os valores
    echo "CNPJ: $cnpj\n";
    echo "Razão Social: $razaoSocial\n";
    echo "Email: $email\n";
} else {
    echo "Erro ao decodificar o JSON.\n";
}

?>

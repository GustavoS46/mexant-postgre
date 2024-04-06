<?php
// Função para consultar o CNPJ
function consultarCNPJ($cnpj) {
    // URL da API ou do site que você quer consultar
    $url = "https://publica.cnpj.ws/cnpj/{$cnpj}";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // Desativar verificação SSL apenas para debug!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    curl_close($curl);

    // Verifica se houve erro na requisição
    if ($resp === false) {
        return json_encode(array("erro" => 'Problemas ao consultar CNPJ'));
    }

    // Convertendo a resposta para um array associativo
    $resultado = json_decode($resp, true);

    if(empty($resultado)){
        return json_encode(array("erro" => 'Problemas ao consultar CNPJ'));
    }

    if(isset($resultado['erro'])){
        return json_encode(array("erro" => $resultado['erro']));
    }

    // Extrair os dados necessários do resultado
    $cnpj = $resultado['estabelecimento']['cnpj'];
    $razaoSocial = $resultado['razao_social'];
    $email = $resultado['estabelecimento']['email'];

    // Retorna os dados consultados
    return json_encode(array(
        "cnpj" => $cnpj,
        "razao_social" => $razaoSocial,
        "email" => $email
    ));
}

// Verifica se o CNPJ foi recebido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o CNPJ foi enviado no corpo da requisição
    if(isset($_POST['cnpj'])) {
        $cnpj = $_POST['cnpj'];

        // Remove caracteres não numéricos do CNPJ
        $cnpj = preg_replace("/[^0-9]/", "", $cnpj);

        // Verifica se o CNPJ possui 14 dígitos
        if(strlen($cnpj) == 14) {
            // Consulta o CNPJ
            $resultado = consultarCNPJ($cnpj);

            // Retorna o resultado como JSON
            header('Content-Type: application/json');
            echo $resultado;
        } else {
            echo json_encode(array("erro" => "O CNPJ deve conter 14 dígitos."));
        }
    } else {
        echo json_encode(array("erro" => "Nenhumsss CNPJ fornecido."));
    }
} else {
    echo json_encode(array("erro" => "Requisição inválida. Use o método POST."));
}
?>

<?php

// Função para consultar o CNPJ
function consultarCNPJ($cnpj) {
    // URL da API ou do site que você quer consultar
    $url = "https://exemplo.com/consulta-cnpj?cnpj=" . $cnpj; // Substitua pela URL real

    // Inicia uma sessão cURL
    $ch = curl_init();

    // Configura as opções da requisição cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Executa a requisição cURL
    $response = curl_exec($ch);

    // Verifica se ocorreu algum erro na requisição
    if(curl_errno($ch)){
        // Trata o erro
        return "Erro ao consultar CNPJ: " . curl_error($ch);
    }

    // Fecha a sessão cURL
    curl_close($ch);

    // Retorna a resposta da requisição
    return $response;
}

// Verifica se a requisição foi feita usando o método POST
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
        echo json_encode(array("erro" => " fornecido."));
    }
} else {
    echo json_encode(array("erro" => "Requisição inválida. Use o método POST."));
}

?>

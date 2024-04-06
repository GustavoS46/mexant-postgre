<?php
// Obtém o JSON enviado pelo JavaScript
$json = json_decode(file_get_contents('php://input'), true);

// Verifica se o JSON foi recebido com sucesso
if (isset($json['json'])) {
    // Decodifica o JSON para um array associativo
    $data = json_decode($json['json'], true);

    // Aqui você pode manipular os dados conforme necessário
    // Por exemplo:
    echo "Nome Fantasia: " . $data['NOME FANTASIA'] . "<br>";
    echo "CNPJ: " . $data['CNPJ'] . "<br>";
    // Adicione mais campos conforme necessário
} else {
    echo "Erro: JSON não recebido.";
}
?>

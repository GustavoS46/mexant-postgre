// Função para preencher os campos de edição com os valores do JSON
function preencherCamposDoJSON(data) {
    document.getElementById('edited-name').value = data["NOME FANTASIA"] || '';
    document.getElementById('edited-phone').value = data["CNPJ"] || '';
    document.getElementById('edited-email').value = data["EMAIL"] || '';
}

// Chama a função preencherCamposDoJSON quando a página carrega
window.onload = function() {
    // Exemplo de objeto JSON retornado pela consulta CNPJ (substitua pelo objeto real)
    var data = {
        "NOME FANTASIA": "KABUM",
        "CNPJ": "05570714000159",
        "EMAIL": "fiscalizacao@kabum.com.br"
        // Adicione mais campos conforme necessário
    };

    preencherCamposDoJSON(data);
};

function verificarResultadoConsulta() {
    var resultado = document.getElementById("resultado");
    var botaoEditar = document.getElementById("botao-editar");

    if (resultado.innerHTML.trim() !== "") {
        botaoEditar.style.display = "block"; // Mostra o botão "Editar"
    } else {
        botaoEditar.style.display = "none"; // Oculta o botão "Editar"
    }
}

// Chamada da função ao carregar a página
window.onload = function() {
    verificarResultadoConsulta();
};

// Função para exibir o formulário de edição quando o botão "Editar" for clicado
function exibirFormularioEdicao() {
    // Coloque aqui o código para exibir o formulário de edição
}

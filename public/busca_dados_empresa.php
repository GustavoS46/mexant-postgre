<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os parâmetros necessários foram passados no formulário
    if(isset($_POST['nome_fantasia']) && isset($_POST['cnpj']) && isset($_POST['email']) && isset($_POST['telefone'])) {
        // Recupera os dados do formulário
        $nome_fantasia = $_POST["nome_fantasia"];
        $cnpj = str_replace([' ', '-'], '', $_POST["cnpj"]);
        $email = $_POST["email"];
        $telefone = $_POST["telefone"];
        $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : '';
// Atribui uma string vazia se 'descricao' não estiver definido

        // Exemplo de conexão com o banco de dados PostgreSQL
        $host = "127.0.0.1"; // Nome do serviço do contêiner PostgreSQL
        $port = "5432"; // Porta padrão do PostgreSQL
        $dbname = "postgres"; // Nome do banco de dados
        $user = "postgres"; // Nome de usuário
        $password = "root"; // Senha

        // Conecta ao banco de dados PostgreSQL
        $conn = pg_connect("host=$host port=$port dbname=$dbname user=$user password=$password");

        // Verifica a conexão
        if (!$conn) {
            die("Erro na conexão com o banco de dados: " . pg_last_error());
        }

        // Remove caracteres não numéricos do telefone
        $telefone = preg_replace("/[^0-9]/", "", $_POST["telefone"]);

        // Prepara a query SQL para inserir os dados da empresa
        $query = "INSERT INTO empresas (nome_fantasia, cnpj, email, telefone, descricao) VALUES ('$nome_fantasia', '$cnpj', '$email', '$telefone', '$descricao')";

        // Executa a query
        $result = pg_query($conn, $query);

        // Verifica se a query foi executada com sucesso
        if ($result) {
            echo "Empresa cadastrada com sucesso!";
            // Redireciona para a página de sucesso
            header("Location: sucesso_cadastro.html");
            exit; // Termina a execução do script para garantir que o redirecionamento funcione corretamente
        } else {
            echo "Erro ao cadastrar empresa: " . pg_last_error($conn);
        }

        // Fecha a conexão com o banco de dados
        pg_close($conn);
    } else {
        echo "Parâmetros ausentes no formulário.";
    }
}
?>

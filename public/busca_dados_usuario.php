<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];

    // Remove espaços em branco e hífens do CPF, se houver
    $cpf = str_replace([' ', '-'], '', $_POST["cpf"]);

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

    // Query SQL para inserir os dados do usuário
    $query = "INSERT INTO usuarios (email, senha, nome, telefone, cpf) VALUES ('$email', '$senha', '$nome', '$telefone', '$cpf')";

    // Executa a query
    $result = pg_query($conn, $query);

    // Verifica se a query foi executada com sucesso
    if ($result) {
        echo "Usuário cadastrado com sucesso!";
        header("Location: sucesso_cadastro.html");
    } else {
        echo "Erro ao cadastrar usuário: " . pg_last_error($conn);
    }

    // Fecha a conexão com o banco de dados
    pg_close($conn);
}
?>

<?php
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $cpf = $_POST["cpf"];
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

    // Query SQL para verificar se o email e a senha correspondem a um usuário existente
    $query = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = pg_query($conn, $query);

    // Obtém os dados do usuário
    $userData = array(
        "email" => $email,
        "senha" => $senha,
        "nome" => $nome,
        "telefone" => $telefone,
        "cpf" => $cpf
    );

    // Converte os dados do usuário em formato JSON
    $userDataJSON = json_encode($userData);

    // Armazena os dados do usuário em um arquivo JSON
    file_put_contents('userData.json', $userDataJSON);


    // Verifica se a consulta retornou algum resultado
    if (pg_num_rows($result) > 0) {
        // Obtém os dados do usuário
        $userData = pg_fetch_assoc($result);

        // Converte os dados do usuário em formato JSON
        $userDataJSON = json_encode($userData);

        // Armazena os dados do usuário em um arquivo JSON
        file_put_contents('userData.json', $userDataJSON);

        // Redireciona para a página de sucesso de login
        header("Location: sucesso_cadastro.html");
        exit;
    } else {
        // Se não houver correspondência, armazena a mensagem de erro na variável de sessão
       // $_SESSION['erro_login'] = "Email ou senha incorretos.";
        // Redireciona de volta para a página de login
        header("Location: contact-us.html");
       // echo "Erro: o formulário não foissss submetido corretamente.";
        exit;
    }

    // Fecha a conexão com o banco de dados
    pg_close($conn);
} elseif (isset($_SESSION['erro_login'])) {
    // Se houver uma mensagem de erro na sessão, redireciona para a página de login passando a mensagem de erro como parâmetro na URL
    $erro = $_SESSION['erro_login'];
    header("Location: index.html?erro=$erro");
    exit;
} else {
    echo "Erro00: o formulário nssão foi submetido corretamente.";
}
?>

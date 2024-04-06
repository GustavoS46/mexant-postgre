<?php
session_start(); // Inicia a sessão

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recupera os dados do formulário
  $email = $_POST["email"];
  $senha = $_POST["senha"];

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
  $query = "SELECT id FROM usuarios WHERE email = '$email' AND senha = '$senha'";
  $result = pg_query($conn, $query);

  // Verifica se a consulta retornou algum resultado
  if (pg_num_rows($result) > 0) {
    // Recupera o ID do usuário da consulta
    $row = pg_fetch_assoc($result);
    $user_id = $row['id'];

    // Armazena o ID do usuário na sessão
    $_SESSION['user_id'] = $user_id;

    // Redireciona para a página de sucesso de login
    header("Location: sucesso_cadastro.html?user_id=$user_id");
    exit;
  } else {
    $_SESSION['erro_login'] = "Erro: email ou senha inválidos.";
    header("Location: contact-us.html");
  }

  // Fecha a conexão com o banco de dados
  pg_close($conn);
} else {
  // Se o formulário não foi submetido corretamente, exibe uma mensagem de erro
  echo "Erro: o formulário não foi submetido corretamente.";
}

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Recupera os dados do formulário
  $nome_fantasia = $_POST["nome_fantasia"];
  $cnpj = str_replace([' ', '-'], '', $_POST["cnpj"]);
  $email = $_POST["email"];
  $telefone = $_POST["telefone"];
  $descricao = isset($_POST["descricao"]) ? $_POST["descricao"] : ''; // Atribui uma string vazia se 'descricao' não estiver definido

  // Obtém o ID do usuário autenticado da sessão
  $user_id = $_SESSION['user_id'];

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

  // Prepara a query SQL para inserir os dados da empresa, incluindo o ID do usuário
  $query = "INSERT INTO empresas (nome_fantasia, cnpj, email, telefone, descricao, usuario_id) VALUES ('$nome_fantasia', '$cnpj', '$email', '$telefone', '$descricao', '$user_id')";

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
}
?>

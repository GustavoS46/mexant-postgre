<?php
// Verifica se a solicitação é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o campo de telefone foi enviado
    if (isset($_POST["phone"])) {
        // Aqui você deve adicionar as verificações de segurança e validação necessárias
        // Conecte-se ao seu banco de dados
        $host = "localhost"; // Endereço do servidor do banco de dados
        $dbname = "nome_do_banco_de_dados"; // Nome do banco de dados
        $user = "nome_de_usuario"; // Nome de usuário do banco de dados
        $password = "senha_do_usuario"; // Senha do banco de dados

        // Crie uma conexão com o banco de dados
        $conn = new mysqli($host, $user, $password, $dbname);

        // Verifica a conexão com o banco de dados
        if ($conn->connect_error) {
            die("Erro de conexão com o banco de dados: " . $conn->connect_error);
        }

        // Prepare e execute a declaração SQL para atualizar o telefone do usuário
        $phone = $_POST["phone"];
        $userId = $_SESSION["user_id"]; // Supondo que você tenha um identificador de usuário na sessão
        $sql = "UPDATE usuarios SET telefone = '$phone' WHERE id = $userId";

        if ($conn->query($sql) === TRUE) {
            // Se a atualização for bem-sucedida, retorne os dados do usuário atualizados
            $result = $conn->query("SELECT * FROM usuarios WHERE id = $userId");
            $user = $result->fetch_assoc();
            // Retorne os dados do usuário em formato JSON
            echo json_encode($user);
        } else {
            echo "Erro ao atualizar o telefone: " . $conn->error;
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    } else {
        echo "O campo de telefone não foi enviado.";
    }
} else {
    echo "Apenas solicitações do tipo POST são permitidas.";
}
?>

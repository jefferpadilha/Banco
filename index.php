<?php
//git  
require_once "user.php"; 
require_once "account.php";
session_start();
if (!isset($_SESSION['users'])) {
    $_SESSION['users'] = [];
}

$users = &$_SESSION['users'];

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $opcao = $_POST['opcao'];

    switch ($opcao) {
        case '1': // Criar conta
            $nome = $_POST['nome'];
            $cpf = $_POST['cpf'];
            $email = $_POST['email'];
            $contaNumero = count($users) + 1;

            $usuario = new User($nome, $cpf, $email);
            $conta = new Account($contaNumero);
            $usuario->setAccount($conta);
            $users[$contaNumero] = $usuario;

            $mensagem = "Conta criada com sucesso! Número da conta: $contaNumero";
            break;

        case '2': // Mostrar dados
            $numero = $_POST['numero'];
            if (isset($users[$numero])) {
                $u = $users[$numero];
                $mensagem = "Nome: {$u->getName()}<br>CPF: {$u->getCpf()}<br>Email: {$u->getEmail()}";
            } else {
                $mensagem = "Conta não encontrada.";
            }
            break;

        case '3': // Depositar
            $numero = $_POST['numero'];
            $valor = $_POST['valor'];
            if (isset($users[$numero])) {
                $users[$numero]->getAccount()->deposit((float)$valor);
                $mensagem = "Depósito realizado.";
            } else {
                $mensagem = "Conta não encontrada.";
            }
            break;

        case '4': // Sacar
            $numero = $_POST['numero'];
            $valor = $_POST['valor'];
            if (isset($users[$numero])) {
                $users[$numero]->getAccount()->withdraw((float)$valor);
                $mensagem = "Saque realizado.";
            } else {
                $mensagem = "Conta não encontrada.";
            }
            break;

        case '5': // Saldo
            $numero = $_POST['numero'];
            if (isset($users[$numero])) {
                $saldo = $users[$numero]->getAccount()->getBalance();
                $mensagem = "Saldo: R$ " . number_format($saldo, 2, ',', '.');
            } else {
                $mensagem = "Conta não encontrada.";
            }
            break;

        case '6': // Mostrar todos
            $mensagem = "Usuários:<br>";
            foreach ($users as $n => $u) {
                $mensagem .= "$n - " . $u->getName() . "<br>";
            }
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>ETECBank</title>
    <style>
        body { font-family: Arial; margin: 30px; }
        form { margin-bottom: 20px; }
    </style>
</head>
<body>
    <h1>ETECBank</h1>

    <form method="post">
        <h3>1. Criar Conta</h3>
        <input type="hidden" name="opcao" value="1">
        Nome: <input type="text" name="nome"><br>
        CPF: <input type="text" name="cpf"><br>
        E-mail: <input type="email" name="email"><br>
        <button type="submit">Criar</button>
    </form>

    <form method="post">
        <h3>2. Mostrar Dados do Usuário</h3>
        <input type="hidden" name="opcao" value="2">
        Número da conta: <input type="number" name="numero"><br>
        <button type="submit">Mostrar</button>
    </form>

    <form method="post">
        <h3>3. Depositar</h3>
        <input type="hidden" name="opcao" value="3">
        Número da conta: <input type="number" name="numero"><br>
        Valor: <input type="number" name="valor" step="0.01"><br>
        <button type="submit">Depositar</button>
    </form>

    <form method="post">
        <h3>4. Sacar</h3>
        <input type="hidden" name="opcao" value="4">
        Número da conta: <input type="number" name="numero"><br>
        Valor: <input type="number" name="valor" step="0.01"><br>
        <button type="submit">Sacar</button>
    </form>

    <form method="post">
        <h3>5. Mostrar Saldo</h3>
        <input type="hidden" name="opcao" value="5">
        Número da conta: <input type="number" name="numero"><br>
        <button type="submit">Consultar</button>
    </form>

    <form method="post">
        <h3>6. Mostrar Todos os Usuários</h3>
        <input type="hidden" name="opcao" value="6">
        <button type="submit">Listar</button>
    </form>

    <?php if ($mensagem): ?>
        <p><strong>Resultado:</strong><br><?= $mensagem ?></p>
    <?php endif; ?>
</body>
</html>

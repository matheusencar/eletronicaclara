<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$db   = 'eletronica_clara';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
    echo json_encode(['erro' => 'Erro de conexão: ' . $e->getMessage()]);
    exit;
}

$acao = $_GET['acao'] ?? '';

if ($acao == 'login' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $usuario = trim($data['usuario'] ?? '');
    $senha = trim($data['senha'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $senha === $user['senha']) {
        $_SESSION['logado'] = true;
        $_SESSION['usuario'] = $user['usuario'];
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Usuário ou senha incorretos']);
    }
    exit;
}

if ($acao == 'mudar_senha' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $usuario = trim($data['usuario'] ?? '');
    $senhaAntiga = trim($data['senha_antiga'] ?? '');
    $novaSenha = trim($data['nova_senha'] ?? '');

    if (!empty($usuario) && !empty($senhaAntiga) && !empty($novaSenha)) {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && $senhaAntiga === $user['senha']) {
            $stmtUpdate = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE usuario = ?");
            $stmtUpdate->execute([$novaSenha, $usuario]);
            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['sucesso' => false, 'erro' => 'Usuário ou senha antiga incorretos']);
        }
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Preencha todos os campos']);
    }
    exit;
}

if ($acao == 'obter_dados') {
    $stmt = $pdo->query("SELECT nome, cnpj FROM clientes ORDER BY nome ASC");
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtOs = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'base_os_numero'");
    $osConfig = $stmtOs->fetch(PDO::FETCH_ASSOC);
    $baseOs = $osConfig ? $osConfig['valor'] : '00000';

    echo json_encode([
        'clientes' => $clientes,
        'base_os' => $baseOs
    ]);
    exit;
}

if ($acao == 'listar_os') {
    $stmt = $pdo->query("SELECT * FROM ordens_servico WHERE oculta = 0 ORDER BY id DESC");
    $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($lista);
    exit;
}

if ($acao == 'atualizar_pagamento' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;
    $paga = $data['paga'] ?? 0;

    if (!empty($id)) {
        $stmt = $pdo->prepare("UPDATE ordens_servico SET paga = ? WHERE id = ?");
        $stmt->execute([$paga, $id]);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'ID inválido']);
    }
    exit;
}

if ($acao == 'ocultar_os' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $id = $data['id'] ?? 0;

    if (!empty($id)) {
        $stmt = $pdo->prepare("UPDATE ordens_servico SET oculta = 1 WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'ID inválido']);
    }
    exit;
}

if ($acao == 'salvar_os' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $numeroOs = $data['numero_os'] ?? '';
    $cliente = $data['cliente'] ?? '';
    $cnpj = $data['cnpj'] ?? '';
    $dataOs = $data['data_os'] ?? date('Y-m-d');
    $valorTotal = $data['valor_total'] ?? 0;
    $descontoPct = $data['desconto_pct'] ?? 0;
    $valorComDesconto = $data['valor_com_desconto'] ?? 0;
    $detalhesJson = json_encode($data['itens'] ?? []);

    if (!empty($numeroOs) && !empty($cliente)) {
        $stmt = $pdo->prepare("INSERT INTO ordens_servico (numero_os, cliente, cnpj, data_os, valor_total, desconto_pct, valor_com_desconto, detalhes_json, paga, oculta) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, 0)");
        $stmt->execute([$numeroOs, $cliente, $cnpj, $dataOs, $valorTotal, $descontoPct, $valorComDesconto, $detalhesJson]);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Dados incompletos']);
    }
    exit;
}

if ($acao == 'atualizar_os' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    $id = $data['id'] ?? 0;
    $numeroOs = $data['numero_os'] ?? '';
    $cliente = $data['cliente'] ?? '';
    $cnpj = $data['cnpj'] ?? '';
    $dataOs = $data['data_os'] ?? date('Y-m-d');
    $valorTotal = $data['valor_total'] ?? 0;
    $descontoPct = $data['desconto_pct'] ?? 0;
    $valorComDesconto = $data['valor_com_desconto'] ?? 0;
    $detalhesJson = json_encode($data['itens'] ?? []);

    if (!empty($id) && !empty($numeroOs)) {
        $stmt = $pdo->prepare("UPDATE ordens_servico SET numero_os = ?, cliente = ?, cnpj = ?, data_os = ?, valor_total = ?, desconto_pct = ?, valor_com_desconto = ?, detalhes_json = ? WHERE id = ?");
        $stmt->execute([$numeroOs, $cliente, $cnpj, $dataOs, $valorTotal, $descontoPct, $valorComDesconto, $detalhesJson, $id]);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Dados incompletos']);
    }
    exit;
}

if ($acao == 'salvar_cliente' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
    $nome = strtoupper(trim($data['nome'] ?? ''));
    $cnpj = trim($data['cnpj'] ?? '');

    if (!empty($nome)) {
        $stmt = $pdo->prepare("INSERT INTO clientes (nome, cnpj) VALUES (?, ?) ON DUPLICATE KEY UPDATE cnpj = ?");
        $stmt->execute([$nome, $cnpj, $cnpj]);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Nome inválido']);
    }
    exit;
}

if ($acao == 'editar_cliente' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nomeAntigo = trim($data['nomeAntigo'] ?? '');
    $novoNome = strtoupper(trim($data['novoNome'] ?? ''));
    $novoCnpj = trim($data['novoCnpj'] ?? '');

    if (!empty($nomeAntigo) && !empty($novoNome)) {
        $stmt = $pdo->prepare("UPDATE clientes SET nome = ?, cnpj = ? WHERE nome = ?");
        $stmt->execute([$novoNome, $novoCnpj, $nomeAntigo]);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false, 'erro' => 'Dados incompletos']);
    }
    exit;
}

if ($acao == 'deletar_cliente' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $nome = trim($data['nome'] ?? '');

    if (!empty($nome)) {
        $stmt = $pdo->prepare("DELETE FROM clientes WHERE nome = ?");
        $stmt->execute([$nome]);
        echo json_encode(['sucesso' => true]);
    } else {
        echo json_encode(['sucesso' => false]);
    }
    exit;
}

if ($acao == 'incrementar_os' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->query("SELECT valor FROM configuracoes WHERE chave = 'base_os_numero'");
    $osConfig = $stmt->fetch(PDO::FETCH_ASSOC);
    $baseAtual = intval($osConfig['valor'] ?? 0);

    $proximo = $baseAtual + 1;
    if ($proximo > 99999) {
        $proximo = 0;
    }

    $novaBaseStr = str_pad($proximo, 5, '0', STR_PAD_LEFT);

    $stmtUpdate = $pdo->prepare("UPDATE configuracoes SET valor = ? WHERE chave = 'base_os_numero'");
    $stmtUpdate->execute([$novaBaseStr]);

    echo json_encode(['sucesso' => true, 'nova_base' => $novaBaseStr]);
    exit;
}
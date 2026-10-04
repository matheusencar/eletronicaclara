<?php
session_start();
$erro = '';
$sucesso = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? 'login';

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=eletronica_clara;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if ($acao == 'login') {
            $usuario = trim($_POST['usuario'] ?? '');
            $senha = trim($_POST['senha'] ?? '');

            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
            $stmt->execute([$usuario]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && $senha === $user['senha']) {
                $_SESSION['logado'] = true;
                $_SESSION['usuario'] = $user['usuario'];
                header('Location: os.php');
                exit;
            } else {
                $erro = 'Usuário ou senha incorretos.';
            }
        } elseif ($acao == 'mudar_senha') {
            $usuario = trim($_POST['usuario'] ?? '');
            $senhaAntiga = trim($_POST['senha_antiga'] ?? '');
            $novaSenha = trim($_POST['nova_senha'] ?? '');

            if (!empty($usuario) && !empty($senhaAntiga) && !empty($novaSenha)) {
                $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ?");
                $stmt->execute([$usuario]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && $senhaAntiga === $user['senha']) {
                    $stmtUpdate = $pdo->prepare("UPDATE usuarios SET senha = ? WHERE usuario = ?");
                    $stmtUpdate->execute([$novaSenha, $usuario]);
                    $sucesso = 'Senha alterada com sucesso! Faça login com a nova senha.';
                } else {
                    $erro = 'Usuário ou senha antiga incorretos.';
                }
            } else {
                $erro = 'Por favor, preencha todos os campos.';
            }
        }
    } catch (\PDOException $e) {
        $erro = 'Erro de conexão com o banco de dados.';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eletrônica Clara - Área do Colaborador</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-card {
            background: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 380px;
            text-align: center;
        }
        .logo-box {
            width: 60px;
            height: 60px;
            border: 2px solid #333;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            background: #ffeb3b;
            font-weight: bold;
            margin: 0 auto 20px auto;
            border-radius: 4px;
        }
        h2 { margin-bottom: 20px; color: #2c3e50; font-size: 22px; }
        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }
        .btn-submit {
            background-color: #2563eb;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            font-size: 15px;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        .btn-submit:hover { background-color: #1d4ed8; }
        .error-msg {
            color: #dc2626;
            font-size: 13px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .success-msg {
            color: #10b981;
            font-size: 13px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .link-toggle, .back-link {
            display: block;
            margin-top: 15px;
            color: #2563eb;
            text-decoration: none;
            font-size: 13px;
            cursor: pointer;
        }
        .link-toggle:hover, .back-link:hover { text-decoration: underline; }
        .back-link { color: #64748b; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo-box">⚡</div>
    <h2 id="tituloForm">Área do Colaborador</h2>
    
    <?php if ($erro): ?>
        <div class="error-msg"><?php echo $erro; ?></div>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <div class="success-msg"><?php echo $sucesso; ?></div>
    <?php endif; ?>

    <!-- Formulário de Login -->
    <form id="formLogin" method="POST">
        <input type="hidden" name="acao" value="login">
        <div class="form-group">
            <label for="usuarioLogin">Usuário</label>
            <input type="text" id="usuarioLogin" name="usuario" required placeholder="Ex: admin">
        </div>
        <div class="form-group">
            <label for="senhaLogin">Senha</label>
            <input type="password" id="senhaLogin" name="senha" required placeholder="Sua senha">
        </div>
        <button type="submit" class="btn-submit">Entrar no Sistema</button>
    </form>

    <!-- Formulário de Mudar Senha -->
    <form id="formMudarSenha" method="POST" style="display: none;">
        <input type="hidden" name="acao" value="mudar_senha">
        <div class="form-group">
            <label for="usuarioSenha">Usuário</label>
            <input type="text" id="usuarioSenha" name="usuario" required placeholder="Ex: admin">
        </div>
        <div class="form-group">
            <label for="senhaAntiga">Senha Antiga</label>
            <input type="password" id="senhaAntiga" name="senha_antiga" required placeholder="Digite sua senha atual">
        </div>
        <div class="form-group">
            <label for="novaSenha">Nova Senha</label>
            <input type="password" id="novaSenha" name="nova_senha" required placeholder="Digite a nova senha">
        </div>
        <button type="submit" class="btn-submit" style="background-color: #0d9488;">Salvar Nova Senha</button>
    </form>

    <a id="btnToggle" class="link-toggle" onclick="alternarFormulario()">Esqueceu a senha / Alterar senha?</a>
    <a href="index.html" class="back-link">← Voltar para o site principal</a>
</div>

<script>
    function alternarFormulario() {
        const formLogin = document.getElementById('formLogin');
        const formMudarSenha = document.getElementById('formMudarSenha');
        const titulo = document.getElementById('tituloForm');
        const btnToggle = document.getElementById('btnToggle');

        if (formLogin.style.display !== 'none') {
            formLogin.style.display = 'none';
            formMudarSenha.style.display = 'block';
            titulo.innerText = 'Alterar Senha';
            btnToggle.innerText = '← Voltar para o Login';
        } else {
            formLogin.style.display = 'block';
            formMudarSenha.style.display = 'none';
            titulo.innerText = 'Área do Colaborador';
            btnToggle.innerText = 'Esqueceu a senha / Alterar senha?';
        }
    }
</script>

</body>
</html>
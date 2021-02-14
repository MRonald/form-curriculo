<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envie Seu Currículo</title>
    <link rel="stylesheet" href="../_css/styles.css">
    <link rel="stylesheet" href="../_css/register.css">
</head>
<body>
    <div class="wrapper">
        <?php
            function pageError($tipo) {
                if ($tipo == 1) {
                    // Tipo 1 -> Faltando dados no post
                    echo "
                        <h1 class='title'>Opa! Tudo bem?</h1>
                        <p>Identificamos um ou mais erros nos dados enviados. Por favor, retorne à página de cadastro e preencha o formulário novamente.</p>
                        <p>Se o erro persistir, tente novamente mais tarde.</p>
                        <div class='boxBtnVoltar'>
                            <a href='../' class='btnvoltar'>Ir para a tela de cadastro</a>
                        </div>
                    ";
                } else {
                    // Tipo 2 -> Acesso direto à pagina register
                    echo "
                        <h1 class='title'>Opa! Tudo bem?</h1>
                        <p>Não identificamos o seu cadastro e o envio do seu currículo. Por favor, vá à página de cadastro e preencha o formulário.</p>
                        <div class='boxBtnVoltar'>
                            <a href='../' class='btnvoltar'>Ir para a tela de cadastro</a>
                        </div>
                    ";
                }
            }
            if ($_POST) {
                require 'config.php';
                require 'connection.php';
                require 'manipulation.php';
                // Guardando dados em variáveis
                $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
                $email = isset($_POST['email']) ? $_POST['email'] : null;
                $tel = isset($_POST['tel']) ? $_POST['tel'] : null;
                $cargo = isset($_POST['cargo']) ? $_POST['cargo'] : null;
                $esc = isset($_POST['esc']) ? $_POST['esc'] : null;
                $obs = isset($_POST['obs']) ? $_POST['obs'] : null;
                $curriculo = isset($_FILES['curriculo']) ? $_FILES['curriculo'] : null;
                $ip = getenv("REMOTE_ADDR");
                if ($nome == null || $email == null || $tel == null || $cargo == null ||
                    $esc == null || $curriculo == null || $ip == null) {
                    pageError(1);
                } else {
                    // Tratando o arquivo recebido
                    $newNameFile = substr(md5(time()), 0, 19) . strrchr($curriculo['name'], '.');
                    move_uploaded_file($curriculo['tmp_name'], "../_curriculos/" . $newNameFile);
                    //Inserindo dados no banco de dados
                    $data = array($nome, $email, $tel, $cargo, $esc, $obs, $newNameFile, $ip);
                    DBInsert($data);
                    // Pegando o primeiro nome do usuário
                    $primeiroNome = explode(' ', $nome)[0];
                    echo "
                        <h1 class='title'>Muito obrigado, $primeiroNome</h1>
                        <p>Recebemos o seu currículo e entraremos em contato o mais rápido possível.</p>
                        <div class='boxBtnVoltar'>
                            <a href='../' class='btnvoltar'>Retornar para a tela de cadastro</a>
                        </div>
                    ";
                }
            } else {
                pageError(2);
            }
        ?>
    </div>
</body>
</html>
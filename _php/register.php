<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envie Seu Currículo</title>
    <link rel="stylesheet" href="../_css/styles.css">
</head>
<body>
    <pre>
    <div class="wrapper">
        <?php
            if ($_POST) {
                require 'config.php';
                require 'connection.php';
                require 'manipulation.php';
                // Guardando dados em variáveis
                $nome = ($_POST['nome']) ? $_POST['nome'] : null;
                $email = ($_POST['email']) ? $_POST['email'] : null;
                $tel = ($_POST['tel']) ? $_POST['tel'] : null;
                $cargo = ($_POST['cargo']) ? $_POST['cargo'] : null;
                $esc = ($_POST['esc']) ? $_POST['esc'] : null;
                $obs = ($_POST['obs']) ? $_POST['obs'] : null;
                $curriculo = ($_FILES['curriculo']) ? $_FILES['curriculo'] : null;
                // Tratando o arquivo recebido
                $newNameFile = substr(md5(time()), 0, 19) . substr($curriculo['name'], -4);
                move_uploaded_file($curriculo['tmp_name'], "../_curriculos/".$newNameFile);
                //Inserindo dados
                $data = array($nome, $email, $tel, $cargo, $esc, $obs, substr($newNameFile, 0, -5));
                DBInsert($data);
            }
        ?>
    </div>
    </pre>
</body>
</html>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Envie Seu Currículo</title>
    <link rel="stylesheet" href="_css/styles.css">
    <link rel="stylesheet" href="_css/register.css">
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
                            <a href='./' class='btnvoltar'>Ir para a tela de cadastro</a>
                        </div>
                    ";
                } else {
                    // Tipo 2 -> Acesso direto à pagina register
                    echo "
                        <h1 class='title'>Opa! Tudo bem?</h1>
                        <p>Não identificamos o seu cadastro e o envio do seu currículo. Por favor, vá à página de cadastro e preencha o formulário.</p>
                        <div class='boxBtnVoltar'>
                            <a href='./' class='btnvoltar'>Ir para a tela de cadastro</a>
                        </div>
                    ";
                }
            }
            if ($_POST) {
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
                    require_once 'vendor/autoload.php';
                    // Pegando o primeiro nome do usuário
                    $primeiroNome = explode(' ', $nome)[0];
                    // Recuperando data e hora atuais
                    date_default_timezone_set('America/Sao_Paulo');
                    $dataEHoraEmail = date('d/m/Y \à\s H:i:s');
                    $dataEHoraDB = date('Y-m-d H:i:s');
                    // Tratando o arquivo recebido
                    $newNameFile = substr(md5(time()), 0, 19) . strrchr($curriculo['name'], '.');
                    move_uploaded_file($curriculo['tmp_name'], "_curriculos/" . $newNameFile);
                    //Inserindo dados no banco de dados
                    $data = array($nome, $email, $tel, $cargo, $esc, $obs, $newNameFile, $ip, $dataEHoraDB);
                    $connection = new ConnectionDB();
                    $connection->DBInsert($data);
                    // Enviando email com os dados
                    $mail = new \PHPMailer\PHPMailer\PHPMailer();
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'formulariocurriculo@gmail.com';
                    $mail->Password = 'formulariosenha2021';
                    $mail->Port = 587;
                    $mail->setFrom('formulariocurriculo@gmail.com');
                    $mail->addAddress('formulariocurriculo@gmail.com');
                    $mail->CharSet = 'utf8';
                    $mail->isHTML(true);
                    $mail->Subject = "Cadastro de currículo [$primeiroNome]";
                    $mail->Body =
                        "Segue os dados do novo cadastro de currículo.

                        <table>
                            <tr>
                                <td colspan='2'>Dados do Registro</td>
                            </tr>
                            <tr>
                                <td>Nome:</td>
                                <td>$nome</td>
                            </tr>
                            <tr>
                                <td>Email:</td>
                                <td>$email</td>
                            </tr>
                            <tr>
                                <td>Telefone:</td>
                                <td>$tel</td>
                            </tr>
                            <tr>
                                <td>Cargo Desejado:</td>
                                <td>$cargo</td>
                            </tr>
                            <tr>
                                <td>Escolaridade:</td>
                                <td>$esc</td>
                            </tr>
                            <tr>
                                <td>Observações:</td>
                                <td>$obs</td>
                            </tr>
                            <tr>
                                <td>Currículo:</td>
                                <td>$newNameFile</td>
                            </tr>
                            <tr>
                                <td>IP:</td>
                                <td>$ip</td>
                            </tr>
                            <tr>
                                <td>Data e Hora:</td>
                                <td>$dataEHoraEmail</td>
                            </tr>
                        </table>
                    ";
                    $mail->AltBody =
                        "Segue os dados do novo cadastro de currículo.\n
                         \n
                         Nome: $nome\n
                         Email: $email\n
                         Telefone: $tel\n
                         Cargo Desejado: $cargo\n
                         Escolaridade: $esc\n
                         Observações: $obs\n
                         Currículo: $newNameFile\n
                         IP: $ip\n
                         Data e Hora: $dataEHoraEmail";
                    $mail->send();
                    // Mostrando mensagem para o usuário
                    echo "
                        <h1 class='title'>Muito obrigado, $primeiroNome</h1>
                        <p>Recebemos o seu currículo e entraremos em contato o mais rápido possível.</p>
                        <div class='boxBtnVoltar'>
                            <a href='./' class='btnvoltar'>Retornar para a tela de cadastro</a>
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
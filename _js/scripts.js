// Variáveis globais e listeners
const campoEmail = document.getElementById('email');
const campoTel = document.getElementById('tel');
const campoObs = document.getElementById('obs');
const pEmailInvalido = document.getElementById('emailinvalido');
const pTelInvalido = document.getElementById('telinvalido');
const pObsInvalido = document.getElementById('obsinvalido');
const pFileInvalido = document.getElementById('fileinvalido');
const inputCurriculo = document.getElementById('curriculo');
const spanFileName = document.getElementById('filename');
const btnSubmit = document.getElementById('btnsubmit');
var emailValido = false, telefoneValido = false, obsValido = true, arquivoValido = false;

campoEmail.addEventListener('keyup', verificarEmail);
campoTel.addEventListener('keyup', verificarTelefone);
campoObs.addEventListener('keyup', verificarObs);
inputCurriculo.addEventListener('change', atualizarNameFile);
btnSubmit.addEventListener('click', analiseParaPost)

// Functions
function verificarEmail() {
    if (campoEmail.value.indexOf('@') != -1) {
        var usuario = campoEmail.value.substring(0, campoEmail.value.indexOf("@"));
        var dominio = campoEmail.value.substring(campoEmail.value.indexOf("@")+ 1, campoEmail.value.length);

        if ((usuario.length >=1) &&
            (dominio.length >=3) &&
            (usuario.search("@")==-1) &&
            (dominio.search("@")==-1) &&
            (usuario.search(" ")==-1) &&
            (dominio.search(" ")==-1) &&
            (dominio.search(".")!=-1) &&
            (dominio.indexOf(".") >= 1)&&
            (dominio.lastIndexOf(".") < dominio.length - 1) &&
            ((dominio.substring(dominio.length-4, dominio.length) == '.com') ||
            (dominio.substring(dominio.length-4, dominio.length) == '.net') ||
            (dominio.substring(dominio.length-3, dominio.length) == '.br'))) {
                pEmailInvalido.style.display = "none";
                emailValido = true;
                if (emailValido && telefoneValido && obsValido && arquivoValido) {
                    btnSubmit.type = 'submit';
                }
        } else {
            pEmailInvalido.style.display = "block";
            btnSubmit.type = 'button';
            emailValido = false;
        }
    } else {
        pEmailInvalido.style.display = "block";
        btnSubmit.type = 'button';
        emailValido = false;
    }
}
function verificarTelefone() {
    var valor = campoTel.value;
    var quantMais = valor.split('+').length - 1;
    var quantTraco = valor.split('-').length - 1;
    var temLetras = false, posTraco = false;
    if ((valor[valor.length-1] != '+') &&
        (valor[valor.length-1] != '-') &&
        (valor[valor.length-1] != ' ') &&
        (valor[valor.length-1] != '1') &&
        (valor[valor.length-1] != '2') &&
        (valor[valor.length-1] != '3') &&
        (valor[valor.length-1] != '4') &&
        (valor[valor.length-1] != '5') &&
        (valor[valor.length-1] != '6') &&
        (valor[valor.length-1] != '7') &&
        (valor[valor.length-1] != '8') &&
        (valor[valor.length-1] != '9')) {
        temLetras = true;
    }
    if ((quantMais > 1) ||
        (valor.indexOf('+') != 0 && valor.indexOf('+') != -1) ||
        (quantTraco > 1) ||
        ((valor.indexOf('-') < 3) && (valor.indexOf('-') != -1)) ||
        ((valor.indexOf('-') != -1) && (valor.length-5 != valor.indexOf('-'))) ||
        (valor.length < 7)||
        (temLetras)) {
        pTelInvalido.style.display = "block";
        telefoneValido = false;
    } else {
        pTelInvalido.style.display = "none";
        telefoneValido = true;
        if (emailValido && telefoneValido && obsValido && arquivoValido) {
            btnSubmit.type = 'submit';
        }
    }
}
function verificarObs() {
    var valor = campoObs.value.length;
    if (valor > 255) {
        pObsInvalido.style.display = "block";
        obsValido = false;
    } else {
        pObsInvalido.style.display = "none";
        obsValido = true;
        if (emailValido && telefoneValido && obsValido && arquivoValido) {
            btnSubmit.type = 'submit';
        }
    }
}
function atualizarNameFile() {
    // Modificando o nome do arquivo na span
    if (inputCurriculo.files[0].name) {
        var nameFile = inputCurriculo.files[0].name;
        if (nameFile.length < 15) { 
            spanFileName.innerText = nameFile;
        } else {
            spanFileName.innerText = nameFile.substring(0, 14) + "...";
        }
        // Verificando tipo e tamanho do arquivo
        if (((nameFile.substring(nameFile.lastIndexOf('.'), nameFile.length) == '.pdf') ||
            (nameFile.substring(nameFile.lastIndexOf('.'), nameFile.length) == '.doc') ||
            (nameFile.substring(nameFile.lastIndexOf('.'), nameFile.length) == '.docx')) &&
            (inputCurriculo.files[0].size / 1048576 <= 1)) {
            arquivoValido = true;
            pFileInvalido.style.display = "none";
            if (emailValido && telefoneValido && obsValido && arquivoValido) {
                btnSubmit.type = 'submit';
            }
        } else {
            arquivoValido = false;
            pFileInvalido.style.display = "block";
        }
    }
}
function analiseParaPost() {
    if (btnSubmit.type == 'button') {
        var msg = 'Corrija os seguintes pontos:\n';
        if (!emailValido) {
            msg += 'Insira um endereço de email válido\n';
        }
        if (!telefoneValido) {
            msg += 'Insira um número de telefone válido\n';
        }
        if (!obsValido) {
            msg += "Digite menos de 255 letras no campo 'Observações'\n";
        }
        if (!arquivoValido) {
            msg += "O Currículo deve ser um arquivo PDF, DOC ou DOCX com tamanho máximo de 1Mb\n";
        }
        alert(msg);
    }
}
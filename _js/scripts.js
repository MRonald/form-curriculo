// Variáveis globais e listeners
const campoEmail = document.getElementById('email');
const pEmailInvalido = document.getElementById('emailinvalido');
const inputCurriculo = document.getElementById('curriculo');
const spanFileName = document.getElementById('filename');
const btnSubmit = document.getElementById('btnsubmit');
var emailValido = false, arquivoValido = false;

campoEmail.addEventListener('keyup', verificarEmail);
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
                if (emailValido && arquivoValido) {
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
function atualizarNameFile() {
    // Modificando o nome do arquivo na span
    if (inputCurriculo.files[0].name) {
        var nameFile = inputCurriculo.files[0].name;
        if (nameFile.length < 14) { 
            spanFileName.innerText = nameFile;
        } else {
            spanFileName.innerText = nameFile.substring(0, 14) + "...";
        }
        // Verificando o tipo do arquivo
        if (nameFile.substring(nameFile.indexOf('.'), nameFile.length) == '.pdf') {
            arquivoValido = true;
            if (emailValido && arquivoValido) {
                btnSubmit.type = 'submit';
            }
        } else {
            arquivoValido = false;
        }
    }
}
function analiseParaPost() {
    if (btnSubmit.type == 'button') {
        if (!emailValido && !arquivoValido) {
            alert('Corrija os seguintes pontos:\nInsira um email válido.\nInsira um currículo no formato PDF.');
        } else if (!emailValido && arquivoValido) {
            alert('Insira um email válido.');
        } else if (emailValido && !arquivoValido) {
            alert('Insira um currículo no formato PDF.')
        }
    }
}
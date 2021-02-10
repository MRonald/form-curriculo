// Variáveis globais e listeners
const campoEmail = document.getElementById('email');
const pEmailInvalido = document.getElementById('emailinvalido');
const inputCurriculo = document.getElementById('curriculo');
const spanFileName = document.getElementById('filename');
const btnSubmit = document.getElementById('btnsubmit');

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
            (dominio.lastIndexOf(".") < dominio.length - 1)) {
            if ((dominio.substring(dominio.length-4, dominio.length) == '.com') ||
                (dominio.substring(dominio.length-4, dominio.length) == '.net') ||
                (dominio.substring(dominio.length-3, dominio.length) == '.br')) {
                pEmailInvalido.style.display = "none";
                btnSubmit.type = 'submit';
            }
        } else {
            pEmailInvalido.style.display = "block";
            btnSubmit.type = 'button';
        }
    } else {
        pEmailInvalido.style.display = "block";
        btnSubmit.type = 'button';
    }
}
function atualizarNameFile() {
    if (inputCurriculo.files[0].name) {
        var nameFile = inputCurriculo.files[0].name;
        if (nameFile.length < 14) { 
            spanFileName.innerText = nameFile;
        } else {
            spanFileName.innerText = nameFile.substring(0, 14) + "...";
        }
    }
}
function analiseParaPost() {
    if (btnSubmit.type == 'button') {
        alert('Insira um email válido antes de prosseguir.');
    }
}
// Variáveis globais e listeners
const campoEmail = document.getElementById('email');
const pEmailInvalido = document.getElementById('emailinvalido');

campoEmail.addEventListener('keyup', verificarEmail);

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
            }
        } else {
            pEmailInvalido.style.display = "block";
        }
    } else {
        pEmailInvalido.style.display = "block";
    }
}
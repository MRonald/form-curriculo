<?php

// Abrir conexão
function DBConnect() {
    $link = @mysqli_connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE) or die(mysqli_connect_error());
    mysqli_set_charset($link, DB_CHARSET);
    return $link;
}
// Fechar conexão
function DBClose($link) {
    return @mysqli_close($link) or die(mysqli_error($link));
}
// Escape nos dados
function DBEscape($string) {
    $link = DBConnect();
    $string = mysqli_real_escape_string($link, $string);
    DBClose($link);
    return $string;
}
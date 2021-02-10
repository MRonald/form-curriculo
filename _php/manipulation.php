<?php

// Insere os dados no banco de dados
function DBInsert(array $data) {
    // Dando escape nos dados
    for ($i = 0; $i < sizeof($data); $i++) {
        $data[$i] = DBEscape($data[$i]);
    }
    // Separando os dados para a query
    $values = '';
    for ($i = 0; $i < sizeof($data); $i++) {
        if ($i != sizeof($data)-1) {
            if ($data[$i] != null) {
                $values = $values . "'" . $data[$i] . "', ";
            } else {
                $values = $values . "NULL, ";
            }
        } else {
            $values = $values."'".$data[$i]."'";
        }
    }
    // Montando a query
    $query = "INSERT INTO reg_curriculos VALUES (DEFAULT, $values, NOW());";
    // Executando a query
    $link = DBConnect();
    mysqli_query($link, $query);
    DBClose($link);
}
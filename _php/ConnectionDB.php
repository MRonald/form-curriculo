<?php

class ConnectionDB
{
    // Atributes
    private $DB_HOSTNAME;
    private $DB_USERNAME;
    private $DB_PASSWORD;
    private $DB_DATABASE;
    private $DB_CHARSET;
    private $linkConnection;

    // Construct
    public function __construct() {
        $this->setDBHOSTNAME('localhost');
        $this->setDBUSERNAME('root');
        $this->setDBPASSWORD(null);
        $this->setDBDATABASE('registro');
        $this->setDBCHARSET('utf8');
    }

    // Setters
    private function setDBHOSTNAME($DB_HOSTNAME)
    {
        $this->DB_HOSTNAME = $DB_HOSTNAME;
    }
    private function setDBUSERNAME($DB_USERNAME)
    {
        $this->DB_USERNAME = $DB_USERNAME;
    }
    private function setDBPASSWORD($DB_PASSWORD)
    {
        $this->DB_PASSWORD = $DB_PASSWORD;
    }
    private function setDBDATABASE($DB_DATABASE)
    {
        $this->DB_DATABASE = $DB_DATABASE;
    }
    private function setDBCHARSET($DB_CHARSET)
    {
        $this->DB_CHARSET = $DB_CHARSET;
    }

    // Functions
    // Abrir conexão
    private function DBConnect() {
        $this->linkConnection = @mysqli_connect($this->DB_HOSTNAME, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_DATABASE) or die(mysqli_connect_error());
        mysqli_set_charset($this->linkConnection, $this->DB_CHARSET);
    }
    // Fechar conexão
    private function DBClose() {
        @mysqli_close($this->linkConnection) or die(mysqli_error($this->linkConnection));
    }
    // Escape nos dados
    private function DBEscape($string) {
        $this->DBConnect();
        $string = mysqli_real_escape_string($this->linkConnection, $string);
        $this->DBClose();
        return $string;
    }
    // Insere os dados no banco de dados
    public function DBInsert(array $data) {
        // Dando escape nos dados
        for ($i = 0; $i < sizeof($data); $i++) {
            $data[$i] = $this->DBEscape($data[$i]);
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
        $query = "INSERT INTO reg_curriculos VALUES (DEFAULT, $values);";
        // Executando a query
        $this->DBConnect();
        mysqli_query($this->linkConnection, $query);
        $this->DBClose();
    }
}
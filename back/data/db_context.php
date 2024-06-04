<?php 


require_once("config.php");

class DbContext{
    private $host;
    private $port;
    private $dbname;
    private $user;
    private $pwd;

    private $connection;

public function __construct() {
     $this->host  = MYSQL_DB_HOST;
     $this->port = MYSQL_DB_PORT;
     $this->dbname = MYSQL_DB_DATABASE;
     $this->user = MYSQL_DB_USERNAME;
     $this->pwd = MYSQL_DB_PASSWORD;
}

public function __connect() {
    $this->connection = new mysqli($this->host, $this->user, $this->pwd, $this->dbname, $this->port);

    if ($this->connection->connect_error) {
        die("Falha de conexão: " . $this->connection->connect_error); 
    }

}

public function close() {
    $this->connection->close();
}

private function run_query_sql($query){
    $result = $this->connection->query($query);

    if (!$result) {
            $error = array('error' => $this->connection->error);
            return json_encode($error);
    }

    if ($result->num_rows > 0) {
        $rows = array ();
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return json_encode($rows);
    }

    return json_encode($result);
} 

public function cadastrar($produto, $quantidade) {
    $query = "INSERT INTO produtos (produto, quantidade) VALUES ('"
    . $this->connection->real_escape_string($produto) . "', '"
    . $this->connection->real_escape_string($quantidade) . "')" ;

    return $this->run_query_sql($query);

}

public function consultar() {
    $query = "SELECT * FROM produtos ORDER BY codigo";
    return $this->run_query_sql($query);
}

public function editar($codigo, $produto, $quantidade) {
    $query = "UPDATE produtos SET produto = '"
    . $this->connection->real_escape_string($produto) . "', quantidade = " . "'"
    . $this ->connection->real_escape_string($quantidade) . "'" . "WHERE id = " .  $codigo;

    return $this->run_query_sql($query);
}

public function deletar($codigo){
    $query = "DELETE FROM produtos WHERE id = " . $codigo;
    return $this->run_query_sql($query);
}
} 

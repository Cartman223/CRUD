<?php

header("Access-Control-Allow-Origin: *");

require("data/db_context.php");

$tipo = 0;

if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo'];
} else {
    $error = array('error'=> 'Parametro TIPO nao especificado!');
    echo json_encode($error);
}

$db_context = new DbContext();
$db_context->__connect(); // inicia a conexao com o backend

// Avalia o resultado da espressao '$tipo', executando o respectivo codigo para cada caso
switch ($tipo) {
    // CREATE
    case 1:
        if (isset($_GET['produto']) && isset($_GET['quantidade'])) {
            $produto = $_GET['produto'];
            $quantidade = $_GET['quantidade'];

            $result = $db_context->cadastrar($produto, $quantidade);
            echo $result;
        } else { 
            $error = array('error' => "Parametro PRODUTO nao especificado!");
            echo json_encode($error);
        }

        break;
    // READ    
    case 2:
        $result = $db_context->consultar();
        echo $result;

        break;
    // UPDATE    
    case 3:
        if (isset($_GET["codigo"]) && isset($_GET['produto']) && isset($_GET['quantidade'])) {
            $codigo = $_GET['codigo'];
            $produto = $_GET['produto'];
            $quantidade = $_GET['quantidade'];

            $result = $db_context->editar($codigo, $produto, $quantidade);
            echo $result;
        } else {    
            $error = array('error' => "Parametro CODIGO, PRODUTO ou QUANTIDADE não especificado!");
            echo json_encode($error);
        }

        break;
    // DELETE    
    case 4:
        if (isset($_GET['codigo'])) {
            $codigo = $_GET['codigo'];

            $result = $db_context->deletar($codigo);
            echo $result;
        } else {
            $error = array('error'=> 'Parametro CODIGO nao especificado!');
            echo json_encode($error);
        }    

        break;
    default:
        $error = array('error'=> 'Falha na requisicao');
        echo json_encode($error);

        break;
}

$db_context->close();


/*The closing ?> tag MUST be omitted from files containing only PHP. Source: PSR-12*/

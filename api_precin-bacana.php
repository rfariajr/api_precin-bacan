<?php
header("Access-Control-Allow-Origin: http://localhost");
$request_method = $_SERVER['REQUEST_METHOD'];
if($request_method == 'POST') {
    $address = "dados/db.csv";
    $dados = explode(";", $_POST["frm_login"]);
    $val = true;
    $arch = fopen($address, "r");
    //Verificando se o email já está sendo usado
    while($linha = fgets($arch)) {
        $str = explode(";", $linha);
        if($str[0] == $dados[0]) {
            $val = false;
            break;
        }
    }
    fclose($arch);
    header("Content-type: application/json; charset=utf-8");
    //Gravando o novo cadastro no banco de dados após a validação
    $arch = fopen($address, "a+");
    if($val == true) {
        $newEntry[] = $dados[0].";".$dados[1];
        fputcsv($arch, $newEntry);
        fclose($arch);
        print("{ \"status\": \"ok\" }");    
    } else {
        print("{ \"status\": \"erro\" }");    
    }
}
if($request_method == 'GET') {
    $address = "dados/db.csv";
    $dados = explode(";", $_GET["frm_usuario"]);
    $val = false;
    $arch = fopen($address, "r");
    //Validando o login
    while($linha = fgets($arch)) {
        $str = explode(";", $linha);
        if((trim($str[0]) == trim($dados[0])) && (trim($str[1]) == trim($dados[1]))) {
            $val = true;
            break;
        } 
    }
    fclose($arch);
    header("Content-type: application/json; charset=utf-8");
    if($val == true) {
        print("{ \"status\": \"ok\" }");    
    } else {
        print("{ \"status\": \"erro\" }");    
    }
}
?>
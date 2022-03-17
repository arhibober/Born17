<?   
    header('Content-Type: application/x-javascript; charset=utf8');   
    $n = array("Min" => date("i"), "Sec" => date("s"));   
    echo json_encode($n);   
?>  
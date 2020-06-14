<?php

include("koneksi.php");

if ($conn) {
    $query = $conn->query("SELECT * FROM lokasi");
    while($lokasi = $query->fetchAll(PDO::FETCH_ASSOC)){
        $data = [
            'status' => TRUE,
            'message' => $lokasi
        ];
        
        print json_encode($data);
    }
}else{
    $data = [
        'status' => FALSE,
        'message' => []
    ];
    
    print json_encode($data);
}
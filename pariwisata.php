<?php

include("koneksi.php");

if ($conn) {
    if (isset($_POST['lokasi'])) {
        $lokasi = $_POST['lokasi'];

        $query = $conn->prepare("SELECT * FROM pariwisata WHERE lokasi=:lokasi");
        $query->bindParam(":lokasi", $lokasi);
        $query->execute();
        $pariwisata = $query->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'status' => TRUE,
            'message' => $pariwisata
        ];
        
        print json_encode($data);
    }else{
        $data = [
            'status' => FALSE,
            'message' => []
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
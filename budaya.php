<?php

include("koneksi.php");

if ($conn) {
    if (isset($_POST['lokasi'])) {
        $lokasi = $_POST['lokasi'];

        $query = $conn->prepare("SELECT * FROM budaya_populer WHERE lokasi=:lokasi");
        $query->bindParam(":lokasi", $lokasi);
        $query->execute();
        $budaya = $query->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'status' => TRUE,
            'message' => $budaya
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
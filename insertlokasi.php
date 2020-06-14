<?php

include("koneksi.php");

if ($conn){
    if (isset($_POST['lokasi'])) {
        $lokasi = $_POST['lokasi'];

        $query = $conn->prepare("INSERT INTO lokasi VALUES(:lokasi)");
        $query->bindParam(":lokasi", $lokasi);
        $exec = $query->execute();

        if ($exec) {
            $data = [
                'status' => TRUE,
                'message' => "Input berhasil"
            ];
            
            print json_encode($data);
        }else{
            $data = [
                'status' => FALSE,
                'message' => "Input gagal"
            ];
            
            print json_encode($data);
        }
    }else{
        $data = [
            'status' => FALSE,
            'message' => "Data lokasi tidak boleh kosong"
        ];
        
        print json_encode($data);
    }
}else{
    $data = [
        'status' => FALSE,
        'message' => "Koneksi gagal"
    ];
    
    print json_encode($data);
}
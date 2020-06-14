<?php

include("koneksi.php");

if ($conn){
    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nama_lengkap']) && isset($_POST['alamat']) && isset($_POST['kontak'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $nama_lengkap = $_POST['nama_lengkap'];
        $alamat = $_POST['alamat'];
        $kontak = $_POST['kontak'];

        $query = $conn->prepare("UPDATE account SET password=:password, nama_lengkap=:nama_lengkap, kontak=:kontak, alamat=:alamat WHERE username=:username");
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->bindParam(":nama_lengkap", $nama_lengkap);
        $query->bindParam(":alamat", $alamat);
        $query->bindParam(":kontak", $kontak);
        $exec = $query->execute();

        if ($exec) {
            $data = [
                'status' => TRUE,
                'message' => 'Berhasil'
            ];

            print json_encode($data);
        }else{
            $data = [
                'status' => FALSE,
                'message' => 'Update Gagal'
            ];

            print json_encode($data);
        }
    }else{
        $data = [
            'status' => FALSE,
            'message' => 'Lengkapi data terlebih dahulu'
        ];

        print json_encode($data);
    }
}else{
    $data = [
        'status' => FALSE,
        'message' => 'Koneksi Gagal'
    ];

    print json_encode($data);
}
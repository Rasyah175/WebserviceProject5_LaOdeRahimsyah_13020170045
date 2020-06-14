<?php

include("koneksi.php");

if ($conn) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $conn->prepare("SELECT * FROM account WHERE username=:username AND password=:password");
        $query->bindParam(":username", $username);
        $query->bindParam(":password", $password);
        $query->execute();

        if ($query->rowCount()) {
            $data = [
                'status' => TRUE,
                'message' => $query->fetch(PDO::FETCH_ASSOC)
            ];
        
            print json_encode($data);
        }else{
            $data = [
                'status' => FALSE,
                'message' => [
                    'username' => null,
                    'password' => null,
                    'nama_lengkap' => null,
                    'kontak' => null,
                    'alamat' => null,
                    'photo' => null
                ]
            ];
        
            print json_encode($data);
        }
    }
}else{
    $data = [
        'status' => FALSE,
        'message' => [
            'username' => null,
            'password' => null,
            'nama_lengkap' => null,
            'kontak' => null,
            'alamat' => null,
            'photo' => null
        ]
    ];

    print json_encode($data);
}
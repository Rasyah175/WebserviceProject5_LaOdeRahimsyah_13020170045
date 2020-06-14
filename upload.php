<?php

include("koneksi.php");

if($conn){
    if(isset($_FILES['gambar']) && isset($_POST['username'])){
        $username = $_POST['username'];
        $file = $_FILES['gambar'];
        $name = $file['name'];
        $size = $file['size'];
        $tmp_name = $file['tmp_name'];

        $formats = explode(".", $name);

        if(end($formats) !== null){
            $format = end($formats);

            $types = ["jpg", "jpeg", "png"];

            $check = in_array($format, $types);

            if ($size < 2097152) {
                if($check){
                    $date = date("_d-m-Y_H-i-s",time());
    
                    $file_name = "$username$date.$format";
    
                    $move = move_uploaded_file($tmp_name, "assets/img/profile/$file_name");
    
                    if ($move){
                        $check_photo = $conn->prepare("SELECT photo FROM account WHERE username=:username");
                        $check_photo->bindParam(":username", $username);
                        $isSet = $check_photo->execute();
    
                        if ($isSet){
                            $prev = $check_photo->fetch(PDO::FETCH_ASSOC)["photo"];
     
                            if (file_exists("assets/img/profile/$prev")) {
                                unlink("assets/img/profile/$prev");
                                $query = $conn->prepare("UPDATE account SET photo=:photo WHERE username=:username");
                                $query->bindParam(":photo", $file_name);
                                $query->bindParam(":username", $username);
                                $check = $query->execute();
            
                                if ($check) {
                                    $data = [
                                        'status' => TRUE,
                                        'message' => 'Photo berhasil diubah'
                                    ];
                        
                                    print json_encode($data);
                                }else{
                                    $data = [
                                        'status' => FALSE,
                                        'message' => 'Photo gagal diubah'
                                    ];
                        
                                    print json_encode($data);
                                }
                            }else{
                                $query = $conn->prepare("UPDATE account SET photo=:photo WHERE username=:username");
                                $query->bindParam(":photo", $file_name);
                                $query->bindParam(":username", $username);
                                $check = $query->execute();
    
                                if ($check) {
                                    $data = [
                                        'status' => TRUE,
                                        'message' => 'Photo berhasil diubah'
                                    ];
                
                                    print json_encode($data);
                                }else{
                                    $data = [
                                        'status' => FALSE,
                                        'message' => 'Photo gagal diubah'
                                    ];
                    
                                    print json_encode($data);
                                }
                            }
                        }
                    }
                }else{
                    $data = [
                        'status' => FALSE,
                        'message' => 'File harus bertipe jpg, jpeg, png'
                    ];
        
                    print json_encode($data);
                }
            }else{
                $data = [
                    'status' => FALSE,
                    'message' => 'Ukuran file max 2MB'
                ];
    
                print json_encode($data);
            }
        }
    }else{
        $data = [
            'status' => FALSE,
            'message' => 'Masukkan photo terlebih dahulu'
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
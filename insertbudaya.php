<?php

include("koneksi.php");

if($conn){
    if(isset($_FILES['gambar']) && isset($_POST['lokasi']) && $_POST['deskripsi'] && $_POST['nama_budaya']){
        $lokasi = $_POST['lokasi'];
        $deskripsi = $_POST['deskripsi'];
        $nama_budaya = $_POST['nama_budaya'];

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
    
                    $file_name = "$lokasi$date.$format";
    
                    if (isset($file_name)){
                        $query = $conn->prepare("INSERT INTO budaya_populer VALUES (:nama_budaya, :lokasi, :deskripsi, :gambar)");
                        $query->bindParam(":gambar", $file_name);
                        $query->bindParam(":lokasi", $lokasi);
                        $query->bindParam(":nama_budaya", $nama_budaya);
                        $query->bindParam(":deskripsi", $deskripsi);
                        $exec = $query->execute();

                        if ($exec) {
                            $move = move_uploaded_file($tmp_name, "assets/img/budaya/$file_name");

                            $data = [
                                'status' => TRUE,
                                'message' => 'Data berhasil diinput'
                            ];
                
                            print json_encode($data);
                        
                        }else{
                            $data = [
                                'status' => FALSE,
                                'message' => 'Data gagal diinput'
                            ];
                            
                            print json_encode($data);
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
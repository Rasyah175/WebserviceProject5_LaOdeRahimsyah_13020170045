<?php

include("koneksi.php");

if($conn){
    if(isset($_FILES['gambar']) && isset($_POST['lokasi']) && $_POST['deskripsi'] && $_POST['nama_wisata']){
        $lokasi = $_POST['lokasi'];
        $deskripsi = $_POST['deskripsi'];
        $nama_wisata = $_POST['nama_wisata'];

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
    
                    $move = move_uploaded_file($tmp_name, "assets/img/pariwisata/$file_name");
    
                    if ($move){
                        $query = $conn->prepare("INSERT INTO pariwisata VALUES (:nama_wisata, :lokasi, :deskripsi, :gambar)");
                        $query->bindParam(":gambar", $file_name);
                        $query->bindParam(":lokasi", $lokasi);
                        $query->bindParam(":nama_wisata", $nama_wisata);
                        $query->bindParam(":deskripsi", $deskripsi);
                        $check = $query->execute();

                        if ($check) {
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
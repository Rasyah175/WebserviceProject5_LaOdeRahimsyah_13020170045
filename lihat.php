<?php

include("koneksi.php");

$query = $conn->query("SELECT * FROM account");
$query->execute();

$data = [
    'status' => TRUE,
    'message' => $query->fetchAll(PDO::FETCH_ASSOC)
];

print json_encode($data);
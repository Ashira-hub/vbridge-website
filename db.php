<?php
$host = "sakura.proxy.rlwy.net";
$port = "13464";
$dbname = "railway";
$user = "postgres";
$password = "bfGvykAKNfipUDEKXvYChZTniBDfuyTz";

$conn = pg_connect(
    "host=$host port=$port dbname=$dbname user=$user password=$password"
);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

echo "Connected to PostgreSQL successfully!";
?>
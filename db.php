<?php
$host = "sakura.proxy.rlwy.net";
$port = "5432";
$dbname = "railway";
$user = "postgres";
$password = "bfGvykAKNfipUDEKXvYChZTniBDfuyTz";

$conn = pg_connect(
    "host=$host port=$port dbname=$dbname user=$user password=$password sslmode=require"
);

if (!$conn) {
    die("Connection failed: Unable to connect to PostgreSQL server. Please check your network connection and database credentials.");
}

echo "Connected to PostgreSQL successfully!";
?>
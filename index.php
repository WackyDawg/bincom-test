<?php

// database connection set up
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inecpublicv2";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pollingUnitId = $_GET['id'] ?? null; 

    
    $stmt = $conn->prepare("SELECT * FROM polling_unit WHERE uniqueid = :pollingUnitId");
    $stmt->bindParam(':pollingUnitId', $pollingUnitId);
    $stmt->execute();
    $pollingUnit = $stmt->fetch(PDO::FETCH_ASSOC);

    
    $stmt = $conn->prepare("SELECT * FROM announced_pu_results WHERE polling_unit_uniqueid = :pollingUnitUniqueId");
    $stmt->bindParam(':pollingUnitUniqueId', $pollingUnit['uniqueid']);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>


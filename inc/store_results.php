<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inecpublicv2";

// Create a database connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function storePollingUnitResults($pollingUnitId, $partyResults, $conn) {
    $stmt = $conn->prepare("INSERT INTO announced_pu_results (polling_unit_uniqueid, party_abbreviation, party_score) 
                            VALUES (:pollingUnitId, :partyAbbreviation, :partyScore)");

    if (is_array($partyResults)) {
        foreach ($partyResults as $partyAbbreviation => $partyScore) {
            $stmt->bindParam(':pollingUnitId', $pollingUnitId);
            $stmt->bindParam(':partyAbbreviation', $partyAbbreviation);
            $stmt->bindParam(':partyScore', $partyScore);
            $stmt->execute();
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pollingUnitId = $_POST['pollingUnitId'];
    $partyResultsString = $_POST['partyResults'];

    // Convert party results from string to associative array
    $partyResults = [];
    $lines = explode("\n", $partyResultsString);
    foreach ($lines as $line) {
        $parts = explode(':', $line);
        if (count($parts) === 2) {
            $partyAbbreviation = trim($parts[0]);
            $partyScore = trim($parts[1]);
            $partyResults[$partyAbbreviation] = $partyScore;
        }
    }

    storePollingUnitResults($pollingUnitId, $partyResults, $conn);

    // Display a success message
    echo "Results for Polling Unit $pollingUnitId have been stored successfully.";
}
?>

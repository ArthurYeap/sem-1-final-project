<?php

require "db.php";

$search = $_GET["search"];

$stmt = $db->prepare("
    SELECT name
    FROM characters
    WHERE name LIKE ?
    LIMIT 5
");

$stmt->execute(["%$search%"]);

$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($characters as $character) {

    echo "<div class='suggestion'>";

    echo $character["name"];

    echo "</div>";
}
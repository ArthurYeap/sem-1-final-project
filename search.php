<?php

require "required files/db.php";

$search = $_GET["search"];

$stmt = $db->prepare("
    SELECT name
    FROM characters
    WHERE name LIKE ? AND status = 'active'
    LIMIT 5
");

$stmt->execute(["%$search%"]);

$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($characters as $character) {

    echo "<div class='suggestion'>";

    echo $character["name"];

    echo "</div>";
}
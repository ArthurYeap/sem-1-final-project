<?php
session_start();
require 'required files/tailwind-cdn.php';
require 'required files/db.php';
require 'required files/admin.php';
$isEdit = isset($_GET['id']);

//!fetching character data
if ($isEdit) {
    $id = $_GET['id'];
    $stmt = $db->prepare("
        SELECT *
        FROM characters
        WHERE id = ?
    ");
    $stmt->execute([$id]);
    $character = $stmt->fetch(PDO::FETCH_ASSOC);
}


if (isset($_POST['submit'])) {

    $name = trim($_POST['name']);
    $talent = trim($_POST['talent']);
    $hair_color = trim($_POST['hair_color']);
    $game = $_POST['game'];
    $outcome = $_POST['outcome'];
    $gender = $_POST['gender'];

//    ! checking for empty field
    if (empty($name) || empty($talent) || empty($hair_color)) {
        echo "<script>
        alert('All fields are required');
        window.history.back();
    </script>";
        exit;
    }

//  !enforcing Ultimate in talent input
    if (!str_contains($talent, 'Ultimate')) {
        $talent = 'Ultimate ' . $talent;
    }

//  !pixel upload
    if (isset($_FILES['pixel']) && $_FILES['pixel']['error'] === UPLOAD_ERR_OK) {
//        ! append unique id to pixel
        $pixelName = uniqid() . "_" . basename
                ($_FILES['pixel']['name']);
        move_uploaded_file($_FILES['pixel']['tmp_name'], "sprites/" . $pixelName);
    }

//    !use back old image if no changes
    else {
        $pixelName = $isEdit ? ($character['pixel'] ?? null) : null;
    }

//    !sprite upload
    if (isset($_FILES['sprite']) && $_FILES['sprite']['error'] === UPLOAD_ERR_OK) {
        $spriteName = uniqid() . "_" . basename($_FILES['sprite']['name']);
        move_uploaded_file($_FILES['sprite']['tmp_name'], "sprites/" . $spriteName);
    } else {
        $spriteName = $isEdit ? ($character['sprite'] ?? null) : null;
    }

//    !voice line upload
    if (isset($_FILES['sound']) && $_FILES['sound']['error'] === UPLOAD_ERR_OK) {
        $audioName = uniqid() . "_" . basename($_FILES['sound']['name']);
        move_uploaded_file($_FILES['sound']['tmp_name'], "voice_line/" . $audioName);
    } else {
        $audioName = $isEdit ? ($character['sound'] ?? null) : null;
    }

//  !    DATABASE TRANSACTIONS

//  !editing
    if ($isEdit) {
        $stmt = $db->prepare("
            UPDATE characters
            SET name = ?, talent = ?, hair_color = ?, game = ?, outcome = ?, gender = ?, pixel = ?, sprite = ?, sound = ?
            WHERE id = ?
        ");
        $stmt->execute([$name, $talent, $hair_color, $game, $outcome, $gender, $pixelName, $spriteName, $audioName, $id]);
        header('Location: manage_characters.php');
        exit;
    }

//    !inserting new character
    else {
        $stmt = $db->prepare("
    INSERT INTO characters (name, talent, hair_color, game, outcome, gender, pixel, sprite, sound)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
");
        $stmt->execute([$name, $talent, $hair_color, $game, $outcome, $gender, $pixelName, $spriteName, $audioName]);
        header('Location: manage_characters.php');
        exit;
    }
}


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>Document</title>
</head>
<body class="bg-pink-900">

<form action="" method="POST" enctype="multipart/form-data" class="mx-auto mt-16 max-w-xl sm:mt-20" >
    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">


        <div class="sm:col-span-2">
            <h1 class="text-white text-3xl font-medium"><?=isset($id )  ? "Edit Character: {$character['name']}" : "Add New Character "  ?></h1>
            <br>
            <label for="company" class="block text-sm/6 font-semibold text-white">Full Name</label>
            <div class="mt-2.5">
                <input id="name" type="text" name="name" value="<?=isset( $character['name'])? $character['name']: "" ; ?>" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>

        <div class="sm:col-span-2">
            <label for="company" class="block text-sm/6 font-semibold text-white">Talent</label>
            <div class="mt-2.5">
                <input id="talent" type="text" name="talent" value="<?=isset( $character['talent'])? $character['talent']: "" ; ?>" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>

        <div class="mb-3">
            <label for="hair_color" class="form-label text-white">Hair Color:</label>
            <select class="form-control text-white bg-black rounded-lg"  name="hair_color" >
                <option value="Black"  <?=isset($character['hair_color']) && $character['hair_color'] == "Black" ? "selected" : "" ?>>Black</option>
                <option value="Gray"  <?=isset($character['hair_color']) && $character['hair_color'] == "Gray" ? "selected" : "" ?>>Gray</option>
                <option value="White"  <?=isset($character['hair_color']) && $character['hair_color'] == "White" ? "selected" : "" ?>>White</option>
                <option value="Red"  <?=isset($character['hair_color']) && $character['hair_color'] == "Red" ? "selected" : "" ?>>Red</option>
                <option value="Orange"  <?=isset($character['hair_color']) && $character['hair_color'] == "Orange" ? "selected" : "" ?>>Orange</option>
                <option value="Blonde"  <?=isset($character['hair_color']) && $character['hair_color'] == "Blonde" ? "selected" : "" ?>>Blonde</option>
                <option value="Green"  <?=isset($character['hair_color']) && $character['hair_color'] == "Green" ? "selected" : "" ?>>Green</option>
                <option value="Blue"  <?=isset($character['hair_color']) && $character['hair_color'] == "Blue" ? "selected" : "" ?>>Blue</option>
                <option value="Purple"  <?=isset($character['hair_color']) && $character['hair_color'] == "Purple" ? "selected" : "" ?>>Purple</option>
                <option value="Pink"  <?=isset($character['hair_color']) && $character['hair_color'] == "Pink" ? "selected" : "" ?>>Pink</option>
                <option value="Brown"  <?=isset($character['hair_color']) && $character['hair_color'] == "Brown" ? "selected" : "" ?>>Brown</option>
            </select>
        </div>

        <div class="mb-3">
                <label for="hair_color" class="form-label text-white">Game:</label>
                <select class="form-control text-white bg-black rounded-lg"  name="game" >
                    <option value="DR1"  <?=isset($character['game']) && $character['game'] == "DR1" ? "selected" : "" ?>>DR1</option>
                    <option value="DR2"  <?=isset($character['game']) && $character['game'] == "DR2" ? "selected" : "" ?>>DR2</option>
                    <option value="V3"  <?=isset($character['game']) && $character['game'] == "V3" ? "selected" : "" ?>>V3</option>
                </select>
            </div>
        <div class="mb-3">
                <label for="outcome" class="form-label   text-white">Outcome:</label>
                <select class="form-control text-white bg-black rounded-lg"  name="outcome" >
                    <option value="Survivor"  <?=isset($character['outcome']) && $character['outcome'] == "Survivor" ? "selected" : "" ?>>Survivor</option>
                    <option value="Victim"  <?=isset($character['outcome']) && $character['outcome'] == "Victim" ? "selected" : "" ?>>Victim</option>
                    <option value="Blackened"  <?=isset($character['outcome']) && $character['outcome'] == "Blackened" ? "selected" : "" ?>>Blackened</option>
                    <option value="Mastermind"  <?=isset($character['outcome']) && $character['outcome'] == "Mastermind" ? "selected" : "" ?>>Mastermind</option>
                </select>
            </div>
        <div class="mb-3">
                <label for="gender" class="form-label text-white">Gender:</label>
                <select class="form-control text-white bg-black rounded-lg"  name="gender" >
                    <option value="Male"  <?=isset($character['gender']) && $character['gender'] == "Male" ? "selected" : "" ?>>Male</option>
                    <option value="Female"  <?=isset($character['gender']) && $character['gender'] == "Female" ? "selected" : "" ?>>Female</option>
                </select>
            </div>

<!--        !pixel input-->
        <div class="">
            <label class="text-white block mb-2">Pixel:</label>
            <!-- If editing and an pixel already exists, show it -->
            <?php if (!empty($character['pixel'])): ?>
                <div class="mb-3">
                    <p class="text-xs text-gray-400 mb-1">Current pixel:</p>
                    <img src="sprites/<?= htmlspecialchars($character['pixel']) ?>" alt="Preview" class="h-20 w-20 object-cover rounded-md border border-gray-600">
                </div>
            <?php endif; ?>

            <input
                    type="file"
                    name="pixel"
                    accept="image/*"
                    class="text-white bg-black rounded-lg">
            <p class="text-xs text-gray-400 mt-1">Leave blank to keep the current pixel.</p>
        </div>
        <div>
            <label class="text-white block mb-2">Sprite</label>

            <!-- If editing and an Sprite already exists, show it -->
            <?php if (!empty($character['sprite'])): ?>
                <div class="mb-3">
                    <p class="text-xs text-gray-400 mb-1">Current sprite:</p>
                    <img src="sprites/<?= htmlspecialchars($character['sprite']) ?>" alt="Preview" class="h-20 w-20 object-cover rounded-md border border-gray-600">
                </div>
            <?php endif; ?>

            <input
                    type="file"
                    name="sprite"
                    accept="image/*"
                    class="text-white bg-black rounded-lg">
            <p class="text-xs text-gray-400 mt-1">Leave blank to keep the current sprite.</p>
        </div>


        <div class="sm:col-span-2">
            <label class="text-white block mb-2 font-semibold text-sm">Character Voice Line (Sound)</label>
            <?php if (!empty($character['sound'])): ?>
                <div class="mb-3 p-2 bg-white/5 rounded-md block">
                    <p class="text-xs text-gray-400 mb-1">Current Audio Track:</p>
                    <audio controls  src="voice_line/<?=$character['sound'] ?>"></audio></td>
                </div>
            <?php endif; ?>
            <input type="file" name="sound" accept="audio/*" class="text-white block w-full text-sm bg-black rounded-lg">
            <p class="text-xs text-gray-400 mt-1">Leave blank to retain current audio asset.</p>
        </div>


    </div>
    <div class="mt-10">
        <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="submit">Save Changes</button>
    </div>
    <div class="mt-10">
        <a href="manage_characters.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
            Go back
        </a>
    </div>
</form>
</body>
</html>

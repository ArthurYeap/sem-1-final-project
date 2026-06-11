<?php
require 'required files/tailwind-cdn.php';
require 'required files/db.php';


session_start();
require 'required files/admin.php';
$isEdit = isset($_GET['id']);

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

    // 1. CHECK FOR EMPTY FIELDS FIRST
    if (empty($name) || empty($talent) || empty($hair_color)) {
        echo "<script>
            alert('All fields are required');
        </script>";
    }

    // 2. ENFORCE THE TALENT RULE SECOND
    if (!str_contains($talent, 'Ultimate')) {
        $talent = 'Ultimate ' . $talent;
    }

    // 3. DATABASE OPERATIONS RUN ONLY IF VALIDATION PASSED
    if ($isEdit) {
        $stmt = $db->prepare("
            UPDATE characters
            SET name = ?, talent = ?, hair_color = ?, game = ?, outcome = ?, gender = ?
            WHERE id = ?
        ");
        $stmt->execute([$name, $talent, $hair_color, $game, $outcome, $gender, $id]);

        header('Location: manage_characters.php');
        exit;
    } else {
        $stmt = $db->prepare("
            INSERT INTO characters (name, talent, hair_color, game, outcome, gender)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$name, $talent, $hair_color, $game, $outcome, $gender]);

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

<form action="" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">


        <div class="sm:col-span-2">
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

        <div class="sm:col-span-2">
            <label for="company" class="block text-sm/6 font-semibold text-white">Hair Color</label>
            <div class="mt-2.5">
                <input  type="text" name="hair_color" value="<?=isset( $character['hair_color'])? $character['hair_color']: "" ; ?>" autocomplete="organization" class="block w-full rounded-md bg-white/5 px-3.5 py-2 text-base text-white outline-1 -outline-offset-1 outline-white/10 placeholder:text-gray-500 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-500" />
            </div>
        </div>

        <div class="mb-3">
                <label for="game" class="form-label text-white">Game:</label>
                <select class="form-control text-white bg-black"  name="game" >
                    <option value="DR1"  <?=isset($character['game']) && $character['game'] == "DR1" ? "selected" : "" ?>>DR1</option>
                    <option value="DR2"  <?=isset($character['game']) && $character['game'] == "DR2" ? "selected" : "" ?>>DR2</option>
                    <option value="V3"  <?=isset($character['game']) && $character['game'] == "V3" ? "selected" : "" ?>>V3</option>
                </select>
            </div>
        <div class="mb-3">
                <label for="outcome" class="form-label text-white">Outcome:</label>
                <select class="form-control text-white bg-black"  name="outcome" >
                    <option value="Survivor"  <?=isset($character['outcome']) && $character['outcome'] == "Survivor" ? "selected" : "" ?>>Survivor</option>
                    <option value="Victim"  <?=isset($character['outcome']) && $character['outcome'] == "Victim" ? "selected" : "" ?>>Victim</option>
                    <option value="Blackened"  <?=isset($character['outcome']) && $character['outcome'] == "Blackened" ? "selected" : "" ?>>Blackened</option>
                </select>
            </div>
        <div class="mb-3">
                <label for="gender" class="form-label text-white">Gender:</label>
                <select class="form-control text-white bg-black"  name="gender" >
                    <option value="Male"  <?=isset($character['gender']) && $character['gender'] == "Male" ? "selected" : "" ?>>Male</option>
                    <option value="Female"  <?=isset($character['gender']) && $character['gender'] == "Female" ? "selected" : "" ?>>Female</option>
                </select>
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

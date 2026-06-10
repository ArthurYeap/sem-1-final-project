<?php
require 'tailwind-cdn.php';
require 'db.php';

session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:index.php"); exit();
}

if(isset($_POST['logout'])){
    session_destroy();
    header("Location:index.php");
    exit();
}
if(isset($_POST['manage'])){
    header("Location:manage-players.php");
    exit();
}

if (!isset($_SESSION['answer_id'])) {

    $stmt = $db->query("
        SELECT id
        FROM characters
        ORDER BY RAND()
        LIMIT 1
    ");

    $random = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['answer_id'] = $random['id'];
}

if (isset($_POST["submit"])) {

    $guess = $_POST["guess"];

    $stmt = $db->prepare("
    SELECT *
    FROM characters
    WHERE name = ?
");

    $stmt->execute([$guess]);

    $character = $stmt->fetch(PDO::FETCH_ASSOC);


    $stmt = $db->prepare("
    SELECT *
    FROM characters
    WHERE id = ?
");

    $stmt->execute([$_SESSION["answer_id"]]);

    $answer = $stmt->fetch(PDO::FETCH_ASSOC);

    if( $character){if ($character["gender"] == $answer["gender"]) {

        echo "Gender matches!";

    } else {

        echo "Gender does not match.";

    }
        if ($character["game"] == $answer["game"]) {

            echo "game matches!";

        } else {

            echo "game does not match.";

        }
        if ($character["hair_color"] == $answer["hair_color"]) {

            echo "hair color matches!";

        } else {

            echo "hair color does not match.";

        }
        if ($character["outcome"] == $answer["outcome"]) {

            echo "outcome matches!";

        } else {

            echo "outcome does not match.";

        }
        if ($character["talent"] == $answer["talent"]) {

            echo "talent matches!";

        } else {

            echo "talent does not match.";

        }

        if ($character["id"] == $answer["id"]) {

            echo "🎉 You Win!";
            unset($_SESSION['answer_id']);
        }else{echo "Character not found";}}


}
?><!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>Document</title>

</head>
<body class = "bg-orange-100">
<form method="POST">
    <div class="sm:col-span-2">
        <label class="block text-sm font-semibold">
            Guess
        </label>

        <div class="mt-2.5">
            <input
                    type="text"
                    id="guess"
                    name="guess"
                    class="block w-full rounded-md bg-stone-900/50 px-3.5 py-2 text-white"
            >
            <div id="suggestions"></div>
        </div>
    </div>

    <button
            type="submit" name="submit"
            class="mt-4 bg-blue-500 text-white px-4 py-2 rounded"
    >
        Guess
    </button>

</form>

    <div class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
        <table class="w-full text-sm text-left rtl:text-right text-body">
            <thead class="bg-neutral-secondary-soft border-b border-default">
            <tr>
                <th scope="col" class="px-6 py-3 font-medium">
                    Name
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Game
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Talent
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Gender
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Hair colour
                </th>
                <th scope="col" class="px-6 py-3 font-medium">
                    Outcome
                </th>
            </tr>
            </thead>
            <tbody>
            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    Apple MacBook Pro 17"
                </th>
                <td class="px-6 py-4">
                    Silver
                </td>
                <td class="px-6 py-4">
                    Laptop
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>

            </tr>
            </tbody>
        </table>
        <form action="" method="post">
            <div class="mt-10">
                <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="logout">logout</button>
            </div>
            <div class="mt-10">
                <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="manage">Manage Players</button>
            </div>
        </form>

    </div>
</body>
</html>
<script src="script.js"></script>


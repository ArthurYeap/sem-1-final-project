<?php
require 'required files/tailwind-cdn.php';
require 'required files/db.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: manage-players.php");
    exit();
}
$game_id = $_GET['id'];

$stmt = $db->prepare("
SELECT c.*
FROM games g
JOIN characters c
ON g.answer_character_id = c.id
WHERE g.id = ?
");

$stmt->execute([$game_id]);

$answer = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $db->prepare("
SELECT
    c.*
FROM guesses g
JOIN characters c
ON g.character_id = c.id
WHERE g.game_id = ?
ORDER BY g.id ASC
");

$stmt->execute([$game_id]);

$guesses = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<body>

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
        <?php foreach ($guesses as $guess): ?>

            <tr>

                <td><?= htmlspecialchars($guess["name"]) ?></td>

                <td class="<?= $guess["game"] == $answer["game"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["game"]) ?>
                </td>

                <td class="<?= $guess["talent"] == $answer["talent"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["talent"]) ?>
                </td>

                <td class="<?= $guess["gender"] == $answer["gender"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["gender"]) ?>
                </td>

                <td class="<?= $guess["hair_color"] == $answer["hair_color"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["hair_color"]) ?>
                </td>

                <td class="<?= $guess["outcome"] == $answer["outcome"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["outcome"]) ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
        <div class="mt-10">
            <a href="history.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
                Go back
            </a>
        </div>
</body>
</html>

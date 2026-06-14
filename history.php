<?php
session_start();
require 'required files/tailwind-cdn.php';
require 'required files/db.php';

$id = $_SESSION['user_id'];
if (empty($id)) {
    header("Location: manage-players.php");
    exit();
}
$i = 0;

$stmt = $db->prepare("
SELECT
    games.*,
    characters.name AS answer_name,
    COUNT(guesses.id) AS guesses_taken
FROM games

JOIN characters
ON games.answer_character_id = characters.id

LEFT JOIN guesses
ON games.id = guesses.game_id

WHERE games.user_id = ?

GROUP BY games.id
");
$stmt->execute([$id]);
$games = $stmt->fetchAll(PDO::FETCH_ASSOC);
if(isset($_POST['submit'])) {
    if ($_GET['main'] == "true"){
        header("Location: main.php");
        exit();
    }else{
        header("Location: manage-players.php");
        exit();
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
<body>
<table class="table-auto">
    <thead>
    <tr class=>
        <th  class=" px-6">ID</th>
        <th>Answer</th>
        <th>Created At</th>
        <th>status</th>
        <th>Guesses Taken</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($games as $game): ?>
        <tr>
            <td><?= ++$i ?></td>
            <td><?= htmlspecialchars($game['answer_name']) ?></td>            <td><?= htmlspecialchars($game['created_at']) ?></td>
            <td class=" px-6"><?= htmlspecialchars($game['status']) ?></td>
            <td><?= htmlspecialchars($game['guesses_taken']) ?></td>
            <td class=" px-6">                        <a href="guesses.php?id=<?=$game['id']?>&&main=<?=isset($_GET['main']) &&$_GET['main'] == "true" ? 'true':'false'; ?>" class="rounded-md bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-gray-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"> manage user </a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<form action="" method="post">
    <div class="mt-10">
        <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="submit">Go back</button>
    </div>
</form>
</body>
</html>
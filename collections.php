<?php
require 'required files/tailwind-cdn.php';
require 'required files/db.php';
session_start();
$id = $_GET['id'];
$stmt = $db->prepare("
    SELECT
        c.*,
        col.character_id AS unlocked
    FROM characters c

    LEFT JOIN collections col
        ON c.id = col.character_id
        AND col.user_id = ?
    
        WHERE c.status = 'active'

");

$stmt->execute([$id]);

$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalCharacters = count($characters);
$unlockedCount = 0;

foreach ($characters as $character) {
    if ($character['unlocked']) {
        $unlockedCount++;
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

<div class="mb-6 p-4 bg-white rounded-lg shadow-sm border border-gray-200 max-w-sm">
    <p class="text-lg font-bold text-gray-700">
        Collection Progress:
        <span class="text-indigo-600"><?= $unlockedCount ?></span> / <span><?= $totalCharacters ?></span>
    </p>

    <!-- Optional: Tailwind Progress Bar -->
    <div class="w-full bg-gray-200 rounded-full h-2.5 mt-2">
        <?php
        $percentage = $totalCharacters > 0 ? ($unlockedCount / $totalCharacters) * 100 : 0;
        ?>
        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: <?= $percentage ?>%"></div>
    </div>
</div>

<div class="mt-10">
    <a href="main.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
        Go back
    </a>
</div>
<?php foreach($characters as $character): ?>

    <?php if($character['unlocked']): ?>

        <div class="card bg-base-100 w-96 shadow-sm">
            <div class="card-body">
                <h2 class="card-title"><?=$character['name'] ?></h2>
                <p>Congrats u have unlock this character</p>
            </div>
            <figure>
                <img
                    src="sprites/<?=$character['name']?> Sprite.webp"
                    alt="Shoes" />
            </figure>
        </div>
    <?php else: ?>

        <div class="card bg-base-100 w-96 shadow-sm">
            <div class="card-body">
                <h2 class="card-title">Card Title</h2>
                <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
            </div>
            <figure>
                <img
                    src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                    alt="Shoes" />
            </figure>
        </div>
    <?php endif; ?>

<?php endforeach; ?>


</body>
</html>

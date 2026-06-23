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

//!progress bar
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
    <title>Collection Page</title>
    <link rel="stylesheet" href="main.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Alumni+Sans+SC:ital,wght@0,100..900;1,100..900&family=Geo:ital@0;1&display=swap" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Alumni+Sans+SC:ital,wght@0,100..900;1,100..900&family=Geo:ital@0;1&display=swap');
    </style>
</head>
<body class="min-h-screen dangan-bg-grid font-sans overflow-x-hidden">

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pt-24 md:pt-32 pb-12 px-4 md:px-8 max-w-7xl mx-auto items-start relative">

<!--!progress container-->
    <div class="col-span-full lg:col-span-3 p-5 border-2 rounded-none flex flex-col md:flex-row items-center justify-between gap-6 relative z-10 border-red-600">
        <p class="font-heading font-black text-white uppercase tracking-tight flex items-center gap-2 text-3xl scale-110 md:ml-12" style="font-family: Geo">
            Culprit Found:
            <span class="text-blue-300 font-mono text-2xl font-bold ml-1"><?= $unlockedCount ?></span> / <span class="text-red-300 font-mono"><?= $totalCharacters ?></span>
        </p>

<!--        !progress bar-->
        <div class="w-full md:max-w-md border h-4 rounded-md mt-2 md:mt-0 relative overflow-hidden border-red-600">
            <?php
            $percentage = $totalCharacters > 0 ? ($unlockedCount / $totalCharacters) * 100 : 0;
            ?>
            <div class=" h-full rounded-none bg-white" style="width: <?= $percentage ?>%">
            </div>
        </div>
    </div>

<!--!go back button-->
    <div class="col-span-full lg:col-span-1 mt-0 w-full flex items-center h-full z-10">
        <a href="main.php" class="block w-full text-center rounded-none  border-2 border-fuchsia-600 text-fuchsia-600 hover:bg-fuchsia-600 hover:text-black py-4 text-xs font-heading font-black uppercase tracking-widest transition-colors duration-150 transform -skew-x-6 cursor-pointer">
        Go back
    </a>
</div>

<!--! character card -->
<?php foreach($characters as $character): ?>

    <?php if($character['unlocked']): ?>

        <div class="w-full col-span-1 border-2 p-4 relative rounded-none flex flex-col justify-between overflow-hidden bg-black group transition-all duration-300 hover:-translate-y-2 z-10">
            <figure class="w-full h-48  border  flex items-center justify-center overflow-hidden transform -skew-x-3 mb-4 shrink-0 relative">
                <img
                        src="sprites/<?=$character['sprite']?>"
                        alt="<?=$character['name']?>"
                        class="max-h-36 w-auto object-contain filter drop-shadow-[0_0_6px_#8F00FC] transition-transform duration-300 group-hover:scale-110 bg-pink-400" />
            </figure>
            <div class="flex flex-col gap-1 p-2">
                <h1 class="font-heading font-black uppercase tracking-tight text-red-600 truncate border-b pb-1 text-3xl" style="font-family: Alumni Sans SC"><?=$character['name'] ?></h1>
            </div>
        </div>
    <?php else: ?>

<!--    !haven't unlcoked card-->
<div class="col-span-1  border-2  p-4 relative rounded-none flex flex-col justify-between overflow-hidden group transition-all duration-300 hover:-translate-y-2 z-10 bg-black ">
    <figure class="w-full h-48  border  flex items-center justify-center overflow-hidden transform -skew-x-3 mb-4 shrink-0 relative">
        <img
                src="sprites/unkown_char.png"
                class="max-h-36 w-auto object-contain filter drop-shadow-[0_0_6px_#8F00FC] transition-transform duration-300 group-hover:scale-110 bg-pink-400" />
    </figure>
    <div class="flex flex-col gap-1 p-2">
        <h2 class="font-heading font-black text-base text-white uppercase tracking-tight text-red-600 truncate border-b pb-1">?????????</h2>
    </div>
</div>
    <?php endif; ?>

<?php endforeach; ?>

</div>
</body>
</html>

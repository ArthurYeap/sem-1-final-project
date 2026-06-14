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
    <link rel="stylesheet" href="main.css"
</head>
<body class=" text-green-500 min-h-screen dangan-bg-grid font-sans  grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 pt-24 md:pt-32 pb-12 px-4 md:px-8 max-w-7xl mx-auto items-start relative overflow-x-hidden">

<div class="col-span-full lg:col-span-3 progress-card p-5 bg-dangan-black/90 border-2 border-dangan-pink rounded-none dangan-neon-shadow flex flex-col md:flex-row items-center justify-between gap-6 relative z-10">
    <p class="text-lg font-heading font-black text-white uppercase tracking-tight flex items-center gap-2">
        Suspect Found:
        <span class="text-dangan-pink font-mono text-2xl font-bold ml-1"><?= $unlockedCount ?></span> / <span class="text-dangan-cyan font-mono"><?= $totalCharacters ?></span>
    </p>

    <!-- Optional: Tailwind Progress Bar -->
    <div class="w-full md:max-w-md bg-dangan-slate border border-dangan-pink/20 h-4 rounded-none mt-2 md:mt-0 relative overflow-hidden">
        <?php
        $percentage = $totalCharacters > 0 ? ($unlockedCount / $totalCharacters) * 100 : 0;
        ?>
        <div class=" h-full transition-all duration-500 rounded-none" style="width: <?= $percentage ?>%"></div>
    </div>
</div>

<div class="col-span-full lg:col-span-1 mt-0 w-full flex items-center h-full z-10">
    <a href="main.php" class="block w-full text-center rounded-none bg-dangan-black border-2 border-dangan-cyan text-dangan-cyan hover:bg-dangan-cyan hover:text-dangan-black py-4 text-xs font-heading font-black uppercase tracking-widest transition-colors duration-150 transform -skew-x-6 cursor-pointer">
        Go back
    </a>
</div>

<?php foreach($characters as $character): ?>

    <?php if($character['unlocked']): ?>

        <div class="card-unlocked col-span-1 bg-dangan-black/95 border-2 border-dangan-pink p-4 relative rounded-none dangan-neon-shadow flex flex-col justify-between overflow-hidden group transition-all duration-300 hover:-translate-y-2 z-10">
            <figure class="w-full h-48 bg-dangan-slate border border-dangan-pink/20 flex items-center justify-center overflow-hidden transform -skew-x-3 mb-4 shrink-0 relative">
                <img
                        src="sprites/<?=$character['sprite']?>"
                        alt="<?=$character['name']?>"
                        class="max-h-36 w-auto object-contain filter drop-shadow-[0_0_6px_#ff007f] transition-transform duration-300 group-hover:scale-110" />
            </figure>
            <div class="flex flex-col gap-1 p-2">
                <h2 class="font-heading font-black text-base text-white uppercase tracking-tight truncate border-b border-dangan-pink/30 pb-1"><?=$character['name'] ?></h2>
                <p class="font-mono text-[10px] text-dangan-cyan uppercase tracking-widest mt-1 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 bg-dangan-cyan rounded-full animate-pulse"></span>
                    You have unlocked this character
                </p>
            </div>
        </div>
    <?php else: ?>

        <div class="card-locked col-span-1 bg-dangan-slate/40 border border-white/10 p-4 relative rounded-none flex flex-col justify-between overflow-hidden group opacity-60 hover:opacity-85 transition-all duration-300 hover:-translate-y-1 z-10">
            <div class="flex flex-col gap-1 p-2 mb-4">
                <h2 class="font-heading font-black text-base text-zinc-500 uppercase tracking-tight truncate border-b border-white/5 pb-1">Card Title</h2>
                <p class="font-mono text-[10px] text-zinc-600 uppercase tracking-wider mt-1 line-clamp-2">A card component has a figure, a body part, and inside body there are title and actions parts</p>
            </div>
            <figure class="w-full h-48 bg-zinc-950 border border-white/5 flex items-center justify-center overflow-hidden transform -skew-x-3 shrink-0 relative">
                <img
                        src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp"
                        alt="Shoes"
                        class="w-full h-full object-cover filter grayscale brightness-50 contrast-125 saturate-0 opacity-20 mix-blend-luminosity transition-transform duration-300 group-hover:scale-105" />
            </figure>
        </div>
    <?php endif; ?>

<?php endforeach; ?>


</body>
</html>

<?php
session_start();
require 'required files/tailwind-cdn.php';
require 'required files/db.php';

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
    <title>Guessses Page</title>
    <link rel="stylesheet" href="main.css">
    <style>
        @media (min-width: 768px) {
            tr {
                border-left: 4px solid #ff007f !important;
                background: rgba(14, 14, 17, 0.6) !important;
                transition: all 0.2s ease;
            }
            tr:hover {
                border-left-color: #00f0ff !important;
                background: rgba(255, 0, 127, 0.05) !important;
            }
            td, th {
                padding: 1.25rem 0.75rem !important;
                border-right: 1px solid rgba(255, 0, 127, 0.15) !important;
            }
            td:last-child, th:last-child {
                border-right: none !important;
            }
        }

        @media (max-width: 767px) {
            thead {
                display: none !important;
            }
            table, tbody, tr, td {
                display: block !important;
                width: 100% !important;
            }
            tr {
                margin-bottom: 1.5rem !important;
                border: 2px solid #ff007f !important;
                padding: 1.25rem !important;
                position: relative;
            }
            td {
                display: flex !important;
                justify-content: space-between !important;
                align-items: center !important;
                padding: 0.75rem 0 !important;
                border-bottom: 1px solid rgba(255, 0, 127, 0.15) !important;
            }

            td::before {
                content: attr(data-label);
                font-size: 8px;
                color: #ff007f;
                font-weight: 700;
                letter-spacing: 0.1em;
            }
        }
    </style>
</head>
<body class="dangan-bg-grid">
<div class="w-full max-w-5xl table-container border-2 border-pink-800 p-6 relative rounded-none z-10 bg-black mx-auto">
    <div class="fixed top-10 left-10 z-20 scale-60  md:scale-100" >
        <a href="history.php?main=<?= isset($_GET['main']) ? $_GET['main'] : 'false' ?>&id=<?= isset($_GET['user_id']) ? $_GET['user_id'] : '' ?>"
           class="group cursor-pointer inline-block p-3 rounded-xl outline-none bg-green-600 hover:bg-green-700 transition-colors duration-200"
          >

        <!-- Removed duplicate tag and set clear 48px sizes directly -->
            <svg class="h-12 w-12 stroke-[#43f97a] fill-none group-hover:scale-110 transition-transform duration-200"
                 viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg"
            >
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path d="M9 22H15C20 22 22 20 22 15V9C22 4 20 2 15 2H9C4 2 2 4 2 9V15C2 20 4 22 9 22Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M9.00002 15.3802H13.92C15.62 15.3802 17 14.0002 17 12.3002C17 10.6002 15.62 9.22021 13.92 9.22021H7.15002" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M8.57 10.7701L7 9.19012L8.57 7.62012" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        </a>
    </div>
    <table class="w-full text-sm text-left text-black border-black  font-mono" style="background-color: #2e2f2d">
        <thead class=" border-b border-black tracking-widest text-sm uppercase">
        <tr>
            <th scope="col" class="px-4 py-3 font-bold border-2 border-black  text-center text-pink-500">
                Name
            </th>
            <th scope="col" class="px-4 py-3 text-pink-500 border-r border-black   font-bold border-r  text-center">
                Game
            </th>
            <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r  text-center">
                Talent
            </th>
            <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r text-center">
                Gender
            </th>
            <th scope="col" class="px-4 border-r text-pink-500 border-black   py-3 font-bold border-r text-center">
                Hair colour
            </th>
            <th scope="col" class="px-4 border-r text-pink-500 border-black   py-3 font-bold text-center">
                Outcome
            </th>
        </tr>
        </thead>
        <tbody class="divide-y ">
        <?php foreach ($guesses as $guess): ?>

            <tr class="border-3 divide-x-3">
                <td data-label="Name" class="px-4 py-4 border-r  text-center"><img
                            src="sprites/<?= $guess['pixel']?>"
                            class="h-12 w-auto mx-auto object-contain drop-shadow-[0_0_4px_rgba(255,0,127,0.7)] hover:scale-110  duration-200"
                    /><br>  <span class="text-[11px] font-sans font-extrabold tracking-wider uppercase text-white"><?= htmlspecialchars($guess["name"]) ?></span>
                </td>

                <td data-label="Game" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm <?= $guess["game"] == $answer["game"] ? 'bg-green-400' : 'bg-red-400' ;?> " >
                    <?= htmlspecialchars($guess["game"]) ?>
                </td>

                <td data-label="Talent" class="px-4 py-4 border-r text-center text-black  font-mono font-bold uppercase tracking-wider text-sm <?= $guess["talent"] == $answer["talent"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["talent"]) ?>
                </td>

                <td data-label="Gender" class="px-4 py-4 border-r text-center font-mono text-black  font-bold uppercase tracking-wider text-sm <?= $guess["gender"] == $answer["gender"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["gender"]) ?>
                </td>

                <td data-label="Hair colour" class="px-4 py-4 border-r text-center text-black  font-mono font-bold uppercase tracking-wider text-sm <?= $guess["hair_color"] == $answer["hair_color"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["hair_color"]) ?>
                </td>

                <td data-label="Outcome" class="px-4 py-4 text-center font-mono font-bold text-black  uppercase tracking-wider text-sm <?= $guess["outcome"] == $answer["outcome"] ? 'bg-green-400' : 'bg-red-400' ;?>">
                    <?= htmlspecialchars($guess["outcome"]) ?>
                </td>
            </tr>

        <?php endforeach; ?>
        </tbody>
    </table><br>
</body>
</html>

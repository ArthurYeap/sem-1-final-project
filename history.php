<?php
session_start();
require 'required files/tailwind-cdn.php';
require 'required files/db.php';
$id = $_GET['id'];
if (empty($id)) {
    header("Location: main.php");
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
<form action="" method="post">
<div class="fixed top-10 left-10 z-20 scale-60  md:scale-100" >
    <button type="submit" name="submit"
            class="group cursor-pointer inline-block p-3 rounded-xl outline-none bg-green-600 hover:bg-green-600 transition-colors duration-200"
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
    </button>
</div>
</form>
<table class="w-full text-sm text-left text-black border-black  font-mono " style="background-color: #2e2f2d">
    <thead class=" border-b border-black tracking-widest text-sm uppercase">
    <tr>
        <th scope="col" class="px-4 py-3 font-bold border-2 border-black  text-center text-pink-500">
            ID
        </th>
        <th scope="col" class="px-4 py-3 font-bold border-2 border-black  text-center text-pink-500">
            Answer
        </th>
        <th scope="col" class="px-4 py-3 text-pink-500 border-r border-black   font-bold border-r  text-center">
            Created At
        </th>
        <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r  text-center">
            Status
        </th>
        <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r  text-center">
            Guess Taken
        </th>
        <th scope="col" class="px-4 border-r text-pink-500 border-black   py-3 font-bold text-center">
            View Game
        </th>
    </tr>
    </thead>
    <tbody class="divide-y ">
    <?php foreach ($games as $game): ?>

        <tr class="border-3 divide-x-3">
            <td data-label="ID" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-black text-white" >
                <?=++$i?>
            </td>
            <td data-label="Name" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-white" >
                <?= htmlspecialchars($game["answer_name"]) ?>
            </td>

            <td data-label="Email" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-white" >
                <?= htmlspecialchars($game["created_at"]) ?>
            </td>

            <td data-label="Role" class="px-4 py-4 border-r text-center text-black bg-white font-mono font-bold uppercase tracking-wider text-sm">
                <?= htmlspecialchars($game["status"]) ?>
            </td>

            <td data-label="Role" class="px-4 py-4 border-r text-center text-black bg-white font-mono font-bold uppercase tracking-wider text-sm">
                <?= $game["guesses_taken"] ?>
            </td>

            <td data-label="Actions" class="px-4 py-4 text-center bg-white align-middle">
                <a href="guesses.php?id=<?=$game['id']?>&main=<?=isset($_GET['main']) && $_GET['main'] == 'true' ? 'true':'false'; ?>&user_id=<?= $_GET['id']?>"
                   class="group cursor-pointer inline-block outline-none transition-transform duration-200 hover:scale-110"
                   title="View History">
                    <!-- Added class="h-6 w-6" here to make the icon visible -->
                    <svg class="h-6 w-6" viewBox="0 -4 20 20" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#aa42ff" stroke="#aa42ff"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <title>view_simple [#815]</title> <desc>Created with Sketch.</desc> <defs> </defs> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="Dribbble-Light-Preview" transform="translate(-260.000000, -4563.000000)" fill="#a52ebd"> <g id="icons" transform="translate(56.000000, 160.000000)"> <path d="M216,4409.00052 C216,4410.14768 215.105,4411.07682 214,4411.07682 C212.895,4411.07682 212,4410.14768 212,4409.00052 C212,4407.85336 212.895,4406.92421 214,4406.92421 C215.105,4406.92421 216,4407.85336 216,4409.00052 M214,4412.9237 C211.011,4412.9237 208.195,4411.44744 206.399,4409.00052 C208.195,4406.55359 211.011,4405.0763 214,4405.0763 C216.989,4405.0763 219.805,4406.55359 221.601,4409.00052 C219.805,4411.44744 216.989,4412.9237 214,4412.9237 M214,4403 C209.724,4403 205.999,4405.41682 204,4409.00052 C205.999,4412.58422 209.724,4415 214,4415 C218.276,4415 222.001,4412.58422 224,4409.00052 C222.001,4405.41682 218.276,4403 214,4403" id="view_simple-[#815]"> </path> </g> </g> </g> </g></svg>
                </a>
            </td>




        </tr>

    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
<?php require "main_backend.php";?>


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
    <link href="https://fonts.googleapis.com/css2?family=Share+Tech+Mono&family=Space+Grotesk:wght@400;700;900&family=Syncopate:wght@700;900&display=swap" rel="stylesheet">
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
<body class="text-white min-h-screen dangan-bg-grid font-sans flex flex-col lg:flex-row items-start justify-center pt-24 md:pt-32 pb-12 px-4 md:px-8 gap-8 relative overflow-x-hidden">

<!--!guessing card-->
    <form method="POST" class=" w-full lg:w-[350px] border-2  p-6 relative rounded-none z-10 lg:sticky lg:top-24 shrink-0 border-pink-800 " style="background-color: #000000">

    <!--    !search bar-->
        <div class="sm:col-span-2 border-2 border-black">
            <div class="mt-2.5 relative">
                <input
                        type="text"
                        id="guess"
                        name="guess"
                        autocomplete="off"
                        placeholder="ENTER SUSPECT NAME"
                        class="block w-full rounded-none px-4 py-3.5  font-mono text-base text-white tracking-widest uppercase opacity-50 border-3 border-pink-800 focus:outline-none "
                        style="background-color: #212121 "
                >

    <!--            !suggestions-->
                <div id="suggestions" class="absolute bg-black left-0 right-0 z-50 mt-1 max-h-60 overflow-y-auto border-pink-800 border-2 text-sm font-mono divide-y rounded-none " style="color: #737373"></div>
            </div>
        </div>

<!--        !guess button-->
        <button
                type="submit" name="submit" <?= isset($_SESSION['game_won']) && $_SESSION['game_won'] ? "disabled" : "" ; ?>
                class="mt-4 w-full bg-pink-800 text-base tracking-[0.2em] py-4 font-black uppercase disabled:opacity-30 disabled:pointer-events-none transform -skew-x-6 hover:-skew-x-3 active:scale-95 duration-100 cursor-pointer hover:bg-pink-400 text-black"
        >
            Choose Suspect
        </button>

    </form>


    <div class="w-full max-w-5xl table-container border-2 border-pink-800 p-6 relative rounded-none z-10 bg-black">
        <table class="w-full text-sm text-left text-black border-black  font-mono" style="background-color: #2e2f2d">

<!--            !table header-->
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

<!--            !table body-->
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
        </table>

<!--        !buttons-->
        <form action="" method="post" class="w-full pt-8 border-t  grid grid-cols-2 md:grid-cols-5 gap-3 justify-items-stretch text-center">

<!--            !logout btn-->
            <div class="w-full">
                <button type="submit"  class="menu-btn-red w-full px-4 py-2.5 text-xs rounded-none"  name="logout">logout</button>
            </div>

            <!--            !history btn-->
            <a href="history.php?id=<?=$_SESSION['user_id']?>&main=true" class="menu-btn w-full px-4 py-2.5 text-xs rounded-none flex items-center justify-center">  Check History </a>

            <!--            !collections btn-->

            <a href="collections.php?id=<?=$_SESSION['user_id']?>" class="menu-btn w-full px-4 py-2.5 text-xs rounded-none flex items-center justify-center">  Collections </a>

<!--            !hidden sound effect-->
            <audio hidden <?= (isset($_SESSION['game_won']) && $_SESSION['game_won']) ? '' : 'muted' ?> controls autoplay src="voice_line/<?=$answer['sound'] ?>"></audio>

            <!--            !manage players btn-->
            <div class="w-full">
                <button <?= $_SESSION['role'] !== "admin" ? "hidden" : "" ; ?> type="submit" class="menu-btn-cyan w-full px-4 py-2.5 text-xs rounded-none" name="manage">Manage Players</button>
            </div>

            <!--            !manage characters btn-->
            <div class="w-full">
                <button <?= $_SESSION['role'] !== "admin" ? "hidden" : "" ; ?> type="submit" class="menu-btn-cyan w-full px-4 py-2.5 text-xs rounded-none" name="characters">Manage Characters</button>
            </div>

<!--            !win card-->
            <div <?=  (isset($_SESSION['game_won']) &&    $_SESSION['game_won']) ? '' : 'hidden' ?> class=" scale-90 col-span-full mt-8 mx-auto w-full max-w-md border-4  relative overflow-hidden z-20 border-pink-600 ">

<!--                !answer sprite-->
                <img class="w-full h-auto object-contain rounded-none border-pink-500 transition-all duration-300  border-b-2 " src="sprites/<?=$answer['sprite']?>" alt="<?=$answer['name']?>" />

                <div class="p-6 text-center">
                    <h5 class="mt-3 mb-6 text-xl font-heading font-black tracking-tight text-red-600  uppercase leading-snug"><?= $answer['name'] ?> has been found guilty </h5>

<!--                    !new trial btn-->
                    <form action="" method="post">
                        <div class="mt-6">
                            <button type="submit" class="block w-full rounded-none text-white hover:bg-pink-400  bg-red-500 text-center text-xs  font-black py-4 transition-colors duration-150 uppercase tracking-widest cursor-pointer" name="new_game">New Trial</button>
                        </div>
                    </form>
                </div>
            </div>

    </div>
</body>
</html>
<script src="required files/script.js"></script>
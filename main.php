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
                    autocomplete="off"
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
    <form action="" method="post">
        <div class="mt-10">
            <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="logout">logout</button>
        </div>
        <div class="mt-10">
            <button <?= $_SESSION['role'] !== "admin" ? "hidden" : "" ; ?> type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="manage">Manage Players</button>
        </div>
    </form>
    <audio hidden <?= (isset($_SESSION['game_won']) && $_SESSION['game_won']) ? '' : 'muted' ?> controls autoplay src="voice_line/dragon-studio-wow-423653.mp3"></audio>


    <div <?=  (isset($_SESSION['game_won']) && $_SESSION['game_won']) ? '' : 'hidden' ?> class="bg-eed-200 block max-w-sm border border-default rounded-base shadow-xs ">
        <a href="#">
            <img class="rounded-t-base" src="/docs/images/blog/image-1.jpg" alt="" />
        </a>
        <div class="p-6 text-center">
        <span class="inline-flex items-center bg-brand-softer border border-brand-subtle text-fg-brand-strong text-xs font-medium px-1.5 py-0.5 rounded-sm">
            <svg class="w-3 h-3 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.122 17.645a7.185 7.185 0 0 1-2.656 2.495 7.06 7.06 0 0 1-3.52.853 6.617 6.617 0 0 1-3.306-.718 6.73 6.73 0 0 1-2.54-2.266c-2.672-4.57.287-8.846.887-9.668A4.448 4.448 0 0 0 8.07 6.31 4.49 4.49 0 0 0 7.997 4c1.284.965 6.43 3.258 5.525 10.631 1.496-1.136 2.7-3.046 2.846-6.216 1.43 1.061 3.985 5.462 1.754 9.23Z"/></svg>
            Trending
        </span>
            <a href="#">
                <h5 class="mt-3 mb-6 text-2xl font-semibold tracking-tight text-heading">Streamlining your design process today.</h5>
            </a>
            <form action="" method="post">
                <div class="mt-10">
                    <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="new_game">new game</button>
                </div>
            </form>
        </div>
    </div>

</div>
</body>
</html>
<script src="required files/script.js"></script>
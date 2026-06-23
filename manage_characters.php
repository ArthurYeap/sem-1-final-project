<?php
session_start();
require 'required files/tailwind-cdn.php';
require 'required files/db.php';
require 'required files/admin.php';
$i = 0;

//! if delete
if (isset($_POST['delete']) && isset($_POST['character_id'])){
    $id = $_POST['character_id'];

    $stmt = $db->prepare("
        UPDATE characters
        SET status = ?
        WHERE id = ?
    ");
    $stmt->execute([
        'inactive',
        $id
    ]);
}

//! fetching characters data
$stmt = $db->query("SELECT * FROM characters WHERE status = 'active';");
$characters = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

    <!doctype html>
    <html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>Manage Characters</title>
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

<a href="add&edit_characters.php"
        class="group cursor-pointer duration-300 fixed inline-block z-20 bottom-4 right-5 bg-red-700 rounded-xl p-2 hover:bg-pink-200"
        title="Add New"
>
    <h4>Add New Character</h4>
</a>


<div class="w-full max-w-5xl table-container border-2 border-pink-800 p-6 relative rounded-none z-10 bg-black mx-auto">
    <table class="w-full text-sm text-left text-black border-black  font-mono " style="background-color: #2e2f2d">
        <thead class=" border-b border-black tracking-widest text-sm uppercase">
        <tr>
            <th scope="col" class="px-4 py-3 font-bold border-2 border-black  text-center text-pink-500">
                ID
            </th>
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
            <th scope="col" class="px-4 py-3 text-pink-500 border-2 border-black font-bold text-center">Edit</th>
            <th scope="col" class="px-4 py-3 text-pink-500 border-2 border-black font-bold text-center">Delete</th>

        </thead>
        <tbody class="divide-y ">
        <?php foreach ($characters as $character): ?>

            <tr class="border-3 divide-x-3">
                <td data-label="ID" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-black text-white" >
                    <?=  ++$i?>
                </td>
                <td data-label="Name" class="px-4 py-4 border-r  text-center"><img
                            src="sprites/<?= $character['pixel']?>"
                            class="h-12 w-auto mx-auto scale-140 object-contain drop-shadow-[0_0_4px_rgba(255,0,127,0.7)] hover:scale-150  duration-200"
                    /><br>  <span class="text-[11px] font-sans font-extrabold tracking-wider uppercase text-white"><?= htmlspecialchars($character["name"]) ?></span>
                </td>

                <td data-label="Game" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-white" >
                    <?= htmlspecialchars($character["game"]) ?>
                </td>

                <td data-label="Talent" class="px-4 py-4 border-r text-center text-black bg-white font-mono font-bold uppercase tracking-wider text-sm">
                    <?= htmlspecialchars($character["talent"]) ?>
                </td>

                <td data-label="Gender" class="px-4 py-4 border-r text-center font-mono text-black bg-white font-bold uppercase tracking-wider text-sm ">
                    <?= htmlspecialchars($character["gender"]) ?>
                </td>

                <td data-label="Hair colour" class="px-4 py-4 border-r text-center text-black bg-white font-mono font-bold uppercase tracking-wider text-sm ">
                    <?= htmlspecialchars($character["hair_color"]) ?>
                </td>

                <td data-label="Outcome" class="px-4 py-4 text-center font-mono font-bold text-black  uppercase bg-white bg-whitetracking-wider text-sm ">
                    <?= htmlspecialchars($character["outcome"]) ?>
                </td>

                <td data-label="Actions" class="px-4 py-4 text-center bg-white align-middle">
                    <a href="add&edit_characters.php?id=<?= $character['id'] ?>"
                       class="group cursor-pointer inline-block outline-none transition-transform duration-200 hover:scale-110"
                       title="Edit Character">
                        <svg class="h-6 w-6 mx-auto stroke-cyan-500 fill-none group-hover:stroke-pink-500 duration-200"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg">
                            <g stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21.2799 6.40005L11.7399 15.94C10.7899 16.89 7.96987 17.33 7.33987 16.7C6.70987 16.07 7.13987 13.25 8.08987 12.3L17.6399 2.75002C17.8754 2.49308 18.1605 2.28654 18.4781 2.14284C18.7956 1.99914 19.139 1.92124 19.4875 1.9139C19.8359 1.90657 20.1823 1.96991 20.5056 2.10012C20.8289 2.23033 21.1225 2.42473 21.3686 2.67153C21.6147 2.91833 21.8083 3.21243 21.9376 3.53609C22.0669 3.85976 22.1294 4.20626 22.1211 4.55471C22.1128 4.90316 22.0339 5.24635 21.8894 5.5635C21.7448 5.88065 21.5375 6.16524 21.2799 6.40005V6.40005Z"></path>
                                <path d="M11 4H6C4.93913 4 3.92178 4.42142 3.17163 5.17157C2.42149 5.92172 2 6.93913 2 8V18C2 19.0609 2.42149 20.0783 3.17163 20.8284C3.92178 21.5786 4.93913 22 6 22H17C19.21 22 20 20.2 20 18V13"></path>
                            </g>
                        </svg>
                    </a>
                </td>

                <td data-label="Actions" class="px-4 py-4 text-center bg-white align-middle">
                    <form method="post" action="" onsubmit="return confirm('Delete this character?');">
<!--                        !hidden input character id-->
                        <input type="hidden" name="character_id" value="<?= htmlspecialchars($character['id']) ?>">
                        <button type="submit" name="delete" class="group cursor-pointer inline-block outline-none transition-transform duration-200 hover:scale-110" title="Delete Character">
                            <!-- SVG icon -->
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mx-auto"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <path d="M10 11V17" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M14 11V17" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M4 7H20" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M6 7H12H18V18C18 19.6569 16.6569 21 15 21H9C7.34315 21 6 19.6569 6 18V7Z" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> <path d="M9 5C9 3.89543 9.89543 3 11 3H13C14.1046 3 15 3.89543 15 5V7H9V5Z" stroke="#ff0000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path> </g></svg>
                        </button>
                    </form>
                </td>


            </tr>

        <?php endforeach; ?>
        </tbody>
    </table>
    </div>
</div>

<div class="fixed top-10 left-10 z-20 scale-60  md:scale-100" >
    <a href="main.php"
       class="group cursor-pointer inline-block p-3 rounded-xl outline-none bg-green-600 hover:bg-green-600 transition-colors duration-200"
       title="Add New"
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

</body>
    </html><?php

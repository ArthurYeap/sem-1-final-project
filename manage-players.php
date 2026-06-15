<?php
require 'required files/tailwind-cdn.php';
require 'required files/db.php';


session_start();
require 'required files/admin.php';
$i = 0;
if (isset($_POST['delete']) && isset($_POST['user_id'])){
    // Store the form value inside a defined variable
    $id = $_POST['user_id'];

    $stmt = $db->prepare("
        UPDATE users
        SET status = ?
        WHERE id = ?
    ");

    $stmt->execute([
        'inactive',
        $id
    ]);



}

// 2. FETCH THE FRESH DATA SECOND
$stmt = $db->query("
 SELECT
    users.id,
    users.username,
    users.email,
    users.role,
    COUNT(DISTINCT games.id) AS games_played,
    COUNT(DISTINCT collections.id) AS characters_collected
FROM users
LEFT JOIN games
    ON users.id = games.user_id
LEFT JOIN collections
    ON users.id = collections.user_id
WHERE users.status = 'active'
GROUP BY
    users.id,
    users.username,
    users.email,
    users.role;
");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
        @media (min-width: 905px) {
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

        @media (max-width: 904px) {
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

    <a href="regristration.php"
       class="group cursor-pointer duration-300 fixed inline-block z-20 bottom-4 right-5 bg-red-700 rounded-xl p-2 hover:bg-pink-200"
       title="Add New"
    >
        <h4>Add New Player</h4>
    </a>
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
                Email
            </th>
            <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r  text-center">
                Role
            </th>
            <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r  text-center">
                Games Played
            </th>
            <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r  text-center">
                Characters Collected
            </th>
            <th scope="col" class="px-4 text-pink-500 border-r border-black   py-3 font-bold border-r text-center">
                History
            </th>
            <th scope="col" class="px-4 border-r text-pink-500 border-black   py-3 font-bold border-r text-center">
                Edit
            </th>
            <th scope="col" class="px-4 border-r text-pink-500 border-black   py-3 font-bold text-center">
                Delete
            </th>
        </tr>
        </thead>
        <tbody class="divide-y ">
        <?php foreach ($users as $user): ?>

            <tr class="border-3 divide-x-3">
                <td data-label="ID" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-black text-white" >
                    <?=++$i?>
                </td>
                <td data-label="Name" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-white" >
                    <?= htmlspecialchars($user["username"]) ?>
                </td>

                <td data-label="Email" class="px-4 py-4 border-r text-center font-mono font-bold uppercase text-black tracking-wider text-sm bg-white" >
                    <?= htmlspecialchars($user["email"]) ?>
                </td>

                <td data-label="Role" class="px-4 py-4 border-r text-center text-black bg-white font-mono font-bold uppercase tracking-wider text-sm">
                    <?= htmlspecialchars($user["role"]) ?>
                </td>

                <td data-label="Role" class="px-4 py-4 border-r text-center text-black bg-white font-mono font-bold uppercase tracking-wider text-sm">
                    <?= $user["games_played"] ?>
                </td>

                <td data-label="Role" class="px-4 py-4 border-r text-center text-black bg-white font-mono font-bold uppercase tracking-wider text-sm">
                    <?= $user["characters_collected"] ?>
                </td>


                <td data-label="Actions" class="px-4 py-4 text-center bg-white align-middle">
                    <a href="history.php?id=<?=$user['id']?>"
                       class="group cursor-pointer inline-block outline-none transition-transform duration-200 hover:scale-110"
                       title="View History">
                        <!-- Added h-6 w-6 to give the icon an exact size -->
                        <svg class="h-6 w-6 mx-auto stroke-[#fee258] fill-none duration-200"
                             viewBox="0 0 24 24"
                             xmlns="http://www.w3.org/2000/svg"
                        >
                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                            <g id="SVGRepo_iconCarrier">
                                <path d="M12 8V12L14.5 14.5" stroke="#fee258" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                <path d="M5.60423 5.60423L5.0739 5.0739V5.0739L5.60423 5.60423ZM4.33785 6.87061L3.58786 6.87438C3.58992 7.28564 3.92281 7.61853 4.33408 7.6206L4.33785 6.87061ZM6.87963 7.63339C7.29384 7.63547 7.63131 7.30138 7.63339 6.88717C7.63547 6.47296 7.30138 6.13549 6.88717 6.13341L6.87963 7.63339ZM5.07505 4.32129C5.07296 3.90708 4.7355 3.57298 4.32129 3.57506C3.90708 3.57715 3.57298 3.91462 3.57507 4.32882L5.07505 4.32129ZM3.75 12C3.75 11.5858 3.41421 11.25 3 11.25C2.58579 11.25 2.25 11.5858 2.25 12H3.75ZM16.8755 20.4452C17.2341 20.2378 17.3566 19.779 17.1492 19.4204C16.9418 19.0619 16.483 18.9393 16.1245 19.1468L16.8755 20.4452ZM19.1468 16.1245C18.9393 16.483 19.0619 16.9418 19.4204 17.1492C19.779 17.3566 20.2378 17.2341 20.4452 16.8755L19.1468 16.1245ZM5.14033 5.07126C4.84598 5.36269 4.84361 5.83756 5.13505 6.13191C5.42648 6.42626 5.90134 6.42862 6.19569 6.13719L5.14033 5.07126ZM18.8623 5.13786C15.0421 1.31766 8.86882 1.27898 5.0739 5.0739L6.13456 6.13456C9.33366 2.93545 14.5572 2.95404 17.8017 6.19852L18.8623 5.13786ZM5.0739 5.0739L3.80752 6.34028L4.86818 7.40094L6.13456 6.13456L5.0739 5.0739ZM4.33408 7.6206L6.87963 7.63339L6.88717 6.13341L4.34162 6.12062L4.33408 7.6206ZM5.08784 6.86684L5.07505 4.32129L3.57507 4.32882L3.58786 6.87438L5.08784 6.86684ZM12 3.75C16.5563 3.75 20.25 7.44365 20.25 12H21.75C21.75 6.61522 17.3848 2.25 12 2.25V3.75ZM12 20.25C7.44365 20.25 3.75 16.5563 3.75 12H2.25C2.25 17.3848 6.61522 21.75 12 21.75V20.25ZM16.1245 19.1468C14.9118 19.8483 13.5039 20.25 12 20.25V21.75C13.7747 21.75 15.4407 21.2752 16.8755 20.4452L16.1245 19.1468ZM20.25 12C20.25 13.5039 19.8483 14.9118 19.1468 16.1245L20.4452 16.8755C21.2752 15.4407 21.75 13.7747 21.75 12H20.25ZM6.19569 6.13719C7.68707 4.66059 9.73646 3.75 12 3.75V2.25C9.32542 2.25 6.90113 3.32791 5.14033 5.07126L6.19569 6.13719Z" fill="#fee258"></path>
                            </g>
                        </svg>
                    </a>
                </td>

                <td data-label="Actions" class="px-4 py-4 text-center bg-white align-middle">
                    <a href="edit_user.php?id=<?=$user['id']?>"
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
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']) ?>">
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


</body>
</html><?php

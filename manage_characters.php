<?php
require 'required files/tailwind-cdn.php';
require 'required files/db.php';


session_start();
require 'required files/admin.php';
$i = 0;
if (isset($_POST['delete']) && isset($_POST['character_id'])){
    // Store the form value inside a defined variable
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

// 2. FETCH THE FRESH DATA SECOND
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
    <title>Document</title>
</head>
<body>
<div class="mt-10">
    <a href="add&edit_characters.php" class="block w-full rounded-md bg-yellow-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500">
        Add New Character    </a>
</div>
<table class="w-full text-sm text-left rtl:text-right text-body">
    <thead class="bg-neutral-secondary-soft border-b border-default">
    <tr>
        <th scope="col" class="px-6 py-3 font-medium">
            ID
        </th>
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
    <?php foreach ($characters as $character): ?>

        <tr>

            <td><?= ++$i ?></td>
            <td><?= htmlspecialchars($character["name"]) ?></td>

            <td>
                <?= htmlspecialchars($character["game"]) ?>
            </td>

            <td>                <?= htmlspecialchars($character["talent"]) ?>
            </td>

            <td>                <?= htmlspecialchars($character["gender"]) ?>
            </td>

            <td>                <?= htmlspecialchars($character["hair_color"]) ?>
            </td>

            <td>                <?= htmlspecialchars($character["outcome"]) ?>
            </td>

            <td class=" px-6">                        <a href="add&edit_characters.php?id=<?=$character['id']?>" class="rounded-md bg-gray-700 px-3.5 py-2.5 text-sm font-semibold text-white inset-ring inset-ring-white/5 hover:bg-gray-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white"> Edit </a></td>
            <form method="post" action="">
                <input type="hidden" name="character_id" value="<?= $character['id'] ?>">
                <td class=" px-6">     <button type="submit"  name="delete" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
                        Delete
                    </button></td>
            </form>
        </tr>

    <?php endforeach; ?>
    </tbody>
</table>
<div class="mt-10">
    <a href="main.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 ">
        Go back
    </a>
</div>
</body>
    </html><?php

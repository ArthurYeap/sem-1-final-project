<?php
require 'tailwind-cdn.php';
require 'db.php';

session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:index.php"); exit();
}

if(isset($_POST['submit'])){
    session_destroy();
    header("Location:index.php");
    exit();
}
if(isset($_POST['manage'])){
    header("Location:manage-players.php");
    exit();
}

$stmt = $db->query("
    SELECT id
    FROM characters
    ORDER BY RAND()
    LIMIT 1
");


?><!doctype html>
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
    <div class="sm:col-span-2">
        <label for="name" class="block text-sm/6 font-semibold text-black">Name</label>
        <div class="mt-2.5">
            <input id="name" type="text" name="name" autocomplete="organization"
                   class="block w-full rounded-md bg-stone-900/50 px-3.5 py-2 text-base text-white border border-stone-700 placeholder:text-stone-500 focus:outline focus:outline-2 focus:outline-offset-2 focus:outline-indigo-500" />
        </div>
    </div><br>

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
            <tr class="odd:bg-neutral-primary even:bg-neutral-secondary-soft border-b border-default">
                <th scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">
                    Apple MacBook Pro 17"
                </th>
                <td class="px-6 py-4">
                    Silver
                </td>
                <td class="px-6 py-4">
                    Laptop
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>
                <td class="px-6 py-4">
                    $2999
                </td>

            </tr>
            </tbody>
        </table>
        <form action="" method="POST" class="mx-auto mt-16 max-w-xl sm:mt-20">
            <div class="mt-10">
                <button type="submit" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500" name="submit">Logout</button>
            </div>
            <div class="mt-10">
                <a href="manage-players.php" class="block w-full rounded-md bg-indigo-500 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-400 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-500 <?php echo ($_SESSION['role'] !== 'admin') ? 'hidden' : ''; ?>">
                    Manage Players
                </a>

            </div>
        </form>
    </div>
</body>
</html>
<?php
echo isset($_SESSION['role']) ? "<h1>Hello</h1>" : "<h1>BADBAD</h1>";
?>
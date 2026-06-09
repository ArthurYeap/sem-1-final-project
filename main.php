<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible"
          content="ie=edge">
    <title>Document</title>
    <?php require 'tailwind-cdn.php';?>

</head>
<body>


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
</div>

<?php


require "db.php";
$query = $db->query("SELECT * FROM characters");

$characters = $query->fetchAll();
?>



</body>
</html>
<?php

<?php
require 'required files/tailwind-cdn.php';
require 'required files/db.php';

session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:index.php"); exit();
}
if(isset($_POST['logout'])){
    session_destroy();
    header("Location:index.php");
    exit();
}
if(isset($_POST['manage'])){
    header("Location:manage-players.php");
    exit();
}
if(isset($_POST['characters'])){
    header("Location:manage_characters.php");
    exit();
}
if(isset($_POST['new_game'])){
    $_SESSION['game_won'] = false;
    unset($_SESSION['answer_id']);
    unset($_SESSION['game_id']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

$character = null;

//TODO:creating and fetching random character
if (!isset($_SESSION['answer_id'])) {

    $stmt = $db->query("
    SELECT id
    FROM characters
    WHERE status = 'active' 
    ORDER BY RAND()
    LIMIT 1
");

    $random = $stmt->fetch(PDO::FETCH_ASSOC);

    $_SESSION['answer_id'] = $random['id'];
}

$stmt = $db->prepare("
    SELECT *
    FROM characters
    WHERE id = ?
");

$stmt->execute([$_SESSION["answer_id"]]);

$answer = $stmt->fetch(PDO::FETCH_ASSOC);
//TODO----------------------------------------------------------------------


//*fetching player's guess character
if (isset($_POST["submit"])) {
    $guess = $_POST["guess"] ?? '';

    if (empty($guess)){

    } else {
        $stmt = $db->prepare("
        SELECT *
        FROM characters
        WHERE name = ?
    ");

        $stmt->execute([$guess]);

        $character = $stmt->fetch(PDO::FETCH_ASSOC);
    }


//*--------------------------------------------------------------------------

//TODO inserting data into guesses table
    if($character){
        if ($character["id"] == $_SESSION['answer_id']) {
            $result_data = "correct guess";
        } else {
            $result_data = "wrong guess";
        }

        // Insert the guess into database
        if (isset($_SESSION['game_id'])) {
            $stmt = $db->prepare("
                INSERT INTO guesses (game_id, character_id, result_data)
                VALUES (?, ?, ?)
            ");

            $stmt->execute([
                $_SESSION['game_id'],
                $character['id'],
                $result_data
            ]);
        }
//*--------------------------------------------------------------------------

//!updating status if win
        if ($character["id"] == $_SESSION['answer_id']) {
            $stmt = $db->prepare("
                INSERT IGNORE INTO collections
                (user_id, character_id)
                VALUES (?, ?)
            ");

            $stmt->execute([
                $_SESSION['user_id'],
                $_SESSION['answer_id']
            ]);
            $_SESSION['game_won'] = true;
            if (isset($_SESSION['game_id'])) {
                $stmt = $db->prepare("
                    UPDATE games
            SET status = 'complete'
            WHERE id = ?
        ");

                $stmt->execute([$_SESSION['game_id']]);
            }


        }
    }}
//!------------------------------------------------------------------------------

//*inserting game session data into table
if (!isset($_SESSION['game_id']) && isset($_SESSION['answer_id'])) {
    $stmt = $db->prepare("
        INSERT INTO games (user_id, answer_character_id, status)
        VALUES (?, ?, 'ongoing')
    ");

    $stmt->execute([
        $_SESSION['user_id'],
        $_SESSION['answer_id']
    ]);

    $_SESSION['game_id'] = $db->lastInsertId();
}
//*------------------------------------------------------------------------------

//TODO:fetching and displaying guesses
if (isset($_SESSION['game_id'])) {
    $stmt = $db->prepare("
        SELECT c.*
        FROM guesses g JOIN characters c 
        ON g.character_id = c.id
        WHERE g.game_id = ?
        ORDER BY g.id ASC
    ");
    $stmt->execute([$_SESSION['game_id']]);
    $guesses = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
//todo----------------------------------------------------------------------------

//TODO prevent auto submitting when reloading
if (isset($_POST["submit"])) {
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
//TODO------------------------------------------------------------------
?><?php

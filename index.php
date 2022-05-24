<?php

use Doctrine\DBAL\DriverManager;

require_once 'vendor/autoload.php';

$connectionParams = [
    'dbname' => 'usarps',
    'user' => 'root',
    'password' => '',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
];

// doctrine dbal connection
try {
    $conn = DriverManager::getConnection($connectionParams);
} catch (\Doctrine\DBAL\Exception $e) {
    echo $e->getMessage();
}

// doctrine dbal query
$query = $conn->createQueryBuilder();
$query->select('*')
    ->from('player');
$players = $query->executeQuery()->fetchAllAssociative();

// insert a new game if form is submitted
if (isset($_POST['player1']) && isset($_POST['player2']) && isset($_POST['choice1']) && isset($_POST['choice2']) && isset($_POST['winner'])) {
    $player1 = $_POST['player1'];
    $player2 = $_POST['player2'];
    $choice1 = $_POST['choice1'];
    $choice2 = $_POST['choice2'];
    $winner = $_POST['winner'];

    $query = $conn->createQueryBuilder();
    $query->insert('game')
        ->values([
            'fk_player1' => '?',
            'fk_player2' => '?',
            'player1_choice' => '?',
            'player2_choice' => '?',
            'fk_winner' => '?',
        ])
        ->setParameter(0, $player1)
        ->setParameter(1, $player2)
        ->setParameter(2, $choice1)
        ->setParameter(3, $choice2)
        ->setParameter(4, $winner);
    $query->execute();
}

// delete a game if form is submitted
if (isset($_POST['delete'])) {
    $game = $_POST['delete'];

    $query = $conn->createQueryBuilder();
    $query->delete('game')
        ->where('pk_id = ?')
        ->setParameter(0, $game);
    $query->execute();
}


$query = $conn->createQueryBuilder();
$query->select('*')
    ->from('choice');
$choices = $query->executeQuery()->fetchAllAssociative();

$query = $conn->createQueryBuilder();
$query->select('*')
    ->from('game');
$games = $query->executeQuery();


// form to insert a new game with dropdown of players
echo '<form action="' . $_SERVER['PHP_SELF'] . '" method="post">';
echo '<select name="player1">';
foreach ($players as $player) {
    echo '<option value="' . $player['pk_id'] . '">' . $player['name'] . '</option>';
}
echo '</select>';
echo '<select name="player2">';
foreach ($players as $player) {
    echo '<option value="' . $player['pk_id'] . '">' . $player['name'] . '</option>';
}
echo '</select>';
echo '<select name="choice1">';
foreach ($choices as $choice) {
    echo '<option value="' . $choice['pk_id'] . '">' . $choice['name'] . '</option>';
}
echo '</select>';
echo '<select name="choice2">';
foreach ($choices as $choice) {
    echo '<option value="' . $choice['pk_id'] . '">' . $choice['name'] . '</option>';
}
echo '</select>';
// winner
echo '<select name="winner">';
foreach ($players as $player) {
    echo '<option value="' . $player['pk_id'] . '">' . $player['name'] . '</option>';
}
echo '</select>';
echo '<input type="submit" value="Submit">';
echo '</form>';


// loop through games
while ($game = $games->fetchAssociative()) {
    // create a table of all games

    $player1 = array_filter($players, function ($player) use ($game) {
        return $player['pk_id'] == $game['fk_player1'];
    });
    $player1 = array_values($player1)[0];

    $player2 = array_filter($players, function ($player) use ($game) {
        return $player['pk_id'] == $game['fk_player2'];
    });
    $player2 = array_values($player2)[0];

    $winner = array_filter($players, function ($player) use ($game) {
        return $player['pk_id'] == $game['fk_winner'];
    });
    $winner = array_values($winner)[0];

    $choice1 = array_filter($choices, function ($choice) use ($game) {
        return $choice['pk_id'] == $game['player1_choice'];
    });
    $choice1 = array_values($choice1)[0];

    $choice2 = array_filter($choices, function ($choice) use ($game) {
        return $choice['pk_id'] == $game['player2_choice'];
    });
    $choice2 = array_values($choice2)[0];

    echo '<table>';
    echo '<tr>';
    echo '<th>Game ID</th>';
    echo '<th>Player 1</th>';
    echo '<th>Player 2</th>';
    echo '<th>Choice 1</th>';
    echo '<th>Choice 2</th>';
    echo '<th>Winner</th>';
    echo '</tr>';
    echo '<tr>';
    echo '<td>' . $game['pk_id'] . '</td>';
    echo '<td>' . $player1['name'] . '</td>';
    echo '<td>' . $player2['name'] . '</td>';
    echo '<td>' . $choice1['name'] . '</td>';
    echo '<td>' . $choice2['name'] . '</td>';
    echo '<td>' . $winner['name'] . '</td>';
    // delete a game
    echo '<td><form action="index.php" method="post">';
    echo '<input type="hidden" name="delete" value="' . $game['pk_id'] . '">';
    echo '<input type="submit" value="delete">';
    echo '</form></td>';
    echo '</tr>';
    echo '</table>';
}






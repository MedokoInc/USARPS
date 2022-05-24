<?php
require_once "bootstrap.php";

use Medoko\Usarps101\RPSGame;

$dql = "SELECT g from RPSGame g";
$query = $entityManager->createQuery($dql);
$games = $query->getResult();

foreach ($games as $game) {
    echo $game->getPlayer1()->getName() . " vs " . $game->getPlayer2()->getName() . ": " . $game->getWinner()->getName() . " won!\n";
}
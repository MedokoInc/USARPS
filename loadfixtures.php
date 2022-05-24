<?php

namespace Medoko\Usarps101;

use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
require_once "bootstrap.php";


$loader = new Loader();
$loader->loadFromFile("src/fixtures/PlayerDataLoader.php");
$loader->loadFromFile("src/fixtures/ChoiceDataLoader.php");
$loader->loadFromFile("src/fixtures/RPSGameDataLoader.php");

$executor = new ORMExecutor($entityManager, new ORMPurger());
$executor->execute($loader->getFixtures());
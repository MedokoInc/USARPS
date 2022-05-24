<?php
// cli-config.php
namespace Medoko\Usarps101;
require_once "bootstrap.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
<?php
// cli-config.php
require_once "entitymanager.php";

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);
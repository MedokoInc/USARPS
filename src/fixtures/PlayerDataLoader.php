<?php

namespace Medoko\Usarps101;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;


class PlayerDataLoader extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $player1 = new Player();
        $player1->setName('Marc Braun');
        $player2 = new Player();
        $player2->setName('Crovin');
        $player3 = new Player();
        $player3->setName('Bernherd Mysker');
        $player4 = new Player();
        $player4->setName('Lizavascript Mokshield');

        $manager->persist($player1);
        $manager->persist($player2);
        $manager->persist($player3);
        $manager->persist($player4);

        $manager->flush();

        $this->addReference('marc', $player1);
        $this->addReference('crovin', $player2);
        $this->addReference('bernhard', $player3);
        $this->addReference('liza', $player4);
    }
}
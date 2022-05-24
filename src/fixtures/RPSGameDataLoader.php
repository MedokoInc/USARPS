<?php

namespace Medoko\Usarps101;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class RPSGameDataLoader extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $game1 = new RPSGame();
        $game1->setPlayer1(
            $this->getReference('marc')
        );
        $game1->setPlayer2(
            $this->getReference('liza')
        );
        $game1->setPlayer1Choice(
            $this->getReference('dynamite')
        );
        $game1->setPlayer2Choice(
            $this->getReference('cat')
        );

        $game2 = new RPSGame();
        $game2->setPlayer1(
            $this->getReference('liza')
        );
        $game2->setPlayer2(
            $this->getReference('bernhard')
        );
        $game2->setPlayer1Choice(
            $this->getReference('cloud')
        );
        $game2->setPlayer2Choice(
            $this->getReference('book')
        );

        $game3 = new RPSGame();
        $game3->setPlayer1(
            $this->getReference('crovin')
        );
        $game3->setPlayer2(
            $this->getReference('marc')
        );
        $game3->setPlayer1Choice(
            $this->getReference('nuke')
        );
        $game3->setPlayer2Choice(
            $this->getReference('sky')
        );

        $game4 = new RPSGame();
        $game4->setPlayer1(
            $this->getReference('bernhard')
        );
        $game4->setPlayer2(
            $this->getReference('crovin')
        );
        $game4->setPlayer1Choice(
            $this->getReference('blood')
        );
        $game4->setPlayer2Choice(
            $this->getReference('helicopter')
        );

        $game5 = new RPSGame();
        $game5->setPlayer1(
            $this->getReference('marc')
        );
        $game5->setPlayer2(
            $this->getReference('bernhard')
        );
        $game5->setPlayer1Choice(
            $this->getReference('butter')
        );
        $game5->setPlayer2Choice(
            $this->getReference('quicksand')
        );


        $manager->persist($game1);
        $manager->persist($game2);
        $manager->persist($game3);
        $manager->persist($game4);
        $manager->persist($game5);

        $manager->flush();
    }
}
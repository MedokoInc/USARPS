<?php

namespace Medoko\Usarps101;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ChoiceDataLoader extends AbstractFixture
{
    public function load(ObjectManager $manager)
    {
        $json = file_get_contents(__DIR__ . '/../../data/data.json');
        $data = json_decode($json, true);

        // iterate through data
        foreach ($data as $entry) {
            $choice = new Choice();
            $choice->setName($entry['title']);

            $manager->persist($choice);
            $this->addReference(strtolower($entry['title']), $choice);
        }

        foreach ($data as $entry) {
            $choice = $this->getReference(strtolower($entry['title']));
            foreach ($entry['beats'] as $beatEntry) {
                $choice->addBeat($this->getReference(strtolower($beatEntry['choice'])));
            }
        }

        $manager->flush();
    }
}
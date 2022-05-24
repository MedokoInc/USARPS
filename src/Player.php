<?php

namespace Medoko\Usarps101;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="player")
 */
class Player
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="RPSGame", mappedBy="player1")
     * @var RPSGame[] an array of RPSGame objects
     */
    private $playedGames1;

    /**
     * @ORM\OneToMany(targetEntity="RPSGame", mappedBy="player2")
     * @var RPSGame[] an array of RPSGame objects
     */
    private $playedGames2;

    // constructor
    public function __construct()
    {
        $this->playedGames1 = new \Doctrine\Common\Collections\ArrayCollection();
        $this->playedGames2 = new \Doctrine\Common\Collections\ArrayCollection();
    }

    // getters and setters for the properties
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getPlayedGames()
    {
        // merge the two collections
        return array_merge($this->playedGames1->toArray(), $this->playedGames2->toArray());
    }

    public function addPlayedGame(RPSGame $game)
    {
        if ($game->getPlayer1() === $this) {
            $this->playedGames1[] = $game;
        } else {
            $this->playedGames2[] = $game;
        }
    }

    public function __toString()
    {
        return $this->name;
    }
}
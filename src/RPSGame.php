<?php
namespace Medoko\Usarps101;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rps_game")
 */

class RPSGame
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    // player 1 entity
    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="playedGames1")
     * @ORM\JoinColumn(name="player1_id", referencedColumnName="id")
     */
    private $player1;

    // player 2 entity
    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="playedGames2")
     * @ORM\JoinColumn(name="player2_id", referencedColumnName="id")
     */
    private $player2;

    /**
     * @ORM\ManyToOne(targetEntity="Choice")
     * @ORM\JoinColumn(name="choice1_id", referencedColumnName="id")
     */
    private $player1Choice;

    /**
     * @ORM\ManyToOne(targetEntity="Choice")
     * @ORM\JoinColumn(name="choice2_id", referencedColumnName="id")
     */
    private $player2Choice;

    // winner
    /**
     * @ORM\ManyToOne(targetEntity="Player")
     * @ORM\JoinColumn(name="winner_id", referencedColumnName="id")
     */
    private $winner;

    // setters and getters
    public function getId()
    {
        return $this->id;
    }

    public function getPlayer1()
    {
        return $this->player1;
    }

    public function setPlayer1(Player $player1)
    {
        $this->player1 = $player1;
        // add this game to the player's played games
        $player1->addPlayedGame($this);
    }

    public function getPlayer2()
    {
        return $this->player2;
    }

    public function setPlayer2(Player $player2)
    {
        $this->player2 = $player2;
        // add the game to the player's played games
        $player2->addPlayedGame($this);
    }

    public function getPlayer1Choice()
    {
        return $this->player1Choice;
    }

    public function setPlayer1Choice(Choice $player1Choice)
    {
        $this->player1Choice = $player1Choice;
        // if player 2 has not yet chosen, set the game's winner to null
        if ($this->player2Choice === null) {
            $this->winner = null;
        }
        // else, set the game's winner to the player who won
        else {
            $this->declareWinner();
        }
    }

    public function getPlayer2Choice()
    {
        return $this->player2Choice;
    }

    public function setPlayer2Choice(Choice $player2Choice)
    {
        $this->player2Choice = $player2Choice;
        // if player 1 has not yet chosen, set the game's winner to null
        if ($this->player1Choice === null) {
            $this->winner = null;
        }
        // else, set the game's winner to the player who won
        else {
            $this->declareWinner();
        }
    }

    public function getWinner()
    {
        return $this->winner;
    }

    public function setWinner(Player $winner)
    {
        $this->winner = $winner;
    }

    public function declareWinner() {
        if ($this->player1Choice->getId() == $this->player2Choice->getId() || $this->player1Choice == null || $this->player2Choice == null) {
            $this->winner = null;
            return;
        }

        $beatsIds = array_map(function($choice) {
            return $choice->getId();
        }, $this->player1Choice->getBeats()->getValues());

        if(in_array($this->player2Choice->getId(), $beatsIds)) {
            $this->winner = $this->player1;
        } else {
            $this->winner = $this->player2;
        }
    }

    // toString
    public function __toString()
    {
        return $this->player1->getName() . " vs " . $this->player2->getName();
    }
}
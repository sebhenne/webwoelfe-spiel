<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PlayerCardRepository")
 */
class PlayerCard
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player")
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Card")
     * @ORM\JoinColumn(nullable=false)
     */
    private $card;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Match", inversedBy="playerCards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $round;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getCard(): ?Card
    {
        return $this->card;
    }

    public function setCard(?Card $card): self
    {
        $this->card = $card;

        return $this;
    }

    public function getRound(): ?Match
    {
        return $this->round;
    }

    public function setRound(?Match $round): self
    {
        $this->round = $round;

        return $this;
    }
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\MatchRepository")
 * @ORM\Table(name="`match`")
 */
class Match
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="matches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlayerCard", mappedBy="round", orphanRemoval=true)
     */
    private $playerCards;

    public function __construct()
    {
        $this->playerCards = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): self
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection|PlayerCard[]
     */
    public function getPlayerCards(): Collection
    {
        return $this->playerCards;
    }

    public function addPlayerCard(PlayerCard $playerCard): self
    {
        if (!$this->playerCards->contains($playerCard)) {
            $this->playerCards[] = $playerCard;
            $playerCard->setRound($this);
        }

        return $this;
    }

    public function removePlayerCard(PlayerCard $playerCard): self
    {
        if ($this->playerCards->contains($playerCard)) {
            $this->playerCards->removeElement($playerCard);
            // set the owning side to null (unless already changed)
            if ($playerCard->getRound() === $this) {
                $playerCard->setRound(null);
            }
        }

        return $this;
    }
}

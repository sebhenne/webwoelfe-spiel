<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     normalizationContext={"groups"={"board:read"}},
 *     denormalizationContext={"groups"={"board:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\BoardRepository")
 */
class Board
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"board:read","board:write","game:read","game:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"board:read","board:write","game:read","game:write"})
     */
    private $master;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Player", mappedBy="board", orphanRemoval=true)
     * @ApiSubresource()
     * @Groups({"board:read","board:write","game:read"})
     */
    private $players;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="boards")
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    public function __construct()
    {
        $this->players = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMaster(): ?bool
    {
        return $this->master;
    }

    public function setMaster(bool $master): self
    {
        $this->master = $master;

        return $this;
    }

    /**
     * @return Collection|Player[]
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    /*
     * @Groups({"board:write"})
     */
    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players[] = $player;
            $player->setBoard($this);
        }

        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->contains($player)) {
            $this->players->removeElement($player);
            // set the owning side to null (unless already changed)
            if ($player->getBoard() === $this) {
                $player->setBoard(null);
            }
        }

        return $this;
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
}

<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


/**
/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"},
 *     normalizationContext={"groups"={"game:read"}},
 *     denormalizationContext={"groups"={"game:write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"game:read"})
     * @ApiProperty(identifier=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"game:read","game:write"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=8)
     * @ApiProperty(identifier=true)
     * @Groups({"game:read"})
     */
    private $urlIdentifier;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Match", mappedBy="game", orphanRemoval=true)
     * @Groups({"game:read"})
     */
    private $matches;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Board", mappedBy="game", orphanRemoval=true, cascade={"persist"})
     * @ApiSubresource()
     * @Groups({"game:read"})
     */
    private $boards;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
        $this->urlIdentifier = substr(md5(time()), 0, 6);
        $this->boards = new ArrayCollection();

        $mainBoard = new Board();
        $mainBoard->setMaster(true);
        $mainBoard->setName($this->getName()."_master");
        $mainBoard->setGame($this);

        $this->boards->add($mainBoard);

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

    public function getUrlIdentifier(): ?string
    {
        return $this->urlIdentifier;
    }

    public function setUrlIdentifier(string $urlIdentifier): self
    {
        $this->urlIdentifier = $urlIdentifier;

        return $this;
    }

    /**
     * @return Collection|Match[]
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Match $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches[] = $match;
            $match->setGame($this);
        }

        return $this;
    }

    public function removeMatch(Match $match): self
    {
        if ($this->matches->contains($match)) {
            $this->matches->removeElement($match);
            // set the owning side to null (unless already changed)
            if ($match->getGame() === $this) {
                $match->setGame(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Board[]
     */
    public function getBoards(): Collection
    {
        return $this->boards;
    }

    public function addBoard(Board $board): self
    {
        if (!$this->boards->contains($board)) {
            $this->boards[] = $board;
            $board->setGame($this);
        }

        return $this;
    }

    public function removeBoard(Board $board): self
    {
        if ($this->boards->contains($board)) {
            $this->boards->removeElement($board);
            // set the owning side to null (unless already changed)
            if ($board->getGame() === $this) {
                $board->setGame(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\TerrainRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TerrainRepository::class)]
class Terrain
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    #[ORM\Column]
    private ?float $latitude = null;

    #[ORM\Column]
    private ?float $longitude = null;

    #[ORM\Column]
    private ?int $capacitePersonnes = null;

    #[ORM\Column]
    private ?bool $aDouche = null;

    #[ORM\Column]
    private ?bool $aElectricite = null;

    #[ORM\Column]
    private ?bool $aToilettes = null;

    #[ORM\Column]
    private ?bool $aWifi = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $prixNuit = null;

    #[ORM\Column]
    private ?bool $estDisponible = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'terrains')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, Avis>
     */
    #[ORM\OneToMany(targetEntity: Avis::class, mappedBy: 'terrain')]
    private Collection $avis;

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): static
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): static
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCapacitePersonnes(): ?int
    {
        return $this->capacitePersonnes;
    }

    public function setCapacitePersonnes(int $capacitePersonnes): static
    {
        $this->capacitePersonnes = $capacitePersonnes;

        return $this;
    }

    public function isADouche(): ?bool
    {
        return $this->aDouche;
    }

    public function setADouche(bool $aDouche): static
    {
        $this->aDouche = $aDouche;

        return $this;
    }

    public function isAElectricite(): ?bool
    {
        return $this->aElectricite;
    }

    public function setAElectricite(bool $aElectricite): static
    {
        $this->aElectricite = $aElectricite;

        return $this;
    }

    public function isAToilettes(): ?bool
    {
        return $this->aToilettes;
    }

    public function setAToilettes(bool $aToilettes): static
    {
        $this->aToilettes = $aToilettes;

        return $this;
    }

    public function isAWifi(): ?bool
    {
        return $this->aWifi;
    }

    public function setAWifi(bool $aWifi): static
    {
        $this->aWifi = $aWifi;

        return $this;
    }

    public function getPrixNuit(): ?string
    {
        return $this->prixNuit;
    }

    public function setPrixNuit(string $prixNuit): static
    {
        $this->prixNuit = $prixNuit;

        return $this;
    }

    public function isEstDisponible(): ?bool
    {
        return $this->estDisponible;
    }

    public function setEstDisponible(bool $estDisponible): static
    {
        $this->estDisponible = $estDisponible;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setTerrain($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getTerrain() === $this) {
                $avi->setTerrain(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\DisponibiliteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: DisponibiliteRepository::class)]
class Disponibilite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    

    #[ORM\ManyToOne(inversedBy: 'disponibilities')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vehicule $vehicule = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateDebut = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateFin = null;

    #[ORM\Column]
    #[Assert\Regex(
        '/^\d*\.?\d+$/',
        message: 'Le prix par jour ne peut qu\'être positive.'
    )]
    private ?float $prixParJour = null;

    #[ORM\Column]
    private bool $isDisponible = true;

    #[ORM\Column(length: 255)]
    #[Assert\Length(min: 3)]
    #[Assert\Regex(
        '/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
        message: 'Le slug ne peut contenir que des lettres minuscules, des chiffres et des tirets.'
    )]
    private ?string $slug = null;

    /**
     * @var Collection<int, Vehicule>
     */
    // #[ORM\OneToMany(targetEntity: Vehicule::class, mappedBy: 'disponibilite', cascade: 'remove')]
    #[ORM\OneToMany(targetEntity: Vehicule::class, mappedBy: 'disponibilite')]
    private Collection $vehicules;

    public function __construct()
    {
        $this->vehicules = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicule(): ?Vehicule
    {
        return $this->vehicule;
    }

    public function setVehicule(?Vehicule $vehicule): static
    {
        $this->vehicule = $vehicule;

        return $this;
    }



    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): static
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): static
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getPrixParJour(): ?float
    {
        return $this->prixParJour;
    }

    public function setPrixParJour(float $prixParJour): static
    {
        $this->prixParJour = $prixParJour;

        return $this;
    }

    public function isDisponible(): bool
    {
        return $this->isDisponible;
    }

    public function setDisponible(bool $isDisponible): self
    {
        $this->isDisponible = $isDisponible;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Vehicule>
     */
    public function getVehicules(): Collection
    {
        return $this->vehicules;
    }

    public function addVehicule(Vehicule $vehicule): static
    {
        if (!$this->vehicules->contains($vehicule)) {
            $this->vehicules->add($vehicule);
            $vehicule->setDisponibilite($this);
        }

        return $this;
    }

    public function removeVehicule(Vehicule $vehicule): static
    {
        if ($this->vehicules->removeElement($vehicule)) {
            // set the owning side to null (unless already changed)
            if ($vehicule->getDisponibilite() === $this) {
                $vehicule->setDisponibilite(null);
            }
        }

        return $this;
    }
    
}

<?php

namespace App\Entity;

use App\Repository\UERepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UERepository::class)]
class UE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 3,
        max: 10,
        minMessage: 'Le code doit faire au moins {{ 3 }} caractères',
        maxMessage: 'Le code ne peut pas dépasser {{ 10 }} caractères',
    )]
    #[Assert\NotBlank(message: 'Le code est obligatoire')]
    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[Assert\Type(type: 'integer', message: 'Le nombre de crédits doit être un entier')]
    #[Assert\Positive(message: 'Le nombre de crédits doit être un entier positif')]
    #[Assert\NotBlank(message: 'Le nombre de crédits est obligatoire')]
    #[ORM\Column]
    private ?int $nbreCredits = null;

    #[Assert\Type(type: 'integer', message: 'Le semestre doit être un entier')]
    #[Assert\Positive(message: 'Le semestre doit être un entier positif')]
    #[Assert\NotBlank(message: 'Le semestre est obligatoire')]
    #[ORM\Column]
    private ?int $semestre = null;

    #[Assert\Type(type: 'integer', message: 'L\'année doit être un entier')]
    #[Assert\Positive(message: 'L\'année doit être un entier positif')]
    #[Assert\NotBlank(message: 'L\'année est obligatoire')]
    #[ORM\Column]
    private ?int $annee = null;

    /**
     * @var Collection<int, Chapitre>
     */
    #[ORM\OneToMany(targetEntity: Chapitre::class, mappedBy: 'ue', orphanRemoval: true)]
    private Collection $chapitres;

    #[Assert\NotBlank(message: 'L\'intitulé est obligatoire')]
    #[Assert\Length(
        min: 3,
        max: 255,
        minMessage: 'L\'intitulé doit faire au moins {{ 3 }} caractères',
        maxMessage: 'L\'intitulé ne peut pas dépasser {{ 255 }} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $intitule = null;

    public function __construct()
    {
        $this->chapitres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getNbreCredits(): ?int
    {
        return $this->nbreCredits;
    }

    public function setNbreCredits(int $nbreCredits): static
    {
        $this->nbreCredits = $nbreCredits;

        return $this;
    }

    public function getSemestre(): ?int
    {
        return $this->semestre;
    }

    public function setSemestre(int $semestre): static
    {
        $this->semestre = $semestre;

        return $this;
    }

    public function getAnnee(): ?int
    {
        return $this->annee;
    }

    public function setAnnee(int $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * @return Collection<int, Chapitre>
     */
    public function getChapitres(): Collection
    {
        return $this->chapitres;
    }

    public function addChapitre(Chapitre $chapitre): static
    {
        if (!$this->chapitres->contains($chapitre)) {
            $this->chapitres->add($chapitre);
            $chapitre->setUe($this);
        }

        return $this;
    }

    public function removeChapitre(Chapitre $chapitre): static
    {
        if ($this->chapitres->removeElement($chapitre)) {
            // set the owning side to null (unless already changed)
            if ($chapitre->getUe() === $this) {
                $chapitre->setUe(null);
            }
        }

        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): static
    {
        $this->intitule = $intitule;

        return $this;
    }
}

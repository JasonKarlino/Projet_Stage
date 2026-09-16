<?php

namespace App\Entity;

use App\Repository\SujetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SujetRepository::class)]
class Sujet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\Positive(message: 'La durée doit être un nombre positif.')]
    #[Assert\Type(type: 'integer', message: 'La durée doit être un nombre entier.')]
    #[Assert\NotBlank(message: 'La durée ne peut pas être vide.')]
    #[ORM\Column]
    private ?int $duree = null;

    #[ORM\ManyToOne(inversedBy: 'sujets')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Enseignant $enseignant = null;

    /**
     * @var Collection<int, Question>
     */
    #[ORM\ManyToMany(targetEntity: Question::class, inversedBy: 'sujets')]
    private Collection $questions;

    #[Assert\Positive(message: 'Le nombre de questions doit être un nombre positif.')]
    #[Assert\Type(type: 'integer', message: 'Le nombre de questions doit être un nombre entier.')]
    #[Assert\Length(
        min: 1,
        max: 50,
        minMessage: 'Le nombre de questions doit être au moins {{ 1 }}.',
        maxMessage: 'Le nombre de questions ne peut pas dépasser {{ 50 }}.'
    )]
    #[Assert\NotBlank(message: 'Le nombre de questions ne peut pas être vide.')]
    #[ORM\Column]
    private ?int $nbreQuestion = null;

    #[Assert\NotBlank(message: 'Le titre ne peut pas être vide.')]
    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[Assert\NotBlank(message: 'La date de création ne peut pas être vide.')]
    #[Assert\Type("\DateTimeImmutable", message: 'La date de création doit être une date valide.')]
    #[ORM\Column]
    private ?\DateTimeImmutable $dateCreation = null;

    #[ORM\ManyToOne(inversedBy: 'sujets')]
    private ?UE $ue = null;

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): static
    {
        $this->duree = $duree;

        return $this;
    }

    public function getEnseignant(): ?Enseignant
    {
        return $this->enseignant;
    }

    public function setEnseignant(?Enseignant $enseignant): static
    {
        $this->enseignant = $enseignant;

        return $this;
    }

    /**
     * @return Collection<int, Question>
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): static
    {
        if (!$this->questions->contains($question)) {
            $this->questions->add($question);
        }

        return $this;
    }

    public function removeQuestion(Question $question): static
    {
        $this->questions->removeElement($question);

        return $this;
    }

    public function getNbreQuestion(): ?int
    {
        return $this->nbreQuestion;
    }

    public function setNbreQuestion(int $nbreQuestion): static
    {
        $this->nbreQuestion = $nbreQuestion;

        return $this;
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

    public function getDateCreation(): ?\DateTimeImmutable
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeImmutable $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getUe(): ?UE
    {
        return $this->ue;
    }

    public function setUe(?UE $ue): static
    {
        $this->ue = $ue;

        return $this;
    }
}

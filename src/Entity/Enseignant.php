<?php

namespace App\Entity;

use App\Repository\EnseignantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use App\Enum\Grade;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: EnseignantRepository::class)]
class Enseignant implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\Length(
        min: 10,
        max: 50,
        minMessage: 'Le nom doit faire au moins {{ limit }} caractères',
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères',
    )]
    #[Assert\NotBlank(message: 'Le nom et les prénoms sont obligatoires')]
    #[ORM\Column(length: 255)]
    private ?string $nomPrenom = null;

    #[Assert\Type(type: 'integer', message: 'Le matricule doit être un nombre entier')]
    #[Assert\NotBlank(message: 'Le matricule est obligatoire')]
    #[ORM\Column]
    private ?int $matricule = null;

    #[Assert\NotBlank(message: 'Le grade est obligatoire')]
    #[ORM\Column(length: 255)]
    private ?Grade $grade = null;

    #[Assert\Email(message: 'L\'adresse email "{{ value }}" n\'est pas valide.')]
    #[Assert\NotBlank(message: 'L\'adresse email est obligatoire')]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[Assert\Type(type: 'integer', message: 'Le contact doit être un nombre entier')]
    #[Assert\Length(
        min: 8,
        max: 8,
        minMessage: 'Le contact doit faire au moins {{ limit }} chiffres',
        maxMessage: 'Le contact ne peut pas dépasser {{ limit }} chiffres',
    )]
    #[Assert\NotBlank(message: 'Le contact est obligatoire')]
    #[Assert\Positive(message: 'Le contact doit être un nombre positif')]
    #[ORM\Column(length: 255)]
    private ?int $contact = null;

    /**
     * @var Collection<int, Sujet>
     */
    #[ORM\OneToMany(targetEntity: Sujet::class, mappedBy: 'enseignant')]
    private Collection $sujets;

    /**
     * @var Collection<int, UE>
     */
    #[ORM\OneToMany(targetEntity: UE::class, mappedBy: 'enseignant', orphanRemoval: true)]
    private Collection $uEs;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    public function __construct()
    {
        $this->sujets = new ArrayCollection();
        $this->uEs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nom): static
    {
        $this->nomPrenom = $nom;

        return $this;
    }

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): static
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getGrade(): ?Grade
    {
        return $this->grade;
    }

    public function setGrade(Grade $grade): static
    {
        $this->grade = $grade;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }

    public function getContact(): ?int
    {
        return $this->contact;
    }

    public function setContact(int $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, Sujet>
     */
    public function getSujets(): Collection
    {
        return $this->sujets;
    }

    public function addSujet(Sujet $sujet): static
    {
        if (!$this->sujets->contains($sujet)) {
            $this->sujets->add($sujet);
            $sujet->setEnseignant($this);
        }

        return $this;
    }

    public function removeSujet(Sujet $sujet): static
    {
        if ($this->sujets->removeElement($sujet)) {
            // set the owning side to null (unless already changed)
            if ($sujet->getEnseignant() === $this) {
                $sujet->setEnseignant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UE>
     */
    public function getUEs(): Collection
    {
        return $this->uEs;
    }

    public function addUE(UE $uE): static
    {
        if (!$this->uEs->contains($uE)) {
            $this->uEs->add($uE);
            $uE->setEnseignant($this);
        }

        return $this;
    }

    public function removeUE(UE $uE): static
    {
        if ($this->uEs->removeElement($uE)) {
            // set the owning side to null (unless already changed)
            if ($uE->getEnseignant() === $this) {
                $uE->setEnseignant(null);
            }
        }

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): static
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_ENSEIGNANT';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUserIdentifier(): string {
         return $this->mail; 
    }

    public function getUsername(): string {
         return $this->getUserIdentifier(); 
    }

    public function getSalt(): ?string { 
        return null; 
    } 

    public function eraseCredentials() : void{
         
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

   
    private ?string $plainPassword = null;

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

}

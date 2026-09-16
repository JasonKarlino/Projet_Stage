<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: AdministrateurRepository::class)]
class Administrateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'L\'adresse email est obligatoire')]
    #[Assert\Email(message: 'L\'adresse email "{{ value }}" n\'est pas valide.')]
    #[Assert\Length(
        min: 10,
        max: 50,
        minMessage: 'L\'adresse email doit faire au moins {{ limit }} caractères',
        maxMessage: 'L\'adresse email ne peut pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[Assert\NotBlank(message: 'Le mot de passe est obligatoire')]
    #[Assert\Length(
        min: 8,
        max: 255,
        minMessage: 'Le mot de passe doit faire au moins {{ limit }} caractères',
        maxMessage: 'Le mot de passe ne peut pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[Assert\NotBlank(message: 'Le nom et prénom sont obligatoires')]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: 'Le nom et prénom doivent faire au moins {{ limit }} caractères',
        maxMessage: 'Le nom et prénom ne peuvent pas dépasser {{ limit }} caractères',
    )]
    #[ORM\Column(length: 255)]
    private ?string $nomPrenom = null;

    public function getId(): ?int
    {
        return $this->id;
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
        $roles[] = 'ROLE_ADMIN';
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
    } // bcrypt/argon2i doesn't need salt

    public function eraseCredentials() : void{
         /* nothing to do */ 
    }

    public function getPassword(): ?string
    {
        return $this->motDePasse;
    }

    public function getNomPrenom(): ?string
    {
        return $this->nomPrenom;
    }

    public function setNomPrenom(string $nomPrenom): static
    {
        $this->nomPrenom = $nomPrenom;

        return $this;
    }

}

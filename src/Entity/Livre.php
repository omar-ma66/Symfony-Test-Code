<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\LivreRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups ;
use ApiPlatform\Metadata\ApiResource ;



#[ORM\Entity(repositoryClass: LivreRepository::class)]
#[ApiResource(
    normalizationContext:['groups' => ['livre:read']],
    denormalizationContext:['groups'=>['livre:write']]
)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["livre:read"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min:3,
        max:30,
        minMessage:'le titre doit faire au moin {{ limit }} carracteres.',
        maxMessage:'le titre ne doit pas depasser {{ limit }} carracteres.'
    )]

    #[Groups(['livre:read','livre:write'])]
    private ?string $titre = null;

    #[ORM\Column]
    #[Assert\Type(\DateTimeInterface::class)]
    #[Assert\NotBlank(message:'le titre ne peut être vide')]
    #[Groups(['livre:read','livre:write'])]
    private ?\DateTimeImmutable $date = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    #[Assert\Positive()]
    #[Groups(['livre:read','livre:write'])]
    private ?string $prix = null;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['livre:read','livre:write'])]
    private ?Auteur $auteur = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livre:read','livre:write'])]
    private ?string $categorie = "Roman";

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

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): static
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function __toString()
    {
        return $this->titre;
    }
}

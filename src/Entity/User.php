<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Entity\Trait\TimestampableTrait;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource(
    operations: [
        new Get(
            normalizationContext: ['groups' => ['user:read']],
            security: "is_granted('USER_READ', object)"
        ),
        new GetCollection(
            normalizationContext: ['groups' => ['user:read']]
        ),
        new Post(
            normalizationContext: ['groups' => ['user:read']],
            denormalizationContext: ['groups' => ['user:write']],
            output: User::class,
            processor: 'App\Processor\UserPasswordProcessor'
        ),
        new Patch(
            normalizationContext: ['groups' => ['user:read']],
            denormalizationContext: ['groups' => ['user:write']],
            security: "is_granted('USER_UPDATE', object)",
            output: User::class,
            processor: 'App\Processor\UserPasswordProcessor'
        ),
        new Delete(
            security: "is_granted('USER_DELETE', object)"
        ),
    ]
)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private int $id;

    #[ORM\Column(length: 180)]
    #[Groups(['user:read', 'user:write'])]
    #[Assert\NotBlank(message: 'L\'adresse email est obligatoire.')]
    #[Assert\Email(message: 'L\'adresse email doit être valide.')]
    private string $email;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['user:write'])]
    #[Assert\NotBlank(message: 'Le mot de passe est obligatoire.')]
    #[Assert\Length(
        min: 8,
        minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.',
    )]
    private string $password;

    #[ORM\Column(length: 55)]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire.')]
    private string $firstName;

    #[ORM\Column(length: 55)]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'Le nom est obligatoire.')]
    private string $lastName;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:write', 'user:read'])]
    private ?string $providerName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:write', 'user:read'])]
    private ?int $googleId = null;

    #[ORM\Column(length: 55, nullable: true)]
    #[Groups(['user:write', 'user:read'])]
    private ?string $appleId = null;

    #[ORM\Column(length: 55)]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'Le numéro de téléphone est obligatoire.')]
    private string $phone;

    #[ORM\Column(length: 255)]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'Le pays est obligatoire.')]
    private string $country;

    #[ORM\Column(length: 55)]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'La ville est obligatoire.')]
    private string $city;

    #[ORM\Column(length: 255)]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'La rue est obligatoire.')]
    private string $street;

    #[ORM\Column(length: 55)]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'Le code postal est obligatoire.')]
    private string $postalCode;

    #[ORM\Column]
    #[Groups(['user:write', 'user:read'])]
    #[Assert\NotBlank(message: 'Le champ SSO est obligatoire.')]
    private bool $isSso = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getProviderName(): ?string
    {
        return $this->providerName;
    }

    public function setProviderName(?string $providerName): static
    {
        $this->providerName = $providerName;

        return $this;
    }

    public function getGoogleId(): ?int
    {
        return $this->googleId;
    }

    public function setGoogleId(?int $googleId): static
    {
        $this->googleId = $googleId;

        return $this;
    }

    public function getAppleId(): ?string
    {
        return $this->appleId;
    }

    public function setAppleId(?string $appleId): static
    {
        $this->appleId = $appleId;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getIsSso(): bool
    {
        return $this->isSso;
    }

    public function setIsSso(bool $isSso): static
    {
        $this->isSso = $isSso;

        return $this;
    }

    #[Groups(['user:read'])]
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[Groups(['user:read'])]
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
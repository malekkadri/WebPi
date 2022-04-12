<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Validator as fullnameAssert;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints as CaptchaAssert;
use App\Controller\EntityManagerInterface;
/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @UniqueEntity(fields={"Username"}, message="There is already an account with this Username")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups("user")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Email(
     * message = "{{ value }} is not a valid email.")
     * @Groups("user")
     */
    private $email;

    /**
     * @ORM\Column(type="array")
     * @Groups("user")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups("user")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("user")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     *  @Assert\Length(
     *      min = 4,
     *      max = 12,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     *      maxMessage = "Your first name cannot be longer than {{ limit }} characters"
     * )
     * @Groups("user")
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(
     *     pattern     = "/^[a-zA-Z]+ [a-zA-Z]+/",
     * )
     * @Groups("user")
     */
    private $fullname;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank
     * @Groups("user")
     */
    private $naissance;

    /**
     * @ORM\Column(type="boolean")
     * @Groups("user")
     */
    private $IsBanned=false;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * Groups("user")
     */
    private $Photo;


    //protected $captchaCode;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->Username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }
    /*public function getCaptchaCode()
    {
        return $this->captchaCode;
    }*/

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getNaissance(): ?\DateTimeInterface
    {
        return $this->naissance;
    }

    public function setNaissance(\DateTimeInterface $naissance): self
    {
        $this->naissance = $naissance;

        return $this;
    }

    public function isBanned(): ?bool
    {
        return $this->IsBanned;
    }

    public function setIsBanned(bool $IsBanned): self
    {
        $this->IsBanned = $IsBanned;

        return $this;
    }
    /*public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }*/
    public function __toString()
    {
       return $this->getUsername();
    }


    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(?string $Photo): self
    {
        $this->Photo = $Photo;

        return $this;
    }

}

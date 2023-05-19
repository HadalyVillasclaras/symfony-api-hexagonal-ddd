<?php

namespace App\mydashboard\Users\Domain;

use App\mydashboard\Shared\Domain\ValueObject\Email;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class Employee implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * id
     *
     * @var string
     */
    private $id;

    /**
     * name
     *
     * @var string
     */
    private $name;

    /**
     * username
     *
     * @var string
     */
    private $username;

    /**
     * email
     *
     * @var string
     */
    private $email;

    /**
     * roles
     *
     * @var array
     */
    private $roles = [];

    /**
     * password
     *
     * @var string
     */
    private $password = '';

    public function __construct($email, $password)
    {
        $this->email = (new Email($email))->value();
        $this->setPassword($password);
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return (string) $this->email;
    }

    public function getName(): string
    {
        return (string) $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';
       

        return array_values(array_unique($roles));
    }

    public function setRoles(array $roles): self
    {
        $this->roles = array_values(array_unique($roles));

        return $this;
    }

    public function addRoles(array $roles): self
    {
        $newRoles = array_merge($this->getRoles(), $roles);
        $this->setRoles($newRoles);
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
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

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}

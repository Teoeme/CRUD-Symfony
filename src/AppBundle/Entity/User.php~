<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"user"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user"})
     * 
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json_array")
     * @Groups({"user"})
     * 
     */
    private $roles;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user"})
     * 
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"user"})
     * 
     */
    private $isActive;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"user"})
     * 
     */
    private $image;

    public function __construct()
    {
        $this->isActive = true; // Default new users as active
        $this->roles = ['ROLE_USER']; // Default role
    }

    // UserInterface methods
    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getRoles()
    {
        return $this->roles;
    }

    public function eraseCredentials()
    {
    }

    public function getSalt()
    {
        // bcrypt and Argon2i do not require a separate salt.
        return null;
    }

    // Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setImage($image)
    {
        $this->image = $image;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;
    }
}

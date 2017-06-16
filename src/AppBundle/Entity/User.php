<?php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints as DoctrineAssert;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * User
 *
 * @ORM\Table(name="structure_user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @DoctrineAssert\UniqueEntity(fields = {"email"}, message="Correo Electrónico ya Registrado.")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=100)
     * @Assert\NotBlank(message="Este campo no puede permanecer en blanco.")
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=100)
     * @Assert\NotBlank(message="Este campo no puede permanecer en blanco.")
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=200)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=11, nullable=true)
     * @Assert\Length(
     *      min="11",
     *      max="11",
     *      minMessage="Debe tener por lo menos {{ limit }} caracteres",
     *      maxMessage="Debe tener como máximo {{ limit }} caracteres"
     * )
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
     */
    private $avatar;

    /**
     * @Vich\UploadableField(mapping="user_image", fileNameProperty="avatar")
     * 
     * @var File
     */
    private $avatarFile;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updated;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var \DateTime
     */
    protected $memberSince;

    /**
     * @var bool
     * @ORM\Column(name="is_online", type="boolean")
     */
    protected $isOnline = false;

    public function __toString()
    {
        return $this->getName();
    }

    // ////////////////////////////// Métodos Própios //////////////////////////////

    public function getNameFull()
    {
        return $this->getName();
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return '';
    }

    /**
     * @return \DateTime
     */
    public function getMemberSince()
    {
        return $this->getCreated();
    }

    /**
     * @return bool
     */
    public function isOnline()
    {
        return $this->getIsOnline();
    }

    public function getIdentifier() {
        return str_replace(' ', '-', $this->getUsername());
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $avatar
     *
     * @return Avatar
     */
    public function setAvatarFile(File $avatar = null)
    {
        $this->avatarFile = $avatar;
        if ($avatar) {
            $this->updated = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getAvatarFile()
    {
        return $this->avatarFile;
    }
    
    /**
     * @ORM\PrePersist()
     */
    public function createUsername()
    {
        $un = explode('@', $this->getEmail());
        $this->setUsername($un[0].'_'.rand());
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function createName()
    {
        $fn = explode(" ", $this->getFirstName());
        $ln = explode(" ", $this->getLastName());
        $this->setName($fn[0].' '.$ln[0]);
    }
    
    // //////////////////////////// END Métodos Própios ////////////////////////////

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = mb_strtoupper($firstName, 'utf-8');

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = mb_strtoupper($lastName, 'utf-8');

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return User
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return User
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return User
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set isOnline
     *
     * @param boolean $isOnline
     *
     * @return User
     */
    public function setIsOnline($isOnline)
    {
        $this->isOnline = $isOnline;

        return $this;
    }

    /**
     * Get isOnline
     *
     * @return boolean
     */
    public function getIsOnline()
    {
        return $this->isOnline;
    }

    /**
     * Set avatar
     *
     * @param string $avatar
     *
     * @return User
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}

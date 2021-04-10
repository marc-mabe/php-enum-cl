<?php declare(strict_types=1);

namespace Example;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="User")
 */
class UserEntity
{
    /**
     * @ORM\Column(name="rowid", type="integer", nullable=false, options={"unsigned"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private ?string $id = null;

    /**
     * @ORM\Column(name="name", type="string", length=85, nullable=false)
     */
    private string $name;
    
    /**
     * @ORM\Column(name="status", type="UserStatus", nullable=false)
     */
    private UserStatus $status;

    public function __construct(string $name)
    {
        $this->name   = $name;
        $this->status = UserStatus::ACTIVE();
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getName(): string
    {
        return $this->name;
    }
    
    public function setName(string $name)
    {
        $this->name = $name;
    }
    
    public function getStatus(): UserStatus
    {
        return $this->status;
    }
    
    public function setStatus(UserStatus $status)
    {
        $this->status = $status;
    }
}
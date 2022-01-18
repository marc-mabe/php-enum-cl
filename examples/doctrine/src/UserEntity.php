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
     * @ORM\Column(name="rowid", type="string", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @var null|string
     */
    private $id = null;

    /**
     * @ORM\Column(name="name", type="string", length=85, nullable=false)
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(name="status", type="UserStatus", nullable=false)
     * @var UserStatus
     */
    private $status;

    public function __construct(string $name)
    {
        $this->name   = $name;
        $this->status = UserStatus::ACTIVE();
    }

    public function getId(): ?string
    {
        return $this->id === null ? null : (string)$this->id;
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

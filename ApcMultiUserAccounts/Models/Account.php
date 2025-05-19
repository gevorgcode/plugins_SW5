<?php

namespace ApcMultiUserAccounts\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="multiuser_accounts", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_master_user", columns={"master_user_id"})
 * })
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="master_user_id", type="integer", unique=true)
     */
    private $masterUserId;

    /**
     * @ORM\Column(name="company_name", type="string", length=255)
     */
    private $companyName;

    /**
     * @ORM\Column(type="boolean", options={"default": true})
     */
    private $active = true;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->active = true;
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->updatedAt = new \DateTime();
    }

    // Getters and setters
    public function getId(): int { return $this->id; }

    public function getMasterUserId(): int { return $this->masterUserId; }
    public function setMasterUserId(int $masterUserId): void { $this->masterUserId = $masterUserId; }

    public function getCompanyName(): string { return $this->companyName; }
    public function setCompanyName(string $companyName): void { $this->companyName = $companyName; }

    public function isActive(): bool { return $this->active; }
    public function setActive(bool $active): void { $this->active = $active; }

    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function setCreatedAt(\DateTime $createdAt): void { $this->createdAt = $createdAt; }

    public function getUpdatedAt(): \DateTime { return $this->updatedAt; }
    public function setUpdatedAt(\DateTime $updatedAt): void { $this->updatedAt = $updatedAt; }

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'masterUserId' => $this->getMasterUserId(),
            'companyName' => $this->getCompanyName(),
            'active' => $this->isActive(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }

}
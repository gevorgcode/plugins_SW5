<?php

namespace ApcMultiUserAccounts\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="multiuser_users", uniqueConstraints={
 *     @ORM\UniqueConstraint(name="unique_user_id", columns={"user_id"})
 * })
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="account_id", type="integer")
     */
    private $accountId;

    /**
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(name="role_id", type="integer")
     */
    private $roleId;

    /**
     * @ORM\Column(name="status_id", type="integer")
     */
    private $statusId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

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
    }

    // Getters and setters
    public function getId(): int { return $this->id; }

    public function getAccountId(): int { return $this->accountId; }
    public function setAccountId(int $accountId): void { $this->accountId = $accountId; }

    public function getUserId(): ?int { return $this->userId; }
    public function setUserId(int $userId): void { $this->userId = $userId; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getRoleId(): int { return $this->roleId; }
    public function setRoleId(int $roleId): void { $this->roleId = $roleId; }

    public function getStatusId(): int { return $this->statusId; }
    public function setStatusId(int $statusId): void { $this->statusId = $statusId; }

    public function getToken(): ? string { return $this->token; }
    public function setToken(?string $token): void { $this->token = $token; }

    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function setCreatedAt(\DateTime $createdAt): void { $this->createdAt = $createdAt; }

    public function getUpdatedAt(): \DateTime { return $this->updatedAt; }
    public function setUpdatedAt(\DateTime $updatedAt): void { $this->updatedAt = $updatedAt; }    

    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'accountId' => $this->getAccountId(),
            'userId' => $this->getUserId(),
            'email' => $this->getEmail(),
            'roleId' => $this->getRoleId(),
            'statusId' => $this->getStatusId(),
            'token' => $this->getToken(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }
    public static function manyToArray(array $users): array
    {
        $result = [];
        foreach ($users as $user) {
            $result[] = $user->toArray();
        }
        return $result;
    }

}
<?php

namespace ApcMultiUserAccounts\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="multiuser_role_history")
 */
class RoleHistory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", name="multiuser_id")
     */
    private $multiuserId;

    /**
     * @ORM\Column(type="datetime", name="changed_at")
     */
    private $changedAt;

    /**
     * @ORM\Column(type="integer", name="previous_role_id", nullable=true)
     */
    private $previousRoleId;

    /**
     * @ORM\Column(type="integer", name="current_role_id")
     */
    private $currentRoleId;

    // Getters and setters
    public function getId() { return $this->id; }

    public function getMultiuserId() { return $this->multiuserId; }
    public function setMultiuserId($multiuserId) { $this->multiuserId = $multiuserId; }

    public function getChangedAt() { return $this->changedAt; }
    public function setChangedAt(\DateTime $changedAt) { $this->changedAt = $changedAt; }

    public function getPreviousRoleId() { return $this->previousRoleId; }
    public function setPreviousRoleId($previousRoleId) { $this->previousRoleId = $previousRoleId; }

    public function getCurrentRoleId() { return $this->currentRoleId; }
    public function setCurrentRoleId($currentRoleId) { $this->currentRoleId = $currentRoleId; }
}
<?php

namespace ApcMultiUserAccounts\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="multiuser_status_history")
 */
class StatusHistory
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
     * @ORM\Column(type="integer", name="previous_status_id", nullable=true)
     */
    private $previousStatusId;

    /**
     * @ORM\Column(type="integer", name="current_status_id")
     */
    private $currentStatusId;

    // Getters and setters
    public function getId() { return $this->id; }

    public function getMultiuserId() { return $this->multiuserId; }
    public function setMultiuserId($multiuserId) { $this->multiuserId = $multiuserId; }

    public function getChangedAt() { return $this->changedAt; }
    public function setChangedAt(\DateTime $changedAt) { $this->changedAt = $changedAt; }

    public function getPreviousStatusId() { return $this->previousStatusId; }
    public function setPreviousStatusId($previousStatusId) { $this->previousStatusId = $previousStatusId; }

    public function getCurrentStatusId() { return $this->currentStatusId; }
    public function setCurrentStatusId($currentStatusId) { $this->currentStatusId = $currentStatusId; }
}
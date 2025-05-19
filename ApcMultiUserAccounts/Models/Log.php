<?php

namespace ApcMultiUserAccounts\Models;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="multiuser_logs")
 */
class Log
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
     * @ORM\Column(type="string")
     */
    private $action;

    /**
     * @ORM\Column(type="datetime")
     */
    private $timestamp;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    public function __construct()
    {
        $this->timestamp = new \DateTime();
    }

    // Getters and setters
    public function getId() { return $this->id; }
    public function getMultiuserId() { return $this->multiuserId; }
    public function setMultiuserId($multiuserId) { $this->multiuserId = $multiuserId; }
    public function getAction() { return $this->action; }
    public function setAction($action) { $this->action = $action; }
    public function getTimestamp() { return $this->timestamp; }
    public function getDetails() { return $this->details; }
    public function setDetails($details) { $this->details = $details; }
}

<?php

namespace ApcMultiUserAccounts\Services;

use Doctrine\ORM\EntityManagerInterface;
use ApcMultiUserAccounts\Models\User;
use ApcMultiUserAccounts\Models\StatusHistory;
use ApcMultiUserAccounts\Models\RoleHistory;
use ApcMultiUserAccounts\Models\Log;

class UserService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(User $user): void
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    public function find(int $id): ?User
    {
        return $this->em->find(User::class, $id);
    }

    public function findAllByAccountId(int $accountId): array
    {
        return $this->em
            ->getRepository(User::class)
            ->findBy(['accountId' => $accountId]);
    }

    public function findAllByEmail(string $email): array
    {
        return $this->em
            ->getRepository(User::class)
            ->findBy(['email' => $email]);
    }

    public function findByToken(string $token): ?User
    {
        return $this->em
            ->getRepository(User::class)
            ->findOneBy(['token' => $token]);
    }

    public function update(User $user): void
    {
        $user->setUpdatedAt(new \DateTime());
        $this->em->flush();
    }

    public function delete(User $user): void
    {
        $this->em->remove($user);
        $this->em->flush();
    }

    public function findAll(): array
    {
        return $this->em->getRepository(User::class)->findAll();
    }

    public function createStatusHistory(int $previousStatusId, int $currentStatusId, int $multiuserId, string $changedBy = '', string $comment = ''): void
    {
        $statusHistory = new StatusHistory();
        $statusHistory->setMultiuserId($multiuserId);
        $statusHistory->setPreviousStatusId($previousStatusId);
        $statusHistory->setCurrentStatusId($currentStatusId);        
        $statusHistory->setChangedBy($changedBy);
        $statusHistory->setDetails($comment);
        $statusHistory->setChangedAt(new \DateTime());

        $this->em->persist($statusHistory);
        $this->em->flush();
    }

    public function createRoleHistory(int $previousRoleId, int $currentRoleId, int $multiuserId, string $comment = ''): void
    {
        $roleHistory = new RoleHistory();
        $roleHistory->setMultiuserId($multiuserId);
        $roleHistory->setPreviousRoleId($previousRoleId);
        $roleHistory->setCurrentRoleId($currentRoleId);
        $roleHistory->setDetails($comment);
        $roleHistory->setChangedAt(new \DateTime());

        $this->em->persist($roleHistory);
        $this->em->flush();
    }

    public function createLog($multiuserId, $action, $comment): void
    {
        $logHistory = new Log();
        $logHistory->setMultiuserId($multiuserId);
        $logHistory->setAction($action);
        $logHistory->getTimestamp(new \DateTime());
        $logHistory->setDetails($comment);

        $this->em->persist($logHistory);
        $this->em->flush();
    }

    public function getLogs(User $user) {
        $logs = [];

        $logs['statusHistory'] = $this->em->getRepository(StatusHistory::class)->findBy(
            ['multiuserId' => $user->getId()],
            ['changedAt' => 'DESC']
        );

        $logs['roleHistory'] = $this->em->getRepository(RoleHistory::class)->findBy(
            ['multiuserId' => $user->getId()],
            ['changedAt' => 'DESC']
        );

        $logs['logHistory'] = $this->em->getRepository(Log::class)->findBy(
            ['multiuserId' => $user->getId()],
            ['timestamp' => 'DESC']
        );

        return $logs;
    }
}
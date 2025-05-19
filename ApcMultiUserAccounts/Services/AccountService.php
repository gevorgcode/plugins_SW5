<?php

namespace ApcMultiUserAccounts\Services;

use Doctrine\ORM\EntityManagerInterface;
use ApcMultiUserAccounts\Models\Account;

class AccountService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Account $account): void
    {
        $this->em->persist($account);
        $this->em->flush();
    }

    public function find(int $id): ?Account
    {
        return $this->em->find(Account::class, $id);
    }

    public function findByMasterUserId(int $masterUserId): ?Account
    {
        return $this->em
            ->getRepository(Account::class)
            ->findOneBy(['masterUserId' => $masterUserId]);
    }

    public function update(Account $account): void
    {
        $account->setUpdatedAt(new \DateTime());
        $this->em->flush();
    }

    public function delete(Account $account): void
    {
        $this->em->remove($account);
        $this->em->flush();
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Account::class)->findAll();
    }
}

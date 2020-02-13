<?php

namespace App\Domain\User\Service;

use App\Domain\Order\Data\OrderListData;
use App\Domain\Order\Repository\OrderListRepository;
use UnexpectedValueException;

/**
 * Service.
 */
final class OrderList
{
    /**
     * @var OrderListRepository
     */
    private $repository;

    /**
     * The constructor.
     *
     * @param OrderListRepository $repository The repository
     */
    public function __construct(OrderListRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create a new user.
     *
     * @param UserCreateData $user The user data
     *
     * @return int The new user ID
     */
    public function createUser(UserCreateData $user): int
    {
        // Validation
        if (empty($user->username)) {
            throw new UnexpectedValueException('Username required');
        }

        // Insert user
        $userId = $this->repository->insertUser($user);

        // Logging here: User created successfully

        return $userId;
    }
}

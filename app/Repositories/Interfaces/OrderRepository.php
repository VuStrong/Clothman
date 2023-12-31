<?php

namespace App\Repositories\Interfaces;

use App\DTOs\Orders\OrderParamsDto;
use App\Models\Order;
use App\Repositories\Interfaces\Repository;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Repository for Order entity
 */
interface OrderRepository extends Repository
{
    public function findByParams(OrderParamsDto $params): LengthAwarePaginator;

    /**
     * Get one order by Code
     */
    public function findByCode(string $code, array $includes = null): ?Order;

    /**
     * Get orders by user id
     */
    public function findByUserId(string $userId, int $page, int $limit, array $includes = null): LengthAwarePaginator;

    /**
     * Count all users by created_at field
     */
    public function countByCreatedAt(string $date): int;
}

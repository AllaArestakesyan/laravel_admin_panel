<?php

namespace App\Contracts;

use App\Data\CountryData;
use App\Data\StoreCountryData;

interface CountryServiceInterface
{

    /**
     * Summary of create
     * 
     * @param \App\Data\StoreCountryData $data
     * @return CountryData
     */
    public function create(int $id,StoreCountryData $data): CountryData|array;

    /**
     * Summary of findByUserId
     * 
     * @param int $id
     * @return array
     */
    public function findByUserId(int $user_id, int $page, int $limit): ?array;

    /**
     * Summary of delete
     * 
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}

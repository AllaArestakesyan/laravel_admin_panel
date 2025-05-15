<?php

namespace App\Services;

use App\Contracts\CountryServiceInterface;
use App\Data\CountryData;
use App\Data\StoreCountryData;
use App\Models\Country;

class CountryService implements CountryServiceInterface
{

    public function create(int $id, StoreCountryData $data): CountryData|array
    {
        $find = Country::where('name', $data->name)
            ->where('user_id', $id)
            ->first();

        if ($find) {

            return ["message" => "Connact has already."];
        }

        $country = Country::create([
            "name" => $data->name,
            'formatted_address' => $data->formatted_address,
            'url' => $data->url,
            'user_id' => $id,
        ]);

        return CountryData::from($country);
    }


    /**
     * Summary of findByUserId
     * 
     * @param int $user_id
     * @param int $page
     * @param int $limit
     * 
     * @return array
     */
    public function findByUserId(int $user_id, int $page, int $limit): array
    {
        $skip = ($page - 1) * $limit;

        $countries = Country::where('user_id', $user_id)
            ->orderBy('name')
            ->skip($skip)
            ->limit($limit)
            ->get();
        $total = Country::where('user_id', $user_id)->count();

        return [
            'data' => $countries,
            'total' => $total,
            'limit' => $limit,
            'current_page' => $page,
            'last_page' => ceil($total / $limit),
        ];
    }


    /**
     * Delete a Country by its ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return Country::destroy($id) > 0;
    }
}
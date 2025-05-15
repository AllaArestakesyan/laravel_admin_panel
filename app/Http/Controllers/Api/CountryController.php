<?php

namespace App\Http\Controllers\Api;

use App\Contracts\CountryServiceInterface;
use App\Data\StoreCountryData;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCountryRequest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Spatie\LaravelData\Exceptions\CannotCreateData;

class CountryController extends Controller
{
    /**
     * Summary of __construct
     * 
     * @param CountryServiceInterface $countryService
     */
    public function __construct(private CountryServiceInterface $countryService)
    {
    }

    /**
     * Summary of store
     * 
     * @param StoreCountryRequest $request
     * @return JsonResponse|mixed
     */
    public function store(StoreCountryRequest $request): JsonResponse
    {
        try {

            $data = StoreCountryData::from($request->validated());
            $countries = $this->countryService->create($request->user()->id, $data);

            return response()->json($countries);
            
        } catch (CannotCreateData $e) {

            return response()->json([
                'message' => 'Invalid input',
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Summary of index
     * 
     * @param Request $request
     * @return JsonResponse|mixed
     */
    public function index(Request $request): JsonResponse    
    {
        $page = (int) $request->input('page', 1); 
        $limit = (int) $request->input('limit', 10); 

        $countries = $this->countryService->findByUserId($request->user()->id, $page, $limit);

        return response()->json($countries);

    }

    /**
     * Summary of destroy
     * 
     * @param int $id
     * @return JsonResponse|mixed
     */
    public function destroy(int $id): JsonResponse
    {
        $success = $this->countryService->delete($id);

        if ($success) {
            return response()->json(['message' => 'Country deleted']);
        }

        return response()->json(['message' => 'Country not found']);
    }
}

<?php declare(strict_types=1);

/**
 * Datince - REST API
 * REST API for Datince.
 * PHP version 8.1
 *
 * The version of the OpenAPI document: 2.0.6
 * Contact: avbaryshev@yandex.ru
 *
 * NOTE: This class is auto generated by OpenAPI-Generator
 * https://openapi-generator.tech
 * Do not edit the class manually.
 *
 * Source files are located at:
 *
 * > https://github.com/OpenAPITools/openapi-generator/blob/master/modules/openapi-generator/src/main/resources/php-laravel/
 */


namespace OpenAPI\Server\Http\Controllers;

use Crell\Serde\SerdeCommon;
use Illuminate\Routing\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


use OpenAPI\Server\Api\LocationsApiInterface;

class LocationsController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly LocationsApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    )
    {
    }

    /**
     * Operation locationsDefaultGet
     *
     * Get default location.
     *
     */
    public function locationsDefaultGet(Request $request): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    
                ],
                $request->all(),
            ),
            [
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        try {
            $apiResult = $this->api->locationsDefaultGet();
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\Location) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\ErrorResponsePlace) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 400);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation locationsLocationIdDelete
     *
     * Delete location.
     *
     */
    public function locationsLocationIdDelete(Request $request, string $locationId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'locationId' => $locationId,
                ],
                $request->all(),
            ),
            [
                'locationId' => [
                    'required',
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        try {
            $apiResult = $this->api->locationsLocationIdDelete($locationId);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent204) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 204);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation locationsLocationIdGet
     *
     * Get specific location.
     *
     */
    public function locationsLocationIdGet(Request $request, string $locationId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'locationId' => $locationId,
                ],
                $request->all(),
            ),
            [
                'locationId' => [
                    'required',
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        try {
            $apiResult = $this->api->locationsLocationIdGet($locationId);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\Location) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation locationsLocationIdPatch
     *
     * Update location status.
     *
     */
    public function locationsLocationIdPatch(Request $request, string $locationId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'locationId' => $locationId,
                ],
                $request->all(),
            ),
            [
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        $locationsLocationIdPatchRequest = $this->serde->deserialize($request->getContent(), from: 'json', to: \OpenAPI\Server\Model\LocationsLocationIdPatchRequest::class);

        try {
            $apiResult = $this->api->locationsLocationIdPatch($locationId, $locationsLocationIdPatchRequest);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent200) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\ErrorResponsePlace) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 400);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
}

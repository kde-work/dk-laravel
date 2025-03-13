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


use OpenAPI\Server\Api\ChatApiInterface;

class ChatController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly ChatApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    )
    {
    }

    /**
     * Operation chatChatIdGet
     *
     * Chat messages.
     *
     */
    public function chatChatIdGet(Request $request, string $chatId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'chatId' => $chatId,
                ],
                $request->all(),
            ),
            [
                'chatId' => [
                    'required',
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        try {
            $apiResult = $this->api->chatChatIdGet($chatId);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\ChatMessages) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation chatGet
     *
     * Chat list with users.
     *
     */
    public function chatGet(Request $request): JsonResponse
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
            $apiResult = $this->api->chatGet();
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\ChatList) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
}

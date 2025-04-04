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


use OpenAPI\Server\Api\UserApiInterface;

class UserController extends Controller
{
    /**
     * Constructor
     */
    public function __construct(
        private readonly UserApiInterface $api,
        private readonly SerdeCommon $serde = new SerdeCommon(),
    )
    {
    }

    /**
     * Operation userDelete
     *
     * Delete user.
     *
     */
    public function userDelete(Request $request): JsonResponse
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
            $apiResult = $this->api->userDelete();
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
     * Operation userEmailPatch
     *
     * Update user email.
     *
     */
    public function userEmailPatch(Request $request): JsonResponse
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

        $userEmailPatchRequest = $this->serde->deserialize($request->getContent(), from: 'json', to: \OpenAPI\Server\Model\UserEmailPatchRequest::class);

        try {
            $apiResult = $this->api->userEmailPatch($userEmailPatchRequest);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\User) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userGet
     *
     * Get user profile.
     *
     */
    public function userGet(Request $request): JsonResponse
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
            $apiResult = $this->api->userGet();
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\User) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userPasswordPatch
     *
     * Update password.
     *
     */
    public function userPasswordPatch(Request $request): JsonResponse
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

        $userPasswordPatchRequest = $this->serde->deserialize($request->getContent(), from: 'json', to: \OpenAPI\Server\Model\UserPasswordPatchRequest::class);

        try {
            $apiResult = $this->api->userPasswordPatch($userPasswordPatchRequest);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent200) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userPhotoPatch
     *
     * Update main photo.
     *
     */
    public function userPhotoPatch(Request $request): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    
                ],
                $request->all(),
            ),
            [
                'photo' => [
                    'file',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $photo = $request->file('photo');

        try {
            $apiResult = $this->api->userPhotoPatch($photo);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent200) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userPhotoPhotoIdDelete
     *
     * Delete user photo.
     *
     */
    public function userPhotoPhotoIdDelete(Request $request, string $photoId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'photoId' => $photoId,
                ],
                $request->all(),
            ),
            [
                'photoId' => [
                    'required',
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        try {
            $apiResult = $this->api->userPhotoPhotoIdDelete($photoId);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent204) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 204);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\ErrorResponse) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 404);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userPhotosPatch
     *
     * Update photos collection.
     *
     */
    public function userPhotosPatch(Request $request): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    
                ],
                $request->all(),
            ),
            [
                'photos' => [
                    'file',
                    'array',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $photos = $request->file('photos');
        $photos = $request->get('photos');

        try {
            $apiResult = $this->api->userPhotosPatch($photos);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent200) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userPut
     *
     * Update user profile.
     *
     */
    public function userPut(Request $request): JsonResponse
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

        $user = $this->serde->deserialize($request->getContent(), from: 'json', to: \OpenAPI\Server\Model\User::class);

        try {
            $apiResult = $this->api->userPut($user);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent200) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userSupportPost
     *
     * Submit support request.
     *
     */
    public function userSupportPost(Request $request): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    
                ],
                $request->all(),
            ),
            [
                'theme' => [
                    'string',
                ],
                'text' => [
                    'string',
                ],
                'file' => [
                    'file',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }

        $theme = $request->string('theme')->value();

        $text = $request->string('text')->value();

        $file = $request->file('file');

        try {
            $apiResult = $this->api->userSupportPost($theme, $text, $file);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\NoContent200) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
    /**
     * Operation userUserIdGet
     *
     * Get user profile.
     *
     */
    public function userUserIdGet(Request $request, string $userId): JsonResponse
    {
        $validator = Validator::make(
            array_merge(
                [
                    'userId' => $userId,
                ],
                $request->all(),
            ),
            [
                'userId' => [
                    'required',
                    'string',
                ],
            ],
        );

        if ($validator->fails()) {
            return response()->json(['error' => 'Invalid input'], 400);
        }


        try {
            $apiResult = $this->api->userUserIdGet($userId);
        } catch (\Exception $exception) {
            // This shouldn't happen
            return response()->json(['error' => $exception->getMessage()], 500);
        }

        if ($apiResult instanceof \OpenAPI\Server\Model\User) {
            return response()->json($this->serde->serialize($apiResult, format: 'array'), 200);
        }


        // This shouldn't happen
        return response()->abort(500);
    }
}

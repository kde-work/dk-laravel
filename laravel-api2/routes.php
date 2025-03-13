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


use Illuminate\Support\Facades\Route;

/**
 * POST authForgotPasswordPost
 * Summary: Initiate password reset
 * Notes: 
 */
Route::POST('/api/v2/auth/forgot-password', [\OpenAPI\Server\Http\Controllers\AuthController::class, 'authForgotPasswordPost'])->name('auth.auth.forgot.password.post');

/**
 * POST authLoginPost
 * Summary: User login
 * Notes: 
 */
Route::POST('/api/v2/auth/login', [\OpenAPI\Server\Http\Controllers\AuthController::class, 'authLoginPost'])->name('auth.auth.login.post');

/**
 * POST authLogoutPost
 * Summary: User logout
 * Notes: 
 */
Route::POST('/api/v2/auth/logout', [\OpenAPI\Server\Http\Controllers\AuthController::class, 'authLogoutPost'])->name('auth.auth.logout.post');

/**
 * POST authRegisterPost
 * Summary: Register new user
 * Notes: 
 */
Route::POST('/api/v2/auth/register', [\OpenAPI\Server\Http\Controllers\AuthController::class, 'authRegisterPost'])->name('auth.auth.register.post');

/**
 * POST authResetPasswordPost
 * Summary: Complete password reset
 * Notes: 
 */
Route::POST('/api/v2/auth/reset-password', [\OpenAPI\Server\Http\Controllers\AuthController::class, 'authResetPasswordPost'])->name('auth.auth.reset.password.post');

/**
 * POST authVerifyEmailPost
 * Summary: Verify email address
 * Notes: 
 */
Route::POST('/api/v2/auth/verify-email', [\OpenAPI\Server\Http\Controllers\AuthController::class, 'authVerifyEmailPost'])->name('auth.auth.verify.email.post');

/**
 * GET chatChatIdGet
 * Summary: Chat messages
 * Notes: 
 */
Route::GET('/api/v2/chat/{chatId}', [\OpenAPI\Server\Http\Controllers\ChatController::class, 'chatChatIdGet'])->name('chat.chat.chat.id.get');

/**
 * GET chatGet
 * Summary: Chat list with users
 * Notes: 
 */
Route::GET('/api/v2/chat', [\OpenAPI\Server\Http\Controllers\ChatController::class, 'chatGet'])->name('chat.chat.get');

/**
 * GET filtersGet
 * Summary: Get user filters
 * Notes: 
 */
Route::GET('/api/v2/filters', [\OpenAPI\Server\Http\Controllers\FiltersController::class, 'filtersGet'])->name('filters.filters.get');

/**
 * PUT filtersPut
 * Summary: Update user filters
 * Notes: 
 */
Route::PUT('/api/v2/filters', [\OpenAPI\Server\Http\Controllers\FiltersController::class, 'filtersPut'])->name('filters.filters.put');

/**
 * GET filtersWithGoalsGet
 * Summary: Get user filters with goals
 * Notes: 
 */
Route::GET('/api/v2/filters-with-goals', [\OpenAPI\Server\Http\Controllers\FiltersController::class, 'filtersWithGoalsGet'])->name('filters.filters.with.goals.get');

/**
 * PUT filtersWithGoalsPut
 * Summary: Update user filters with goals
 * Notes: 
 */
Route::PUT('/api/v2/filters-with-goals', [\OpenAPI\Server\Http\Controllers\FiltersController::class, 'filtersWithGoalsPut'])->name('filters.filters.with.goals.put');

/**
 * GET filtersWithGoalsGet
 * Summary: Get user filters with goals
 * Notes: 
 */
Route::GET('/api/v2/filters-with-goals', [\OpenAPI\Server\Http\Controllers\GoalsController::class, 'filtersWithGoalsGet'])->name('goals.filters.with.goals.get');

/**
 * PUT filtersWithGoalsPut
 * Summary: Update user filters with goals
 * Notes: 
 */
Route::PUT('/api/v2/filters-with-goals', [\OpenAPI\Server\Http\Controllers\GoalsController::class, 'filtersWithGoalsPut'])->name('goals.filters.with.goals.put');

/**
 * GET goalsGet
 * Summary: Get user goals
 * Notes: 
 */
Route::GET('/api/v2/goals', [\OpenAPI\Server\Http\Controllers\GoalsController::class, 'goalsGet'])->name('goals.goals.get');

/**
 * PUT goalsPut
 * Summary: Update all goals
 * Notes: 
 */
Route::PUT('/api/v2/goals', [\OpenAPI\Server\Http\Controllers\GoalsController::class, 'goalsPut'])->name('goals.goals.put');

/**
 * GET locationsDefaultGet
 * Summary: Get default location
 * Notes: 
 */
Route::GET('/api/v2/locations/default', [\OpenAPI\Server\Http\Controllers\LocationsController::class, 'locationsDefaultGet'])->name('locations.locations.default.get');

/**
 * DELETE locationsLocationIdDelete
 * Summary: Delete location
 * Notes: 
 */
Route::DELETE('/api/v2/locations/{locationId}', [\OpenAPI\Server\Http\Controllers\LocationsController::class, 'locationsLocationIdDelete'])->name('locations.locations.location.id.delete');

/**
 * GET locationsLocationIdGet
 * Summary: Get specific location
 * Notes: 
 */
Route::GET('/api/v2/locations/{locationId}', [\OpenAPI\Server\Http\Controllers\LocationsController::class, 'locationsLocationIdGet'])->name('locations.locations.location.id.get');

/**
 * PATCH locationsLocationIdPatch
 * Summary: Update location status
 * Notes: 
 */
Route::PATCH('/api/v2/locations/{locationId}', [\OpenAPI\Server\Http\Controllers\LocationsController::class, 'locationsLocationIdPatch'])->name('locations.locations.location.id.patch');

/**
 * GET resourcesFiltersGet
 * Summary: Filters data
 * Notes: 
 */
Route::GET('/api/v2/resources/filters', [\OpenAPI\Server\Http\Controllers\ResourcesController::class, 'resourcesFiltersGet'])->name('resources.resources.filters.get');

/**
 * DELETE userDelete
 * Summary: Delete user
 * Notes: 
 */
Route::DELETE('/api/v2/user', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userDelete'])->name('user.user.delete');

/**
 * PATCH userEmailPatch
 * Summary: Update user email
 * Notes: 
 */
Route::PATCH('/api/v2/user/email', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userEmailPatch'])->name('user.user.email.patch');

/**
 * GET userGet
 * Summary: Get user profile
 * Notes: 
 */
Route::GET('/api/v2/user', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userGet'])->name('user.user.get');

/**
 * PATCH userPasswordPatch
 * Summary: Update password
 * Notes: 
 */
Route::PATCH('/api/v2/user/password', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userPasswordPatch'])->name('user.user.password.patch');

/**
 * PATCH userPhotoPatch
 * Summary: Update main photo
 * Notes: 
 */
Route::PATCH('/api/v2/user/photo', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userPhotoPatch'])->name('user.user.photo.patch');

/**
 * DELETE userPhotoPhotoIdDelete
 * Summary: Delete user photo
 * Notes: 
 */
Route::DELETE('/api/v2/user/photo/{photoId}', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userPhotoPhotoIdDelete'])->name('user.user.photo.photo.id.delete');

/**
 * PATCH userPhotosPatch
 * Summary: Update photos collection
 * Notes: 
 */
Route::PATCH('/api/v2/user/photos', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userPhotosPatch'])->name('user.user.photos.patch');

/**
 * PUT userPut
 * Summary: Update user profile
 * Notes: 
 */
Route::PUT('/api/v2/user', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userPut'])->name('user.user.put');

/**
 * POST userSupportPost
 * Summary: Submit support request
 * Notes: 
 */
Route::POST('/api/v2/user/support', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userSupportPost'])->name('user.user.support.post');

/**
 * GET userUserIdGet
 * Summary: Get user profile
 * Notes: 
 */
Route::GET('/api/v2/user/{userId}', [\OpenAPI\Server\Http\Controllers\UserController::class, 'userUserIdGet'])->name('user.user.user.id.get');


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


/**
 * AuthResetPasswordPostRequest
 */
namespace OpenAPI\Server\Model;

/**
 * AuthResetPasswordPostRequest
 */
use Crell\Serde\Renaming\Cases;
use Crell\Serde\Attributes as Serde;

#[Serde\ClassSettings(renameWith: Cases::snake_case)]
class AuthResetPasswordPostRequest
{
    /**
    *
    * 
    * @param string $token
    *
    * 
    * @param string $newPassword
    */

    public function __construct(
        public string $token,
        public string $newPassword,
    ) {}
}


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
 * NoContent202
 */
namespace OpenAPI\Server\Model;

/**
 * NoContent202
 * @description No content for 202
 */
use Crell\Serde\Renaming\Cases;
use Crell\Serde\Attributes as Serde;

#[Serde\ClassSettings(renameWith: Cases::snake_case)]
class NoContent202
{
    /**
    *
    * dummy property for no-content responses
    * @param null | string $dummy
    */

    public function __construct(
        public ?string $dummy = null,
    ) {}
}


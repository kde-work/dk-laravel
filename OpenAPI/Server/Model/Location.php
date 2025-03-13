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
 * Location
 */
namespace OpenAPI\Server\Model;

/**
 * Location
 */
use Crell\Serde\Renaming\Cases;
use Crell\Serde\Attributes as Serde;

#[Serde\ClassSettings(renameWith: Cases::snake_case)]
class Location
{
    /**
    *
    * 
    * @param string $address
    *
    * 
    * @param string $name
    *
    * 
    * @param \OpenAPI\Server\Model\LocationCoord $coord
    *
    * 
    * @param \OpenAPI\Server\Model\User[] $users
    */

    public function __construct(
        public string $address,
        public string $name,
        public \OpenAPI\Server\Model\LocationCoord $coord,
        public array $users,
    ) {}
}


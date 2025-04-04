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
 * User
 */
namespace OpenAPI\Server\Model;

/**
 * User
 */
use Crell\Serde\Renaming\Cases;
use Crell\Serde\Attributes as Serde;

#[Serde\ClassSettings(renameWith: Cases::snake_case)]
class User
{
    /**
    *
    * 
    * @param string $name
    *
    * 
    * @param string $email
    *
    * 
    * @param int $age
    *
    * 
    * @param float $height
    *
    * 
    * @param bool $children
    *
    * 
    * @param string $photo
    *
    * 
    * @param string[] $photos
    *
    * 
    * @param \DateTime $birthdate
    *
    * 
    * @param string $chatId
    *
    * 
    * @param bool $hasChat
    */

    public function __construct(
        public string $name,
        public string $email,
        public int $age,
        public float $height,
        public bool $children,
        public string $photo,
        public array $photos,
        public \DateTime $birthdate,
        public string $chatId,
        public bool $hasChat,
    ) {}
}


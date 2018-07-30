<?php
/**
 * Created by PhpStorm.
 * User: zamba
 * Date: 30/07/18
 * Time: 21.41
 */

namespace GermanoZambelli\Hassio\Credentials;

abstract class AbstractCredentials
{
    /**
     * @return string
     */
    public abstract function getUri(): string;

    /**
     * @param $uri
     * @return bool
     */
    public function isValidUri($uri): bool
    {
        return (filter_var($uri, FILTER_VALIDATE_URL) !== false);
    }
}
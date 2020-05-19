<?php

declare(strict_types=1);

namespace pakman\jsp\parsers\exceptions;

/**
 * Class ValidationException
 *
 * @package pakman\jsp\exceptions
 */
class ValidationException extends ParseErrorException {
    protected $message = 'Validation error';
}

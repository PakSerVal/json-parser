<?php

declare(strict_types=1);

namespace pakman\jsp\parsers\exceptions;

/**
 * Class WrongFormatException
 *
 * @package pakman\jsp\exceptions
 */
class WrongFormatException extends ParseErrorException {
    protected $message = 'Wrong format error';
}

<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

use pakman\jsp\parsers\exceptions\ValidationException;

/**
 * Class FloatParser
 *
 * @package pakman\jsp\parsers
 */
class FloatParser extends Parser {

    /**
     * @param $data
     *
     * @throws ValidationException
     *
     * @return float
     */
    public function parse($data): float {
        $data = filter_var($data, FILTER_VALIDATE_FLOAT);

        if (false === $data) {
            throw new ValidationException();
        }

        return $data;
    }
}

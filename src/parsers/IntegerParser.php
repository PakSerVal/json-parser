<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

use pakman\jsp\parsers\exceptions\ValidationException;

/**
 * Class IntegerParser
 *
 * @package pakman\jsp\parsers
 */
class IntegerParser extends Parser {

    /**
     * @param $data
     *
     * @throws ValidationException
     *
     * @return int
     */
    public function parse($data): int {
        $data = filter_var($data, FILTER_VALIDATE_INT);

        if (false === $data) {
            throw new ValidationException();
        }

        return $data;
    }
}

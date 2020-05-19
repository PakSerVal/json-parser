<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

use pakman\jsp\parsers\exceptions\ValidationException;

class StringParser extends Parser {

    /**
     * @param $data
     *
     * @throws ValidationException
     *
     * @return string
     */
    public function parse($data): string {
        if (is_string($data) === false) {
            throw new ValidationException();
        }

        return $data;
    }
}

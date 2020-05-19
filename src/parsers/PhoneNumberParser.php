<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

use pakman\jsp\parsers\exceptions\ParseErrorException;
use pakman\jsp\parsers\exceptions\ValidationException;
use pakman\jsp\parsers\exceptions\WrongFormatException;

class PhoneNumberParser extends Parser {

    /**
     * @param $data
     *
     * @throws ParseErrorException
     *
     * @return string
     */
    public function parse($data): string {
        if (is_string($data) === false) {
            throw new WrongFormatException();
        }

        if (!preg_match('/^((\+?7|8)[ \-] ?)?((\(\d{3}\))|(\d{3}))?([ \-])?(\d{3}[\- ]?\d{2}[\- ]?\d{2})$/', $data)) {
            throw new ValidationException();
        }

        $data = str_replace(['+', '(', ')', ' ', '-'], '', $data);
        $data = preg_replace('/^\d(\d+)/', '7${1}', $data);

        return $data;
    }
}

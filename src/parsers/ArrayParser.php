<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

use pakman\jsp\dto\Definition;
use pakman\jsp\parsers\exceptions\ParseErrorException;
use pakman\jsp\parsers\exceptions\WrongFormatException;

/**
 * Class ArrayParser
 *
 * @package pakman\jsp\parsers
 */
class ArrayParser extends Parser {

    /**
     * @param $data
     *
     * @return array
     *
     * @throws \pakman\jsp\parsers\exceptions\ParseErrorException
     */
    public function parse($data): array {
        if (is_array($data) === false) {
            throw new WrongFormatException();
        }

        $definition       = new Definition();
        $definition->type = $this->options['type'];
        $internalParser   = ParserFactory::build($definition);

        $result = [];
        foreach ($data as $item) {
            $result[] = $internalParser->parse($item);
        }

        return $result;
    }
}

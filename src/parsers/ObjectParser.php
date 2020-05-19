<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

use pakman\jsp\parsers\exceptions\ParseErrorException;
use pakman\jsp\parsers\exceptions\WrongFormatException;
use pakman\jsp\TypeDefinitions;

/**
 * Class ObjectParser
 *
 * @package pakman\jsp\parsers
 */
class ObjectParser extends Parser {

    /**
     * @param $data
     *
     * @throws ParseErrorException
     *
     * @return array
     */
    public function parse($data): array {
        if (is_array($data) === false) {
            throw new WrongFormatException();
        }

        $definitions = $this->options['definitions'] /** @var TypeDefinitions $definitions */;

        $result = [];
        foreach ($data as $key => $value) {
            $definition = $definitions->get($key);

            if ($definition === null) {
                $result[$key] = $value;

                continue;
            }

            $parser       = ParserFactory::build($definition);
            $result[$key] = $parser->parse($value);
        }

        return $result;

//        return $result;
    }
}

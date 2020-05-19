<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

use mysql_xdevapi\Exception;
use pakman\jsp\dto\Definition;

/**
 * Class ParserFactory
 *
 * @package pakman\jsp\parsers
 */
class ParserFactory {

    /**
     * @param Definition $definition
     *
     * @return Parser
     */
    public static function build(Definition $definition): Parser {
        $parsersMap = include __DIR__ . '/../config/parsers.php';

        if (array_key_exists($definition->type, $parsersMap) === false) {
            throw new Exception('Wrong definition type');
        }

        $parserClass = $parsersMap[$definition->type];

        return new $parserClass($definition->options);
    }
}

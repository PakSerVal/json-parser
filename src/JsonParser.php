<?php

declare(strict_types=1);

namespace pakman\jsp;

use pakman\jsp\parsers\exceptions\ParseErrorException;
use pakman\jsp\parsers\ParserFactory;

/**
 * Class JsonParser
 *
 * @package pakman\jsp
 */
class JsonParser {

    /** @var array (Key => Error message) */
    private $errors;

    /** @var TypeDefinitions */
    private $definitions;

    public function __construct(TypeDefinitions $definitions) {
        $this->definitions = $definitions;
    }

    /**
     * @param string $json
     *
     * @return array
     */
    public function parse(string $json): array {
        $tree = json_decode($json, true);

        $result = [];
        foreach ($tree as $key => $data) {
            $definition = $this->definitions->get($key);
            if ($definition === null) {
                $result[$key] = $data;

                continue;
            }

            try {
                $parser = ParserFactory::build($definition);
                $value  = $parser->parse($data);

                $result[$key] = $value;
            }
            catch (ParseErrorException $e) {
                $this->errors[$key] = $e->getMessage();
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getErrors() {
        return $this->errors;
    }
}

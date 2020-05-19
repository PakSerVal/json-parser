<?php

declare(strict_types=1);

namespace pakman\jsp\parsers;

/**
 * Class Parser
 *
 * @package pakman\jsp\parsers
 */
abstract class Parser {
    /** @var array */
    protected $options;

    /**
     * Parser constructor.
     *
     * @param array $options
     */
    public function __construct(array $options = []) {
        $this->options = $options;
    }

    /**
     * @param $data
     *
     * @return mixed
     * @throws \pakman\jsp\parsers\exceptions\ParseErrorException
     *
     */
    abstract public function parse($data);
}

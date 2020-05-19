<?php

declare(strict_types=1);

namespace pakman\jsp;

use pakman\jsp\dto\Definition;

/**
 * Class TypeDefinitions
 *
 * @package pakman\jsp
 */
class TypeDefinitions {

    const INTEGER = 'INTEGER';
    const FLOAT   = 'FLOAT';
    const STRING  = 'STRING';
    const PHONE   = 'PHONE';
    const ARRAY   = 'ARRAY';
    const OBJECT  = 'OBJECT';

    private $definitions = [];

    /**
     * @return TypeDefinitions
     */
    public static function define() {
        return new static();
    }

    /**
     * @param string $key
     *
     * @return TypeDefinitions
     */
    public function float(string $key) {
        return $this->add($key, self::FLOAT);
    }

    /**
     * @param string $key
     *
     * @return TypeDefinitions
     */
    public function string(string $key) {
        return $this->add($key, self::STRING);
    }

    /**
     * @param string $key
     *
     * @return TypeDefinitions
     */
    public function integer(string $key) {
        return $this->add($key, self::INTEGER);
    }

    /**
     * @param string $key
     *
     * @return TypeDefinitions
     */
    public function phone(string $key) {
        return $this->add($key, self::PHONE);
    }

    /**
     * @param string $key
     * @param string $type
     *
     * @return TypeDefinitions
     */
    public function array(string $key, string $type) {
        $options = ['type' => $type];

        return $this->add($key, self::ARRAY, $options);
    }

    /**
     * @param string          $key
     * @param TypeDefinitions $definitions
     *
     * @return TypeDefinitions
     */
    public function object(string $key, TypeDefinitions $definitions) {
        $options = ['definitions' => $definitions];

        return $this->add($key, self::OBJECT, $options);
    }

    /**
     * @param string $key
     * @param string $definitionType
     * @param array  $options
     *
     * @return $this
     */
    public function add(string $key, string $definitionType, array $options = []) {
        $definition = new Definition();

        $definition->type    = $definitionType;
        $definition->options = $options;

        $this->definitions[$key] = $definition;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return Definition|null
     */
    public function get(string $key): ?Definition {
        if (array_key_exists($key, $this->definitions)) {
            return $this->definitions[$key];
        }

        return null;
    }
}

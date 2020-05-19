<?php

declare(strict_types=1);

namespace pakman\jsp;

use PHPUnit\Framework\TestCase;

class JsonParserTest extends TestCase {

    public function testInteger() {
        $json = '{"foo": "123", "error": "123abc"}';

        $typeDefinitions = TypeDefinitions::define()
            ->integer('foo')
            ->integer('error')
        ;
        $parser = new JsonParser($typeDefinitions);
        $result   = $parser->parse($json);
        $this->assertEquals(['foo' => 123], $result);
        $this->assertArrayHasKey('error', $parser->getErrors());
    }

    public function testFloat() {
        $json = '{"foo": "10.20", "error": "abc"}';

        $typeDefinitions = TypeDefinitions::define()
            ->float('foo')
            ->float('error')
        ;
        $parser = new JsonParser($typeDefinitions);
        $result = $parser->parse($json);
        $this->assertEquals(['foo' => 10.2], $result);
        $this->assertArrayHasKey('error', $parser->getErrors());
    }

    public function testString() {
        $json = '{"foo": "abc", "error": ["1", "2"]}';

        $typeDefinitions = TypeDefinitions::define()
            ->string('foo')
            ->string('error')
        ;
        $parser = new JsonParser($typeDefinitions);
        $result = $parser->parse($json);
        $this->assertEquals(['foo' => "abc"], $result);
        $this->assertArrayHasKey('error', $parser->getErrors());
    }

    public function testArray() {
        $json = '{"foo": ["1", "2", "3"], "wrongFormat": "str", "validationError": ["str1", "str2", "str3"]}';

        $typeDefinitions = TypeDefinitions::define()
            ->array('foo', TypeDefinitions::INTEGER)
            ->array('wrongFormat', TypeDefinitions::INTEGER)
            ->array('validationError', TypeDefinitions::INTEGER)
        ;
        $parser = new JsonParser($typeDefinitions);
        $result = $parser->parse($json);
        $this->assertEquals(['foo' => [1, 2, 3]], $result);
        $this->assertArrayHasKey('wrongFormat', $parser->getErrors());
        $this->assertArrayHasKey('validationError', $parser->getErrors());
    }

    public function testObject() {
        $json = '{"foo": {"a": "1", "b": "str", "d": ["1", "2"], "e": {"a": "1"}}, "bar": {"f": "2"}}';

        $typeDefinitions = TypeDefinitions::define()
            ->object('foo', TypeDefinitions::define()
                ->integer('a')
                ->string('b')
                ->float('c')
                ->array('d', TypeDefinitions::INTEGER)
                ->object('e', TypeDefinitions::define()->integer('a'))
            )
            ->object('bar', TypeDefinitions::define()->integer('f'))
        ;
        $parser = new JsonParser($typeDefinitions);
        $result = $parser->parse($json);

        var_dump($result);

        $this->assertEquals(['foo' => [
            'a' => 1,
            'b' => 'str',
            'c' => [1, 2],
            'd' => ['a' => 1]
        ]], $result);
        $this->assertArrayHasKey('error', $parser->getErrors());
    }
}

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
        $json = '{"foo": {"a": "1", "b": "str", "c": "2.1", "d": ["1", "2"], "e": {"a": "1"}}, "error": {"f": "str"}}';

        $typeDefinitions = TypeDefinitions::define()
            ->object('foo', TypeDefinitions::define()
                ->integer('a')
                ->string('b')
                ->float('c')
                ->array('d', TypeDefinitions::INTEGER)
                ->object('e', TypeDefinitions::define()->integer('a'))
            )
            ->object('error', TypeDefinitions::define()->integer('f'))
        ;
        $parser = new JsonParser($typeDefinitions);
        $result = $parser->parse($json);

        $this->assertEquals(['foo' => [
            'a' => 1,
            'b' => 'str',
            'c' => 2.1,
            'd' => [1, 2],
            'e' => ['a' => 1]
        ]], $result);
        $this->assertArrayHasKey('error', $parser->getErrors());
    }

    public function testPhone() {
        $json = '{"foo": "8 (950) 288-56-23", "error": "260557"}';

        $typeDefinitions = TypeDefinitions::define()
            ->phone('foo')
            ->phone('error')
        ;
        $parser = new JsonParser($typeDefinitions);
        $result = $parser->parse($json);

        $this->assertEquals(['foo' => '79502885623'], $result);
        $this->assertArrayHasKey('error', $parser->getErrors());
    }
}

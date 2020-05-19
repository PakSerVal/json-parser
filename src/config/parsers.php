<?php

use pakman\jsp\parsers\ArrayParser;
use pakman\jsp\parsers\FloatParser;
use pakman\jsp\parsers\IntegerParser;
use pakman\jsp\parsers\ObjectParser;
use pakman\jsp\parsers\PhoneNumberParser;
use pakman\jsp\parsers\StringParser;
use pakman\jsp\TypeDefinitions;

return [
    TypeDefinitions::INTEGER => IntegerParser::class,
    TypeDefinitions::STRING  => StringParser::class,
    TypeDefinitions::FLOAT   => FloatParser::class,
    TypeDefinitions::PHONE   => PhoneNumberParser::class,
    TypeDefinitions::ARRAY   => ArrayParser::class,
    TypeDefinitions::OBJECT  => ObjectParser::class,
];

# JSON Parser

Простой парсер для валидации и преобразования JSON в нужный формат


## Установка

```bash
composer require pakman/json-parser
```

### Типы

По умолчанию парсер поддерживает 6 типов данных

- integer
- float
- string
- phone
- array
- object

Помимо этого можно добавлять собственные типы.

#### Пример использования

Исходный JSON
```$json
{
    "foo": {
        "a": "1",
        "b": "str",
        "c": "2.1",
        "d": [
            "1",
            "2"
        ],
        "e": {
            "a": "1"
        }
    },
    "bar": "8 (950) 288-56-23"
}
```

Валидация и приведение к нужному формату
```php
$json = '{"foo": {"a": "1", "b": "str", "c": "2.1", "d": ["1", "2"], "e": {"a": "1"}}, "bar": "8 (950) 288-56-23"}';

$typeDefinitions = TypeDefinitions::define()
    ->object('foo', TypeDefinitions::define()
        ->integer('a')
        ->string('b')
        ->float('c')
        ->array('d', TypeDefinitions::INTEGER)
        ->object('e', TypeDefinitions::define()->integer('a'))
    )
    ->phone('bar')
;
$parser = new JsonParser($typeDefinitions);
$result = $parser->parse($json);

var_dump($result);
```
Результатом будет:

```php
array(4)
  'foo' => 
    array(4)
      'a' => int(1)
      'b' => string(3) "str"
      'c' => float(2.1)
      'd' => 
        array (2)
          0 => int(1)
          1 => int(2)
      'e' => 
        array(1)
          'a' => int(1)
  'bar' => string(11) "79502885623"
```

#### Добавление собственного типа
1. Создать парсер, который будет приводить данные к нужному типу (Класс должен наследовать ```pakman\jsp\parsers\Parser```):
    ```php
    ...
    use pakman\jsp\parsers\Parser;
    
    class HelloWorldParser extends Parser {
    
        public function parse($data): array {
            if ($data !== 'Hello') {
                throw new ValidationException();
            }
    
            return $data . ' world!';
        }
    }
    ```

2. Добавить класс в конфигурационный файл ```src/config/parsers.php```:
    ```php
    ...
    use path\to\HelloWorldParser;
    
    return [
        ...
        'HELLO_WORLD_TYPE' => 'HelloWorldParser::class'
    ];
    ```

3. Использовать его
    ```php
    $json = '{"foo": {"Hello"}}';
    
    $typeDefinitions = TypeDefinitions::define()
        ->add('foo', 'HELLO_WORLD_TYPE')
    ;
    $parser = new JsonParser($typeDefinitions);
    $result = $parser->parse($json);
    
    var_dump($result);

    // array(4)
    //   'foo' => string(12) "Hello world!"
    ```

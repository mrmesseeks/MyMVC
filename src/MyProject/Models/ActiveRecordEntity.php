<?php

namespace MyProject\Models;

use MyProject\Services\Db;
use MyProject\Services\Functions;

abstract class ActiveRecordEntity
{
    protected $id;

    public function getID(): int
    {
        return $this->id;
    }



    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }
    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }


    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `'.static::getTableName().'`;', [], static::class);
    }


    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }
    abstract protected static function getTableName(): string;


    public function save (): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }
    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        $index = 1;
        foreach ($mappedProperties as $column => $value) {
            $i = ':param' . $index; // :param1
            $columns2params[] = $column . ' = ' . $i; // column1 = :param1
            $params2values[':param' . $index] = $value; // [:param1 => value1]
            $index++;
        }
        $sql = 'UPDATE '. static::getTableName(). ' SET '.
            implode(', ',$columns2params). ' WHERE id = '.$this->id;
        $db = Db::getInstance();
        $db->query($sql,$params2values,static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);

        $colums = [];
        $paramsNames = [];
        $index = 1;
        foreach ($filteredProperties as $columnName => $value) {
            $columns[]='`'.$columnName.'`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ')
         VALUES (' . $paramsNamesViaSemicolon . ');';

        $db =Db::getInstance();
        $db ->query($sql,$params2values,static::class);

    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }
    public function delete(): void
    {
        $sql = 'DELETE FROM `'.static::getTableName().'` WHERE id = :id;';
        $id = [':id'=>$this->id];
        $db =Db::getInstance();
        $db->query($sql,$id);

        $this->id=null;
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
        /* [A-Z] - берём большие буквы
        (?<!^) - а это означает, что при этом самую первую букву в начале строки мы не берем, даже если она большая
        _$0 - это знак подчеркивания, за которым следует нулевое совпадение в регулярке (нулевое - это вся строка, попавшая под регулярку.
        В нашем случае - это одна большая буква). Таким образом, с помощью preg_replace, мы заменяем все большие буквы A - Z на _A - _Z.
         А затем с помощью strtolower приводим всю строку к нижнему регистру.

        */
    }


}
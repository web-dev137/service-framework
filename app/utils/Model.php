<?php

namespace App\utils;

abstract class Model
{
    protected ?array $properties = null;
    protected ?array $values = null;
    protected Db $db;
    public function __construct()
    {
        $this->db = App::$db;
    }
    public function load(array $data): bool
    {
        if(!empty($data)) {
            $obj = (object)$data;
            foreach ($obj as $key => $val) {
                if (property_exists($this, $key)) {
                    $this->$key = $val;
                }
            }
            $this->properties = $this->attributes();
            $this->values = $this->getValues();
            return true;
        }
        return false;
    }

    public function __get($key)
    {
        return $this->$key;
    }

    /**
     * @return string[]
     */
    public function attributes(): array
    {
        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if(!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        return $names;
    }

    public function getValues():array
    {
        $values = [];
        foreach ($this->properties as $property) {
            $values[] = $this->$property;
        }
        return $values;
    }

    abstract public function validation():bool;
}
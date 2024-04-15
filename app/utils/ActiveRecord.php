<?php

namespace App\utils;

abstract class ActiveRecord extends Model
{
    static public function primaryKey():string
    {
        return "id";
    }
    static public function tableName():string
    {
        return "tableName";
    }

    public function update()
    {
        $primaryKey = static::primaryKey();
        if($this->validation() && $this->$primaryKey) {
            try {
                $vars = $this->prepareForUpdate();
                $pdo = $this->db->pdo
                    ->prepare("UPDATE 
                                ".static::tableName()." 
                                SET ".$vars."
                                WHERE ".$primaryKey."=".$this->$primaryKey
                    );
                $pdo->execute();
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
            return true;
        }
        return false;
    }

    public function delete():bool
    {
        $primaryKey = static::primaryKey();
        if($this->validation() && $this->$primaryKey) {
            try {
                $q = "DELETE FROM ".static::tableName()."
                            WHERE ".$primaryKey."=".$this->$primaryKey;
                $pdo = $this->db->pdo->prepare($q);
                $pdo->execute();
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
            return true;
        }
        return false;
    }


    public function save(): bool
    {
        if($this->validation()) {
            try {
                $placeholders = array_fill(0,count($this->properties),'?');
                $pdo = $this->db->pdo
                    ->prepare("INSERT IGNORE INTO 
                                ".static::tableName()."(".implode(', ',$this->properties).") 
                                 VALUES (".implode(', ',$placeholders).")");
                $pdo->execute($this->values);
            } catch (\PDOException $e) {
                throw new \PDOException($e->getMessage());
            }
            return true;
        }
        return false;
    }

    private function prepareForUpdate(): string
    {
        $setValues = '';
        $n = count($this->properties);
        for($i = 0; $i < $n; $i++) {
            $setValues .=  $this->properties[$i].'=\''.$this->values[$i]."'";
        }
        return $setValues;
    }
}
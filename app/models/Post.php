<?php

namespace App\models;

use App\utils\ActiveRecord;
use OpenApi\Annotations as QA;

/**
 * @OA\Schema(
 *     title="Post",
 *     required={"post"}
 *  ),
 *  @OA\Property(
 *     property="id",
 *     type="int",
 *     description="ID",
 *     readOnly="true",
 *     example=1
 *  ),
 * @property-read int $id
 * @OA\Property(
 *     property="post",
 *     type="string",
 *     description="Text post",
 *     example="post1 first"
 *  ),
 * @property string $post
 * @OA\Property(
 *     property="created_at",
 *     type="int",
 *     description="Date of create post in current timestamp",
 *     example="2024-04-12 22:50:07"
 *  ),
 * @property int $created_at
 */
class Post extends ActiveRecord
{
    public ?string $post = null;
    //public ?int $created_at =  null;

    public static function tableName():string
    {
        return 'post';
    }

    public static function primaryKey():string
    {
        return 'id';
    }

    public function validation():bool
    {
        return is_string($this->post);
    }

    public function findAll()
    {
        $pdo = $this->db->pdo
            ->prepare("SELECT `id`,`post`,`created_at`
                             FROM " . Post::tableName());
        $this->handlerErr($pdo);
        return $pdo->fetchAll(\PDO::FETCH_OBJ);
    }

    public function findOne(int $id)
    {
       $pdo = $this->db->pdo
        ->prepare(
            "SELECT `id`,`post`,`created_at`
                    FROM " . Post::tableName() .
                  " WHERE id=:id ORDER BY created_at LIMIT 1");
        $pdo->bindParam(':id',$id);
        $this->handlerErr($pdo);
        return $pdo->fetchObject(self::class);
    }

    private function handlerErr(\PDOStatement $pdo): bool
    {
        try {
            $res=$pdo->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
        return $res;
    }

}
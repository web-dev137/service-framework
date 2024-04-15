<?php

namespace App\models\requests;
use OpenApi\Annotations as QA;

/**
 * @OA\Schema(
 *   schema="PostRequest",
 *   required={"post"}
 *  ),
 * @OA\Property(
 *     property="post",
 *     type="string",
 *     description="Text post",
 *     example="post1 first"
 *  ),
 * @property string $post
 */

class PostRequest{}
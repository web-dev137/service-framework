<?php

namespace App\models\response;
use OpenApi\Annotations as QA;

/**
 * @OA\Schema(
 *   schema="PostResponse",
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

class PostResponse{}
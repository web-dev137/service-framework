<?php

namespace App\handlers\api;

use App\models\Post;
use App\utils\App;
use App\utils\Response;
use OpenApi\Annotations as QA;

/**
 * @QA\Info(
 *     title="Post API"
 *     version="1.0"
 * ),
 */
class PostApi
{
    /**
     * @QA\Get(
     *     path="/api/post",
     *     tags={"Unathorize"},
     *     description="Return all posts",
     *     @QA\Response(response=200,description="success",
     *           @QA\JsonContent(type="array",@QA\Items(ref="#/components/schemas/Post"))
     *     ),
     *     @QA\Response(rasponse=500,description="validation error")
     * ),
     * @return array|false
     */
    public function index()
    {
        $model = new Post();
        return $model->findAll();
    }

    /**
     * @QA\Post(
     *     path="/api/post/create",
     *     tags={"Unathorize"},
     *     description="",
     *     @QA\RequestBody(
     *          required=true,
     *          @QA\JsonContent(ref="#/components/schemas/PostRequest")
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Post",
     *         @QA\JsonContent(ref="#/components/schemas/PostResponse")
     *     ),
     *     @QA\Response(response="500", description="Validation error"),
     * ),
     * @return Post|string[]
     */
    public function create()
    {
        $model = new Post();

        if($model->load(App::getPostParams()) && $model->validation()) {
            return ($model->save())?$model:Response::internalErr();
        }
        return Response::internalErr("Not valid");
    }

    /**
     * @QA\Get(
     *     path="/api/post/view",
     *     tags={"Unathorize"},
     *     description="Return all posts",
     *     @QA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          description="ID of post to view",
     *          @QA\Schema(
     *              type="integer",
     *              format="int64"
     *          ),
     *          example=1
     *     ),
     *     @QA\Response(response=200,description="success",
     *          @QA\JsonContent(ref="#components/schemas/Post")
     *     ),
     *     @QA\Response(rasponse=500,description="validation error")
     * ),
     * @param int $id
     * @return bool|int|mixed
     */
    public function view(int $id)
    {
        $model = new Post();
        $res = $model->findOne($id);

        return ($res===false)?Response::notFoundErr():$res;
    }

    /**
     * @OA\Delete(
     *     tags={"Unathorize"},
     *     path="/api/post",
     *     description="Delete post",
     *     @QA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          description="ID of post to delete",
     *          @QA\Schema(
     *               type="integer",
     *              format="int64"
     *          ),
     *          example=1
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="success delete",
     *         @QA\Schema(
     *               type="boolean"
     *          ),
     *     )
     * ),
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $model = new Post();
        $model = $model->findOne($id);
        http_response_code(204);
        return $model->delete();
    }

    /**
     * @OA\Patch(
     *     path="/api/post",
     *     tags={"Unathorize"},
     *     description="Reply on post",
     *     @QA\Parameter(
     *          name="id",
     *          in="query",
     *          required=true,
     *          description="ID",
     *          @QA\Schema(
     *               type="integer",
     *              format="int64"
     *          ),
     *          example=1
     *     ),
     *     @QA\RequestBody(
     *          required=true,
     *          @QA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="post",
     *                  description="post",
     *                  type="string",
     *                  example="post1 first"
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Post",
     *         @QA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @QA\Response(response="500", description="Validation error")
     * ),
     * @param int $id
     * @return Post|string[]
     */
    public function update(int $id)
    {
        $model = new Post();
        $model = $model->findOne($id);
        if($model && $model->load(App::getPostParams())) {
            return ($model->update())?$model:Response::internalErr();
        }
        return Response::internalErr("Not valid or not found");
    }
}
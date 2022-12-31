<?php

namespace App\Services;

use App\Models\Article;
use App\Repositories\Article\ArticleRepository;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ArticleService
{
    /**
     * @var $articleRepository
     */
    protected $articleRepository;

    /**
     * ArticleService constructor.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * Delete post by id.
     *
     * @param $id
     * @return String
     */
    public function deleteById($id)
    {
        DB::beginTransaction();
        try {
            $post = $this->articleRepository->delete($id);
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());

            throw new InvalidArgumentException('Unable to delete article data');
        }
        DB::commit();
        return $post;
    }

    /**
     * Get all post.
     *
     * @return String
     */
    public function getAll()
    {
        return $this->articleRepository->getAll();
    }

    /**
     * Get post by id.
     *
     * @param $id
     * @return String
     */
    public function getById($id)
    {
        return $this->articleRepository->getById($id);
    }

    /**
     * Update post data
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function updateArticle($data, $id)
    {
        DB::beginTransaction();
        try {
            $post = $this->articleRepository->update($data, $id);

        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e->getMessage());
            throw new InvalidArgumentException('Unable to update article data');
        }

        DB::commit();
        return $post;

    }

    /**
     * Validate post data.
     * Store to DB if there are no errors.
     *
     * @param array $data
     * @return String
     */
    public function saveArticleData($data)
    {
        $result = $this->articleRepository->save($data);
        return $result;
    }

}
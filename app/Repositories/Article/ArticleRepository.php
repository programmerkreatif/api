<?php

namespace App\Repositories\Article;

use App\Models\Article;

class ArticleRepository
{
    /**
     * @var Article
     */
    protected $article;

    /**
     * ArticleRepository constructor.
     *
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get all Articles.
     *
     * @return Article $article
     */
    public function getAll()
    {
        return $this->article
            ->get();
    }

    /**
     * Get Article by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->article
            ->where('id', $id)
            ->get();
    }

    /**
     * Save Article
     *
     * @param $data
     * @return Article
     */
    public function save($data)
    {
        $article = new $this->article;
        $article->title = $data['title'];
        $article->description = $data['description'];
        $article->save();
        return $article->fresh();
    }

    /**
     * Update Article
     *
     * @param $data
     * @return Article
     */
    public function update($data, $id)
    {
        
        $article = $this->article->find($id);
        $article->title = $data['title'];
        $article->description = $data['description'];
        $article->update();
        return $article;
    }

    /**
     * Update Article
     *
     * @param $data
     * @return Article
     */
    public function delete($id)
    {
        $article = $this->article->find($id);
        $article->delete();
        return $article;
    }

}
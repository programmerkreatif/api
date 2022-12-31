<?php

namespace App\Http\Controllers;

use App\Enums\HttpStatus;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use App\Service\ArticleService;
use Exception;

class ArticleController extends BaseController
{


     /**
     * @var articleService
     */
    protected $articleService;
    protected $userSession;


     /**
     * PostController Constructor
     *
     * @param ArticleService $articleService
     *
     */
    public function __construct(ArticleService $articleService)
    {
        $user = Auth::user();
        $this->articleService = $articleService;
        $this->userSession = $user;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $data = $this->articleService->getAll();
            return $this->successResponse($data, 'Article has been loaded');
        } catch (Exception $e) {
            return $this->errorResponse('Article has been loaded', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        try {
            if ($this->userSession->can('create', Article::class)) {
                $data = $this->articleService->saveArticleData($request);
                return $this->successResponse($data, 'Article has been saved');
            } else {
                return $this->errorResponse("You don't have access to create article", $e->getMessage(), HttpStatus::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        try {
            $data = $this->articleService->getById($article->id);
            return $this->successResponse($data, 'Article data');
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(ArticleRequest $request, Article $article)
    {
        try {
            if ($this->userSession->can('create', Article::class)) {
                $check = $this->articleService->getById($article->id);
                if ( !empty($check) ) {
                    $data = $this->articleService->updateArticle($request);
                    return $this->successResponse($data, 'Success updated article data');
                } else {
                    return $this->errorResponse('Data Invalid', null, HttpStatus::HTTP_NOT_FOUND);
                }
            } else {
                return $this->errorResponse("You don't have access to create article", $e->getMessage(), HttpStatus::HTTP_UNAUTHORIZED);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            $check = $this->articleService->getById($article->id);
            if ( !empty($check) ) {
                $data = $this->articleService->deleteById($article->id);
                return $this->successResponse($data, 'Success deleted article data');
            } else {
                return $this->errorResponse('Data Invalid', null, HttpStatus::HTTP_NOT_FOUND);
            }
        } catch (Exception $e) {
            return $this->errorResponse('Error', $e->getMessage(), HttpStatus::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

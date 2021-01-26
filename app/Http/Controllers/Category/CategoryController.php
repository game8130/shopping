<?php

namespace App\Http\Controllers\Category;

use App\Services\Category\CategoryServices;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    private $categoryServices;

    public function __construct(CategoryServices $categoryServices)
    {
        $this->categoryServices = $categoryServices;
    }

    /**
     * 查詢
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function index(Request $request)
    {
        return $this->responseWithJson($request, $this->categoryServices->index($request->all()));
    }
}

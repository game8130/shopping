<?php

namespace App\Http\Controllers\Category;

use App\Services\Category\Category1Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class Category1Controller extends Controller
{
    private $category1Services;

    public function __construct(Category1Services $category1Services)
    {
        $this->category1Services = $category1Services;
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
        return $this->responseWithJson($request, $this->category1Services->index($request->all()));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:30|unique:category1,name',
        ]);
        return $this->responseWithJson($request, $this->category1Services->store($request->all()));
    }

    /**
     * 修改
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $request['id'] = $id;
        $this->validate($request, [
            'id'   => 'required|exists:category1',
            'name' => ['required', Rule::unique('category1')->ignore($id)],
        ]);
        return $this->responseWithJson($request, $this->category1Services->update($request->all()));
    }

    /**
     * 刪除
     *
     * @param Request $request
     * @param $id
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroy(Request $request, $id)
    {
        $request['id'] = $id;
        $this->validate($request, [
            'id' => 'required|exists:category1',
        ]);
        return $this->responseWithJson($request, $this->category1Services->destroy($request->all()));
    }
}

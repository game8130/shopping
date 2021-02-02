<?php

namespace App\Http\Controllers\Category;

use App\Services\Category\Category2Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Category2Controller extends Controller
{
    private $category2Services;

    public function __construct(Category2Services $category2Services)
    {
        $this->category2Services = $category2Services;
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
        return $this->responseWithJson($request, $this->category2Services->index($request->all()));
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
            'category1_id' => 'required|exists:category1,id',
            'category2_name' => 'required|max:30',
        ]);
        return $this->responseWithJson($request, $this->category2Services->store($request->all()));
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
            'id'   => 'required|exists:category2',
            'category1_id' => 'required|exists:category1,id',
            'category2_name' => 'required|max:30',
        ]);
        return $this->responseWithJson($request, $this->category2Services->update($request->all()));
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
            'id' => 'required|exists:category2',
        ]);
        return $this->responseWithJson($request, $this->category2Services->destroy($request->all()));
    }
}

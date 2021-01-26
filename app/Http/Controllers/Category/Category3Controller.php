<?php

namespace App\Http\Controllers\Category;

use App\Services\Category\Category3Services;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class Category3Controller extends Controller
{
    private $category3Services;

    public function __construct(Category3Services $category3Services)
    {
        $this->category3Services = $category3Services;
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
        return $this->responseWithJson($request, $this->category3Services->index($request->all()));
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
            'category2_id' => 'required|exists:category2,id',
            'category3_name' => 'required|max:30',
        ]);
        return $this->responseWithJson($request, $this->category3Services->store($request->all()));
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
            'id'   => 'required|exists:category3',
            'category2_id' => 'required|exists:category2,id',
            'category3_name' => 'required|max:30',
        ]);
        return $this->responseWithJson($request, $this->category3Services->update($request->all()));
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
            'id' => 'required|exists:category3',
        ]);
        return $this->responseWithJson($request, $this->category3Services->destroy($request->all()));
    }
}

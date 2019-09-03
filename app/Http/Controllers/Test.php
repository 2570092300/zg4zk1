<?php

namespace App\Http\Controllers;

use App\Users;
use Illuminate\Http\Request;

/**
 * 注册登录功能模块
 * Undocumented class
 */
class Test extends Controller
{
    /**
     * 注册页面渲染
     *
     * @return void
     */
    public function index()
    {
        return view('test.index');
    }

    /**
     * 注册入库功能实现
     *
     * @param Request $request
     * @return void
     */
    public function indexDo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users',
            'pwd' => 'required',
            'phone' => 'required',
        ]);

        $model = new Users();
        $model->name = $request['name'];
        $model->username = rand(10000000, 99999999);
        $model->pwd = md5($request['pwd']);
        $model->phone = $request['phone'];
        $res = $model->save();

        if ($res) {
            return $this->login();
        } else {
            return '失败';
        }
    }

    /**
     * 登录页面渲染
     *
     * @return void
     */
    public function login()
    {
        return view('test.login');
    }

    /**
     * 登录查询功能实现
     *
     * @param Request $request
     * @return void
     */
    public function loginDo(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'pwd' => 'required',
        ]);

        $model = new Users();
        $res = $model->where('name', $request['name'])->where('pwd', md5($request['pwd']))->first();

        if ($res) {
            return view('test.list', ['data' => $res]);
        } else {
            return '失败';
        }
    }
}

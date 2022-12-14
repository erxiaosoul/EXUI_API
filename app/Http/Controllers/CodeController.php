<?php
/*
 * @Author: 贾二小
 * @Date: 2022-07-17 23:45:54
 * @LastEditTime: 2022-08-05 18:00:54
 * @LastEditors: 贾二小
 * @FilePath: /exuiApi/app/Http/Controllers/CodeController.php
 */

namespace App\Http\Controllers;

use App\Http\Requests\CodeExistUserRequest;
use App\Http\Requests\CodeNotExistUserRequest;
use App\Http\Requests\CodeRequest;
use App\Http\Requests\CodeSendToExistUserRequest;
use App\Http\Requests\CodeSendToNotExistUserRequest;
use App\Services\CodeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CodeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum'])->only(['user']);
    }

    // 任意帐号发送验证码
    public function send(CodeRequest $request, CodeService $codeService)
    {
        $code = $codeService->send($request->account);
        return $this->success('验证码发送成功', $code);
    }

    // 已经注册用户发送验证码
    public function currentUser(string $type, CodeService $codeService)
    {
        $code = $codeService->send(Auth::user()[$type == 'mobile' ? 'mobile' : 'email']);
        return $this->success('验证码发送成功',  $code);
    }

    // 不存在用户发送验证码
    public function notExistUser(CodeSendToNotExistUserRequest $request, CodeService $codeService)
    {
        $code = $codeService->send($request->account);
        return $this->success('验证码发送成功', $code);
    }

    // 已存在用户发送验证码
    public function existUser(CodeSendToExistUserRequest $request, CodeService $codeService)
    {
        $code = $codeService->send($request->account);
        return $this->success('验证码发送成功', $code);
    }
}

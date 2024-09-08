<?php

namespace App\Http\Controllers\Auth;

use App\Enums\AuditAction;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuditTrailService;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function __construct(
        private readonly AuditTrailService $auditTrailService,
    ) {
        parent::__construct();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();

        $loginData = array(
            "username" => strtolower(trim($data["username"])),
            "password" => trim($data["password"]),
            "clientIp" => $this->clientIp,
        );

        $re = $this->authRepository->doLogin($loginData);

        if ($re['code'] == 200) {
            $userInfo = $re['data'];

            $result = array(
                'token' => $userInfo['token'],
                'uid'   => $userInfo['id'],
            );

            $this->auditTrailService->log(
                $result['uid'],
                AuditAction::LOGIN,
                ['ip' => long2ip($this->clientIp)],
            );

            return response()->json([
                'msg'  => 'ok',
                'data' => $result,
            ]);
        }

        return response()->json(['msg' => $re['msg']], $re['code']);
    }

    public function logout(): JsonResponse
    {
        $this->authRepository->logout($this->clientId);

        return response()->json(['msg'  => 'ok']);
    }
}

<?php

namespace App\Http\Controllers\IpAddress;

use App\Enums\AuditAction;
use App\Http\Controllers\BaseController;
use App\Http\Requests\IpAddress\IpAddressStoreRequest;
use App\Http\Requests\IpAddress\IpAddressUpdateRequest;
use App\Models\IpAddress;
use App\Services\AuditTrailService;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IpAddressController extends BaseController
{
    use ResponseTrait;

    public function __construct(
        private readonly IpAddress $ipAddressModel,
        private readonly AuditTrailService $auditTrailService,
    ) {
        parent::__construct();
    }

    public function index(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 15);

        $ipAddresses = $this->ipAddressModel->paginateRows($page, $perPage);

        return response()->json($ipAddresses);
    }

    public function store(IpAddressStoreRequest $request): JsonResponse
    {
        $ipAddressData = $request->validated();
        $ipAddressData['user_id'] = $this->uid;

        $result = $this->ipAddressModel->create($ipAddressData);

        $this->auditTrailService->log(
            $this->uid,
            AuditAction::CREATE_IP_ADDRESS,
            [],
            $result->id,
        );

        return response()->json($result);
    }

    public function update(IpAddressUpdateRequest $request, IpAddress $ipAddress): JsonResponse
    {
        $ipAddressData = $request->validated();

        $oldLabel = $ipAddress->label;

        $ipAddress->update($ipAddressData);

        $this->auditTrailService->log(
            $this->uid,
            AuditAction::UPDATE_IP_ADDRESS,
            ['old_label' => $oldLabel, 'new_label' => $ipAddressData['label']],
            $ipAddress->id,
        );

        return response()->json($ipAddress);
    }

    public function showAuditLog(IpAddress $ipAddress): JsonResponse
    {
        $auditLogs = $ipAddress->auditTrails()->where('action', AuditAction::UPDATE_IP_ADDRESS)->get();

        return response()->json($auditLogs);
    }

}

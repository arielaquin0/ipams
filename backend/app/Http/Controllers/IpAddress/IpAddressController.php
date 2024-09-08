<?php

namespace App\Http\Controllers\IpAddress;

use App\Http\Controllers\BaseController;
use App\Http\Requests\IpAddress\IpAddressStoreRequest;
use App\Http\Requests\IpAddress\IpAddressUpdateRequest;
use App\Models\IpAddress;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IpAddressController extends BaseController
{
    use ResponseTrait;

    public function __construct(
        private readonly IpAddress $ipAddressModel,
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

        return response()->json($result);
    }

    public function update(IpAddressUpdateRequest $request, IpAddress $ipAddress): JsonResponse
    {
        $ipAddressData = $request->validated();

        $ipAddress->update($ipAddressData);

        return response()->json($ipAddress);
    }

}

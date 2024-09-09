<?php

namespace Tests\Unit;

use App\Enums\AuditAction;
use App\Http\Controllers\IpAddress\IpAddressController;
use App\Http\Requests\IpAddress\IpAddressStoreRequest;
use App\Models\IpAddress;
use App\Services\AuditTrailService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery;
use Tests\TestCase;

class IpAddressControllerTest extends TestCase
{
    use RefreshDatabase;

    protected IpAddressController $controller;
    protected $ipAddressModel;
    protected $auditTrailService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->ipAddressModel = Mockery::mock(IpAddress::class);
        $this->auditTrailService = Mockery::mock(AuditTrailService::class);

        $this->controller = new IpAddressController(
            $this->ipAddressModel,
            $this->auditTrailService
        );

        $this->controller->uid = 1;
    }

    public function testItCanListIpAddresses()
    {
        $request = Request::create('/ip-addresses', 'GET', ['page' => 1, 'per_page' => 15]);

        $data = [
            [
                "id" => 1,
                "ip_address" => "224.56.109.95",
                "label" => "Spare",
                "comment" => "Voluptates aut ipsam rerum dignissimos officia quia.",
                "user_id" => 1,
                "created_at" => "2024-09-08T13:28:34.000000Z",
                "updated_at" => "2024-09-08T13:28:34.000000Z"
            ]
        ];
        $items = collect($data);
        $totalItems = 10;
        $perPage = 15;
        $currentPage = 1;
        $paginator = new LengthAwarePaginator($items, $totalItems, $perPage, $currentPage);

        $this->ipAddressModel
            ->shouldReceive('paginateRows')
            ->with(1, 15)
            ->andReturn($paginator);

        $response = $this->controller->index($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $responseData = $response->getData(true);
        $this->assertEquals($data, $responseData['data']);
    }
}

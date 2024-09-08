<?php
namespace App\Services;

use App\Enums\AuditAction;
use App\Models\AuditTrail;

class AuditTrailService
{
    public function log(int $userId, AuditAction $action, array $details = [], string|null $ipAddressId = null): void
    {
        (new AuditTrail)->create([
            'user_id' => $userId,
            'ip_address_id' => $ipAddressId,
            'action' => $action->value,
            'details' => json_encode($details),
        ]);
    }
}

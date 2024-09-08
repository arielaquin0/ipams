<?php
namespace App\Enums;

enum AuditAction: string
{
    case LOGIN = 'login';
    case CREATE_IP_ADDRESS = 'create_ip_address';
    case UPDATE_IP_ADDRESS = 'update_ip_address';
}

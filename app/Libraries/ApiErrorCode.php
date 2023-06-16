<?php

namespace App\Libraries;

class ApiErrorCode
{
    public const INVALID_DATA = 30;
    public const USER_BLOCKED = 31;
    public const USER_DISABLED = 32;
    public const NEED_ACCOUNT_ACTIVATION = 35;
    public const VALIDATION_CODE_SENT = 37;
    public const TOKEN_NOT_FOUND = 40;
    public const TOKEN_EXPIRED = 41;
    public const TOKEN_INVALID = 42;
    public const SERVER_ERROR = 50;
    public const SERVICE_NOT_AVAILABLE = 53;
    public const REMIT_INVALID_DATA = 60;
    public const REMIT_NEED_REGISTER = 61;
    public const REMIT_NEED_ACCOUNT_ACTIVATION = 62;
    public const REMIT_DEVICE_REGISTER = 63;
    public const REMIT_SHOW_STATE_DISCLAIMER = 64;
    public const REMIT_PAYMENT_METHOD_BLOCK = 66;
    public const REMIT_ACCOUNT_BLOCKED = 67;
}

<?php
// app/Support/RequestContext.php

namespace App\Support\helpers;

class RequestContext
{
    public ?string $route = null;
    public ?string $ip = null;
    public bool $isAdmin = false;
}

<?php

namespace App\Http\Controllers\Application\API;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Tenant;

class FindTenantByShareCodeController extends Controller
{
    public function __invoke(string $shareCode)
    {
        $tenant = Tenant::whereId(
            Team::whereShareCode($shareCode)
                ->firstOrFail()
                ->id
        )->firstOrFail();

        return response()->json($tenant);
    }
}

<?php

namespace App\Policies;

use App\Enums\RequestStatus;
use App\Models\ProcurementRequest;
use App\Models\User;

class ProcurementRequestPolicy
{
    public function view(User $user, ProcurementRequest $request): bool
    {
        return $this->canManage($user, $request);
    }

    public function update(User $user, ProcurementRequest $request): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'purchaser') {
            return in_array($request->status, [
                RequestStatus::Draft,
                RequestStatus::Submitted,
                RequestStatus::Approved,
                RequestStatus::Ordered,
            ], true);
        }

        if ($user->role === 'camp_manager') {
            return $request->camp_id === $user->camp_id
                && $request->status === RequestStatus::Draft;
        }

        return false;
    }

    public function archive(User $user, ProcurementRequest $request): bool
    {
        return in_array($user->role, ['admin', 'purchaser'], true);
    }

    protected function canManage(User $user, ProcurementRequest $request): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'purchaser') {
            return true;
        }

        if ($user->role === 'camp_manager') {
            return $request->camp_id === $user->camp_id;
        }

        return false;
    }
}

<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\AdminAccount;
use App\Rank;

class RankPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * ランクチェック
     */
    public function rankCheck(AdminAccount $adminAccount, Rank $rank)
    {
        return $adminAccount->rank_id >= $rank->id;
    }
}

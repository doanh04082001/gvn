<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface ApplyLeaveRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface ApplyLeaveRepository extends RepositoryInterface
{
    // get my apply leave
    public function myApplyLeaves();

    //get all apply leave status 0,1,2
    public function applyLeaves();

    //get all apply leave status = 2 (using user super_admin)
    public function getApplyLeaveStatus();

    public function applyLeaveEdit($id);

    // get apply leaver (filter)    
    public function getStatistic($params);

}

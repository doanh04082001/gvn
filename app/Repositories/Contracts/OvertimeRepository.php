<?php

namespace App\Repositories\Contracts;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OvertimeRepository.
 *
 * @package namespace App\Repositories\Contracts;
 */
interface OvertimeRepository extends RepositoryInterface
{
    // get my overTime
    public function myOverTime();

    //get all overTime
    public function overTimes();

    public function getOvertimeStatus();

    // statistic overtime
    public function getStatistic($params);
}

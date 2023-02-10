<?php

namespace App\Jobs;

use App\Models\Province;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GenerateAddressJsonFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $addressDbData = $this->getAddressDb();

        $currentFileData = Storage::exists(Province::ADDRESS_PATH_NAME)
            ? Storage::get(Province::ADDRESS_PATH_NAME)
            : '';

        if ($addressDbData != $currentFileData) {
            Storage::put(Province::ADDRESS_PATH_NAME, $addressDbData);
            Storage::put(Province::ADDRESS_VERSION_PATH_NAME, time());
        }
    }

    /**
     * Get provinces, districts, wards from database.
     *
     * @return string
     */
    private function getAddressDb()
    {
        return Province::select('id', 'name')
            ->with([
                'districts' => function ($query) {
                    $query->select('id', 'province_id', 'name')
                        ->orderBy('name');
                },
                'districts.wards' => function ($query) {
                    $query->select('id', 'district_id', 'name')
                        ->orderBy('name');
                },
            ])
            ->orderBy('name')
            ->get()
            ->toJson();
    }
}

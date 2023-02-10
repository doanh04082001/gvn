<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $stores = [
        //     [
        //         'name' => "CN1: Số 19/1 Nguyễn Thị Minh Khai, P. Bến Nghé, Q.1",
        //         'phone' => '0909005214',
        //         'address' => "Số 19/1 Nguyễn Thị Minh Khai, P. Bến Nghé, Q.1, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.847474660622579,
        //         'longitude' => 106.76860964165314,
        //     ],
        //     [
        //         'name' => "CN2: 22, Đoàn Kết, P. Bình Thọ, Q.Thủ Đức",
        //         'phone' => '0909005214',
        //         'address' => "22, Đoàn Kết, P. Bình Thọ, Q.Thủ Đức, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.784858643651308,
        //         'longitude' => 106.70006817815882,
        //     ],
        //     [
        //         'name' => "CN3: 236, Nguyễn Hồng Đào, P. 13, Q.Tân Bình",
        //         'phone' => '0909005214',
        //         'address' => "236, Nguyễn Hồng Đào, P. 13, Q.Tân Bình, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.809834922943185,
        //         'longitude' => 106.71277684350066,
        //     ],
        //     [
        //         'name' => "CN4: 40 Đề Thám, P. Cầu Ông Lãnh, Q1",
        //         'phone' => '0909005214',
        //         'address' => "40 Đề Thám, P. Cầu Ông Lãnh, Q1, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.790992296396787,
        //         'longitude' => 106.64113738398198,
        //     ],
        //     [
        //         'name' => "CN5: 63 Phùng Văn Cung, P.7, Q. Phú Nhuận",
        //         'phone' => '0909005214',
        //         'address' => "63 Phùng Văn Cung, P.7, Q. Phú Nhuận, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.779168762007211,
        //         'longitude' => 106.6650889686403,
        //     ],
        //     [
        //         'name' => "CN6: 268 Tô Hiến Thành, P.15, Q. 10",
        //         'phone' => '0909005214',
        //         'address' => "268 Tô Hiến Thành, P.15, Q. 10, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.759308035923656,
        //         'longitude' => 106.70126796864015,
        //     ],
        //     [
        //         'name' => "CN7: 147 D5, P.25, Q. Bình Thạnh",
        //         'phone' => '0909005214',
        //         'address' => "147 D5, P.25, Q. Bình Thạnh, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.805984686918986,
        //         'longitude' => 106.71729203980517,
        //     ],
        //     [
        //         'name' => "CN8: 9 Dương Quảng Hàm, P.5, Q. Gò Vấp",
        //         'phone' => '0909005214',
        //         'address' => "9 Dương Quảng Hàm, P.5, Q. Gò Vấp, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.800968567634905,
        //         'longitude' => 106.68528338398204,
        //     ],
        //     [
        //         'name' => "CN9: 798 Đ. Nguyễn Trãi, P.14, Quận 5",
        //         'phone' => '0909005214',
        //         'address' => "798 Đ. Nguyễn Trãi, P.14, Quận 5, Thành phố Hồ Chí Minh",
        //         'latitude' => 10.763718773912792,
        //         'longitude' => 106.6958283956279,
        //     ],
        // ];

        // foreach ($stores as $store) {
        //     $storeModel = Store::create($store);
        //     $storeModel->users()->sync(User::inRandomOrder()->limit(5)->pluck('id')->toArray());
        // }
    }
}

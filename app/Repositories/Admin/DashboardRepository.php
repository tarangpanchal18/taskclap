<?php

namespace App\Repositories\Admin;

use App\Models\Banner;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardRepository
{
    public function getDashboardData()
    {
        return [
            'totalActiveUser' => User::where('status', 'Active')->count(),
            'totalInActiveUser' => User::where('status', 'InActive')->count(),
            'totalCategory' => Category::where('status', 'InActive')->count(),
            'totalBanner' => Banner::where('status', 'Active')->count(),
        ];
    }

    public function getDashboardChartData()
    {
        $activeUser = $inActiveUser = array_fill(0, 12, 0);;
        $getActiveUserByMonth = User::select(DB::raw('MONTH(created_at) AS MONTH, COUNT(id) AS COUNT'))->where('status', 'Active')->groupBy(DB::Raw('MONTH(created_at)'))->get()->toArray();
        $getInActiveUserByMonth = User::select(DB::raw('MONTH(created_at) AS MONTH, COUNT(id) AS COUNT'))->where('status', 'InActive')->groupBy(DB::Raw('MONTH(created_at)'))->get()->toArray();

        foreach ($getActiveUserByMonth as $item) {
            $activeUser[$item['MONTH']-1] = $item['COUNT'];
        }
        foreach ($getInActiveUserByMonth as $item) {
            $inActiveUser[$item['MONTH']-1] = $item['COUNT'];
        }

        return [
            'category_label' => json_encode(['Active', 'InActive']),
            'category' => json_encode([
                Category::where('status', 'Active')->count(),
                Category::where('status', 'InActive')->count()
            ]),
            'user_label' => json_encode(array_map(function($m) { return date('M', strtotime("{$m}/1")); }, range(1, 12))),
            'user' => json_encode([
                [
                    'name' => 'Active User',
                    'background' => 'rgba(60,141,188,0.9)',
                    'value' => $activeUser
                ],
                [
                    'name' =>'Inactive User',
                    'background' => 'rgba(210, 214, 222, 1)',
                    'value' => $inActiveUser
                ],
            ]),
        ];
    }
}

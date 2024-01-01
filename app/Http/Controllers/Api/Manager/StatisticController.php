<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticController extends BaseController
{
    public function __construct()
    {
    }

    public function getTotalOrderByDate(Request $request)
    {
        try {
            $end_date = $this->makeDateStart($request->end_date);
            $start_date = $this->makeDateEnd($request->start_date);
            $store_id = $request->store_id ?? 6688;

            $dataOrders = Order::whereBetween('created_at', [$start_date, $end_date]);
            if ($store_id != 6688) {
                $dataOrders = $dataOrders->where('store_id', $store_id);
            }
            $dataOrders = $dataOrders->get();

            $resData = [
                'total_orders' => count($dataOrders),
                'total_order_offline' => count($dataOrders->where('type', 1)),
                'total_order_online' => count($dataOrders->where('type', 2)),
            ];

            return $this->responseSuccess($resData);
        } catch (Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    public function getDataForLineChart(Request $request)
    {
        try {
            $end_date = $request->end_date;
            $start_date = $request->start_date;
            $store_id = $request->store_id ?? 6688;

            if ($store_id != 6688) {
                $data_total_order = DB::select(DB::raw("WITH RECURSIVE
                cte AS ( SELECT '$start_date' AS `data_date`
                       UNION ALL
                         SELECT `data_date` + INTERVAL 1 DAY
                         FROM cte
                         WHERE `data_date` < '$end_date' )
                SELECT `data_date`, COALESCE(od.amount_order, 0) amount_orders
                FROM (
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS data_date, count(id) as amount_order
                FROM orders
                WHERE store_id = '$store_id'
                GROUP BY data_date
                ) as od
                RIGHT JOIN cte USING (`data_date`)"));
                // dd(array_column($data_total_order, 'data_date'));

                $data_order_offline = DB::select(DB::raw("WITH RECURSIVE
                cte AS ( SELECT '$start_date' AS `data_date`
                       UNION ALL
                         SELECT `data_date` + INTERVAL 1 DAY
                         FROM cte
                         WHERE `data_date` < '$end_date' )
                SELECT `data_date`, COALESCE(od.amount_order, 0) amount_orders
                FROM (
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS data_date, count(id) as amount_order
                FROM orders
                where `type` = 1 AND store_id = '$store_id'
                GROUP BY data_date
                ) as od
                RIGHT JOIN cte USING (`data_date`)"));

                $data_order_online = DB::select(DB::raw("WITH RECURSIVE
                cte AS ( SELECT '$start_date' AS `data_date`
                       UNION ALL
                         SELECT `data_date` + INTERVAL 1 DAY
                         FROM cte
                         WHERE `data_date` < '$end_date' )
                SELECT `data_date`, COALESCE(od.amount_order, 0) amount_orders
                FROM (
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS data_date, count(id) as amount_order
                FROM orders
                where `type` = 2 AND store_id = '$store_id'
                GROUP BY data_date
                ) as od
                RIGHT JOIN cte USING (`data_date`)"));
            } else {
                $data_total_order = DB::select(DB::raw("WITH RECURSIVE
                cte AS ( SELECT '$start_date' AS `data_date`
                    UNION ALL
                        SELECT `data_date` + INTERVAL 1 DAY
                        FROM cte
                        WHERE `data_date` < '$end_date' )
                SELECT `data_date`, COALESCE(od.amount_order, 0) amount_orders
                FROM (
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS data_date, count(id) as amount_order
                FROM orders
                GROUP BY data_date
                ) as od
                RIGHT JOIN cte USING (`data_date`)"));
                    // dd(array_column($data_total_order, 'data_date'));

                $data_order_offline = DB::select(DB::raw("WITH RECURSIVE
                cte AS ( SELECT '$start_date' AS `data_date`
                    UNION ALL
                        SELECT `data_date` + INTERVAL 1 DAY
                        FROM cte
                        WHERE `data_date` < '$end_date' )
                SELECT `data_date`, COALESCE(od.amount_order, 0) amount_orders
                FROM (
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS data_date, count(id) as amount_order
                FROM orders
                where `type` = 1
                GROUP BY data_date
                ) as od
                RIGHT JOIN cte USING (`data_date`)"));

                $data_order_online = DB::select(DB::raw("WITH RECURSIVE
                cte AS ( SELECT '$start_date' AS `data_date`
                    UNION ALL
                        SELECT `data_date` + INTERVAL 1 DAY
                        FROM cte
                        WHERE `data_date` < '$end_date' )
                SELECT `data_date`, COALESCE(od.amount_order, 0) amount_orders
                FROM (
                SELECT DATE_FORMAT(created_at, '%Y-%m-%d') AS data_date, count(id) as amount_order
                FROM orders
                where `type` = 2
                GROUP BY data_date
                ) as od
                RIGHT JOIN cte USING (`data_date`)"));
            }

            $resData = [
                'labels' => array_column($data_total_order, 'data_date'),
                'data_total_order' => array_column($data_total_order, 'amount_orders'),
                'data_order_offline' => array_column($data_order_offline, 'amount_orders'),
                'data_order_online' => array_column($data_order_online, 'amount_orders'),
            ];

            return $this->responseSuccess($resData);
        } catch (Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    private function makeDateStart($start_date)
    {
        return "$start_date 00:00:00";
    }

    private function makeDateEnd($end_date)
    {
        return "$end_date 23:59:59";
    }
}

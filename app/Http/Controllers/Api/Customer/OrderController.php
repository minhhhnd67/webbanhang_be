<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Exception;
use App\Repositories\Manager\OrderDetailRepository;
use App\Repositories\Manager\OrderRepository;

class OrderController extends BaseController
{
    private $orderRepository;
    private $orderDetailRepository;

    public function __construct(OrderRepository $orderRepository, OrderDetailRepository $orderDetailRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $pageSize = $request->pageSize ?? 10;
            $userId = $request->userId ?? '';
            $relations = ['orderDetails.product'];
            $orders = $this->orderRepository->getOrderByUser($userId, $relations, $pageSize);

            return $this->responseSuccess($orders);
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $order = $this->orderRepository->create([
                'store_id' => $data['store_id'],
                'code' => $this->generateCode(),
                'user_id' => $data['user_id'],
                'status' => $data['status'],
                'total_money' => $data['total_money'],
                'type' => $data['type'],
                'name' => $data['name'],
                'phone' => $data['phone'],
                'province_id' => $data['province_id'],
                'province_name' => $data['province_name'],
                'district_id' => $data['district_id'],
                'district_name' => $data['district_name'],
                'ward_id' => $data['ward_id'],
                'ward_name' => $data['ward_name'],
                'address_detail' => $data['address_detail'],
            ]);

            $order_details = $data['order_details'] ?? [];
            foreach($order_details as $order_detail) {
                $this->orderDetailRepository->create([
                    'order_id' => $order->id,
                    'product_id' => $order_detail['product_id'],
                    'amount' => $order_detail['amount'],
                    'sku_info' => $order_detail['skus'],
                ]);
            }

            return $this->responseSuccess(['order_id' => $order->id]);
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $relations = ['orderDetails.product'];
            $order = $this->orderRepository->getById($id, $relations);

            return $this->responseSuccess($order);
        } catch(Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $relations = [];
            $order = $this->orderRepository->getById($id, $relations);
            if (isset($request->code_shipping)) {
                $order->update([
                    'code_shipping' => $request->code_shipping
                ]);
            }
            if (isset($request->status)) {
                $order->update([
                    'status' => $request->status
                ]);
            }

            return $this->responseSuccess();
        } catch (Exception $e) {
            return $this->responseFalse($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generateCode()
    {
        $n = 8;
        $range_start = 10 ** ($n - 1);
        $range_end = (10 ** $n) - 1;
        $random_integer = random_int($range_start, $range_end);
        return $random_integer;
    }
}

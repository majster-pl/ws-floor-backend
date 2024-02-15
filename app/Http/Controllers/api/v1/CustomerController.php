<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Event;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\CustomerCollection;
use App\Models\Asset;
use Symfony\Component\HttpFoundation\Response;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::where("owner_id", Auth::user()->owner_id)->withTrashed()->get()
            ->sortBy('customer_name', SORT_NATURAL | SORT_FLAG_CASE);
        return new CustomerCollection($customers);
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
        $data = $request->all();
        $data['status'] = "active";
        $data['owner_id'] = Auth::user()->owner_id;
        $data['uuid'] =
            Str::uuid()->toString();
        $data['created_by'] = Auth::id();
        $new = Customer::create($data);
        // $customer = Customer::create();
        // $customer->$request->all();
        // $customer->status = "active";
        // $customer = $request->all();
        // // $customer->uuid = Str::uuid()->toString();
        // // $customer->status = "active";

        // $newCustomer = $customer->save();

        return $new;
        // return response(Auth::id());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::where([['uuid', $id], ['owner_id', Auth::user()
            ->owner_id]])->first();
        if ($customer) {
            return new CustomerResource($customer);
        } else {
            $response = ['message' => 'Customer Not Found!'];
            return response()->json(
                $response,
                Response::HTTP_NOT_FOUND
            );
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
    public function update(Request $request, $uuid)
    {
        $customer = Customer::where("uuid", $uuid)->first();

        $customer->update($request->all());
        // return $customer;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // both below perform soft-delete
        $customer = Customer::find($id)->delete();
        $events = Event::where("customer_id", $id)->delete();

        return $customer;
    }
}

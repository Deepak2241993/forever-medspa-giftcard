@extends('layouts.admin_layout')
@section('body')
<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Service Order History</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Service Order History
                        </li>
                    </ol>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content Header-->
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            {{ $data->onEachSide(5)->links() }}
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Transaction Id</th>
                    <th>Total Amount</th>
                    <th>Transaction Amount</th>
                    <th>Gift Card Use</th>
                    <th>Payment Status</th>
                    <th>Transaction Status</th>
                    <th>Created Date & Time</th>
                   
                </tr>
                </thead>


                <tbody>
                    @foreach($data as $key=>$value)
                    
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->order_id}}</td>
                    <td>{{$value->fname ." ".$value->lname}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->phone}}</td>
                    <td>{{$value->city}}</td>
                    <td>{{$value->country}}</td>
                    <td>{{$value->payment_intent}}</td>
                    <td>{{$value->final_amount}}</td>
                    <td>{{$value->transaction_amount}}</td>
                    <td>{{$value->gift_card_applyed}}</td>
                    <td><span class="badge text-bg-{{$value->payment_status =='paid'?'success':'danger'}}">{{ucFirst($value->payment_status)}}</span></td>
                    <td><span class="badge text-bg-{{$value->transaction_status =='complete'?'success':'danger'}}">{{ucFirst($value->transaction_status)}}</span></td>
                    <td>{{date('m-d-Y h:i:m',strtotime($value->updated_at))}}</td>
                
                </tr>
                @endforeach
                
                </tbody>
            </table>
            {{ $data->onEachSide(5)->links() }}
            <!--end::Row-->               
                <!-- /.Start col -->
            </div>
            <!-- /.row (main row) -->
        </div>
        <!--end::Container-->
    </div>
    <!--end::App Content-->
</main>
@endsection


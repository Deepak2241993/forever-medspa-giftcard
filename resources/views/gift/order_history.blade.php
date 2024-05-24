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
                    <h3 class="mb-0">Transaction History</h3>
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Orders</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Transaction History
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

            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Transaction Id</th>
                    <th>Card Last 4 Digit</th>
                    <th>Amount $</th>
                    <th>Status</th>
                   
                </tr>
                </thead>


                <tbody>
                    @foreach($data as $key=>$value)
                    
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$value->transaction_id}}</td>
                    <td>{{$value->last_for_digit}}</td>
                    <td>{{$value->amount}}</td>
                    <td>{{$value->status}}</td>
                
                </tr>
                @endforeach
                
                </tbody>
            </table>
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


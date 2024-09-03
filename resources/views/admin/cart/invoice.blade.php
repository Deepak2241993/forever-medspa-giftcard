@extends('layouts.admin_layout')
@section('body')
    <!-- Body main wrapper start -->
    <!-- Your existing content in invoice.blade.php -->
   
    <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Row-->
                <div class="row">
                    <div class="col-sm-4">
                        <h3 class="mb-0">Invoice Details</h3>

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-end">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">
                               Invoice
                            </li>
                        </ol>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::Container-->
        </div>
    <!-- Include the service_invoice.blade.php file here -->
    @include('invoice.service_invoice', ['transaction_data' => $transaction_data])
    </main>
    <!-- Rest of your content in invoice.blade.php -->
@endsection

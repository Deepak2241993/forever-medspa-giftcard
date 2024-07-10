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
                    <h3 class="mb-0">Search Keywords</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Search Keywords
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
            {{-- <form action="">
                <div class="row mt-4 mb-4">
                    <div class="col-md-4">
                        <input type="date" class="form-control" placeholder="To Date">
                    </div>
                    <div class="col-md-4">
                        <input type="date" class="form-control" placeholder="From Date">
                    </div>
                    <div class="col-md-4">
                        <button class="form-control btn btn-primary">Export</button>
                    </div>
                </div>
               </form> --}}
               <a href="{{route('export_date')}}" class="btn btn-primary">Click For Data Export</a>
            <div class="card-header">
               
               <span class="text-success"> @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif</span>
            </div>
           
            
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Keywords Search</th>
                    <th>No.of Search</th>
                   </tr>
                </thead>
                 <tbody>
                    @foreach($keywordsData as $key => $value)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $value->keywords ? $value->keywords:'NULL' }}</td>
                        <td>{{ $value->keyword_count ? $value->keyword_count :'NULL' }}</td>
                        
                        
                        
                        <!-- Button trigger modal -->

  

                       
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{$keywordsData->links('vendor.pagination.default')}}
           
           
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

  @push('script')
  
    
  @endpush

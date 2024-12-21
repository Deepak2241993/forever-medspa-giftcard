@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Patient</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Patient</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="card">
    <div class="card-header">
        <h4 class="mb-0">Search Data</h4>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <label for="fname" class="form-label">First Name:</label>
                <input type="text" class="form-control" id="fname" name="fname"
                    placeholder="First Name" onkeyup="SearchView()">
            </div>
            <div class="col-md-3">
                <label for="lname" class="form-label">Last Name:</label>
                <input type="text" class="form-control" id="lname" name="lname"
                    placeholder="Last Name" onkeyup="SearchView()">
            </div>
            <div class="col-md-3">
                <label for="email" class="form-label">Email:</label>
                <input type="text" class="form-control" id="email" name="email" 
                    placeholder="Enter Email" onkeyup="SearchView()">
            </div>
            <div class="col-md-3">
                <label for="phone" class="form-label">Phone:</label>
                <input type="text" class="form-control" id="phone" name="phone" 
                    placeholder="Enter phone" onkeyup="SearchView()">
            </div>
        </div>
    </div>
</div>
<section class="content-header">
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <section class="content">
            <div class="container-fluid">
                <!--begin::Row-->
                {{-- <a href="{{route('medspa-gift.create') }}"  class="btn btn-block
                btn-outline-primary">Add More</a> --}}
                <div class="card-header">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach(explode(' ', session('error')) as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                

                </div>
                <span class="text-success" id="response_msg"></span>
                <div class="scroll-container">
                    <div style="overflow: scroll">
                        {{-- <div class="scroll-content"> --}}

                        <table id="datatable-buttons" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Action</th>
                                    <th>Patient Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Zip Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="data-table-body">
                                
                                @if(count($data)>0)
                                @foreach($data as $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>
                                        
                                        <a href="{{route('patient.edit',$value->id)}}"
                                             class="btn btn-block btn-outline-primary mb-2">Edit</a>
                                        {{-- <form
                                            action="{{route('patient.destroy',$value->id)}}"
                                            method="POST">
                                            @method('DELETE')
                                            
                                              @csrf
                                            <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form> --}}
                                    </td>
                                    <td>{{$value->fname ." ".$value->lname }}</td>
                                    <td>{{$value->email }}</td>
                                    <td>{{$value->phone }}</td>
                                    <td>{{$value->address }}</td>
                                    <td>{{$value->zip_code }}</td>
                                    <td>
                                        @if($value->status==1)
                                        <span class="badge bg-success">Active</span>
                                        @else
                                        <span class="badge bg-danger">Inactive</span>
                                        @endif
                                      </td>
                                 
                                
                                    <!-- Button trigger modal -->
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6"><h3>No Program Available</h3></td>
                                </tr>
                                
                                @endif
                                
                                <br>
                                {{ $data->links() }}
                            </tbody>
                        </table>

                        {{ $data->links() }}
                       

                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
    </div>
</section>


@endsection

@push('script')
<script>
function SearchView() {
    var fname = $('#fname').val();
    var lname = $('#lname').val();
    var email = $('#email').val();
    var phone = $('#phone').val();

    $.ajax({
        url: '{{ route('patient-search') }}', // API endpoint
        method: "GET",
        dataType: "json",
        data: {
            fname: fname,
            lname: lname,
            email: email,
            phone: phone,
        },
        success: function(response) {
            if (response.status === 'success') {
                var tableBody = $('#data-table-body'); // ID of your table body
                tableBody.empty(); // Clear existing rows

                // Loop through the response data and populate the table
                $.each(response.data.data, function(key, value) {
                    var updatedDate = new Date(value.updated_at).toLocaleString('en-US', {
                        month: '2-digit',
                        day: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit'
                    });

                    tableBody.append(`
                        <tr>
                            <td>${key + 1}</td>
                            <td>
                                <a href="/patient/${value.id}/edit" class="btn btn-block btn-outline-primary">Edit</a>
                                <form action="/patient/${value.id}" method="POST" style="display:inline;">
                                    @method('DELETE')
                                    @csrf
                                    <button class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                </form>
                            </td>
                            <td>${value.fname} ${value.lname}</td>
                            <td>${value.email}</td>
                            <td>${value.phone}</td>
                            <td>${value.address}</td>
                            <td>${value.zip_code}</td>
                            <td>
                                <span class="badge bg-${value.status === '1' ? 'success' : 'danger'}">
                                   ${value.status === '1' ? 'Active' : 'Inactive'}
                                </span>
                            </td>
                        </tr>
                    `);
                });
            } else {
                alert(response.message || 'No results found.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('An error occurred while fetching data.');
        }
    });
}
</script>
@endpush

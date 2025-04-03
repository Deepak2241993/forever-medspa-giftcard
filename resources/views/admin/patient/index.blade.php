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
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="#">#</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Action">Action</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Patient Name">Patient Name</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Email">Email</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Phone">Phone</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Address">Address</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Zip Code">Zip Code</th>
                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="datatable-buttons" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Status">Status</th>
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
                                    <td colspan="8"><h3>No Program Available</h3></td>
                                </tr>
                                
                                @endif
                                
                                <br>
                                {{-- {{ $data->links() }} --}}
                            </tbody>
                        </table>

                        {{-- {{ $data->links() }} --}}
                       

                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
    </div>
</section>


@endsection

@push('script')
<script>

function deletePatient(id) {
    if (confirm('Are you sure you want to delete this patient?')) {
        $.ajax({
            url: `{{url('/')}}/admin/patient/${id}`,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                alert(response.message);
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Failed to delete the patient.');
            }
        });
    }
}

</script>

<script>
    $(function () {
      $("#datatable-buttons").DataTable({
        "responsive": true, "lengthChange": true, "autoWidth": false,
        "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
      }).buttons().container().appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endpush

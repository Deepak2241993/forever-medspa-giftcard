@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Sliders</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Sliders</li>
                </ol>
            </div>
        </div>
        <a href="{{ route('banner.create') }}" class="btn btn-primary">Add More</a>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">
    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <section class="content">
            <div class="container-fluid">
                <!--begin::Row-->
                {{-- <a href="{{route('medspa-gift.create') }}" class="btn
                btn-primary">Add More</a> --}}
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
                </div>
                <span class="text-success" id="response_msg"></span>
                <div class="scroll-container">
                    <div style="overflow: scroll">
                        {{-- <div class="scroll-content"> --}}

                        <table id="datatable-buttons" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Image</th>
                                    <th>URL</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result as $key=>$value)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $value->title ? $value->title : '' }}
                                        </td>
                                        <td><img src="{{ $value->image ? $value->image : '' }}"
                                                height="100" width="200" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"></td>
                                        <td>{{ $value->url ? $value->url : '' }}
                                        </td>
                                        <td>{{ $value->status ==1 ? 'Active' : 'Inactive' }}
                                        </td>
                                        <td>
                                            <!-- <a href="{{ route('banner.edit', $value->id) }}"
                                                class="btn btn-primary">Edit</a> -->
                                            <form
                                                action="{{ route('banner.destroy', $value->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                
                                                  @csrf
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
                                        </td>


                                        <!-- Button trigger modal -->
                                    </tr>
                                @endforeach
                                <br>

                            </tbody>
                        </table>


                        <hr>

                    </div>
                </div>
            </div>
            <!-- /.row (main row) -->
    </div>
</section>


@endsection

@push('script')

@endpush

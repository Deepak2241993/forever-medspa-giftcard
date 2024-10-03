@extends('layouts.admin_layout')
@section('body')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h3 class="mb-0">Email Template</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Email Template
                        </li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<main class="app-main">

    <!--begin::App Content-->
    <div class="app-content">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <a href="{{ route('email-template.create') }}" class="btn btn-primary">Add More</a>
            <form class="mt-2" method="get" action="{{ route('ServicesSearch') }}">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-4">
                        <label for="Email Name">Template Name:</label>
                        <input type="text" class="form-control" id="Email Name" name="Email Name"
                            placeholder="Template Name">
                    </div>

                    <div class="col-md-1">
                        <input type="hidden" name="user_token" value="{{ Auth::user()->user_token }}">
                        <button type="submit" class="btn btn-success mt-4">Search</button>
                    </div>
                </div>
            </form>
            <div class="card-header">
                @if(session()->has('error'))
                    {{ session()->get('error') }}
                @endif
                @if(session()->has('success'))
                    {{ session()->get('success') }}
                @endif
            </div>
            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>
                </thead>


                <tbody>
                    @foreach($data as $key => $value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $value->title }}</td>
                            <td>
                                @if(!empty($value->image))
                                    <image src="{{ $value->image }}" height="100px" width="100px">
                                @endif
                            </td>
                            <td>{{ substr($value->message_email, 0, 100) }}</td>

                            <td>{{ $value->status == 1 ? 'Active' : 'Deactive' }}
                            </td>
                            <td><a href="{{ route('email-template.edit', $value->id) }}"
                                    class="btn btn-primary"><i class="bx bx-pencil"></i>Edit </a>
                                <form method="post"
                                    action="{{ route('email-template.destroy', $value->id) }}">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('Are You sure')"><i
                                            class="bx bx-trash-alt"></i>Delete</button>

                                </form>
                            </td>
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
</main>
@endsection

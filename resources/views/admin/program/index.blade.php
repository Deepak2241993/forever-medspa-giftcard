@extends('layouts.admin_layout')
@section('body')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>All Program</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ url('/root') }}">Home</a></li>
                    <li class="breadcrumb-item active">All Program</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content-header">
    <a href="{{ route('program.create') }}"  class="btn btn-block btn-outline-primary">Add More</a>
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
                                    <th>Program Name</th>
                                    <th>Unit Name</th>
                                    <th>Selling Price</th>
                                    <th>Terms & Conditions</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Prorgam 1 </td>
                                    <td>Xeomin – A Natural Choice – Black Friday 10% Off</td>
                                    <td>$15.00
                                    <td>Terms &Condition's 1 </td>
                                    <td> Active </td>
                                    <td>
                                        <a href="#"
                                             class="btn btn-block btn-outline-primary">Edit</a>
                                        <form
                                            action="#"
                                            method="POST">
                                            @method('DELETE')
                                            
                                              @csrf
                                            <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                
                                    <!-- Button trigger modal -->
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Prorgam 2 </td>
                                    <td>Dysport – Refresh Your Look – Black Friday 10% Off</td>
                                    <td>$20.00
                                    <td>Terms &Condition's 2 </td>
                                    <td> Active </td>
                                    <td>
                                        <a href="#"
                                             class="btn btn-block btn-outline-primary">Edit</a>
                                        <form
                                            action="#"
                                            method="POST">
                                            @method('DELETE')
                                            
                                              @csrf
                                            <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Prorgam 3 </td>
                                    <td>Botox – Smooth Fine Lines – Black Friday 10% Off</td>
                                    <td>$25.00
                                    <td>Terms &Condition's 3 </td>
                                    <td> Inactive </td>
                                    <td>
                                        <a href="#"
                                             class="btn btn-block btn-outline-primary">Edit</a>
                                        <form
                                            action="#"
                                            method="POST">
                                            @method('DELETE')
                                            
                                              @csrf
                                            <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                {{-- @foreach($result as $key=>$value)
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
                                            <a href="{{ route('banner.edit', $value->id) }}"
                                                 class="btn btn-block btn-outline-primary">Edit</a>
                                            <form
                                                action="{{ route('banner.destroy', $value->id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                
                                                  @csrf
                                                <button  class="btn btn-block btn-outline-danger" type="submit">Delete</button>
                                            </form>
                                        </td>


                                        <!-- Button trigger modal -->
                                    </tr>
                                @endforeach --}}
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

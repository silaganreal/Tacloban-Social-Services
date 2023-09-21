@extends('layouts.tmp')

@section('externalcss')
<style>
#imageUpload {
    display: none;
}

#profileImage {
    cursor: pointer;
}

#profile-container {
    width: 200px;
    height: 200px;
    margin-left: auto;
    margin-right: auto;
}

#profile-container img {
    width: 200px;
    height: 200px;
    border-radius: 15px;
}
</style>
<script src="{{asset('dist/js/ajax-jquery.min.js')}}"></script>
@endsection

@section('navlink')
<?php
    $link_clients = 'active';
?>
@endsection

@section('content')
<div class="content-wrapper">

    @if (session('status'))
        <div class="col-md-12 mt-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{session('status')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    @endif

    {{-- modal add client start --}}
    <div class="modal fade" id="addClient" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert alert-info">
                    <h5 class="modal-title" id="staticBackdropLabel">Add New Client</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/addClient') }}" method="post" enctype="multipart/form-data">
                    {{-- <form action="/addClient" method="post" enctype="multipart/form-data"> --}}
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-4"></div>
                            <div class="col-md-4">
                                <div class="form-group align-items-center">
                                <!--------------------------------------Upload Photo----------------------------------------------------------->

                                    <div id="profile-container">
                                    <img id="profileImage" src="{{asset('/img/default.png')}}" />
                                    </div>
                                    <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required accept="image/*" capture><br>
                                    <script type="text/javascript">
                                        $("#profileImage").click(function(e) {
                                            $("#imageUpload").click();
                                        });

                                        function fasterPreview( uploader ) {
                                            if ( uploader.files && uploader.files[0] ){
                                                $('#profileImage').attr('src', window.URL.createObjectURL(uploader.files[0]) );
                                            }
                                        }

                                        $("#imageUpload").change(function(){
                                            fasterPreview( this );
                                        });
                                    </script>
                                <!--------------------------------------Upload Photo----------------------------------------------------------->
                                </div>
                            </div>
                            <div class="col-md-4"></div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="text" name="fname" class="form-control" placeholder="First name" oninput="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Middle Name</label>
                                    <input type="text" name="mname" class="form-control" placeholder="Middle name" oninput="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="lname" class="form-control" placeholder="Last name" oninput="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Birthday</label>
                                    <input type="date" name="birthday" class="form-control" placeholder="Birthday" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div> --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Mobile No.</label>
                                    <input type="number" name="mobileNo" class="form-control" placeholder="Mobile No." required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Barangay</label>
                                    <select name="barangay" class="form-control" required>
                                        <option value="" selected>-- Select Barangay --</option>
                                        @if(isset($barangays))
                                            @foreach ($barangays as $barangay)
                                            <option value="{{$barangay->barangay}}">{{$barangay->barangay}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Barangay</label>
                                    <select name="barangay" class="form-control" required>
                                        <option value="" selected>-- Select Barangay --</option>
                                        @if(isset($barangays))
                                            @foreach ($barangays as $barangay)
                                            <option value="{{$barangay->barangay}}">{{$barangay->barangay}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div> --}}
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>House No./St. Name</label>
                                    <input type="text" name="houseNoStName" class="form-control" placeholder="House No./St. Name" required>
                                </div>
                            </div> --}}
                        </div>
                        <button type="submit" class="btn btn-sm btn-info">Save</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal add client end --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-auto">
                    <h1 class="m-0">Clients</h1>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addClient">Add New Client</button>
                </div>
                <div class="col-sm-8" style="margin-left:10%;">
                    <form method="GET" action="{{ url('search') }}">
                        <div class="form-row">
                            <div class="col">
                                <input type="text" name="sfname" class="form-control" placeholder="First name">
                            </div>
                            <div class="col">
                                <input type="text" name="slname" class="form-control" placeholder="Last name">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-sm btn-primary" style="margin-top: .2rem;">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    {{-- <th scope="col" style="width: 60px;">#</th> --}}
                                    <th scope="col">Name</th>
                                    <th scope="col">Address</th>
                                    {{-- <th scope="col">Gender</th> --}}
                                    <th scope="col">Mobile No.</th>
                                    <th scope="col" style="text-align:right;padding-right:20px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($clients))
                                    @foreach($clients as $client)
                                        <?php
                                        $fullname = $client->fname .' '. $client->mname .' '. $client->lname;
                                        // $address = $client->barangay .' - '. $client->houseNoStName;
                                        ?>
                                        <tr>
                                            {{-- <td>{{  }}</td> --}}
                                            <td>{{$fullname}}</td>
                                            <td>{{$client->barangay}}</td>
                                            {{-- <td>{{$client->gender}}</td> --}}
                                            <td>{{$client->mobileNo}}</td>
                                            <td style="text-align:right;padding-right:20px;">
                                                <a href="{{ url('/viewClient/'.$client->id) }}" class="btn btn-sm btn-info">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {!! $clients->links() !!}
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

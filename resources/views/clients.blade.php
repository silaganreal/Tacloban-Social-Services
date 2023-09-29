@extends('layouts.tmp')

@section('externalcss')
    <link rel="stylesheet" href="{{ asset('dist/css/profile-photo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css">
    <style>
        .btn-orange {
            background-color:#ff751a;
            color:white;
        }
    </style>
@endsection

@section('navlink')
<?php
    $link_clients = 'active';
    $link_medicines = '';
    $link_household = '';
    $link_logs = '';
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
        @if (session('mtrue'))
            <div class="col-md-12 mt-2">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{session('mtrue')}}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
        @endif
        @if (session('mfalse'))
            <div class="col-md-12 mt-2">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{session('mfalse')}}</strong>
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
                            @csrf
                            <div class="row mb-2">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div class="form-group align-items-center">
                                    <!--------------------------------------Upload Photo----------------------------------------------------------->
                                        <div id="profile-container">
                                            <img id="profileImage" src="{{asset('/img/default.png')}}" />
                                        </div>
                                        <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" required capture><br>
                                    <!--------------------------------------Upload Photo----------------------------------------------------------->
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control" placeholder="First name" oninput="this.value=this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" name="mname" class="form-control" placeholder="Middle name" oninput="this.value=this.value.toUpperCase()">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control" placeholder="Last name" oninput="this.value=this.value.toUpperCase()" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="">-- Select Gender --</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Birthday</label>
                                        <input type="date" name="birthday" class="form-control" placeholder="Birthday" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Mobile No.</label>
                                        <input type="number" name="mobileNo" class="form-control" placeholder="Mobile No." required>
                                    </div>
                                </div>
                                <div class="col-md-3">
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
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-control" required>
                                            <option value="" selected>Select Category</option>
                                            <option value="PWD">PWD</option>
                                            <option value="Senior Citizen">Senior Citizen</option>
                                            <option value="Solo Parent">Solo Parent</option>
                                            <option value="Fisherman">Fisherman</option>
                                            <option value="Farmer">Farmer</option>
                                            <option value="4Ps">4Ps</option>
                                            <option value="Market Vendor">Market Vendor</option>
                                            <option value="Resident">Resident</option>
                                        </select>
                                    </div>
                                </div>
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
                        <form method="GET" action="{{ url('/search') }}">
                            <div class="form-row">
                                <div class="col">
                                    <input type="text" name="slname" class="form-control" placeholder="Last name">
                                </div>
                                <div class="col">
                                    <input type="text" name="sfname" class="form-control" placeholder="First name">
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
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Recent Service</th>
                                        <th scope="col">Service Date/Time</th>
                                        <th scope="col">Members</th>
                                        <th scope="col" style="text-align:right;padding-right:20px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($clients))
                                        @foreach($clients as $index => $client)
                                            <?php
                                            $cID = $client->id;
                                            $fullname = $client->fname .' '. $client->mname .' '. $client->lname;
                                            ?>
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $fullname }}</td>
                                                <td>{{ $client->barangay }}</td>
                                                <td>
                                                    @foreach ($client->recentService as $services)
                                                        {{ $services->service }}
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @foreach ($client->recentService as $services)
                                                        {{ $services->dateTime }}
                                                    @endforeach
                                                </td>
                                                <td>{{ $client->memberCount }}</td>
                                                <td style="text-align:right;padding-right:20px;">
                                                    @if(Auth::user()->accountType == 'admin' || Auth::user()->accountType == 'cswdo' || Auth::user()->accountType == 'masa')
                                                        @if ($client->householdID == '')
                                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#makeMember{{ $cID }}">Household</button>
                                                            {{-- modal Make Member start --}}
                                                            <div class="modal fade" id="makeMember{{$cID}}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header alert alert-info">
                                                                            <h5 class="modal-title" id="staticBackdropLabel">Make Member - {{ $fullname }}</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ url('/newHholdStat2') }}" method="post" style="text-align: left;">
                                                                                @csrf
                                                                                <div class="row mb-1">
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label>Household No.</label>
                                                                                            <select name="hhNumber2" class="form-control selectizeHH">
                                                                                                <option value="">Select Household No.</option>
                                                                                                @foreach($hhMember as $hhMem)
                                                                                                    <option value="{{ $hhMem->householdNumber }}">{{ $hhMem->householdNumber }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Relation</label>
                                                                                            <select name="relation2" class="form-control" required>
                                                                                                <option value="">Select Relation</option>
                                                                                                <option value="Son">Son</option>
                                                                                                <option value="Daughter">Daughter</option>
                                                                                                <option value="Father">Father</option>
                                                                                                <option value="Mother">Mother</option>
                                                                                                <option value="Brother">Brother</option>
                                                                                                <option value="Sister">Sister</option>
                                                                                                <option value="Niece">Niece</option>
                                                                                                <option value="Nephew">Nephew</option>
                                                                                                <option value="Granddaughter">Granddaughter</option>
                                                                                                <option value="Grandson">Grandson</option>
                                                                                                <option value="Grandmother">Grandmother</option>
                                                                                                <option value="Grandfather">Grandfather</option>
                                                                                                <option value="Uncle">Uncle</option>
                                                                                                <option value="Aunt">Aunt</option>
                                                                                                <option value="Cousin">Cousin</option>
                                                                                                <option value="Common Law Wife">Common Law Wife</option>
                                                                                                <option value="Common Law Husband">Common Law Husband</option>
                                                                                                <option value="Mother In-Law">Mother In-Law</option>
                                                                                                <option value="Father In-Law">Father In-Law</option>
                                                                                                <option value="Son In-Law">Son In-Law</option>
                                                                                                <option value="Daughter In-Law">Daughter In-Law</option>
                                                                                                <option value="Sister In-Law">Sister In-Law</option>
                                                                                                <option value="Brother In-Law">Brother In-Law</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Educational Attainment</label>
                                                                                            <select name="educAttain2" class="form-control" required>
                                                                                                <option value="">Select Educational Attainment</option>
                                                                                                <option value="College Graduate">College Graduate</option>
                                                                                                <option value="College Undergraduate">College Undergraduate</option>
                                                                                                <option value="High School Graduate">High School Graduate</option>
                                                                                                <option value="High School Undergraduate">High School Undergraduate</option>
                                                                                                <option value="Elementary Graduate">Elementary Graduate</option>
                                                                                                <option value="Elementary Undergraduate">Elementary Undergraduate</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Occupation</label>
                                                                                            <input type="text" name="occupation2" class="form-control" placeholder="Occupation">
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label>Income</label>
                                                                                            <input type="number" name="income2" class="form-control" placeholder="Annual Income">
                                                                                        </div>
                                                                                        <input type="hidden" name="hhtype2" value="Member">
                                                                                        <input type="hidden" name="hhcID2" value="{{ $cID }}">
                                                                                        <input type="hidden" name="hhcName2" value="{{ $fullname }}">
                                                                                    </div>
                                                                                </div>
                                                                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                                                            </form>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- modal Make Member end --}}
                                                        @elseif ($client->householdID != '')
                                                            <a href="{{ url('view-members/'.$client->householdID) }}" class="btn btn-sm btn-orange">Members</a>
                                                        @endif
                                                    @endif
                                                    <a href="{{ url('viewClient/'.$client->id) }}" class="btn btn-sm btn-primary">View Services</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                            {!! $clients->withQueryString()->links('pagination::bootstrap-5') !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('externaljs')
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

        $(document).ready(function() {
            $('.selectizeHH').selectize({
                sortField: 'text'
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
@endsection

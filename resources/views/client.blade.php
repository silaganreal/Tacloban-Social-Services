@extends('layouts.tmp')

@section('externalcss')
    <link rel="stylesheet" href="{{ asset('dist/css/profile-photo.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css">
    @if (Auth::user()->accountType != 'dhc')
        <style>
            #div_medicine {
                display: none;
            }
        </style>
    @endif
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

        <?php
            $fullname = $client->fname .' '. $client->mname .' '. $client->lname;
            $address = $client->barangay .' - '. $client->houseNoStName;
            $age = floor((time() - strtotime($client->birthday)) / (60*60*24*365));
        ?>

        {{-- modal add-service start --}}
        <div class="modal fade" id="addHistory" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header alert alert-info">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Service - {{ $fullname }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{-- <form action="{{ url('/addHistory') }}" method="post"> --}}
                        <form id="addServices">
                            @csrf
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    @if(Auth::user()->accountType == 'admin')
                                    <div class="form-group">
                                        <label>Office</label>
                                        <select name="office" id="sel_office" class="form-control" required>
                                            <option value="">-- Select Office --</option>
                                            @foreach($offices as $office)
                                                <option value="{{ $office->office }}">{{ $office->office }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Service</label>
                                        <select name="service" id="sel_service" class="form-control" required>
                                            <option value="">-- Select Service --</option>
                                        </select>
                                    </div>
                                    @endif
                                    @if (Auth::user()->accountType == 'cswdo')
                                        <input type="hidden" name="office" id="sel_office" value="CSWDO">
                                        <div class="form-group">
                                            <label>Service</label>
                                            <select name="service" id="sel_service" class="form-control" required>
                                                <option value="">-- Select Service --</option>
                                                @foreach ($cswdoServices as $cswdoServ)
                                                    <option value="{{ $cswdoServ->service }}">{{ $cswdoServ->service }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if (Auth::user()->accountType == 'dhc')
                                        @if(Auth::user()->username == 'tacital')
                                            <input type="hidden" name="office" id="sel_office" value="TCH">
                                        @else
                                            <input type="hidden" name="office" id="sel_office" value="CHO">
                                        @endif
                                        <div class="form-group">
                                            <label>Service</label>
                                            <select name="service" id="sel_service" class="form-control" required>
                                                <option value="">-- Select Service --</option>
                                                @foreach ($dhcServices as $dhcServ)
                                                    <option value="{{ $dhcServ->service }}">{{ $dhcServ->service }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    @if (Auth::user()->accountType == 'dhc')
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" id="serviceDate" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Time</label>
                                            <input type="time" id="serviceTime" class="form-control" required>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if (Auth::user()->accountType == 'cswdo' || Auth::user()->accountType == 'admin')
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Amount <small class="text-info"><i>(Leave blank if not needed)</i></small></label>
                                                <input type="number" id="amount" class="form-control" placeholder="Amount">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Reference No. <small class="text-info"><i>(Leave blank if not needed)</i></small></label>
                                                <input type="text" id="reference" class="form-control" placeholder="Reference No.">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <input type="hidden" name="type" id="type" value="{{ Auth::user()->name }}">
                                    <div class="form-group">
                                        <label>Assisted By</label>
                                        <input type="text" id="assisstedBy" class="form-control" placeholder="Assisted By" oninput="this.value=this.value.toUpperCase()" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea id="remarks" class="form-control" rows="2" required placeholder="Remarks"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div id="div_medicine" style="border:1px solid#ccc!important;padding:10px;margin:10px;">
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Diagnosis</label>
                                        <input type="text" id="diagnosis" class="form-control" placeholder="Diagnosis">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-5">
                                        <label>Medicine</label>
                                        {{-- <select id="medicine" multiple class="form-control"> --}}
                                        <select id="medicine" class="form-control">
                                            <option value="">Select Medicine</option>
                                            @foreach ($medlist as $medlist)
                                                <option value="{{ $medlist->medicine }}">{{ $medlist->medicine }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-5">
                                        <label>Treatment</label>
                                        <input type="text" id="treatment" class="form-control" placeholder="Treatment">
                                    </div>
                                    <div class="col-md-2">
                                        <label>Pieces</label>
                                        <input type="number" id="medpieces" class="form-control" placeholder="Pieces">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12" style="text-align:right;">
                                        <button type="button" id="addMedicine" class="btn btn-sm btn-info">Add Medicine</button>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-hovered table-striped dtable2">
                                        <thead>
                                            <tr>
                                                {{-- <th>Diagnosis</th> --}}
                                                <th>Medicine</th>
                                                <th>Treatment</th>
                                                <th>Pieces</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="dynameTable">
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <input type="hidden" id="clientID" value="{{ $client->id }}">
                            <button type="button" id="btnAddService" class="btn btn-sm btn-info mt-4">Save Service</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal add-service end --}}

        {{-- modal add-log start --}}
        <div class="modal fade" id="addLog" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert alert-primary">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Log - {{ $fullname }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/addLog') }}" method="post">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="logDate" class="form-control" placeholder="Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input type="time" name="logTime" class="form-control" placeholder="Time" required>
                                    </div>
                                    <input type="hidden" name="logPlaceEvent" value="{{ Auth::user()->name }}">
                                    {{-- <div class="form-group">
                                        <label>Place/Event</label>
                                        <input type="text" name="logPlaceEvent" class="form-control" placeholder="Enter Place/Event" required>
                                    </div> --}}
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea name="logRemarks" class="form-control" rows="2" placeholder="Enter Remarks" required></textarea>
                                    </div>
                                    <input type="hidden" name="logclientID" value="{{ $client->id }}">
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
        {{-- modal add-log end --}}

        {{-- modal make leader start --}}
        <div class="modal fade" id="makeLeader" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header alert alert-primary">
                        <h5 class="modal-title" id="staticBackdropLabel">Make Leader - {{ $fullname }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/addLog') }}" method="post">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="logDate" class="form-control" placeholder="Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Time</label>
                                        <input type="time" name="logTime" class="form-control" placeholder="Time" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Place/Event</label>
                                        <input type="text" name="logPlaceEvent" class="form-control" placeholder="Enter Place/Event" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea name="logRemarks" class="form-control" rows="2" placeholder="Enter Remarks" required></textarea>
                                    </div>
                                    <input type="hidden" name="logclientID" value="{{ $client->id }}">
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
        {{-- modal make leader end --}}

        {{-- modal edit-info start --}}
        <div class="modal fade" id="editInfo" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header alert alert-warning">
                        <h5 class="modal-title" id="staticBackdropLabel">Edit Info - {{ $fullname }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('updateClient/'.$client->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row mb-1">
                                <div class="col-md-3">
                                    <!--------------------------------------Upload Photo----------------------------------------------------------->
                                        <div id="profile-container">
                                            @if ($client->profile != '')
                                                <img id="profileImage" src="{{ asset('/img/'.$client->profile) }}" />
                                            @else
                                                <img id="profileImage" src="{{ asset('/img/default.png') }}" />
                                            @endif
                                        </div>
                                        <input id="imageUpload" type="file" name="profile_photo" placeholder="Photo" capture><br>
                                    <!--------------------------------------Upload Photo----------------------------------------------------------->
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" name="fname" class="form-control" value="{{ $client->fname }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" name="mname" class="form-control" value="{{ $client->mname }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" name="lname" class="form-control" value="{{ $client->lname }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Birthday</label>
                                        <input type="date" name="birthday" class="form-control" value="{{ $client->birthday }}" required>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control" required>
                                            <option value="{{ $client->gender }}">{{ $client->gender }}</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Marital Status</label>
                                        <select name="maritalStatus" class="form-control">
                                            <option value="{{ $client->maritalStatus }}">{{ $client->maritalStatus }}</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Common Law Wife">Common Law Wife</option>
                                            <option value="Common Law Husband">Common Law Husband</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Occupation</label>
                                        <input type="text" name="occupation" class="form-control" value="{{ $client->occupation }}">
                                    </div>
                                    <div class="form-group">
                                        <label>Mobile No.</label>
                                        <input type="number" name="mobileNo" class="form-control" value="{{ $client->mobileNo }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Barangay</label>
                                        <select name="barangay" class="form-control" required>
                                            <option value="{{ $client->barangay }}" selected>{{ $client->barangay }}</option>
                                            @if(isset($barangays))
                                                @foreach ($barangays as $barangay)
                                                <option value="{{$barangay->barangay}}">{{$barangay->barangay}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select name="category" class="form-control" required>
                                            <option value="{{ $client->category }}" selected>{{ $client->category }}</option>
                                            <option value="PWD">PWD</option>
                                            <option value="Senior Citizen">Senior Citizen</option>
                                            <option value="Solo Parent">Solo Parent</option>
                                            <option value="Fisherman">Fisherman</option>
                                            <option value="Farmer">Farmer</option>
                                            <option value="4Ps">4Ps</option>
                                            <option value="Market Vendor">Market Vendor</option>
                                            <option value="Others">Others</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Name of Spouse/Live-In Partner</label>
                                        <input type="text" name="spouse" class="form-control" value="{{ $client->spouse }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    <h4>In case of emergency:</h4>
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="emergencyName" class="form-control" value="{{ $client->emergencyName }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group" style="margin-top:36px;">
                                        <label>Mobile No.</label>
                                        <input type="number" name="emergencyNumber" class="form-control" value="{{ $client->emergencyNumber }}">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-sm btn-warning">Update</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal edit-info end --}}

        {{-- modal add indigency start --}}
        <div class="modal fade" id="addIndigency" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header alert alert-info">
                        <h5 class="modal-title" id="staticBackdropLabel">Make Indigency - {{ $fullname }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('/addIndigency') }}" method="post">
                            @csrf
                            <div class="row mb-1">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Source of Income</label>
                                        <input type="text" name="sourceIncome" class="form-control" placeholder="Source of Income" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Total Family Income</label>
                                        <input type="number" name="income" class="form-control" placeholder="Total Family Income" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Needs</label>
                                        <input type="text" name="needs" class="form-control" placeholder="Needs" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Services Offered</label>
                                        <input type="text" name="services" class="form-control" placeholder="Services to Avail" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Financial Assisstance</label>
                                        <input type="number" name="financialAmount" class="form-control" placeholder="Financial Assisstance (Amount)" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Brief case findings/Social Case Study Report Dated</label>
                                        <input type="date" name="bcfscsr" class="form-control" placeholder="Brief case findings/Social Case Study Report Dated" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Assissted By</label>
                                        <input type="text" name="assisstedBy" class="form-control" value="{{ Auth::user()->user_name }}" required>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="indigencyClientID" value="{{ $client->id }}">
                            <input type="hidden" name="type" id="type" value="{{ Auth::user()->name }}">
                            <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are all the info entered correct?')">Submit</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal add indigency end --}}

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-2">
                        <h1 class="m-0">View Client</h1>
                    </div>
                    {{-- <div class="col-auto">
                        <a href="{{ url('printClient/'.$client->id) }}" class="btn btn-sm btn-primary">Print Certificates</a>
                    </div> --}}
                    {{-- <div class="col-auto">
                        <a href="{{ url('printBCfindings/'.$client->id) }}" class="btn btn-sm btn-primary">Print Brief Case Findings</a>
                    </div> --}}
                    <div class="col" style="text-align:right">
                        <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="content">
            <div class="container-fluid">
                <div class="row">

                    {{-- services start --}}
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">User Services</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-striped table-hover dtable1 display" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Office</th>
                                                    <th>Service</th>
                                                    <th>Date</th>
                                                    <th>Remarks</th>
                                                    <th style="text-align:center;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($histories as $history)
                                                    <tr>
                                                        <td>{{ $history->office }}</td>
                                                        <td>{{ $history->service }}</td>
                                                        <td>{{ $history->dateTime }}</td>
                                                        <td>{{ $history->remarks }}</td>
                                                        <td style="text-align:center;">
                                                            <a href="{{ url('viewService/'.$history->id) }}" class="btn btn-sm btn-info">View</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addHistory">Add Service</button>
                            </div>
                        </div>
                    </div>
                    {{-- services end --}}

                    {{-- logs start --}}
                    {{-- @if (Auth::user()->accountType == 'admin' || Auth::user()->accountType == 'dhc')
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">User Logs</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover dtable1 display" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th style="width:150px;">Date</th>
                                                    <th>Place/Event</th>
                                                    <th>Remarks</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($logs as $log)
                                                    <tr>
                                                        <td>{{ $log->dateTime }}</td>
                                                        <td>{{ $log->placeEvent }}</td>
                                                        <td>{{ $log->remarks }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#addLog">Add Log</button>
                            </div>
                        </div>
                    </div>
                    @endif --}}
                    {{-- logs end --}}

                    {{-- indigency start --}}
                    @if(Auth::user()->accountType == 'admin' || Auth::user()->accountType == 'cswdo')
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Indigency</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-striped table-hover dtable2 display" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Source of Income</th>
                                                    <th>Total Family Income</th>
                                                    <th>Needs</th>
                                                    <th>Services to Avail</th>
                                                    <th>Financial Amount</th>
                                                    <th>Assisted By</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($indigencies as $indigency)
                                                <tr>
                                                    <td>{{ $indigency->sourceOfIncome }}</td>
                                                    <td>{{ $indigency->totalFamilyIncome }}</td>
                                                    <td>{{ $indigency->needs }}</td>
                                                    <td>{{ $indigency->servicesToAvail }}</td>
                                                    <td>{{ $indigency->financialAmount }}</td>
                                                    <td>{{ $indigency->assisstedBy }}</td>
                                                    <td style="display:flex;flex-direction:row;gap:4px;">
                                                        <a href="{{ url('printClient/'.$indigency->id) }}" class="btn btn-sm btn-info">Print</a>
                                                        <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#indID{{ $indigency->id }}">Edit</button>
                                                        {{-- modal edit indigency start --}}
                                                        <div class="modal fade" id="indID{{ $indigency->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header alert alert-primary">
                                                                        <h5 class="modal-title" id="staticBackdropLabel">Edit Indigency - {{ $fullname }}</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <form action="{{ url('editIndigency/'.$indigency->id) }}" method="post">
                                                                            @csrf
                                                                            <div class="row mb-1">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Source of Income</label>
                                                                                        <input type="text" name="sourceIncome" class="form-control" value="{{ $indigency->sourceOfIncome }}" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Total Family Income</label>
                                                                                        <input type="number" name="income" class="form-control" value="{{ $indigency->totalFamilyIncome }}" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Needs</label>
                                                                                        <input type="text" name="needs" class="form-control" value="{{ $indigency->needs }}" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Services Offered</label>
                                                                                        <input type="text" name="services" class="form-control" value="{{ $indigency->servicesToAvail }}" required>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label>Financial Assisstance</label>
                                                                                        <input type="number" name="financialAmount" class="form-control" value="{{ $indigency->financialAmount }}" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Brief case findings/Social Case Study Report Dated</label>
                                                                                        <input type="date" name="bcfscsr" class="form-control" value="{{ $indigency->bcfscsr }}" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label>Assissted By</label>
                                                                                        <input type="text" name="assisstedBy" class="form-control" value="{{ Auth::user()->user_name }}" required>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input type="hidden" name="indigencyClientID" value="{{ $client->id }}">
                                                                            <input type="hidden" name="type" id="type" value="{{ Auth::user()->name }}">
                                                                            <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('Are all the info entered correct?')">Submit</button>
                                                                        </form>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- modal edit indigency end --}}
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addIndigency">Add Indigency</button>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{-- indigency end --}}

                    {{-- household start --}}
                    {{-- @if (Auth::user()->accountType == 'admin')
                    <div class="col-md-12">
                        <div class="card card-info">
                            <div class="card-header">
                                <h3 class="card-title">Household</h3>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="table-responsive mt-2">
                                        <table class="table table-striped table-hover dtable1 display" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Barangay</th>
                                                    <th>Recent Service</th>
                                                    <th>Service Date/Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (isset($hhMembers))
                                                    @foreach ($hhMembers as $member)
                                                    <tr>
                                                        <td>{{ $member->fname .' '. $member->lname }}</td>
                                                        <td>{{ $member->barangay }}</td>
                                                        <td>
                                                            @foreach ($member->recentService as $service)
                                                                {{ $service->service }}
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            @foreach ($member->recentService as $service)
                                                                {{ $service->dateTime }}
                                                            @endforeach
                                                        </td>
                                                        <td>
                                                            <a href="{{ url('viewClient/'.$member->id) }}" class="btn btn-sm btn-primary">View Services</a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    @endif --}}
                    {{-- household end --}}

                    {{-- profile start --}}
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User Info</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <!--------------------------------------Upload Photo----------------------------------------------------------->
                                        <div id="profile-container">
                                            @if ($client->profile != '')
                                                <img src="{{ asset('/img/'.$client->profile) }}" />
                                            @else
                                                <img src="{{ asset('/img/default.png') }}" />
                                            @endif
                                        </div>
                                        <!--------------------------------------Upload Photo----------------------------------------------------------->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" class="form-control" value="{{ $fullname }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Address</label>
                                            <input type="text" class="form-control" value="{{ $address}}">
                                        </div>
                                        <div class="form-group">
                                            <label>Gender</label>
                                            <input type="text" class="form-control" value="{{ $client->gender }}">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Birthday</label>
                                            <input type="text" class="form-control" value="{{ $client->birthday }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Contact</label>
                                            <input type="text" class="form-control" value="{{ $client->mobileNo .' - '. $client->email }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Category</label>
                                            <input type="text" class="form-control" value="{{ $client->category }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editInfo">Edit Info</button>
                            </div>
                        </div>
                    </div>
                    {{-- profile end --}}

                </div>
            </div>
        </div>
    </div>
@endsection
@section('externaljs')
    <script>
        $(document).ready(function() {
            var i = 0;
            var medhistory = [];
            var medlist = '';

            $('#sel_office').change(function() {
                var id = $(this).val();
                $('#sel_service').find('option').not(':first').remove();

                if(id == 'CHO') {
                    $('#div_medicine').show();
                } else {
                    $('#div_medicine').hide();
                }

                $.ajax({
                    url: "{{url('/getServices/')}}" + '/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var len = 0;
                        if(response['data'] != null) {
                            len = response['data'].length;
                        }
                        if(len > 0) {
                            for(var i=0; i<len; i++) {
                                var officeID = response['data'][i].officeID;
                                var service = response['data'][i].service;
                                var option = "<option value='"+service+"'>"+service+"</option>";
                                $('#sel_service').append(option);
                            }
                        }
                    }
                });
            });

            $('#addMedicine').click(function() {
                i++;
                var clientID = $('#clientID').val();
                var diagnosis = $('#diagnosis').val();
                var treatment = $('#treatment').val();
                var medicine = $('#medicine').val();
                var pieces = $('#medpieces').val();

                if(medicine != '' && pieces != '') {
                    $('.dataTables_empty').hide();
                    $('#dynameTable').append('<tr id="row'+i+'" class="dynamic-added"><td>'+medicine+'</td><td>'+treatment+'</td><td>'+pieces+'</td><td><button type="button" id="'+i+'" class="btn btn-sm btn-danger remove_row"><i class="fas fa-trash"></i></button></td></tr>');

                    medhistory.push( {
                        id : 'row'+i,
                        // clientID : clientID,
                        // medicine : medicine.join(", "),
                        diagnosis : diagnosis,
                        treatment : treatment,
                        medicine : medicine,
                        pieces : pieces,
                    });

                    console.log(medhistory);

                    if(medlist != '') {
                        medlist = medlist + ', ' + medicine + ' - ' + pieces + ' pcs';
                    } else {
                        medlist = medicine + ' - ' + pieces + ' pcs';
                    }

                    // $('#diagnosis').val("");
                    // $('#medicine').val("");
                    $('#treatment').val("");
                    $('#medpieces').val("");
                } else {
                    // $('#diagnosis').val("");
                    // $('#medicine').val("");
                    $('#treatment').val("");
                    $('#medpieces').val("");
                    alert('Please fill all the required fields!');
                }
            });

            $(document).on('click','.remove_row', function() {
                var row_id = $(this).attr("id");
                $('#row'+row_id+'').remove();
                medhistory = $.grep(medhistory, function(data, index) {
                    return data.id != 'row'+row_id;
                });
                // console.log(medhistory);
            });

            $('#btnAddService').click(function(){
                var clientID = $('#clientID').val();
                var sel_office = $('#sel_office').val();
                var sel_service = $('#sel_service').val();
                var serviceDate = $('#serviceDate').val();
                var serviceTime = $('#serviceTime').val();
                var remarks = $('#remarks').val();
                var type = $('#type').val();
                var assisstedBy = $('#assisstedBy').val();
                var diagnosis = $('#diagnosis').val();
                var treatment = $('#treatment').val();
                var postData = {clientID, sel_office, sel_service, serviceDate, serviceTime, remarks, type, assisstedBy, diagnosis, medlist, treatment, medhistory};

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: "<?php echo url('/addService'); ?>",
                    method: "post",
                    data: postData,
                    type: 'json',
                    success:function(data)
                    {
                        if(data.error){
                            alert(data.error);
                        } else {
                            i=1;
                            $('.dynamic-added').remove();
                            $('#addServices')[0].reset();
                            $('#addHistory').modal('hide');
                            alert('Record has been saved!');
                            location.reload();
                        }
                    }
                });
            });

            $('#medicine').selectize({
                sortField: 'text'
            });
        });

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
@endsection

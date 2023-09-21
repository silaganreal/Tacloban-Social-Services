@extends('layouts.tmp')

@section('externalcss')
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

    @foreach ($qclient as $client)
        <?php
            $dday = date('d');
            $dmonth = date('m');
            $monthName = date('F', mktime(0, 0, 0, $dmonth, 10));
            $dyear = date('Y');
            $fulldate = date('Y-m-d');
            $fullname = $client->fname .' '. $client->mname .' '. $client->lname;
            $age = floor((time() - strtotime($client->birthday)) / (60*60*24*365));

            if($client->profile == '') {
                $profilePic = '';
            } else {
                $profilePic = $client->profile;
            }
        ?>
    @endforeach

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-auto">
                    <h1 class="m-0">Print Brief Case Findings - {{ $fullname }}</h1>
                </div>
                <div class="col-auto">
                    <button class="btn btn-sm btn-success" onclick="window.print()">Print</button>
                </div>
                <div class="col" style="text-align:right;padding-right:20px;">
                    <a href="{{ url('viewClient/'. $client->id) }}" class="btn btn-sm btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-12"><br>
                <div class="row">
                    <div class="col-md-3" style="text-align: right">
                        <img src="{{ asset('img/tac-logo.png') }}" alt="Tacloban Logo" height="170" width="170">
                    </div>
                    <div class="col-md-6" style="text-align:center">
                        <span>Republic of the Philippines</span><br>
                        <span style=""><b>City Government of Tacloban</b></span><br>
                        <span><b>City Social Welfare and Development Office</b></span><br>
                        <p>Tacloban City</p>
                    </div>
                    {{-- <div class="col-md-3" style="text-align: left">
                        <img src="{{ asset('img/'. $profilePic) }}" alt="Client Profile" height="170" width="170">
                    </div> --}}
                </div>
                <div class="row mt-3">
                    <div class="col-md-10 offset-1">
                        <p><b>Date: __<u>{{ $fulldate }}</u>__</b></p>
                    </div>
                    <div class="col-md-12" style="text-align: center">
                        <p style="font-size: 25px;font-weight:bold;">BRIEF CASE FINDINGS</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-1">
                        <div style="width: 100%;background-color:beige;font-size:19px;">
                            <p>
                                <span style="font-weight:bold;font-size:20px;"><span>I.</span><span style="margin-left:60px;">Identifying Information</span></span><br>
                                <span style="margin-left:70px;">Name: <u>{{ $fullname }}</u></span><br>
                                <span style="margin-left:70px;">Age: <u>{{ $age }}</u></span><br>
                                <span style="margin-left:70px;">Address: <u>{{ $client->barangay }}</u></span><br>
                                <span style="margin-left:70px;">Contact Number: ____<u>{{ $client->mobileNo }}</u>____</span><br>
                                <span style="margin-left:70px;">Occupation: ______________</span><br>
                            </p>
                            <p>
                                <span style="font-weight:bold;font-size:20px;"><span>II.</span><span style="margin-left:60px;">Family Composition</span></span><br>
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Age</th>
                                            <th>Relation to Client</th>
                                            <th>Educational Attainment</th>
                                            <th>Occupation</th>
                                            <th>Income</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($members as $member)
                                            <?php
                                                $mfullname = $member->fname .' '. $member->lname;
                                                $mage = floor((time() - strtotime($member->birthday)) / (60*60*24*365));
                                            ?>
                                            <tr>
                                                <td>{{ $mfullname }}</td>
                                                <td>{{ $mage }}</td>
                                                <td>{{ $member->relation }}</td>
                                                <td>{{ $member->educationAttain }}</td>
                                                <td>{{ $member->occupation }}</td>
                                                <td>{{ $member->income }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </p>
                        </div>
                    </div>
                </div>
            </div><br><br>
        </div>
    </div>

</div>
@endsection

@section('externaljs')
@endsection

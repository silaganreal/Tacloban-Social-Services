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
        $fullname = $client->fname .' '. $client->mname .' '. $client->lname;
        $age = floor((time() - strtotime($client->birthday)) / (60*60*24*365));

        if($client->profile == '') {
            $profilePic = '';
        } else {
            $profilePic = $client->profile;
        }
    ?>
    @endforeach

    @foreach ($indigencies as $indigency)
    <?php
        $sourceOfIncome = $indigency->sourceOfIncome;
        $totalFamilyIncome = $indigency->totalFamilyIncome;
        $needs = $indigency->needs;
        $servicesToAvail = $indigency->servicesToAvail;
        $financialAmount = $indigency->financialAmount;

        $toWordsFamIncome = NumConvert::word($totalFamilyIncome);
        $toWordsFinancial = NumConvert::word($financialAmount);
    ?>
    @endforeach

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-auto">
                    <h1 class="m-0">Print Certificates - {{ $fullname }}</h1>
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
                    <div class="col-md-3" style="text-align: left">
                        <img src="{{ asset('img/'. $profilePic) }}" alt="Client Profile" height="170" width="170">
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-12" style="text-align: center">
                        <p style="font-size: 25px;font-weight:bold;">CERTIFICATE OF INDIGENCY</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-1">
                        <div style="width: 100%;background-color:beige;font-size:19px;">
                            <p>
                                <span style="margin-left: 60px;font-size: 18px;"><b>This is to certify that ____________<u>{{ $fullname }}</u>___________, __<u>{{ $age }}</u>__</b> years old,</span><br>
                                <span>__<u>{{ $client->maritalStatus }}</u>__, ___<u>{{ $client->occupation }}</u>___, a resident of __<u>{{ $client->barangay }}</u>___, Tacloban City</span><br>
                                <span style="margin-left:1%;font-size:14px;">(marital status)</span><span style="margin-left:4%;font-size:14px;">(occupation)</span><br>
                                <span>as per Barangay certification presented.</span>
                            </p>
                            <p>
                                <span style="margin-left: 60px;">The family subsist through _____<u>{{ $sourceOfIncome }}</u>_____ and has a total family income of</span>
                                <span style="margin-left:33%;font-size:14px;">(source of income)</span><br>
                                <span>_<u>{{ $toWordsFamIncome }}</u>_, ___<u>{{ $totalFamilyIncome }}</u>___ that falls within the poverty threshold.</span><br>
                                <span style="margin-left:18%;font-size:14px;">(amount in words)</span><span style="margin-left:10%;font-size:14px;">(amount in figure)</span><br>
                                <span>As per interview, they have neither assets nor valuable belongings registered in their<span><br>
                                </span>name. Further claimed that due to their depressed economic condition, they cannot afford to</span><br>
                                <span>pay for ___________<u>{{ $needs }}</u>___________</span>
                            </p>
                            <p>
                                <span style="margin-left:60px;">Henceforth, after thorough assessment, client is classified indigent and is found eligible to</span><br>
                                <span>avail _____<u>{{ $servicesToAvail }}</u>_____ at ______<u>Tacloban City</u>______.</span><br>
                                <span style="margin-left:40%;font-size:14px;">(Name of Office/Organization)</span>
                            </p>
                            <p>
                                <span style="margin-left:60px;">Issued this __<u>{{ $dday }}</u>__ day of ___<u>{{ $monthName }}</u>___, {{ $dyear }}</span>
                            </p>
                        </div>
                    </div>
                </div><hr>
                <div class="row mt-3">
                    <div class="col-md-12" style="text-align: center">
                        <p style="font-size: 25px;font-weight:bold;">CERTIFICATE OF ELIGIBILITY</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-1">
                        <div style="width: 100%;background-color:beige;font-size:19px;">
                            <p style="margin-left: 60px;">This is to certify that __________<u><b>{{ $fullname }}</b></u>_____________</p>
                            <p>residing at ________________<u>{{ $client->barangay }}</u>____________ has been eligible for</p>
                            <p>_____<u>FINANCIAL ASSISTANCE</u>__________ after interview and brief case findings has been made.</p>
                            <p style="margin-left: 60px;">Record of the Brief case findings/Social Case Study Report dated __<u>{{ $indigency->bcfscsr }}</u>__</p>
                            <p>are in the confidential files of CSWDO.</p>
                            <p style="margin-left:60px;">Client is recommended for financial Assisstance in the amount of</p>
                            <span style="margin-left:8%;">___<u>{{ $toWordsFinancial }}</u>___,</span><span style="margin-left:30%;">____<u>{{ $financialAmount }}</u>____</span><br>
                            <span style="margin-left: 10%;">(amount in words)</span><span style="margin-left: 30%;">(amount in figures)</span><br><br>
                            <span style="margin-left:3%;">____<u>{{ $needs }}</u>____</span><br>
                            <span style="margin-left:9%;">Purpose</span><span style="margin-left:48%;">Prepared by:</span><br><br><br>
                            <span>Approved by:</span><span style="margin-left:53%;"><u>{{ $indigency->assisstedBy }}</u></span><br><br><br><br>
                            <span><b>FE CHONA A. BAHIN, RSW</b></span><br>
                            <span>City Social Welfare Officer</span>
                        </div>
                    </div>
                </div>

                {{-- <div class="row mt-5">
                    <div class="col-md-12" style="text-align: center">
                        <p style="font-size: 20px;font-weight:bold;">ACKNOWLEDGEMENT RECEIPT</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10 offset-1">
                        <div style="width: 100%;background-color:beige;font-size:16px;">
                            <div style="margin-left:60px;text-align-last: justify;">This is to acknowledge receipt the amount of</div>
                            <span>___________________________________________________ as __________________________________________________,</span><br><br>
                            <span style="margin-left: 60px;">This acknowledgement was executed to attest to the truth of the foregoing statement. Henceforth, no claim, no action</span><br>
                            <span>or demand, judicial or extra-judicial, shall prosper or any non-delivery of amount abovementioned, or of any such claim as</span><br>
                            <span>would contravene the tenor of the foregoing statement.</span><br><br>
                            <span style="font-size:18px;margin-left:60px;"><b>IN WITNESS WHEREOF</b></span><span>, I have hereunto set my hand this __<u>{{ $dday }}</u>__ day of __<u>{{ $monthName }}</u>,__<u>{{ $dyear }}</u>__ at</span><br
                        </div>
                    </div>
                </div> --}}
            </div><br><br>
        </div>
    </div>

</div>
@endsection

@section('externaljs')
@endsection

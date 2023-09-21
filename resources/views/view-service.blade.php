@extends('layouts.tmp')

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

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                @foreach ($client as $client)
                <?php
                $fullname = $client->fname .' '. $client->mname .' '. $client->lname;
                $address = $client->barangay .' - '. $client->houseNoStName;
                ?>
                <div class="col-auto">
                    <h1 class="m-0">{{ $fullname }}</h1>
                </div>
                <div class="col" style="text-align:right;margin-right:20px;">
                    <a href="{{ url('/viewClient/'.$client->id) }}" class="btn btn-sm btn-secondary">Back</a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-12">
                    <div class="card card-warning">
                        <div class="card-header">
                            <h3 class="card-title">Details</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Office</label>
                                        <input type="text" class="form-control" value="{{ $history->office }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Service</label>
                                        <input type="text" class="form-control" value="{{ $history->service }}" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>Place/Event</label>
                                        <input type="text" class="form-control" value="{{ $history->type }}" readonly>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Assissted By</label>
                                        <input type="text" class="form-control" value="{{ $history->assisstedBy }}" readonly>
                                    </div>
                                    @if(Auth::user()->accountType != 'dhc')
                                        <div class="form-group">
                                            <label>Amount</label>
                                            <input type="number" class="form-control"  value="{{ $history->amount }}" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label>Reference No.</label>
                                            <input type="text" class="form-control" value="{{ $history->reference }}" readonly>
                                        </div>
                                    @endif
                                    @if(Auth::user()->accountType == 'dhc')
                                        <div class="form-group">
                                            <label>Date/Time</label>
                                            <input type="text" class="form-control"  value="{{ $history->dateTime }}" readonly>
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <label>Remarks</label>
                                        <textarea class="form-control" rows="2" readonly>{{ $history->remarks }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Medicines</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12">
                                <h5><b>Diagnosis: <i>{{ $history->diagnosis }}</i></b></h5>
                                <div class="table-responsive mt-2">
                                    <table class="table table-striped table-hover dtable1 display" style="width:100%;">
                                        <thead>
                                            <tr>
                                                <th>Medicine</th>
                                                <th>Treatment</th>
                                                <th>Pieces</th>
                                                <th>Date/Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($medicines as $medicine)
                                                <tr>
                                                    <td>{{ $medicine->medicine }}</td>
                                                    <td>{{ $medicine->treatment }}</td>
                                                    <td>{{ $medicine->pieces }}</td>
                                                    <td>{{ $medicine->dateTime }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
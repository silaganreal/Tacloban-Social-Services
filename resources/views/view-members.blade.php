@extends('layouts.tmp')

@section('externalcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css">
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

    {{-- modal new household start --}}
    {{-- <div class="modal fade" id="newHousehold" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert alert-info">
                    <h5 class="modal-title" id="staticBackdropLabel">New Household</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/newHousehold') }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Barangay</label>
                                    <select name="hhBrgy" class="form-control selectizeBrgy">
                                        <option value="">Select Barangay</option>
                                        @foreach ($barangays as $barangay)
                                            <option value="{{ $barangay->barangay }}">{{ $barangay->barangay }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Household No.</label>
                                    <input type="text" name="hhID" class="form-control" placeholder="Household No." oninput="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-info">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- modal new household end --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-auto">
                    <h1 class="m-0">Family Composition</h1>
                </div>
                {{-- <div class="col" style="text-align:right;padding-right:20px;">
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#newHousehold">New Household</button>
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

                {{-- household start --}}
                @if (Auth::user()->accountType == 'admin')
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
                                            @if (isset($members))
                                                @foreach ($members as $member)
                                                <tr>
                                                    <td>{{ $member->fname .' '. $member->lname }}</td>
                                                    <td>{{ $member->barangay }}</td>
                                                    <td>{{ $member->recentService }}</td>
                                                    <td>{{ $member->serviceDateTime }}</td>
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
                @endif
                {{-- household end --}}

            </div>
        </div>
    </div>

</div>
@endsection

@section('externaljs')
<script>
    $(document).ready(function() {
        $('.selectizeBrgy').selectize({
            sortField: 'text'
        });
    });
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
@endsection
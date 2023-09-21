@extends('layouts.tmp')

@section('externalcss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css">
@endsection

@section('navlink')
<?php
    $link_clients = '';
    $link_medicines = '';
    $link_household = 'active';
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
    <div class="modal fade" id="newHousehold" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
    </div>
    {{-- modal new household end --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-auto">
                    <h1 class="m-0">Family Composition</h1>
                </div>
                <div class="col" style="text-align:right;padding-right:20px;">
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#newHousehold">New Household</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped dtable1 display" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Household #</th>
                                    <th scope="col">Barangay</th>
                                    <th scope="col">Members</th>
                                    <th scope="col" style="text-align:right;padding-right:20px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($households))
                                    @foreach($households as $household)
                                        <tr>
                                            <td>{{ $household->householdNumber }}</td>
                                            <td>{{ $household->barangay }}</td>
                                            <td>{{ $household->memCount }}</td>
                                            <td style="text-align:right;padding-right:20px;">
                                                <a href="{{ url('household-members/'.$household->householdNumber) }}" class="btn btn-sm btn-primary">View Members</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        {{-- {!! $medicines->withQueryString()->links('pagination::bootstrap-5') !!} --}}
                    </div>

                </div>
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
@extends('layouts.tmp')

@section('navlink')
<?php
    $link_clients = '';
    $link_medicines = '';
    $link_household = '';
    $link_logs = 'active';
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

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-2">
                    <h1 class="m-0">Logs</h1>
                </div>
                <div class="col-sm-8">
                    <form method="GET" action="{{ url('filter-logs') }}">
                        <div class="form-row">
                            <div class="col">
                                <select name="filterDHC" id="filterDHC" class="form-control">
                                    @if (isset($_GET['filterDHC']) && $_GET['filterDHC'] != '')
                                        <option value="{{ $_GET['filterDHC'] }}">{{ $_GET['filterDHC'] }}</option>
                                    @else
                                        <option value="">Select DHC</option>
                                    @endif
                                    @foreach ($dhcs as $dhc)
                                        <option value="{{ $dhc->name }}">{{ $dhc->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                @if(isset($_GET['filterDate']) && $_GET['filterDate'] != '')
                                    <input type="date" name="filterDate" id="filterDate" class="form-control" value="{{ $_GET['filterDate'] }}">
                                @else
                                    <input type="date" name="filterDate" id="filterDate" class="form-control" placeholder="Date">
                                @endif
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-sm btn-primary" style="margin-top:.2rem;">Filter Logs</button>
                                <button type="button" class="btn btn-sm btn-dark" onclick="clearSearch()" style="margin-top:.2rem">Clear</button>
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
                        <table class="table table-hover table-striped table-sm dtable1" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Date/Time</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Birthday/Age</th>
                                    <th scope="col">Gender</th>
                                    <th scope="col">Diagnosis</th>
                                    <th scope="col">Medication</th>
                                    <th scope="col">Assisted By</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($logs))
                                    @foreach($logs as $log)
                                        @php
                                            $fullname = $log->fname .' '. $log->lname;
                                            if($log->birthday != '') {
                                                $currentYear = date('Y');
                                                $birthYear = date('Y', strtotime($log->birthday));
                                                $age = $currentYear - $birthYear;
                                                $bdayAge = $log->birthday .' / '. $age;
                                            } else {
                                                $bdayAge = '';
                                            }

                                        @endphp
                                        <tr>
                                            <td>{{ $log->dateTime }}</td>
                                            <td>{{ $fullname }}</td>
                                            <td>{{ $bdayAge }}</td>
                                            <td>{{ $log->gender }}</td>
                                            <td>{{ $log->diagnosis }}</td>
                                            <td>
                                                {{ $log->treatment .' - '. $log->medicine .' - '. $log->pieces }}
                                            </td>
                                            <td>{{ $log->assisstedBy }}</td>
                                            <td>{{ $log->remarks }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        function clearSearch() {
            document.getElementById('filterDHC').value = '';
            document.getElementById('filterDate').value = '';
            window.location = './client-logs';
        }
    </script>

</div>
@endsection
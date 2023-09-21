@extends('layouts.tmp')

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

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-auto">
                    <h1 class="m-0">Household Members</h1>
                </div>
                <div class="col" style="text-align:right;padding-right:20px;">
                    <a href="{{ url('household') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive mt-2">
                        <table class="table table-striped table-hover dtable1 display" style="width:100%;">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Barangay</th>
                                    <th>Recent Service</th>
                                    <th>Service Date/Time</th>
                                    <th style="text-align:right;padding-right:45px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($members as $member)
                                    <?php
                                    $fullname = $member->fname .' '. $member->lname;
                                    $age = floor((time() - strtotime($member->birthday)) / (60*60*24*365));
                                    ?>
                                    <tr>
                                        <td>{{ $fullname }}</td>
                                        <td>{{ $member->barangay }}</td>
                                        <td>
                                            @foreach ($member->recentService as $services)
                                                {{ $services->service }}
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach ($member->recentService as $services)
                                                {{ $services->dateTime }}
                                            @endforeach
                                        </td>
                                        <td style="text-align:right;padding-right:20px;">
                                            <a href="{{ url('viewClient/'.$member->id) }}" class="btn btn-sm btn-primary">View Services</a>
                                        </td>
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
@endsection
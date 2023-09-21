@extends('layouts.tmp')

@section('navlink')
<?php
    $link_clients = '';
    $link_medicines = 'active';
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

    {{-- modal add medicine start --}}
    <div class="modal fade" id="addMedicine" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header alert alert-info">
                    <h5 class="modal-title" id="staticBackdropLabel">Add Medicine</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/addMedicine') }}" method="post">
                        @csrf
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Medicine</label>
                                    <input type="text" name="medicine" class="form-control" placeholder="Medicine" oninput="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            {{-- <div class="col-md-4">
                                <div class="form-group">
                                    <label>Unit</label>
                                    <select name="unit" class="form-control">
                                        <option value="">Select Unit</option>
                                        <option value="Bottle">Bottle</option>
                                        <option value="Ampune">Tablet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Miligram</label>
                                    <input type="number" name="miligram" class="form-control" placeholder="Miligram" oninput="this.value=this.value.toUpperCase()" required>
                                </div>
                            </div> --}}
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" oninput="this.value=this.value.toUpperCase()" required>
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
    {{-- modal add medicine end --}}

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-md-2">
                    <h1 class="m-0">Medicines</h1>
                </div>
                <div class="col"> <!-- style="text-align:right;padding-right:20px;" -->
                    <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#addMedicine">Add Medicine</button>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-sm dtable3" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">Medicine</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col" style="text-align:right;padding-right:20px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($medicines))
                                    @foreach($medicines as $medicine)
                                        <tr>
                                            <td>{{$medicine->medicine}}</td>
                                            <td>{{$medicine->quantity}}</td>
                                            <td style="text-align:right;padding-right:20px;">
                                                {{-- modal add medicine start --}}
                                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editMedicine{{ $medicine->id }}">Edit</button>
                                                <div class="modal fade" id="editMedicine{{ $medicine->id }}" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header alert alert-info">
                                                                <h5 class="modal-title" id="staticBackdropLabel">Edit Medicine - {{ $medicine->medicine }}</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ url('/editMedicine') }}" method="post" style="text-align:left;">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label>Medicine</label>
                                                                                <input type="text" name="editMed" class="form-control" value="{{ $medicine->medicine }}" oninput="this.value=this.value.toUpperCase()" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-2">
                                                                        <div class="col-md-12">
                                                                            <div class="form-group">
                                                                                <label>Quantity</label>
                                                                                <input type="number" name="editQuan" class="form-control" value="{{ $medicine->quantity }}" oninput="this.value=this.value.toUpperCase()" required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="editMedID" value="{{ $medicine->id }}">
                                                                    <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                                                </form>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- modal add medicine end --}}
                                            </td>
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

</div>
@endsection

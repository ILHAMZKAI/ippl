@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dasbor'])
<div class="row mx-4">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light">
            <div class="alert mt-n4 mb-n1 ms-n3">
                <strong>Perkebunan</strong>
            </div>
            <div>
                <button class="btn btn-success me-2"
                    onclick="window.location='{{ route('dashboard', ['sortBy' => 'id', 'sortOrder' => 'asc']) }}'">ID
                    Sort
                    Asc</button>
                <button class="btn btn-success me-2"
                    onclick="window.location='{{ route('dashboard', ['sortBy' => 'id', 'sortOrder' => 'desc']) }}'">ID
                    Sort
                    Desc</button>
                <button class="btn btn-success me-2"
                    onclick="window.location='{{ route('dashboard', ['sortBy' => 'berat', 'sortOrder' => 'asc']) }}'">Weight
                    Sort
                    Asc</button>
                <button class="btn btn-success me-2"
                    onclick="window.location='{{ route('dashboard', ['sortBy' => 'berat', 'sortOrder' => 'desc']) }}'">
                    Weight Sort
                    Desc</button>
            </div>
            <div class="p-4 m-20 mt-2 mb-n1 bg-white rounded shadow">
                <div>
                    {!! $chart->container() !!}
                </div>
            </div>
        </div>
    </div>

    <script src="{{ $chart->cdn() }}"></script>

    {{ $chart->script() }}
    @endsection

    @push('js')
    @endpush
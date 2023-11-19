@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Dasbor'])
<div class="row mx-4 me-4-1 mb-4">
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Perkebunan</strong>
            <div class="p-6 m-20 mt-2 mb-n1 bg-white rounded shadow">
                <div class="mb-4">
                    <button class="btn btn-success me-2"
                        onclick="window.location='{{ route('dashboard', ['sortBy' => 'id', 'sortOrder' => 'asc']) }}'">Sort
                        Asc</button>
                    <button class="btn btn-success"
                        onclick="window.location='{{ route('dashboard', ['sortBy' => 'id', 'sortOrder' => 'desc']) }}'">Sort
                        Desc</button>
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
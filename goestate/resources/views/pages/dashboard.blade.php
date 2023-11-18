@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
    @include('layouts.navbars.auth.topnav', ['title' => 'Dasbor'])
    <div class="row mx-4 me-4-1 mb-4">
        <div class="col-12 mx-1">
            <div class="alert1 alert-light"><strong>Perkebunan</strong> @csrf
                <div class="p-6 m-20 mt-3 bg-white rounded shadow">
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

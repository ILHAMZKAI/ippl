@extends('layouts.app', ['class' => 'g-sidenav-show bg-gray-100'])

@section('content')
@include('layouts.navbars.auth.topnav', ['title' => 'Manajemen Kebun'])
<div class="row mx-4 me-4-1">
    <style>
        .light {
            background-color: white;
            border: 2px solid black;
        }
    </style>
    <div class="col-12 mx-1">
        <div class="alert1 alert-light"><strong>Lahan Kebun</strong>
            <form action="{{ route('update-garden-management') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="num_rows">Jumlah Baris:</label>
                    <input type="number" id="num_rows" name="num_rows" min="1" value="{{ $numRows }}">
                </div>
                <div class="form-group">
                    <label for="num_columns">Jumlah Kolom:</label>
                    <input type="number" id="num_columns" name="num_columns" min="1" value="{{ $numColumns }}">
                </div>
                <button type="submit" class="btn1 btn-danger1 ms-0 mx-auto mt-n5">Update Lahan</button>
            </form>
        </div>
        <div class="card mb-4">
            <div class="card-body px-2 pt-2 pb-8">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0" style="width: 40%;">
                        <thead>
                            <div>Lahan Kebun</div>
                        </thead>
                        <div>

                            @for ($i = 0; $i < $numRows + 1; $i++)<tr>
                                @for ($j=0; $j < $numColumns; $j++) <td class="light">
                                    </td>
                                    @endfor
                                    </tr>
                                    @endfor
                        </div>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection
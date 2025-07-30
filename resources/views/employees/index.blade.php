@extends('layouts.app')

@section('buttons')
<div class="btn-toolbar mb-2 mb-md-0">
    <div>
        <a href="{{ route('employees.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus-circle me-1"></i>
            Tambah Data Pegawai
        </a>
    </div>
</div>
@endsection

@section('content')
@include('employees.table')
@endsection
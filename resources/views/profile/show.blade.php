@extends('layouts.app')

@section('title', 'Profil Saya - DapurMahasiswa')

@section('content')
    <div class="card">
        <h1>Profil Saya</h1>
        <p class="muted">
            Data ini digunakan untuk memudahkan proses pemesanan dan pengantaran catering.
        </p>

        <p>
            <strong>Nama:</strong>
            {{ auth()->user()->name }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ auth()->user()->email }}
        </p>

        <p>
            <strong>Nomor HP:</strong>
            {{ auth()->user()->phone ?? '-' }}
        </p>

        <p>
            <strong>Alamat Kos:</strong>
            <br>
            {{ auth()->user()->address ?? '-' }}
        </p>

        <div style="margin-top:18px;">
            <a href="{{ route('profile.edit') }}" class="btn">
                Edit Profil
            </a>
        </div>
    </div>
@endsection
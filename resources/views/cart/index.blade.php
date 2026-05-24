@extends('layouts.app')

@section('title', 'Keranjang - DapurMahasiswa')

@section('content')
    <h1>Keranjang</h1>

    @if(empty($cart))
        <div class="card">
            <p>Keranjang kamu masih kosong.</p>
            <a href="{{ route('menu.index') }}" class="btn">Pilih Menu</a>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cart as $key => $item)
                    <tr>
                        <td>
                            <strong>{{ $item['item_name'] }}</strong>
                            <br>
                            <span class="muted">{{ ucfirst($item['item_type']) }}</span>

                            @if($item['preference_note'])
                                <br>
                                <span class="muted">Catatan: {{ $item['preference_note'] }}</span>
                            @endif
                        </td>
                        <td>Rp{{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.update', $key) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width:80px;">
                                <button type="submit" class="btn btn-secondary">Update</button>
                            </form>
                        </td>
                        <td>Rp{{ number_format($item['total'], 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('cart.destroy', $key) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="card" style="margin-top:18px;">
            <h3>Subtotal: Rp{{ number_format($subtotal, 0, ',', '.') }}</h3>

            <a href="{{ route('checkout.index') }}" class="btn">Lanjut Checkout</a>

            <form action="{{ route('cart.clear') }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Kosongkan Keranjang</button>
            </form>
        </div>
    @endif
@endsection
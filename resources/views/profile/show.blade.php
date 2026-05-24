@extends('layouts.app')

@section('title', 'Profil Saya - DapurMahasiswa')

@section('content')
    @php
        $statusLabels = [
            'pending' => 'Pending',
            'confirmed' => 'Dikonfirmasi',
            'processing' => 'Diproses',
            'delivering' => 'Diantar',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];

        $statusStyles = [
            'pending' => 'background:#fef3c7; color:#92400e;',
            'confirmed' => 'background:#dbeafe; color:#1e40af;',
            'processing' => 'background:#ede9fe; color:#5b21b6;',
            'delivering' => 'background:#ffedd5; color:#9a3412;',
            'completed' => 'background:#dcfce7; color:#166534;',
            'cancelled' => 'background:#fee2e2; color:#991b1b;',
        ];

        $initial = strtoupper(substr($user->name ?? 'U', 0, 1));
    @endphp

    <style>
        .profile-layout {
            display: grid;
            grid-template-columns: 360px 1fr;
            gap: 24px;
            align-items: start;
        }

        .profile-card {
            background:
                radial-gradient(circle at top right, rgba(217, 155, 43, 0.15), transparent 30%),
                linear-gradient(135deg, #ffffff 0%, #edf7ef 100%);
            border: 1px solid #eee5d8;
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 24px;
            position: sticky;
            top: 106px;
        }

        .profile-avatar {
            width: 92px;
            height: 92px;
            border-radius: 28px;
            display: grid;
            place-items: center;
            background: var(--primary);
            color: #fff;
            font-size: 38px;
            font-weight: 900;
            box-shadow: 0 12px 26px rgba(31, 91, 47, 0.22);
            margin-bottom: 18px;
        }

        .profile-name {
            margin: 0 0 6px;
            color: #102d19;
            font-size: 28px;
            line-height: 1.2;
        }

        .profile-email {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .profile-role {
            display: inline-flex;
            margin-top: 14px;
            padding: 7px 12px;
            border-radius: 999px;
            background: #fff7e8;
            color: #8a5a10;
            border: 1px solid #f2d8a6;
            font-size: 13px;
            font-weight: 800;
        }

        .profile-info-list {
            display: grid;
            gap: 12px;
            margin-top: 22px;
        }

        .profile-info-item {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid #eee5d8;
        }

        .profile-info-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 5px;
        }

        .profile-info-value {
            color: var(--text);
            font-weight: 800;
            line-height: 1.5;
            word-break: break-word;
        }

        .profile-main {
            display: grid;
            gap: 22px;
        }

        .profile-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .profile-stat {
            background: #fff;
            border: 1px solid #eee5d8;
            border-radius: 20px;
            box-shadow: var(--shadow);
            padding: 18px;
        }

        .profile-stat-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 8px;
        }

        .profile-stat-value {
            color: var(--primary);
            font-size: 28px;
            font-weight: 900;
        }

        .profile-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .profile-form-grid .full {
            grid-column: 1 / -1;
        }

        .recent-orders {
            display: grid;
            gap: 12px;
            margin-top: 16px;
        }

        .recent-order-item {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 14px;
            align-items: center;
            padding: 15px;
            border-radius: 16px;
            border: 1px solid #eee5d8;
            background: #fbfaf7;
        }

        .recent-order-code {
            margin: 0 0 5px;
            color: #102d19;
            font-weight: 900;
            line-height: 1.4;
        }

        .recent-order-meta {
            margin: 0;
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
        }

        .recent-order-total {
            color: var(--primary);
            font-weight: 900;
            white-space: nowrap;
            text-align: right;
        }

        @media (max-width: 980px) {
            .profile-layout {
                grid-template-columns: 1fr;
            }

            .profile-card {
                position: static;
            }

            .profile-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 620px) {
            .profile-form-grid {
                grid-template-columns: 1fr;
            }

            .profile-stats {
                grid-template-columns: 1fr;
            }

            .recent-order-item {
                grid-template-columns: 1fr;
            }

            .recent-order-total {
                text-align: left;
            }
        }
    </style>

    <div class="page-header">
        <h1>Profil Saya</h1>
        <p>
            Kelola data akun, alamat pengantaran, dan lihat ringkasan aktivitas pesanan kamu di DapurMahasiswa.
        </p>
    </div>

    <div class="profile-layout">
        <aside class="profile-card">
            <div class="profile-avatar">
                {{ $initial }}
            </div>

            <h2 class="profile-name">
                {{ $user->name }}
            </h2>

            <p class="profile-email">
                {{ $user->email }}
            </p>

            <span class="profile-role">
                {{ $user->role === 'admin' ? 'Admin' : 'User' }}
            </span>

            <div class="profile-info-list">
                <div class="profile-info-item">
                    <div class="profile-info-label">Nomor HP</div>
                    <div class="profile-info-value">
                        {{ $user->phone ?? 'Belum diisi' }}
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="profile-info-label">Alamat Utama</div>
                    <div class="profile-info-value">
                        {{ $user->address ?? 'Belum diisi' }}
                    </div>
                </div>

                <div class="profile-info-item">
                    <div class="profile-info-label">Bergabung Sejak</div>
                    <div class="profile-info-value">
                        {{ $user->created_at->format('d M Y') }}
                    </div>
                </div>
            </div>
        </aside>

        <div class="profile-main">
            <div class="profile-stats">
                <div class="profile-stat">
                    <div class="profile-stat-label">Total Pesanan</div>
                    <div class="profile-stat-value">
                        {{ $orderStats['total'] ?? 0 }}
                    </div>
                </div>

                <div class="profile-stat">
                    <div class="profile-stat-label">Pending</div>
                    <div class="profile-stat-value">
                        {{ $orderStats['pending'] ?? 0 }}
                    </div>
                </div>

                <div class="profile-stat">
                    <div class="profile-stat-label">Diproses</div>
                    <div class="profile-stat-value">
                        {{ $orderStats['processing'] ?? 0 }}
                    </div>
                </div>

                <div class="profile-stat">
                    <div class="profile-stat-label">Selesai</div>
                    <div class="profile-stat-value">
                        {{ $orderStats['completed'] ?? 0 }}
                    </div>
                </div>
            </div>

            <div class="card">
                <h2>Edit Profil</h2>

                <p class="muted">
                    Data alamat ini juga bisa membantu mempercepat pengisian alamat saat checkout.
                </p>

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="profile-form-grid">
                        <div>
                            <label>Nama Lengkap</label>
                            <input
                                type="text"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                placeholder="Masukkan nama lengkap"
                                required
                            >
                        </div>

                        <div>
                            <label>Email</label>
                            <input
                                type="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                placeholder="Masukkan email"
                                required
                            >
                        </div>

                        <div>
                            <label>Nomor HP</label>
                            <input
                                type="text"
                                name="phone"
                                value="{{ old('phone', $user->phone) }}"
                                placeholder="Contoh: 081234567890"
                            >
                        </div>

                        <div class="full">
                            <label>Alamat Utama</label>
                            <textarea
                                name="address"
                                placeholder="Contoh: Kos Putri Melati No. 12, Jl. Merdeka, sekitar UINSU"
                            >{{ old('address', $user->address) }}</textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn" style="margin-top:18px;">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            <div class="card">
                <div class="section-head" style="margin-bottom:0;">
                    <div>
                        <h2 style="margin-bottom:8px;">Pesanan Terbaru</h2>
                        <p class="muted" style="margin:0;">
                            Tiga pesanan terakhir yang kamu buat.
                        </p>
                    </div>

                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        Lihat Semua
                    </a>
                </div>

                @if($orders->isEmpty())
                    <div class="empty-state">
                        <h3>Belum ada pesanan</h3>
                        <p class="muted">
                            Pesanan terbaru akan tampil di sini setelah kamu melakukan checkout.
                        </p>
                    </div>
                @else
                    <div class="recent-orders">
                        @foreach($orders as $order)
                            @php
                                $status = $order->status ?? 'pending';
                            @endphp

                            <div class="recent-order-item">
                                <div>
                                    <p class="recent-order-code">
                                        {{ $order->order_code }}
                                    </p>

                                    <p class="recent-order-meta">
                                        {{ $order->created_at->format('d M Y H:i') }}
                                        <br>
                                        <span class="status" style="{{ $statusStyles[$status] ?? '' }}">
                                            {{ $statusLabels[$status] ?? ucfirst($status) }}
                                        </span>
                                    </p>
                                </div>

                                <div>
                                    <div class="recent-order-total">
                                        Rp{{ number_format($order->total, 0, ',', '.') }}
                                    </div>

                                    <a href="{{ route('orders.show', $order) }}" class="btn btn-secondary" style="margin-top:8px;">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
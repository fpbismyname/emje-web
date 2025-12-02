<x-layouts.admin-app title="Dashboard">
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-title">Total pelatihan</div>
            <div class="stat-value">{{ $datas['total_pelatihan'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Total kontrak kerja</div>
            <div class="stat-value">{{ $datas['total_kontrak_kerja'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Total lamaran kontrak kerja</div>
            <div class="stat-value">{{ $datas['total_lamaran'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Total kontrak kerja diterima</div>
            <div class="stat-value">{{ $datas['total_kontrak_kerja_diterima'] }}</div>
        </div>
    </div>
    <div class="stats shadow">
        <div class="stat">
            <div class="stat-title">Total pendaftaran pelatihan</div>
            <div class="stat-value">{{ $datas['total_pendaftaran'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Total peserta lulus</div>
            <div class="stat-value">{{ $datas['total_peserta_lulus'] }}</div>
        </div>
        <div class="stat">
            <div class="stat-title">Total peserta</div>
            <div class="stat-value">{{ $datas['total_peserta'] }}</div>
        </div>
    </div>
</x-layouts.admin-app>

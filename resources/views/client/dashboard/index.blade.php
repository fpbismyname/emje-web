<x-layouts.client-app title="Dashboard">
    <div class="stats bg-base-200 w-full">
        <div class="stat text-primary">
            <div class="stat-title">Kelengkapan profil</div>
            <div class="stat-value">{{ $kelengkapan_profil }}</div>
        </div>
        <div class="stat text-secondary">
            <div class="stat-title">Kontrak tersedia</div>
            <div class="stat-value">{{ $jumlah_kontrak_kerja_saat_ini }}</div>
        </div>
        <div class="stat text-accent">
            <div class="stat-title">Pelatihan diselesaikan</div>
            <div class="stat-value">{{ $jumlah_pelatihan_lulus }}</div>
        </div>
    </div>
</x-layouts.client-app>

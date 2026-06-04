@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Cartes KPI futuristes -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="card-futur rounded-3xl p-6 border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">Utilisateurs</p>
                    <p class="text-4xl font-bold text-white mt-2">{{ number_format($stats['total_users'] ?? 0) }}</p>
                    <p class="text-emerald-400 text-sm mt-2 flex items-center gap-1"><i class="fas fa-arrow-up"></i> +12% ce mois</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-orange-500 to-orange-700 flex items-center justify-center text-2xl shadow-lg">👥</div>
            </div>
            <div class="mt-4 h-1 w-full bg-white/10 rounded-full overflow-hidden">
                <div class="h-full w-3/4 bg-gradient-to-r from-orange-500 to-orange-400 rounded-full"></div>
            </div>
        </div>

        <div class="card-futur rounded-3xl p-6 border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">Réservations</p>
                    <p class="text-4xl font-bold text-white mt-2">{{ number_format($stats['total_reservations'] ?? 0) }}</p>
                    <p class="text-emerald-400 text-sm mt-2 flex items-center gap-1"><i class="fas fa-arrow-up"></i> +18% cette semaine</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-2xl shadow-lg">🎫</div>
            </div>
            <div class="mt-4 h-1 w-full bg-white/10 rounded-full overflow-hidden">
                <div class="h-full w-2/3 bg-gradient-to-r from-emerald-500 to-teal-400 rounded-full"></div>
            </div>
        </div>

        <div class="card-futur rounded-3xl p-6 border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">Chiffre d'affaires</p>
                    <p class="text-3xl font-bold text-white mt-2">{{ number_format($stats['chiffre_affaires'] ?? 0, 0, ',', ' ') }} <span class="text-sm">FCFA</span></p>
                    <p class="text-emerald-400 text-sm mt-2 flex items-center gap-1"><i class="fas fa-arrow-up"></i> +23% ce mois</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-amber-500 to-orange-600 flex items-center justify-center text-2xl shadow-lg">💰</div>
            </div>
            <div class="mt-4 h-1 w-full bg-white/10 rounded-full overflow-hidden">
                <div class="h-full w-4/5 bg-gradient-to-r from-amber-500 to-orange-400 rounded-full"></div>
            </div>
        </div>

        <div class="card-futur rounded-3xl p-6 border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-400 text-sm uppercase tracking-wider">Taux occupation</p>
                    <p class="text-4xl font-bold text-white mt-2">{{ $stats['taux_occupation'] ?? 0 }}%</p>
                    <p class="text-cyan-400 text-sm mt-2 flex items-center gap-1"><i class="fas fa-chart-line"></i> +5% cette semaine</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-600 flex items-center justify-center text-2xl shadow-lg">📊</div>
            </div>
            <div class="mt-4 h-1 w-full bg-white/10 rounded-full overflow-hidden">
                <div class="h-full w-[{{ min(100, $stats['taux_occupation'] ?? 0) }}%] bg-gradient-to-r from-cyan-500 to-blue-400 rounded-full"></div>
            </div>
        </div>
    </div>

    <!-- Graphique et Top destinations -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 card-futur rounded-3xl p-6 border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-semibold text-white">📈 Activité récente</h3>
                <div class="flex gap-2">
                    <button class="text-xs px-3 py-1 rounded-full bg-white/10 text-gray-300 hover:bg-white/20 transition">Semaine</button>
                    <button class="text-xs px-3 py-1 rounded-full bg-gradient-to-r from-orange-500 to-orange-600 text-white">Mois</button>
                    <button class="text-xs px-3 py-1 rounded-full bg-white/10 text-gray-300 hover:bg-white/20 transition">Année</button>
                </div>
            </div>
            <div class="h-72">
                <canvas id="activityChart"></canvas>
            </div>
        </div>

        <div class="card-futur rounded-3xl p-6 border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg">
            <h3 class="text-xl font-semibold text-white mb-4">🏆 Destinations top</h3>
            <div class="space-y-4">
                @forelse($topDestinations as $index => $dest)
                <div class="flex items-center justify-between p-3 rounded-2xl bg-white/5 hover:bg-white/10 transition group cursor-pointer">
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">{{ $dest['medal'] }}</span>
                        <div>
                            <p class="text-white font-medium">{{ $dest['nom'] }}</p>
                            <p class="text-xs {{ $dest['growth'] >= 0 ? 'text-emerald-400' : 'text-red-400' }}">
                                <i class="fas {{ $dest['growth'] >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }} mr-1"></i>
                                {{ abs($dest['growth']) }}% cette semaine
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="text-orange-400 font-bold text-xl">{{ number_format($dest['count']) }}</span>
                        <p class="text-xs text-gray-400">réservations</p>
                    </div>
                </div>
                @empty
                <div class="text-center text-gray-400 py-8">
                    <i class="fas fa-chart-line text-4xl mb-2 opacity-50"></i>
                    <p>Aucune réservation pour le moment</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Dernières réservations et prochains départs -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-white/10 flex justify-between items-center">
                <h3 class="font-semibold text-xl text-white">🔄 Dernières réservations</h3>
                <a href="{{ route('admin.reservations.index') }}" class="text-orange-400 hover:text-orange-300 text-sm transition">Voir tout →</a>
            </div>
            <div class="divide-y divide-white/10">
                @forelse($recentReservations as $res)
                <div class="px-6 py-4 hover:bg-white/5 transition group">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-white font-medium">{{ $res->user->name ?? 'Client' }}</p>
                            <p class="text-gray-400 text-sm">
                                <i class="fas fa-map-marker-alt text-xs mr-1"></i>
                                {{ $res->trajet->villeDepart->nom ?? '---' }} → {{ $res->trajet->villeArrivee->nom ?? '---' }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $res->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-orange-400 font-bold">{{ number_format($res->montant_total, 0, ',', ' ') }} FCFA</p>
                            <span class="text-xs px-2 py-1 rounded-full inline-block mt-1 
                                {{ $res->statut == 'confirmee' ? 'bg-emerald-500/20 text-emerald-400' : ($res->statut == 'annulee' ? 'bg-red-500/20 text-red-400' : 'bg-amber-500/20 text-amber-400') }}">
                                <i class="fas {{ $res->statut == 'confirmee' ? 'fa-check-circle' : ($res->statut == 'annulee' ? 'fa-times-circle' : 'fa-clock') }} mr-1"></i>
                                {{ ucfirst($res->statut) }}
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-ticket-alt text-4xl mb-2 opacity-50"></i>
                    <p>Aucune réservation récente</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="card-futur rounded-3xl border border-white/20 bg-gradient-to-br from-white/10 to-white/5 backdrop-blur-lg overflow-hidden">
            <div class="px-6 py-5 border-b border-white/10 flex justify-between items-center">
                <h3 class="font-semibold text-xl text-white">⏰ Prochains départs</h3>
                <a href="{{ route('admin.trajets.index') }}" class="text-orange-400 hover:text-orange-300 text-sm transition">Gérer →</a>
            </div>
            <div class="divide-y divide-white/10">
                @forelse($upcomingTrajets as $trajet)
                <div class="px-6 py-4 hover:bg-white/5 transition">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-white font-medium">
                                <i class="fas fa-bus text-orange-400 mr-2"></i>
                                {{ $trajet->villeDepart->nom ?? '---' }} → {{ $trajet->villeArrivee->nom ?? '---' }}
                            </p>
                            <p class="text-gray-400 text-sm mt-1">
                                <i class="far fa-calendar-alt mr-1"></i>
                                {{ $trajet->date_depart->format('d/m/Y') }} 
                                <i class="far fa-clock ml-2 mr-1"></i>
                                {{ $trajet->heure_depart->format('H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                <i class="fas fa-hourglass-half mr-1"></i>
                                Bus: {{ $trajet->bus->nom ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block px-3 py-1 rounded-full text-xs {{ $trajet->places_libres > 0 ? 'bg-emerald-500/20 text-emerald-400' : 'bg-red-500/20 text-red-400' }}">
                                <i class="fas fa-chair mr-1"></i>
                                {{ $trajet->places_libres }} places
                            </span>
                            <p class="text-orange-400 text-sm mt-2">
                                <i class="fas fa-money-bill-wave mr-1"></i>
                                {{ number_format($trajet->prix, 0, ',', ' ') }} FCFA
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="px-6 py-12 text-center text-gray-400">
                    <i class="fas fa-bus text-4xl mb-2 opacity-50"></i>
                    <p>Aucun trajet à venir</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($chartData);
    
    const ctx = document.getElementById('activityChart').getContext('2d');
    
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(249, 115, 22, 0.3)');
    gradient.addColorStop(1, 'rgba(249, 115, 22, 0.0)');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Réservations',
                data: chartData.data,
                borderColor: '#f97316',
                backgroundColor: gradient,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#f97316',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { labels: { color: '#cbd5e1', usePointStyle: true } },
                tooltip: {
                    backgroundColor: '#1e293b',
                    titleColor: '#f97316',
                    bodyColor: '#cbd5e1',
                    borderColor: '#f97316',
                    borderWidth: 2,
                    callbacks: {
                        label: function(context) {
                            return `📊 ${context.parsed.y} réservation${context.parsed.y > 1 ? 's' : ''}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: 'rgba(255,255,255,0.08)' },
                    ticks: { color: '#cbd5e1', stepSize: 1 }
                },
                x: {
                    grid: { color: 'rgba(255,255,255,0.05)' },
                    ticks: { color: '#cbd5e1' }
                }
            }
        }
    });
</script>

<style>
    .card-futur {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-futur:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }
    .divide-y::-webkit-scrollbar {
        width: 6px;
    }
    .divide-y::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 10px;
    }
    .divide-y::-webkit-scrollbar-thumb {
        background: rgba(249, 115, 22, 0.5);
        border-radius: 10px;
    }
</style>
@endsection
<footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-10">
            
            <!-- Colonne 1 : Logo & Description -->
            <div class="col-span-2 md:col-span-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center text-white text-3xl">
                        🚌
                    </div>
                    <div>
                        <span class="font-bold text-3xl text-white tracking-tight">Bus</span>
                        <span class="font-bold text-3xl text-orange-500 tracking-tight">Ticket</span>
                    </div>
                </div>
                <p class="text-gray-400 leading-relaxed">
                    La plateforme la plus rapide pour réserver vos billets de bus au Maroc.
                </p>
                <div class="flex gap-4 mt-8">
                    <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-600 transition rounded-2xl flex items-center justify-center">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-600 transition rounded-2xl flex items-center justify-center">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="w-9 h-9 bg-gray-800 hover:bg-orange-600 transition rounded-2xl flex items-center justify-center">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <!-- Colonne 2 : Navigation -->
            <div>
                <h3 class="text-white font-semibold mb-5">Plateforme</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-white transition">Accueil</a></li>
                    <li><a href="#" class="hover:text-white transition">Rechercher un trajet</a></li>
                    <li><a href="#" class="hover:text-white transition">Destinations populaires</a></li>
                    <li><a href="#" class="hover:text-white transition">Compagnies partenaires</a></li>
                </ul>
            </div>

            <!-- Colonne 3 : Voyageurs -->
            <div>
                <h3 class="text-white font-semibold mb-5">Voyageurs</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('profile') }}" class="hover:text-white transition">Mon compte</a></li>
                    <li><a href="#" class="hover:text-white transition">Mes réservations</a></li>
                    <li><a href="#" class="hover:text-white transition">Mes billets</a></li>
                    <li><a href="#" class="hover:text-white transition">Annuler une réservation</a></li>
                </ul>
            </div>

            <!-- Colonne 4 : Support -->
            <div>
                <h3 class="text-white font-semibold mb-5">Support</h3>
                <ul class="space-y-3 text-sm">
                    <li><a href="#" class="hover:text-white transition">Centre d'aide</a></li>
                    <li><a href="#" class="hover:text-white transition">Nous contacter</a></li>
                    <li><a href="#" class="hover:text-white transition">Conditions générales</a></li>
                    <li><a href="#" class="hover:text-white transition">Politique de confidentialité</a></li>
                </ul>
            </div>

            <!-- Colonne 5 : Contact -->
            <div class="col-span-2 md:col-span-1">
                <h3 class="text-white font-semibold mb-5">Contact</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-phone mt-1 text-orange-500"></i>
                        <div>
                            <p>+212 619619100</p>
                            <p class="text-gray-500">Disponible 24/7</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-envelope mt-1 text-orange-500"></i>
                        <div>
                            <p>contact@busTicket.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-1 text-orange-500"></i>
                        <div>
                            <p>Bamako, Mali</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ligne de séparation -->
        <div class="border-t border-gray-800 my-12"></div>

        <!-- Bas de footer -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-6 text-sm">
            <p class="text-gray-500">
                &copy; {{ date('Y') }} BusTicket.com - Tous droits réservés.
            </p>
            
            <div class="flex flex-wrap gap-x-6 gap-y-2 justify-center text-gray-500">
                <a href="#" class="hover:text-gray-300 transition">Confidentialité</a>
                <a href="#" class="hover:text-gray-300 transition">Conditions d'utilisation</a>
                <a href="#" class="hover:text-gray-300 transition">Mentions légales</a>
                <a href="#" class="hover:text-gray-300 transition">Accessibilité</a>
            </div>

            <div class="text-gray-500 text-xs flex items-center gap-2">
                <span>BAH TRAORE - CHEICK OUMAR DOUMBIA</span>
            </div>
        </div>
    </div>
</footer>
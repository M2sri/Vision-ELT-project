<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" 
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    
    <!-- Custom CSS for Sidebar -->
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-collapsed: 80px;
            --header-height: 64px;
        }
        
        .sidebar-transition {
            transition: all 0.3s ease-in-out;
        }
        
        .sidebar-link.active {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            box-shadow: 0 4px 20px rgba(99, 102, 241, 0.3);
        }
        
        .sidebar-link:hover:not(.active) {
            background-color: rgba(99, 102, 241, 0.1);
        }
        
        .mobile-menu {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }
        
        .mobile-menu.open {
            transform: translateX(0);
        }
        
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 10px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #a1a1a1;
        }
        
        /* Dark mode scrollbar */
        .dark ::-webkit-scrollbar-track {
            background: #374151;
        }
        
        .dark ::-webkit-scrollbar-thumb {
            background: #6b7280;
        }
        
        .dark ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
        
        /* Loading animation */
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .animate-pulse {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        
        /* Card hover effects */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        
        .dark .card-hover:hover {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-200 min-h-screen">
    
    <!-- Mobile Header -->
    <header class="fixed top-0 left-0 right-0 h-16 bg-white dark:bg-gray-800 shadow-md z-50 flex items-center justify-between px-4 lg:hidden">
        <button onclick="toggleMobileMenu()" 
                class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
            <i class="fas fa-bars text-lg"></i>
        </button>
        
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-gradient-to-r from-primary-500 to-blue-500 rounded-lg flex items-center justify-center">
                <i class="fas fa-chart-line text-white text-sm"></i>
            </div>
            <span class="font-bold text-lg">Admin Panel</span>
        </div>
        
        <div class="flex items-center gap-3">
            <!-- User dropdown for mobile -->
            <div class="relative">
                <button onclick="toggleUserMenu()" 
                        class="flex items-center gap-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700">
                    <div class="w-8 h-8 bg-gradient-to-r from-primary-500 to-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-sm">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                </button>
                
                <div id="userMenu" 
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 hidden">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                        <p class="font-semibold">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg flex items-center gap-2">
                            <i class="fas fa-sign-out-alt"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Mobile Menu -->
    <div id="mobileMenu" 
         class="mobile-menu fixed top-16 left-0 bottom-0 w-64 bg-white dark:bg-gray-800 shadow-xl z-40 lg:hidden">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-blue-500 rounded-lg flex items-center justify-center">
                    <i class="fas fa-chart-line text-white text-lg"></i>
                </div>
                <div>
                    <p class="font-bold">Admin Panel</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Dashboard</p>
                </div>
            </div>
        </div>
        
        <nav class="p-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line w-5 text-center"></i>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('admin.students') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.students') ? 'active' : '' }}">
                <i class="fas fa-user-graduate w-5 text-center"></i>
                <span>Students</span>
            </a>
            
            <a href="{{ route('admin.kids') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.kids') ? 'active' : '' }}">
                <i class="fas fa-child w-5 text-center"></i>
                <span>Kids</span>
            </a>
            
            <a href="{{ route('admin.add-teachers') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.add-teachers') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher w-5 text-center"></i>
                <span>Teachers</span>
            </a>
            
            <a href="{{ route('admin.club') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.club') ? 'active' : '' }}">
                <i class="fas fa-calendar w-5 text-center"></i>
                <span>Activities</span>
            </a>
            
            <a href="{{ route('admin.gallery') }}" 
               class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.gallery') ? 'active' : '' }}">
                <i class="fas fa-images w-5 text-center"></i>
                <span>Highlight</span>
            </a>
        </nav>
        
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-700">
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white rounded-lg transition-all">
                    <i class="fas fa-sign-out-alt"></i>
                    Logout
                </button>
            </form>
        </div>
    </div>
    
    <!-- Main Layout -->
    <div class="flex min-h-screen pt-16 lg:pt-0">
        <!-- Desktop Sidebar -->
        <aside class="hidden lg:flex flex-col w-64 bg-white dark:bg-gray-800 shadow-lg fixed left-0 top-0 bottom-0 sidebar-transition z-30">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-blue-500 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-line text-white text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-lg">Admin Panel</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Dashboard</p>
                    </div>
                </div>
            </div>
            
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.students') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.students') ? 'active' : '' }}">
                    <i class="fas fa-user-graduate w-5 text-center"></i>
                    <span>Students</span>
                </a>
                
                <a href="{{ route('admin.kids') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.kids') ? 'active' : '' }}">
                    <i class="fas fa-child w-5 text-center"></i>
                    <span>Kids</span>
                </a>
                
                <a href="{{ route('admin.add-teachers') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.add-teachers') ? 'active' : '' }}">
                    <i class="fas fa-chalkboard-teacher w-5 text-center"></i>
                    <span>Teachers</span>
                </a>
                
                <a href="{{ route('admin.club') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.club') ? 'active' : '' }}">
                    <i class="fas fa-calendar w-5 text-center"></i>
                    <span>Activities</span>
                </a>
                
                <a href="{{ route('admin.gallery') }}" 
                   class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-lg {{ request()->routeIs('admin.gallery') ? 'active' : '' }}">
                    <i class="fas fa-images w-5 text-center"></i>
                    <span>Highlight</span>
                </a>
            </nav>
            
            <div class="p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center gap-3 px-4 py-3">
                    <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold">{{ substr(auth()->user()->name ?? 'A', 0, 1) }}</span>
                    </div>
                    <div class="flex-1">
                        <p class="font-semibold text-sm">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 p-4 lg:p-6 transition-all duration-300">
            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- JavaScript -->
    <script>
        // Toggle mobile menu
        function toggleMobileMenu() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('open');
            
            // Add backdrop
            if (!document.getElementById('menuBackdrop')) {
                const backdrop = document.createElement('div');
                backdrop.id = 'menuBackdrop';
                backdrop.className = 'fixed inset-0 bg-black bg-opacity-50 z-30 lg:hidden';
                backdrop.onclick = toggleMobileMenu;
                document.body.appendChild(backdrop);
            } else {
                document.getElementById('menuBackdrop').remove();
            }
        }
        
        // Toggle user menu
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.classList.toggle('hidden');
        }
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            const userMenu = document.getElementById('userMenu');
            const userButton = event.target.closest('button[onclick*="toggleUserMenu"]');
            
            if (userMenu && !userMenu.contains(event.target) && !userButton) {
                userMenu.classList.add('hidden');
            }
        });
        
        // Auto-close mobile menu on link click
        document.querySelectorAll('#mobileMenu a').forEach(link => {
            link.addEventListener('click', () => {
                toggleMobileMenu();
            });
        });
        
        // Initialize page
        document.addEventListener('DOMContentLoaded', function() {
            // Add loading animation to cards
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
            });
            
            // Check for active filters and show notification
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.toString()) {
                console.log('Active filters detected');
            }
        });
        
        // Theme toggle (optional)
        function toggleTheme() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
        
        // Load saved theme
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
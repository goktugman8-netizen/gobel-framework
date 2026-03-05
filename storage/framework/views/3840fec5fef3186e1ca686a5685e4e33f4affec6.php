<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobel Framework - The PHP Framework for Artisans</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff1f1',
                            100: '#ffdfdf',
                            200: '#ffc5c5',
                            300: '#f99c9c',
                            400: '#f4645f',
                            500: '#e13d3d',
                            600: '#cc2525',
                            700: '#ab1c1c',
                            800: '#8d1a1a',
                            900: '#751c1c',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=JetBrains+Mono&display=swap');
        body { font-family: 'Outfit', sans-serif; }
        .mono { font-family: 'JetBrains Mono', monospace; }
        .glass { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); }
        .glass-blur { background: rgba(255, 255, 255, 0.03); backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.1); }
        .gradient-text { background: linear-gradient(135deg, #f4645f 0%, #ab1c1c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0% { transform: translateY(0px); } 50% { transform: translateY(-10px); } 100% { transform: translateY(0px); } }
    </style>
</head>
<body class="bg-[#0f1115] text-white overflow-x-hidden">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass px-6 py-4 top-4 left-1/2 -translate-x-1/2 max-w-7xl rounded-2xl mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <div class="bg-brand-400 w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-brand-400/20">G</div>
            <span class="text-xl font-bold tracking-tight">Gobel<span class="text-brand-400">.</span></span>
        </div>
        <div class="hidden md:flex items-center space-x-8 text-sm font-medium text-gray-400">
            <a href="/docs" class="hover:text-white transition-colors">Documentation</a>
            <a href="/" class="hover:text-white transition-colors">Laracasts</a>
            <a href="/" class="hover:text-white transition-colors">News</a>
            <a href="/" class="hover:text-white transition-colors">Forge</a>
        </div>
        <div class="flex items-center space-x-4">
            <a href="https://github.com/goktugman8-netizen/gobel-framework" target="_blank" class="text-gray-400 hover:text-white">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.042-1.416-4.042-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
            </a>
            <a href="/about" class="bg-brand-400 hover:bg-brand-500 text-white px-5 py-2 rounded-xl text-sm font-bold transition-all shadow-lg shadow-brand-400/20 active:scale-95">About Us</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-40 pb-20 px-6">
        <!-- Background Elements -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 pointer-events-none">
            <div class="absolute top-[-5%] left-[10%] w-[400px] h-[400px] bg-brand-400/5 rounded-full blur-[80px]"></div>
            <div class="absolute bottom-[20%] right-[10%] w-[300px] h-[300px] bg-blue-500/5 rounded-full blur-[60px]"></div>
        </div>

        <div class="max-w-7xl mx-auto text-center">
            <div class="inline-flex items-center space-x-2 bg-brand-400/10 border border-brand-400/20 px-4 py-2 rounded-full text-brand-400 text-sm font-bold mb-8">
                <span>New: Gobel relationships is here!</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
            </div>
            
            <h1 class="text-6xl md:text-8xl font-bold tracking-tight mb-8 leading-[1.1]">
                The PHP Framework <br> <span class="gradient-text">for Artisans</span>
            </h1>
            
            <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-12">
                Gobel is a web application framework with expressive, elegant syntax. We’ve already laid the foundation — freeing you to create without sweating the small things.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                <a href="/docs" class="w-full sm:w-auto px-8 py-4 bg-white text-black font-bold rounded-2xl hover:bg-brand-50 transition-all shadow-xl active:scale-95">Get Started</a>
                <a href="#features" class="w-full sm:w-auto px-8 py-4 glass text-white font-bold rounded-2xl hover:bg-white/5 transition-all active:scale-95 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Watch Demo
                </a>
            </div>
        </div>

        <!-- Dashboard Preview -->
        <div class="max-w-6xl mx-auto mt-24 relative">
            <div class="glass p-2 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
                <div class="bg-[#1a1d23] rounded-[2rem] p-4 md:p-8 aspect-video flex flex-col items-center justify-center text-center">
                    <div class="mono text-brand-400 text-lg mb-4">$ php gobel make:controller WelcomeController</div>
                    <div class="bg-gray-800/50 w-full h-1 mt-auto rounded-full overflow-hidden">
                        <div class="bg-brand-400 h-full w-[65%]"></div>
                    </div>
                </div>
            </div>
            <!-- Decorative Dots -->
            <div class="absolute -top-12 -left-12 w-24 h-24 bg-brand-400/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-12 -right-12 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl"></div>
        </div>
    </section>

    <!-- Features Grid -->
    <section id="features" class="py-20 px-6">
        <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="glass p-8 rounded-3xl hover:bg-white/[0.05] transition-all group">
                <div class="w-12 h-12 bg-brand-400/10 rounded-2xl flex items-center justify-center text-brand-400 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Fast Performance</h3>
                <p class="text-gray-400 leading-relaxed">Built from scratch for speed. Lightweight core with high-performance routing and view rendering.</p>
            </div>
            <!-- Feature 2 -->
            <div class="glass p-8 rounded-3xl hover:bg-white/[0.05] transition-all group">
                <div class="w-12 h-12 bg-purple-400/10 rounded-2xl flex items-center justify-center text-purple-400 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4m0 5c0 2.21-3.58 4-8 4s-8-1.79-8-4"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Powerful ORM</h3>
                <p class="text-gray-400 leading-relaxed">Active Record pattern with automated query building. Handle relationships with zero effort.</p>
            </div>
            <!-- Feature 3 -->
            <div class="glass p-8 rounded-3xl hover:bg-white/[0.05] transition-all group">
                <div class="w-12 h-12 bg-blue-400/10 rounded-2xl flex items-center justify-center text-blue-400 mb-6 group-hover:scale-110 transition-transform">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                </div>
                <h3 class="text-xl font-bold mb-4">Blade Rendering</h3>
                <p class="text-gray-400 leading-relaxed">The famous Blade-like engine is now in Gobel. Clean, simple, and powerful frontend logic.</p>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 px-6">
        <div class="max-w-5xl mx-auto glass rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-brand-400/10 blur-[100px]"></div>
            <h2 class="text-4xl md:text-5xl font-bold mb-8">Ready to build your <br> next big idea?</h2>
            <p class="text-gray-400 mb-10 text-lg max-w-xl mx-auto">Join the new era of PHP development. Gobel gives you the tools to succeed without the bloat.</p>
            <a href="https://github.com/goktugman8-netizen/gobel-framework" class="inline-block px-10 py-5 bg-brand-400 text-white font-bold rounded-2xl hover:bg-brand-500 transition-all shadow-xl active:scale-95">Star on GitHub</a>
        </div>
    </section>

    <footer class="py-12 px-6 border-t border-white/5 text-center text-gray-500 text-sm">
        <p>© 2026 Gobel Framework. Created by Artisans, for Artisans.</p>
    </footer>
</body>
</html>

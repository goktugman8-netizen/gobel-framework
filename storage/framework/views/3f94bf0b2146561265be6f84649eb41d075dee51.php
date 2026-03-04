<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Gobel Framework</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap');
        body { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); }
        .gradient-text { background: linear-gradient(135deg, #f4645f 0%, #ab1c1c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
    </style>
</head>
<body class="bg-[#0f1115] text-white overflow-x-hidden min-h-screen">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 glass px-6 py-4 top-4 left-1/2 -translate-x-1/2 max-w-7xl rounded-2xl mx-auto flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <div class="bg-[#f4645f] w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white">G</div>
            <a href="/" class="text-xl font-bold tracking-tight">Gobel<span class="text-[#f4645f]">.</span></a>
        </div>
        <div class="flex items-center space-x-4">
            <a href="/" class="text-gray-400 hover:text-white text-sm font-medium transition-colors">Back to Home</a>
        </div>
    </nav>

    <main class="pt-40 pb-20 px-6 max-w-4xl mx-auto">
        <h1 class="text-5xl md:text-6xl font-bold mb-8 transition-all">
            About <span class="gradient-text">Gobel</span>
        </h1>
        
        <div class="space-y-12 text-lg text-gray-400 leading-relaxed">
            <section class="glass p-8 rounded-3xl">
                <h2 class="text-2xl font-bold text-white mb-4">Our Philosophy</h2>
                <p>
                    Gobel was born from a desire to create a PHP framework that is both powerful and incredibly lightweight. Inspired by the giants of the industry, we focused on the core essentials: speed, simplicity, and elegance.
                </p>
            </section>

            <section class="grid md:grid-cols-2 gap-8">
                <div class="glass p-8 rounded-3xl">
                    <h3 class="text-xl font-bold text-white mb-2">Modern Core</h3>
                    <p>Leveraging PHP 8.1+ features to provide a type-safe and performant foundation for your applications.</p>
                </div>
                <div class="glass p-8 rounded-3xl">
                    <h3 class="text-xl font-bold text-white mb-2">Developer Experience</h3>
                    <p>Designed for humans. With expressive syntax and a powerful CLI, you can focus on building features, not boilerplate.</p>
                </div>
            </section>

            <section class="glass p-8 rounded-3xl border-brand-400/20">
                <h2 class="text-2xl font-bold text-white mb-4">Why Gobel?</h2>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-[#f4645f] mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Zero Bloat:</strong> No unnecessary dependencies. You only get what you need.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-[#f4645f] mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Advanced Routing:</strong> Powerful middleware support and clean URI resolution.</span>
                    </li>
                    <li class="flex items-start">
                        <svg class="w-6 h-6 text-[#f4645f] mr-3 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        <span><strong>Customizable:</strong> Highly modular architecture using the IoC Container.</span>
                    </li>
                </ul>
            </section>
        </div>
    </main>

    <footer class="py-12 px-6 border-t border-white/5 text-center text-gray-500 text-sm">
        <p>© 2026 Gobel Framework. Built with passion.</p>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobel Framework - Documentation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .code-font { font-family: 'JetBrains Mono', monospace; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
        .glass-gradient { background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%); }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-300 antialiased h-screen flex flex-col overflow-hidden">

    <!-- Header -->
    <header class="h-16 px-8 border-b border-white/10 flex items-center justify-between bg-[#0f172a]/80 backdrop-blur-xl shrink-0 z-50">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-white shadow-lg shadow-blue-500/20">G</div>
            <span class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-blue-400 to-indigo-400">Gobel Framework</span>
            <span class="px-2 py-0.5 rounded-full bg-blue-500/10 text-blue-400 text-[10px] font-bold tracking-wider border border-blue-500/20 uppercase">Core v1.0.0</span>
        </div>
        <div class="flex items-center space-x-6 text-sm">
            <a href="/" class="hover:text-blue-400 transition-colors">Home</a>
            <a href="https://github.com" class="hover:text-blue-400 transition-colors">GitHub</a>
            <div class="px-4 py-1.5 bg-blue-600/10 border border-blue-500/20 rounded-full text-blue-400 font-medium">Enterprise Edition</div>
        </div>
    </header>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside class="w-72 border-r border-white/10 bg-[#0f172a]/50 flex flex-col px-6 py-8 overflow-y-auto hidden md:flex shrink-0">
            <div class="space-y-8">
                <div>
                    <h5 class="text-slate-100 font-bold text-xs uppercase tracking-widest mb-4">Getting Started</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#intro" class="hover:text-blue-400 transition-colors border-l-2 border-blue-500 pl-4 text-blue-400">Introduction</a></li>
                        <li><a href="#installation" class="hover:text-blue-400 transition-colors border-l-2 border-transparent pl-4">Installation</a></li>
                        <li><a href="#lifecycle" class="hover:text-blue-400 transition-colors border-l-2 border-transparent pl-4">Application Lifecycle</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-slate-100 font-bold text-xs uppercase tracking-widest mb-4">Core Components</h5>
                    <ul class="space-y-3 text-sm font-medium">
                        <li><a href="#routing" class="hover:text-blue-400 transition-colors">Routing & Controllers</a></li>
                        <li><a href="#middleware" class="hover:text-blue-400 transition-colors">Middleware Stack</a></li>
                        <li><a href="#database" class="hover:text-blue-400 transition-colors">Database & ORM</a></li>
                        <li><a href="#views" class="hover:text-blue-400 transition-colors">Blade View Engine</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-slate-100 font-bold text-xs uppercase tracking-widest mb-4">Enterprise Features</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#auth" class="hover:text-blue-400 transition-colors font-medium">Authentication (Session/JWT)</a></li>
                        <li><a href="#cache-mail" class="hover:text-blue-400 transition-colors font-medium">Cache & Transact Mail</a></li>
                        <li><a href="#queue" class="hover:text-blue-400 transition-colors font-medium">Background Queues</a></li>
                        <li><a href="#notifications" class="hover:text-blue-400 transition-colors font-medium">Multi-channel Notifications</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-slate-100 font-bold text-xs uppercase tracking-widest mb-4">CLI & Utilities</h5>
                    <ul class="space-y-3 text-sm">
                        <li><a href="#cli" class="hover:text-blue-400 transition-colors">Artisan CLI Commands</a></li>
                        <li><a href="#storage" class="hover:text-blue-400 transition-colors">Storage & Media</a></li>
                        <li><a href="#validation" class="hover:text-blue-400 transition-colors">Validation System</a></li>
                    </ul>
                </div>
            </div>
        </aside>

        <!-- Content Area -->
        <main class="flex-1 overflow-y-auto px-8 md:px-16 py-12 scroll-smooth">
            <div class="max-w-4xl mx-auto space-y-24 pb-24">
                
                <!-- Introduction -->
                <section id="intro" class="space-y-6">
                    <h2 class="text-4xl font-extrabold text-white">Introduction</h2>
                    <p class="text-lg leading-relaxed text-slate-400 tracking-wide">
                        The Gobel Framework is a developer-centric PHP framework designed for high-performance enterprise applications. 
                        By combining the elegance of custom architecture with the power of world-class libraries like 
                        <span class="text-blue-400">Illuminate Components</span>, Gobel provides a robust foundation for building Super-Apps, 
                        RESTful APIs, and complex web ecosystems.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 glass-gradient">
                            <h4 class="text-white font-bold mb-2 flex items-center">
                                <span class="w-6 h-6 bg-blue-500/20 text-blue-400 rounded-lg flex items-center justify-center mr-3 text-xs italic">!</span>
                                Modern Architecture
                            </h4>
                            <p class="text-sm text-slate-500">Built on a powerful IoC container with full support for dependency injection and service providers.</p>
                        </div>
                        <div class="p-6 rounded-2xl bg-white/5 border border-white/10 glass-gradient">
                            <h4 class="text-white font-bold mb-2 flex items-center">
                                <span class="w-6 h-6 bg-green-500/20 text-green-400 rounded-lg flex items-center justify-center mr-3 text-xs font-serif">$</span>
                                Performance Ready
                            </h4>
                            <p class="text-sm text-slate-500">Integrated background queues, caching, and optimized autoloading for ultra-fast response times.</p>
                        </div>
                    </div>
                </section>

                <!-- Installation -->
                <section id="installation" class="space-y-6">
                    <h2 class="text-3xl font-extrabold text-white tracking-tight">Installation</h2>
                    <p class="text-slate-400">Get started with a single command using Composer:</p>
                    <div class="p-5 bg-slate-950 rounded-xl border border-white/5 code-font text-blue-400 shadow-2xl relative group">
                        <span class="absolute right-4 top-4 text-[10px] uppercase text-slate-600 font-bold opacity-0 group-hover:opacity-100 transition-opacity">Copy</span>
                        composer create-project gobel/framework my-app
                    </div>
                </section>

                <!-- Routing -->
                <section id="routing" class="space-y-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-2 h-8 bg-blue-600 rounded-full mr-4"></div>
                        Routing & Controllers
                    </h3>
                    <p class="text-slate-400">Define routes with expressive syntax and map them to controllers or closures.</p>
                    <div class="bg-slate-950 rounded-xl border border-white/5 p-6 shadow-xl">
                        <pre><code class="language-php">use App\Controllers\UserController;

$router->get('/users', [UserController::class, 'index']);
$router->post('/users', [UserController::class, 'store']);

// Grouping with Middleware
$router->group(['prefix' => 'admin', 'middleware' => 'auth'], function($router) {
    $router->get('/dashboard', [AdminController::class, 'dashboard']);
});</code></pre>
                    </div>
                </section>

                <!-- Database -->
                <section id="database" class="space-y-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-2 h-8 bg-indigo-600 rounded-full mr-4"></div>
                        Database & Eloquent ORM
                    </h3>
                    <p class="text-slate-400">Fully integrated with <span class="text-indigo-400">Eloquent ORM</span> for fluid database interaction.</p>
                    <div class="bg-slate-950 rounded-xl border border-white/5 p-6 shadow-xl">
                        <pre><code class="language-php">// Fetch user with relationships
$user = User::with('posts')->find(1);

// Active Record Creation
User::create([
    'name' => 'John Doe',
    'email' => 'john@example.com',
    'password' => Hash::make('secret')
]);</code></pre>
                    </div>
                </section>

                <!-- CLI -->
                <section id="cli" class="space-y-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-2 h-8 bg-orange-600 rounded-full mr-4"></div>
                        CLI Commands
                    </h3>
                    <p class="text-slate-400">Generate code, run migrations, and manage background workers with the <code class="bg-slate-800 px-2 rounded text-orange-400">gobel</code> tool.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-slate-950 border border-white/5 p-4 rounded-xl font-mono text-xs flex justify-between items-center">
                            <span class="text-slate-500">php gobel migrate</span>
                            <span class="text-white/20">Run migrations</span>
                        </div>
                        <div class="bg-slate-950 border border-white/5 p-4 rounded-xl font-mono text-xs flex justify-between items-center">
                            <span class="text-slate-500">php gobel make:auth</span>
                            <span class="text-white/20">Scaffold Auth</span>
                        </div>
                        <div class="bg-slate-950 border border-white/5 p-4 rounded-xl font-mono text-xs flex justify-between items-center">
                            <span class="text-slate-500">php gobel queue:work</span>
                            <span class="text-white/20">Start worker</span>
                        </div>
                        <div class="bg-slate-950 border border-white/5 p-4 rounded-xl font-mono text-xs flex justify-between items-center">
                            <span class="text-slate-500">php gobel db:seed</span>
                            <span class="text-white/20">Populate DB</span>
                        </div>
                    </div>
                </section>

                <!-- Middleware -->
                <section id="middleware" class="space-y-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-2 h-8 bg-green-600 rounded-full mr-4"></div>
                        Middleware Stack
                    </h3>
                    <p class="text-slate-400">Middleware provides a convenient mechanism for inspecting and filtering HTTP requests entering your application.</p>
                    <div class="bg-slate-950 rounded-xl border border-white/5 p-6 shadow-xl">
                        <pre><code class="language-php">class AuthMiddleware
{
    public function handle($request, $next)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        return $next($request);
    }
}</code></pre>
                    </div>
                </section>

                <!-- Auth -->
                <section id="auth" class="space-y-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-2 h-8 bg-brand-400 rounded-full mr-4"></div>
                        Authentication (JWT & Session)
                    </h3>
                    <p class="text-slate-400">Gobel supports both stateful session-based auth and stateless JWT auth out of the box.</p>
                    <div class="bg-slate-950 rounded-xl border border-white/5 p-6 shadow-xl">
                        <pre><code class="language-php">// Session Login
Auth::attempt(['email' => $email, 'password' => $pass]);

// JWT Token Generation
$token = Jwt::encode(['user_id' => $user->id]);</code></pre>
                    </div>
                </section>

                <!-- Queue -->
                <section id="queue" class="space-y-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-2 h-8 bg-yellow-600 rounded-full mr-4"></div>
                        Background Queues
                    </h3>
                    <p class="text-slate-400">Offload heavy tasks to background workers for a seamless user experience.</p>
                    <div class="bg-slate-950 rounded-xl border border-white/5 p-6 shadow-xl">
                        <pre><code class="language-php">// Dispatch a job
ProcessOrder::dispatch($order);

// Run the worker
php gobel queue:work</code></pre>
                    </div>
                </section>

                <!-- Notifications -->
                <section id="notifications" class="space-y-6">
                    <h3 class="text-2xl font-bold text-white flex items-center">
                        <div class="w-2 h-8 bg-pink-600 rounded-full mr-4"></div>
                        Multi-channel Notifications
                    </h3>
                    <p class="text-slate-400">Send notifications via Mail, Slack, or Database with a unified API.</p>
                    <div class="bg-slate-950 rounded-xl border border-white/5 p-6 shadow-xl">
                        <pre><code class="language-php">use App\Notifications\WelcomeNotification;

$user->notify(new WelcomeNotification());</code></pre>
                    </div>
                </section>

                <!-- Features Footer -->
                <section class="pt-12 border-t border-white/10">
                    <div class="p-10 rounded-3xl bg-gradient-to-br from-blue-600 to-indigo-700 text-white text-center shadow-2xl shadow-blue-500/20">
                        <h2 class="text-3xl font-extrabold mb-4">Ready to build the future?</h2>
                        <p class="mb-8 opacity-80 max-w-lg mx-auto">Join the Gobel ecosystem and build high-performance applications with ease.</p>
                        <a href="/" class="px-8 py-3 bg-white text-blue-600 rounded-full font-bold hover:scale-105 transition-transform inline-block">Go to Home Page</a>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-php.min.js"></script>
</body>
</html>

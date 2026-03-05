<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobel Exception: {{ $message }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Outfit:wght@400;600;700&display=swap');
        body { font-family: 'Outfit', sans-serif; }
        .code-block { font-family: 'JetBrains Mono', monospace; }
        .glass { background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2); }
        .line-highlight { background-color: rgba(239, 68, 68, 0.15); border-left: 4px solid #ef4444; }
        .error-gradient { background: linear-gradient(135deg, #f87171 0%, #ef4444 100%); }
        pre { counter-reset: line; }
        .code-line::before { counter-increment: line; content: counter(line); display: inline-block; width: 3rem; margin-right: 1.5rem; color: #4b5563; text-align: right; user-select: none; }
    </style>
</head>
<body class="h-full bg-[#fafafa] text-[#1a1a1a]">
    <div class="min-h-full flex flex-col">
        <!-- Top Bar -->
        <header class="bg-white/80 backdrop-blur-md border-b border-gray-100 px-8 py-5 flex items-center justify-between sticky top-0 z-50">
            <div class="flex items-center space-x-4">
                <div class="error-gradient p-2.5 rounded-xl shadow-lg shadow-red-200">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h1 class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Unhandled Exception</h1>
                    <p class="text-lg font-bold text-gray-900 tracking-tight">{{ get_class($exception) }}</p>
                </div>
            </div>
            <div class="hidden md:flex items-center space-x-6">
                <div class="text-right">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Framework</p>
                    <p class="text-xs font-semibold text-gray-600">Gobel v1.0.0</p>
                </div>
                <div class="h-8 w-px bg-gray-100"></div>
                <div class="text-right">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">PHP Version</p>
                    <p class="text-xs font-semibold text-gray-600">{{ PHP_VERSION }}</p>
                </div>
            </div>
        </header>

        <main class="flex-grow container max-w-6xl mx-auto px-6 py-12">
            <!-- Main Error Info -->
            <div class="mb-12">
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-[1.1] mb-6 tracking-tight">
                    {{ $message }}
                </h2>
                <div class="inline-flex items-center px-4 py-2 bg-white border border-gray-100 rounded-full shadow-sm text-sm text-gray-600 font-medium whitespace-nowrap overflow-hidden max-w-full">
                    <span class="text-red-500 font-bold mr-2">Line {{ $line }}</span>
                    <span class="text-gray-300 mx-2">in</span>
                    <span class="truncate pr-1">{{ $file }}</span>
                </div>
            </div>

            <!-- Code Preview Section -->
            <div class="bg-[#111] rounded-2xl shadow-2xl shadow-black/10 overflow-hidden mb-12 border border-white/5">
                <div class="px-6 py-4 bg-[#1a1a1a] border-b border-white/5 flex items-center justify-between">
                    <div class="flex items-center space-x-2">
                        <div class="w-3 h-3 rounded-full bg-[#ff5f56]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#ffbd2e]"></div>
                        <div class="w-3 h-3 rounded-full bg-[#27c93f]"></div>
                        <span class="ml-4 text-xs font-mono text-gray-500">{{ basename($file) }}</span>
                    </div>
                </div>
                <div class="p-0 code-block overflow-x-auto">
                    <pre class="py-6 text-[13px] leading-[1.6]">
@foreach($snippet as $ln => $content)
<div class="flex {{ $ln == $line ? 'line-highlight' : '' }}">
<span class="inline-block w-16 text-gray-600 text-right pr-6 select-none">{{ $ln }}</span>
<span class="text-gray-300 whitespace-pre">{{ $content }}</span>
</div>
@endforeach
                    </pre>
                </div>
            </div>

            <!-- Stack Trace Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <div class="lg:col-span-2">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        Stack Trace
                    </h3>
                    <div class="space-y-3">
                        @foreach($exception->getTrace() as $index => $trace)
                        <div class="group bg-white p-5 rounded-2xl border border-gray-100 hover:border-red-200 transition-all hover:shadow-md cursor-default">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-2">
                                <div class="flex items-start">
                                    <span class="text-xs font-bold text-gray-300 group-hover:text-red-300 transition-colors mt-1 mr-4 w-6">#{{ count($exception->getTrace()) - $index }}</span>
                                    <div>
                                        <p class="font-bold text-gray-800 break-all">{{ $trace['class'] ?? '' }}{{ $trace['type'] ?? '' }}{{ $trace['function'] }}()</p>
                                        @if(isset($trace['file']))
                                        <p class="text-xs text-gray-400 font-mono mt-1 truncate">{{ $trace['file'] }}:{{ $trace['line'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Request Info</h3>
                    <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-6 shadow-sm">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Method</p>
                            <p class="font-bold text-gray-800">{{ $_SERVER['REQUEST_METHOD'] }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">URL</p>
                            <p class="font-bold text-gray-800 break-all">{{ $_SERVER['HTTP_HOST'] }}{{ $_SERVER['REQUEST_URI'] }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Referer</p>
                            <p class="font-medium text-gray-600 break-all">{{ $_SERVER['HTTP_REFERER'] ?? 'None' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-gray-50 border-t border-gray-100 px-8 py-8 mt-12">
            <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-4">
                <p class="text-sm text-gray-400">© {{ date('Y') }} <strong>Gobel Framework</strong> — Performance & Elegance</p>
                <div class="flex space-x-4">
                    <a href="#" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">Documentation</a>
                    <a href="https://github.com/goktugman8-netizen/gobel-framework" class="text-xs font-bold text-gray-400 hover:text-gray-600 transition-colors uppercase tracking-widest">GitHub</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>

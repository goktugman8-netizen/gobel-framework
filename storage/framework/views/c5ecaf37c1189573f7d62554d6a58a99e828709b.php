<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gobel Exception: <?php echo htmlspecialchars($message ?? '', ENT_QUOTES, 'UTF-8'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .code-block { font-family: 'JetBrains Mono', monospace; }
        .line-highlight { background-color: rgba(244, 100, 95, 0.1); border-left: 3px solid #f4645f; }
        .error-accent { color: #f4645f; }
        .bg-error-soft { background-color: #fff5f5; }
    </style>
</head>
<body class="h-full bg-gray-50 text-gray-900">
    <div class="min-h-full flex flex-col">
        <!-- Top Bar -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-10">
            <div class="flex items-center space-x-3">
                <div class="bg-red-500 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h1 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Exception Thrown</h1>
                    <p class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars(get_class($exception) ?? '', ENT_QUOTES, 'UTF-8'); ?></p>
                </div>
            </div>
            <div class="text-sm text-gray-500 font-mono">
                Gobel Framework v1.0.0 (PHP <?php echo htmlspecialchars(PHP_VERSION ?? '', ENT_QUOTES, 'UTF-8'); ?>)
            </div>
        </header>

        <main class="flex-grow container mx-auto px-6 py-8">
            <!-- Main Error Box -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="p-8 border-b border-gray-100 bg-error-soft">
                    <h2 class="text-2xl font-bold text-red-700 leading-tight mb-4">
                        <?php echo htmlspecialchars($message ?? '', ENT_QUOTES, 'UTF-8'); ?>
                    </h2>
                    <div class="flex items-center text-sm text-gray-600 font-mono">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3l-2-2H9L7 7H3z"></path></svg>
                        <span class="font-bold underline"><?php echo htmlspecialchars($file ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        <span class="mx-2">:</span>
                        <span class="bg-red-100 px-2 py-0.5 rounded text-red-600 font-bold"><?php echo htmlspecialchars($line ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                    </div>
                </div>

                <!-- Code Preview -->
                <div class="bg-gray-900 p-6 code-block overflow-x-auto">
                    <div class="text-xs text-gray-500 mb-4 pb-4 border-b border-gray-800 flex justify-between">
                        <span><?php echo htmlspecialchars($file ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                        <span>PHP</span>
                    </div>
                    <pre class="text-sm leading-relaxed">
<?php foreach($snippet as $ln => $content): ?>
<div class="flex <?php echo htmlspecialchars($ln == $line ? 'line-highlight' : '' ?? '', ENT_QUOTES, 'UTF-8'); ?>">
    <span class="inline-block w-12 text-gray-600 text-right pr-4 select-none"><?php echo htmlspecialchars($ln ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
    <span class="text-gray-300"><?php echo htmlspecialchars(htmlspecialchars($content) ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
</div>
<?php endforeach; ?>
                    </pre>
                </div>
            </div>

            <!-- Stack Trace -->
            <div class="space-y-4">
                <h3 class="text-lg font-bold text-gray-800 px-2">Stack Trace</h3>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 divide-y divide-gray-100">
                    <?php foreach($exception->getTrace() as $index => $trace): ?>
                    <div class="p-4 hover:bg-gray-50 transition-colors cursor-default">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="text-gray-400 font-mono text-xs mr-2">#<?php echo htmlspecialchars(count($exception->getTrace()) - $index ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                                <span class="font-bold text-gray-800"><?php echo htmlspecialchars($trace['class'] ?? '' ?? '', ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($trace['type'] ?? '' ?? '', ENT_QUOTES, 'UTF-8'); ?><?php echo htmlspecialchars($trace['function'] ?? '', ENT_QUOTES, 'UTF-8'); ?>()</span>
                            </div>
                            <?php if(isset($trace['file'])): ?>
                            <span class="text-xs text-gray-500 font-mono"><?php echo htmlspecialchars(basename($trace['file']) ?? '', ENT_QUOTES, 'UTF-8'); ?>:<?php echo htmlspecialchars($trace['line'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <div class="p-4 bg-gray-50 border-t border-gray-200">
                        <div class="flex items-center">
                            <span class="text-gray-400 font-mono text-xs mr-2">#0</span>
                            <span class="font-bold text-gray-800">{main}</span>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="bg-white border-t border-gray-200 px-6 py-4 text-center text-sm text-gray-400">
            Rendered by <strong>Gobel Framework</strong>'s Exception Handler
        </footer>
    </div>
</body>
</html>

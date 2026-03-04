<?php

namespace Gobel\Console;

use Gobel\Support\Facades\DB;

class MakeAuthCommand extends Command
{
    /**
     * The command signature.
     *
     * @var string
     */
    protected $signature = 'make:auth';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic login and registration views and routes';

    /**
     * Execute the command.
     *
     * @param array $args
     * @return int
     */
    public function handle(array $args): int
    {
        $this->createDirectories();
        $this->exportViews();
        $this->exportController();
        $this->addRoutes();

        $this->info('Authentication scaffolding generated successfully.');
        return 0;
    }

    protected function createDirectories()
    {
        $dirs = [
            $this->app->resourcePath('views/auth'),
            $this->app->basePath('app/Controllers/Auth'),
        ];

        foreach ($dirs as $dir) {
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
        }
    }

    protected function exportViews()
    {
        $views = [
            'auth/login.gobel.php' => $this->getLoginStub(),
            'auth/register.gobel.php' => $this->getRegisterStub(),
        ];

        foreach ($views as $name => $content) {
            $path = $this->app->resourcePath('views/' . $name);
            if (!file_exists($path)) {
                file_put_contents($path, $content);
                $this->info("Created: {$name}");
            }
        }
    }

    protected function exportController()
    {
        $path = $this->app->basePath('app/Controllers/Auth/AuthController.php');
        if (!file_exists($path)) {
            file_put_contents($path, $this->getControllerStub());
            $this->info('Created: AuthController.php');
        }
    }

    protected function addRoutes()
    {
        $path = $this->app->basePath('routes/web.php');
        $routes = PHP_EOL . "// Auth Routes" . PHP_EOL .
            "\$router->get('/login', [App\Controllers\Auth\AuthController::class, 'showLoginForm']);" . PHP_EOL .
            "\$router->post('/login', [App\Controllers\Auth\AuthController::class, 'login']);" . PHP_EOL .
            "\$router->get('/register', [App\Controllers\Auth\AuthController::class, 'showRegistrationForm']);" . PHP_EOL .
            "\$router->post('/register', [App\Controllers\Auth\AuthController::class, 'register']);" . PHP_EOL .
            "\$router->post('/logout', [App\Controllers\Auth\AuthController::class, 'logout']);" . PHP_EOL;

        file_put_contents($path, $routes, FILE_APPEND);
        $this->info('Routes updated.');
    }

    protected function getLoginStub()
    {
        return <<<'HTML'
@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-slate-900">
    <div class="w-full max-w-md p-8 space-y-8 bg-slate-800 rounded-2xl border border-white/10 shadow-2xl">
        <h2 class="text-3xl font-bold text-center text-white">Login to Gobel</h2>
        <form action="/login" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-300">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-3 mt-1 bg-slate-700 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 mt-1 bg-slate-700 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <button type="submit" class="w-full py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700 font-semibold transition-all">Login</button>
        </form>
        <p class="text-center text-slate-400">Don't have an account? <a href="/register" class="text-blue-500 hover:underline">Register</a></p>
    </div>
</div>
@endsection
HTML;
    }

    protected function getRegisterStub()
    {
        return <<<'HTML'
@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-slate-900">
    <div class="w-full max-w-md p-8 space-y-8 bg-slate-800 rounded-2xl border border-white/10 shadow-2xl">
        <h2 class="text-3xl font-bold text-center text-white">Join Gobel</h2>
        <form action="/register" method="POST" class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-slate-300">Full Name</label>
                <input type="text" name="name" required class="w-full px-4 py-3 mt-1 bg-slate-700 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300">Email Address</label>
                <input type="email" name="email" required class="w-full px-4 py-3 mt-1 bg-slate-700 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-300">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 mt-1 bg-slate-700 border border-white/10 rounded-lg text-white focus:ring-2 focus:ring-blue-500 outline-none">
            </div>
            <button type="submit" class="w-full py-3 text-white bg-blue-600 rounded-lg hover:bg-blue-700 font-semibold transition-all">Register</button>
        </form>
        <p class="text-center text-slate-400">Already have an account? <a href="/login" class="text-blue-500 hover:underline">Login</a></p>
    </div>
</div>
@endsection
HTML;
    }

    protected function getControllerStub()
    {
        return <<<'PHP'
<?php

namespace App\Controllers\Auth;

use Gobel\Http\Request;
use Gobel\Http\Response;
use App\Models\User;
use Gobel\Support\Facades\Hash;
use Gobel\Support\Facades\Auth;

class AuthController
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (Auth::attempt($credentials)) {
            return redirect('/')->with('success', 'Welcome back!');
        }

        return redirect('/login')->with('error', 'Invalid credentials.');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->all();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect('/login')->with('success', 'Account created! Please login.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('info', 'Logged out.');
    }
}
PHP;
    }
}

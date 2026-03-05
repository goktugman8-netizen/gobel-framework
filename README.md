# 🚀 Gobel Framework — The Enterprise-Grade PHP Engine

<p align="center">
  <img src="https://raw.githubusercontent.com/goktugman8-netizen/gobel-framework/main/public/logo.png" width="200" alt="Gobel Logo">
</p>

<p align="center">
  <a href="https://github.com/goktugman8-netizen/gobel-framework/actions"><img src="https://img.shields.io/badge/build-passing-brightgreen?style=for-the-badge&logo=github" alt="Build Status"></a>
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-8.2+-777bb4?style=for-the-badge&logo=php" alt="PHP Version"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-yellow?style=for-the-badge" alt="License"></a>
  <a href="https://github.com/goktugman8-netizen/gobel-framework/stargazers"><img src="https://img.shields.io/github/stars/goktugman8-netizen/gobel-framework?style=for-the-badge&color=orange" alt="Stars"></a>
</p>

---

## 💎 What is Gobel?

**Gobel** is a high-performance, developer-centric PHP framework designed for modern web artisans. It combines a custom, lightweight core with industry-standard **Illuminate Components** to deliver an enterprise-grade experience without the unnecessary bloat.

Whether you're building a stateless Super-App API, a complex SaaS platform, or a lightning-fast web portal, Gobel provides the elegance and power you need.

## ✨ Key Features

- **🚀 Performance First:** Ultra-lightweight kernel with optimized autoloading.
- **🏗️ Enterprise Architecture:** Built on a robust IoC Container with full Dependency Injection support.
- **⚙️ Standard Tech Stack:** Leverages `illuminate/http`, `illuminate/pipeline`, and `illuminate/database` (Eloquent).
- **🎨 Blade-like Engine:** Powerful, familiar, and expressive view rendering.
- **🛠️ Artisan-style CLI:** Command-line power for migrations, scaffolding, and background workers.
- **🛡️ Modern Security:** Built-in support for JWT, Session Auth, and industry-standard hashing.
- **🔥 Beautiful DX:** Ignition-style professional error reporting via Whoops integration.

## 🛠️ Quick Start

### 1. Installation

```bash
composer create-project goktugman8-netizen/gobel-framework my-project
```

### 2. Configure Environment

```bash
cp .env.example .env
php gobel key:generate
```

### 3. Run Migrations

```bash
php gobel migrate
```

### 4. Serve the App

```bash
php -S localhost:8000 -t public
```

Now visit `http://localhost:8000` to see the magic! 🎩⭐

## 📖 Feature Showcase

### Expressive Routing
```php
$router->get('/users/{id}', [UserController::class, 'show'])->middleware('auth');
```

### Eloquent ORM
```php
$user = User::with('orders')->where('active', true)->first();
```

### Background Jobs
```php
ProcessPayment::dispatch($order)->onQueue('high');
```

## 🤝 Contributing

We love contributions! Please see our [Contributing Guide](CONTRIBUTING.md) to get started. Let's make Gobel even better together!

## 📜 License

The Gobel Framework is open-sourced software licensed under the [MIT license](LICENSE).

---

<p align="center">
  Made with ❤️ by <strong>Goktug</strong> and the <strong>Gobel Community</strong>
</p>

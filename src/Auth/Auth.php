<?php

namespace Gobel\Auth;

use Gobel\Session\Session;
use App\Models\User;

class Auth
{
    /**
     * The session implementation.
     *
     * @var Session
     */
    protected $session;

    /**
     * The authenticated user.
     *
     * @var User|null
     */
    protected $user;

    /**
     * Create a new auth instance.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Attempt to authenticate a user.
     *
     * @param array $credentials
     * @return bool
     */
    public function attempt(array $credentials)
    {
        $user = User::where('email', '=', $credentials['email'])->first();

        if ($user && password_verify($credentials['password'], $user->password)) {
            $this->login($user);
            return true;
        }

        return false;
    }

    /**
     * Log a user into the application.
     *
     * @param User $user
     * @return void
     */
    public function login(User $user)
    {
        $this->session->set('user_id', $user->id);
        $this->user = $user;
    }

    /**
     * Log the user out of the application.
     *
     * @return void
     */
    public function logout()
    {
        $this->session->remove('user_id');
        $this->user = null;
    }

    /**
     * Check if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        return $this->session->get('user_id') !== null;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return User|null
     */
    public function user()
    {
        if ($this->user) {
            return $this->user;
        }

        $id = $this->session->get('user_id');

        if ($id) {
            $this->user = User::find($id);
        }

        return $this->user;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|null
     */
    public function id()
    {
        return $this->session->get('user_id');
    }
}

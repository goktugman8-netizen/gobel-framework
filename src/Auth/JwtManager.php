<?php

namespace Gobel\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtManager
{
    /**
     * The secret key for JWT signing.
     *
     * @var string
     */
    protected $secret;

    /**
     * The algorithm for JWT signing.
     *
     * @var string
     */
    protected $algo;

    /**
     * Create a new JWT manager instance.
     *
     * @param string $secret
     * @param string $algo
     */
    public function __construct(string $secret, string $algo = 'HS256')
    {
        $this->secret = $secret;
        $this->algo = $algo;
    }

    /**
     * Encode a payload into a JWT token.
     *
     * @param array $payload
     * @param int|null $expires
     * @return string
     */
    public function encode(array $payload, int $expires = null): string
    {
        if ($expires) {
            $payload['exp'] = time() + $expires;
        }

        $payload['iat'] = time();

        return JWT::encode($payload, $this->secret, $this->algo);
    }

    /**
     * Decode a JWT token into a payload.
     *
     * @param string $token
     * @return array|null
     */
    public function decode(string $token): ?array
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret, $this->algo));
            return (array) $decoded;
        } catch (Exception $e) {
            return null;
        }
    }
}

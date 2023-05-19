<?php

namespace App\mydashboard\Users\Application;

use App\mydashboard\Users\Domain\Exceptions\LoginException;
use App\mydashboard\Shared\Domain\ValueObject\Uuid;
use App\mydashboard\Users\Domain\ApiUserRepositoryInterface;
use App\mydashboard\Users\Domain\EmployeeRepositoryInterface;
use DateTimeImmutable;
use Firebase\JWT\JWT;

class LogInApiUserService
{
    private $apiUserRepository;
    private $employeeRepository;

    public function __construct(ApiUserRepositoryInterface $apiUserRepository, EmployeeRepositoryInterface $employeeRepository)
    {
        $this->apiUserRepository = $apiUserRepository;
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * @param LogInApiUserRequest $logInApiUserRequest  The login request with email and password
     * @return LogInApiUserResponse Response with User, JWT and token expire
     * @throws LoginException
     */
    public function execute(LogInApiUserRequest $logInApiUserRequest): LogInApiUserResponse
    {
        $user = $this->apiUserRepository->findByEmail($logInApiUserRequest->email());

        if ($user === null) {
            $user = $this->employeeRepository->findByEmail($logInApiUserRequest->email());
        }

        if ($user === null) {
            throw new LoginException("Invalid credentials");
        }

        // check password
        $userPasswordParts	= explode(':', $user->getPassword());

        $userPasswordCrypt	= $userPasswordParts[0] ?? '';
        $userPasswordSalt	= $userPasswordParts[1] ?? '';

        $encryptedPasswordFromRequest = ($userPasswordSalt !== '')
            ? md5($logInApiUserRequest->password() . $userPasswordSalt)
            : md5($logInApiUserRequest->password());

        if ($userPasswordCrypt !== $encryptedPasswordFromRequest) {
            throw new LoginException("Invalid credentials");
        }

        try {
            // JWT
            $secretKey = $_SERVER['JWT_SECRET_KEY'];
            $tokenId = Uuid::random()->value();
            $issuedAt = new DateTimeImmutable();
            $expire = $issuedAt->modify('+' . $_SERVER['JWT_EXPIRATION_INTERVAL_IN_MINUTES'] . ' minutes')->getTimestamp(); // Add 60 seconds
            $issuer = $_SERVER['JWT_ISSUER'];
            $algorithm = $_SERVER['JWT_SIGN_TOKEN_ALGORITHM'];

            // Create the token as an array
            $payload = [
                'iat'  => $issuedAt->getTimestamp(), // Issued at: time when the token was generated
                'nbf'  => $issuedAt->getTimestamp(), // Not before
                'exp'  => $expire, // Expire
                'jti'  => $tokenId, // Json Token Id: an unique identifier for the token
                'iss'  => $issuer, // Issuer
                'data' => [ // Data related to the signer user
                    'id' => $user->getId(),
                    'name' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'roles' => $user->getRoles()
                ]
            ];

            // Encode the array to a JWT string.
            $jwt = JWT::encode(
                $payload, //Data to be encoded in the JWT
                $secretKey, // The signing key
                $algorithm // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
            );
        } catch (\Throwable $th) {
            throw new LoginException($th->getMessage());
        }

        return new LogInApiUserResponse($user, $jwt, $expire);
    }
}

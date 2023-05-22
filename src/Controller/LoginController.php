<?php

namespace App\Controller;

use App\MyDashboard\User\Application\LoginUserService;
use App\MyDashboard\User\Application\LoginUserRequest;
use App\MyDashboard\Shared\Utils\ApiResponse;
use Error;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractController
{
     /**
     * @Route("/users/login", name="users_login", methods={"POST"})
     */
    public function login(LoginUserService $loginApiUserService, Request $request): Response
    {
        $apiResponse = new ApiResponse();
        $response = new JsonResponse();

        try {
            $requestParams = json_decode($request->getContent(), true);
            $email =  $requestParams['email'] ?? null;
            $password =  $requestParams['password'] ?? null;

            if (empty($email) || empty($password)) {
                throw new InvalidArgumentException("email and password are required fields and cannot be empty or null");
            }

            $loginApiUserRequest = new LoginUserRequest($email, $password);
            $loginApiUserResponse = $loginApiUserService->execute($loginApiUserRequest);

            return
            $apiResponse->setData($loginApiUserResponse->__toArray());
            $response->setStatusCode(Response::HTTP_OK);
        } catch (Exception $e) {
            $apiResponse->setError($e->getMessage(), $e->getCode());
            $response->setStatusCode(Response::HTTP_BAD_REQUEST);
        } catch (Error $e) {
            $apiResponse->setError($e->getMessage(), $e->getCode());
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $response->setData($apiResponse->getApiResponse());
        return $response;
    }
}



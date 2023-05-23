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
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
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

    /**
     * @Route("/login/jwt", name="app_login_jwt", methods={"POST"})
     */
    public function jwtLogin(Request $request, LogInApiUserService $logInApiUserService): Response
    {
        try {
            if (
                !$request->headers->has("content-type")
                || $request->headers->get("content-type") !== "application/json"
            ) {
                throw new BadRequestHttpException("Ivalid Request Header: 'application/json' Content Type required");
            }

            $requestParams = json_decode($request->getContent(), true);

            if (
                !isset($requestParams['email'])
                || !isset($requestParams['password'])
            ) {
                throw new BadRequestHttpException("Ivalid Request: 'email' and 'password' are required in json format");
            }

            $auth = $logInApiUserService->execute(
                new LogInUserRequest($requestParams['email'], $requestParams['password'])
            );

            $apiResponse = new JsonResponse([
                'data' => [
                    'jwt' => $auth->token(),
                    'expire' => $auth->expire()
                ]
            ], Response::HTTP_OK);
        } catch (BadRequestHttpException $e) {
            $apiResponse = new JsonResponse([
                'code' => Response::HTTP_BAD_REQUEST,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        } catch (Exception $e) {
            $apiResponse = new JsonResponse([
                'code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Unauthorized: ' . $e->getMessage()
            ], Response::HTTP_UNAUTHORIZED);
        } catch (Error $e) {
            $apiResponse = new JsonResponse([
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => 'Internal server error: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $apiResponse;
    }
}



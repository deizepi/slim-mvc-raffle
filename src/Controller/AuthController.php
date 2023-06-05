<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Model\User;

final class AuthController extends BaseController
{

    private function auth(string $email, string $pswd)
    {
        $uinfo = User::where("email", "=", $email)
            ->first();
        if ($uinfo == null) return null;
        if (!password_verify($pswd, $uinfo->password)) return null;

        return $uinfo;
    }

    public function login(Request $request, Response $response, array $args = []): Response
    {
        if ($request->getMethod() == 'POST') {
            $data = $request->getParsedBody();

            if (empty($data["email"]) || empty($data["pswd"])) {
                $this->flash->addMessage('info', 'Empty value in login/password');
                return $response->withStatus(302)->withHeader('Location', '/member/login');
            }

            // Check the user username / pass
            $uinfo = $this->auth($data["email"], $data['pswd']);
            if ($uinfo == null) {
                $this->flash->addMessage('info', 'Invalid login/password');
                return $response->withStatus(302)->withHeader('Location', '/member/login');
            }

            $session = $request->getAttribute('session');
            $session['logged'] = true;
            $session['uinfo'] = [
                'id' => $uinfo->id,
                'name' => $uinfo->name,
                'email' => $uinfo->email
            ];

            $this->flash->addMessage('info', 'Logged');
            return $response->withStatus(302)->withHeader('Location', '/');
        }
        return $this->view->render($response, 'login.twig', ['flash' => $this->flash->getMessage('info') , 'uinfo' => $request->getAttribute('uinfo')]);
    }

    public function logout(Request $request, Response $response, array $args = []): Response
    {
        $session = $request->getAttribute('session');
        $session['logged'] = false;
        unset($session['uinfo']);
        return $response->withStatus(302)->withHeader('Location', '/');
    }
}

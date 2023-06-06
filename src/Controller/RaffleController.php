<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Respect\Validation\Validator as v;

use App\Model\Raffle;

final class RaffleController extends BaseController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        if ($request->getMethod() == 'POST') {
            $data = $request->getParsedBody();
            try {
                if (!v::alpha(' ')->validate($data["name"]))
                    throw new \Exception('O nome da rifa não é válido.');
    
                if (!v::slug()->validate($data["slug"]))
                    throw new \Exception('O link da rifa não é válido.');
    
                $data["value"] = (float) str_replace(",", ".", preg_replace("/[^0-9\,]/", "", $data["value"]));
                if (!v::floatVal()->min(0.01)->validate($data["value"]))
                    throw new \Exception('O valor da rifa não é válido');
    
                if (!v::intVal()->between(100, 10000)->validate($data["quantity"]))
                    throw new \Exception('A quantidade não pode ser menor que 100 ou maior que 10.0000');

                $raffle = new Raffle($data);
                $raffle->save();
    
                $this->flash->addMessage('info', 'Rifa criada com sucesso');
                return $response->withStatus(302)->withHeader('Location', '/');
            } catch(\Exception $error) {
                $this->flash->addMessage('name', $data['name']);
                $this->flash->addMessage('slug', $data['slug']);
                $this->flash->addMessage('quantity', $data['quantity']);
                $this->flash->addMessage('error', $error->getMessage());
                return $response->withStatus(302)->withHeader('Location', '/member/raffle');
            }
        }
        return $this->render($request, $response, '/raffle/create.twig', [
            "pageTitle" => "Nova Rifa"
        ]);
    }
}

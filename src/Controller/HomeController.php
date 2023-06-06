<?php
namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Respect\Validation\Validator as v;

use App\Model\Buyer;
use App\Model\BuyerRaffle;
use App\Model\Raffle;

final class HomeController extends BaseController
{
    public function index(Request $request, Response $response, array $args = []): Response
    {
        if ($request->getMethod() == 'POST') {
            $data = $request->getParsedBody();
            try {
                if (!v::intVal()->validate($data["raffle_id"]))
                    throw new \Exception('Não encontramos nenhuma rifa com os dados fornecidos.');

                $raffle = Raffle::findOrFail($data["raffle_id"]);
                if (!$raffle)
                    throw new \Exception('Não encontramos nenhuma rifa com os dados fornecidos, por favor, tente novamente.');

                $numbers = explode(";", $data['number']);
                if (!v::each(v::intVal())->validate($numbers))
                    throw new \Exception('Um dos números fornecidos para compra não é válido.');

                if (!v::each(v::max($raffle->quantity))->validate($numbers))
                    throw new \Exception('Um dos números fornecidos para compra é maior que os números disponíveis na rifa.');

                foreach($numbers as $number) {
                    $alreadyBuyed = BuyerRaffle::where("number", "=", $number)
                        ->where("raffle_id", "=", $raffle->id)
                        ->first();
                    if ($alreadyBuyed)
                        throw new \Exception("O número {$number} já foi comprado por outro comprador");
                }

                if (!v::alpha(' ')->validate($data["name"]))
                    throw new \Exception('O nome do comprador não é válido.');
    
                if (!v::regex('/\([0-9]{2}\)\ [0-9]{4,5}\-[0-9]{4}/')->validate($data['phone']))
                    throw new \Exception('O número de telefone do comprador não é válido.');
                
                $data['phone'] = preg_replace("/[^0-9]/", "", $data['phone']);

                $buyer = Buyer::where("name", "=", $data['name'])
                    ->where("phone", "=", $data['phone'])
                    ->first();
                if (!$buyer) {
                    $buyer = new Buyer($data);
                    $buyer->save();
                } else {
                    if ($data['notes'] && $buyer->notes != $data['notes']) {
                        $buyer->notes = $data['notes'];
                        $buyer->save();
                    }
                }

                $data['buyer_id'] = $buyer->id;

                foreach ($numbers as $number) {
                    $data['number'] = $number;
                    $buyerRaffle = new BuyerRaffle($data);
                    $buyerRaffle->save();
                }
    
                $this->flash->addMessage('info', 'Compra registrada com sucesso');
                return $response->withStatus(302)->withHeader('Location', '/');
            } catch(\Exception $error) {
                $this->flash->addMessage('raffle_id', $data['raffle_id']);
                $this->flash->addMessage('number', $data['number']);
                $this->flash->addMessage('name', $data['name']);
                $this->flash->addMessage('phone', $data['phone']);
                $this->flash->addMessage('notes', $data['notes']);
                $this->flash->addMessage('error', $error->getMessage());
                return $response->withStatus(302)->withHeader('Location', '/');
            }
        }

        if (v::slug()->validate(@$args["slug"])) {
            $raffle = Raffle::where("slug", "=", $args["slug"])->first();
        } else {
            $raffle = Raffle::first();
        }

        if ($raffle) {
            $buyers = $raffle->buyers()->with(["buyer"])->get()->toArray();
            $raffle = $raffle->toArray();
            $raffle["formatted_value"] = "R$ " . number_format($raffle["value"], 2, ",", ".");
            $raffle["numbers"] = [];
            for($i = 1; $i <= $raffle["quantity"]; $i++) {
                $key = array_search($i, array_column($buyers, 'number'));
                $raffle["numbers"][] = [
                    "number" => str_pad($i, strlen($raffle["quantity"]), "0", STR_PAD_LEFT),
                    "buyer" => $key !== false ? $buyers[$key]["buyer"] : null
                ];
            }
        }

        $raffles = Raffle::all();

        return $this->render($request, $response, 'index.twig', [ 
            'raffles' => $raffles->toArray(),
            'raffle' => $raffle
        ]);
    }
}

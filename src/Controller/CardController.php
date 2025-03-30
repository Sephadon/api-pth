<?php

namespace App\Controller;

use App\Repository\CardRepository;
use App\Service\DealTheCards;
use App\Entity\Card;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\RateLimiter\RateLimiterFactory;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

use Nelmio\ApiDocBundle\Attribute\Model;
use Nelmio\ApiDocBundle\Attribute\Security;
use OpenApi\Attributes as OA;

class CardController extends AbstractController
{
    // Récupérer les 52 cartes
    #[OA\Tag(name: 'Cards', description: 'Collect all the cards')]
    #[Route('/api/cards', name: 'card', methods: ['GET'])]
    public function getCards(Request $request, RateLimiterFactory $anonymousApiLimiter, CardRepository $cardRepository, SerializerInterface $serializer): JsonResponse
    {
        $limiter = $anonymousApiLimiter->create($request->getClientIp());
        if (false === $limiter->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException(JsonResponse::HTTP_BAD_REQUEST, "Vous avez dépassé le nombre de requêtes autorisées");
        }

        $cardList = $cardRepository->findAll();
        $jsonCardList = $serializer->serialize($cardList, 'json');
        return new JsonResponse($jsonCardList, Response::HTTP_OK, [], true);
    }

    
    // Récupérer une donne    
    #[Route('/api/game/{nbrPlayers}', name: 'game', methods: ['GET'])]
    #[OA\Response(
        response: 200,
        description: 'Returns a deal according to the number of players',
        content: new OA\JsonContent(
            type: 'array',
            items: new OA\Items(ref: new Model(type: Card::class))
        )
    )]
    #[OA\Parameter(
        name: 'nbrPlayers',
        in: 'path',
        description: 'Enter the number of players',
        required: true,
        schema: new OA\Schema(type: 'integer')
    )]
    #[OA\Tag(name: 'Game', description: 'Collect a deal according to the number of players')]
    public function game(Request $request, RateLimiterFactory $anonymousApiLimiter, int $nbrPlayers,CardRepository $cardRepository, SerializerInterface $serializer): JsonResponse
    {
        $limiter = $anonymousApiLimiter->create($request->getClientIp());
        if (false === $limiter->consume(1)->isAccepted()) {
            throw new TooManyRequestsHttpException(JsonResponse::HTTP_BAD_REQUEST, "Vous avez dépassé le nombre de requêtes autorisées");
        }

        if ($nbrPlayers < 2 || $nbrPlayers > 6) {
            throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, "Le nombre de joueurs doit être supérieur ou égale à 2 et inférieur ou égale à 6");
        } elseif (!is_int($nbrPlayers)) {
            throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, "La valeur doit être un entier supérieur ou égale à 2 et inférieur ou égale à 6");
        }

        $cardsList = $cardRepository->findAll();

        $dealTheCards = new DealTheCards;
        
        $cardsDealt = $dealTheCards->distribute($nbrPlayers, $cardsList);

        $jsonCardsDealt = $serializer->serialize($cardsDealt, 'json');
        return new JsonResponse($jsonCardsDealt, Response::HTTP_OK, [], true);
    }
}

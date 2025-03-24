<?php

namespace App\Controller;

use App\Repository\CardRepository;
use App\Service\DealTheCards;
use Doctrine\Migrations\Configuration\Migration\JsonFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CardController extends AbstractController
{
    // Retrieve all cards
    #[Route('/api-pth/cards', name: 'card', methods: ['GET'])]
    public function getCards(CardRepository $cardRepository, SerializerInterface $serializer): JsonResponse
    {
        $cardList = $cardRepository->findAll();
        $jsonCardList = $serializer->serialize($cardList, 'json');
        return new JsonResponse($jsonCardList, Response::HTTP_OK, [], true);
    }

    // Retrieve a set
    #[Route('/api-pth/game/{nbrPlayers}', name: 'game', methods: ['GET'])]
    public function game(int $nbrPlayers,CardRepository $cardRepository, SerializerInterface $serializer): JsonResponse {

        if ($nbrPlayers < 2 || $nbrPlayers > 6) {
            throw new HttpException(JsonResponse::HTTP_BAD_REQUEST, "Le nombre de joueurs doit être compris entre 2 et 6");
        }

        $cardsList = $cardRepository->findAll();

        $dealTheCards = new DealTheCards;
        
        $cardsDealt = $dealTheCards->distribute($nbrPlayers, $cardsList);

        $jsonCardsDealt = $serializer->serialize($cardsDealt, 'json');
        return new JsonResponse($jsonCardsDealt, Response::HTTP_OK, [], true);
    }
}

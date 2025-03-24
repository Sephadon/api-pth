<?php
namespace App\Service;

// Distribution des cartes => DealTheCards
class DealTheCards
{
    public array $cardsDealt = ['cardsPlayers' => [], 'board' => []];

    public function distribute(int $nbrPlayers, $cardsList): array
    {
        // index of the card at the top of the pile
        $cardIndex = 0;

        // shuffle the cards
        $cardsListShuffled = $cardsList;
        shuffle($cardsListShuffled);

        // Distribution of PLAYERS' cards - FIRST ROUND TABLE
        for ($i = $cardIndex; $i < $nbrPlayers; $i++) {
            $this->cardsDealt['cardsPlayers'][] = [$cardsListShuffled[$i]];
            unset($cardsListShuffled[$i]);
            if ($i === $nbrPlayers - 1) {
                $cardIndex = $i+1;
            }
        }

        // Distribution of PLAYERS' cards - SECOND ROUND OF TABLES
        for ($i = $cardIndex; $i < $nbrPlayers+$cardIndex; $i++) {
            $this->cardsDealt['cardsPlayers'][$i-$cardIndex][] = $cardsListShuffled[$i];
            unset($cardsListShuffled[$i]);
        }
        $cardIndex = $cardIndex + $nbrPlayers;

        // we burn a card before flop
        unset($cardsListShuffled[$cardIndex]);
        $cardIndex++;

        // FLOP
        for ($i = 0; $i < 3; $i++) {
            $this->cardsDealt['board'][] = $cardsListShuffled[$cardIndex];
            unset($cardsListShuffled[$cardIndex]);
            $cardIndex++;
        }

        // we burn a card before turn
        unset($cardsListShuffled[$cardIndex]);
        $cardIndex++;

        // TURN
        $this->cardsDealt['board'][] = $cardsListShuffled[$cardIndex];
        unset($cardsListShuffled[$cardIndex]);
        $cardIndex++;

        // we burn a card before river
        unset($cardsListShuffled[$cardIndex]);
        $cardIndex++;

        // RIVER
        $this->cardsDealt['board'][] = $cardsListShuffled[$cardIndex];
        unset($cardsListShuffled[$cardIndex]);

        return $this->cardsDealt;
    }
}
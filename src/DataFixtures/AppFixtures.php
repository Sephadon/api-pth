<?php

namespace App\DataFixtures;

use App\Entity\Card;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Convertir un fichier CSV en tableau associatif PHP
        function convertCsvToPhp()
        {
            $file_csv = fopen('src/playing-cards.csv', 'r');
            while (!feof($file_csv))
            {
                $cardsCsv[] = fgetcsv($file_csv, 1024, ';');
            }
            fclose($file_csv);

            $firstEntryArray = $cardsCsv[0];

            $propertiesArrayKeys = [];
            foreach ($firstEntryArray as $key)
            {
                $propertiesArrayKeys[] = $key;
                // array_push($propertiesArrayKeys, $key);
            }

            $cards = array();
            for($i = 1; $i < count($cardsCsv) - 1; $i++)
            {
                $card = array();
                for ($i2 = 0; $i2 < count($propertiesArrayKeys); $i2++)
                {
                    if (isset($cardsCsv[$i][$i2]))
                    {
                        $card[$propertiesArrayKeys[$i2]] = $cardsCsv[$i][$i2];
                    }
                }
                array_push($cards, $card);
            }

            return $cards;
        }

        $cards = convertCsvToPhp();

        for ($i =0; $i < count($cards); $i++) {
            $card = new Card;
            $card->setName($cards[$i]['name']);
            $card->setHeightId($cards[$i]['height_id']);
            $card->setImageUrl("https://websworld.fr/images/card_".$cards[$i]['name']);
            $manager->persist($card);
        }

        $manager->flush();
    }
}

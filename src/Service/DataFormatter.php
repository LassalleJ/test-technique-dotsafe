<?php

namespace App\Service;

use DateTime;

class DataFormatter
{
    public function formatDataFromApi(array $dataFromApi, Datetime $fixedDate): array
    {
        $arrayOfEvent = [];
        foreach ($dataFromApi as $data) {

            $passageDateClosureString = $data['fields']['date_passage'] . ' ' . $data['fields']['fermeture_a_la_circulation'];
            $passageDateOpeningString = $data['fields']['date_passage'] . ' ' . $data['fields']['re_ouverture_a_la_circulation'];
            $reason = $data['fields']['bateau'];

            $passageDateClosure = new DateTime($passageDateClosureString);
            $passageDateOpening = new DateTime($passageDateOpeningString);
            if($passageDateOpening>$fixedDate) {
                if ($passageDateClosure>$passageDateOpening) {
                    $passageDateOpening=$passageDateOpening->modify('+1 day');
                }

                $passageDateClosure = $passageDateClosure->format("d-m-Y à H:i:s");
                $passageDateOpening = $passageDateOpening->format("d-m-Y à H:i:s");
                $closureEvent = [
                    'closureHour' => $passageDateClosure,
                    'reOpenHour' => $passageDateOpening,
                    'reason' => $reason,
                ];
                $arrayOfEvent[] = $closureEvent;
            }


        }
        return $arrayOfEvent;
    }
}
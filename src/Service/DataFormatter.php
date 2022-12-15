<?php

namespace App\Service;

use DateTime;

class DataFormatter
{
    public function formatDataFromApi(array $dataFromApi): array
    {
        $arrayOfEvent = [];
        foreach ($dataFromApi as $data) {
            $passageDateClosureString = $data['fields']['date_passage'] . ' ' . $data['fields']['fermeture_a_la_circulation'];
            $passageDateOpeningString = $data['fields']['date_passage'] . ' ' . $data['fields']['re_ouverture_a_la_circulation'];
            $reason = $data['fields']['bateau'];
            $passageDateClosure = new DateTime($passageDateClosureString);
            $passageDateOpening = new DateTime($passageDateOpeningString);
            $closureEvent = [
                'closureHour' => $passageDateClosureString,
                'reOpenHour' => $passageDateOpeningString,
                'reason' => $reason,
            ];
            $arrayOfEvent[] = $closureEvent;
        }
        return $arrayOfEvent;
    }
}
<?php

namespace App\Service;

use DateTime;

class DataFormatter
{
    public function formatDataFromApi(array $dataFromApi, Datetime $fixedDate): array
    {
        $arrayOfEvent = [];
        foreach ($dataFromApi as $data) {

            // Get the date and hour of closure and reopening in a unique string

            $passageDateClosureString = $data['fields']['date_passage'] . ' ' . $data['fields']['fermeture_a_la_circulation'];
            $passageDateOpeningString = $data['fields']['date_passage'] . ' ' . $data['fields']['re_ouverture_a_la_circulation'];
            $reason = $data['fields']['bateau'];

            // Create DateTime object from those strings

            $passageDateClosure = new DateTime($passageDateClosureString);
            $passageDateOpening = new DateTime($passageDateOpeningString);

            // Check if the closure event occurs after the fake 'current day' date

            if ($passageDateOpening > $fixedDate) {

                // In the case of maintenance, the reopening occurs the day after the closure of the bridge, adding +1 day to the variable was necessary

                if ($passageDateClosure > $passageDateOpening) {
                    $passageDateOpening = $passageDateOpening->modify('+1 day');
                }

                // Format the date and hour of the events

                $passageDateClosureString = $passageDateClosure->format("d-m-Y à H:i:s");
                $passageDateOpeningString = $passageDateOpening->format("d-m-Y à H:i:s");

                // Add every required data of an event inside an array

                $closureEvent = [
                    'closureHour' => $passageDateClosureString,
                    'reOpenHour' => $passageDateOpeningString,
                    'reason' => $reason,
                    'closureHourObject' => $passageDateClosure
                ];

                // Add this array to another to get an array of array of all events
                $arrayOfEvent[] = $closureEvent;
            }
        }

        // Sort the array of event

        $key_values = array_column($arrayOfEvent, 'closureHourObject');
        array_multisort($key_values, SORT_ASC, $arrayOfEvent);
        return $arrayOfEvent;
    }
}
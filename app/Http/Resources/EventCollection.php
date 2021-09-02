<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class EventCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        if ($request->days === null) {
            return parent::toArray(['message' => 'unsupported request, please check documentation']);
        }

        if ($request->format === 'grid') {
            // group result into seperate dates, need to be done to carry out further proccesing of 
            // the data
            $collectionByDate = $this->mapToGroups(fn ($item) => [$item['booked_date'] => $item]);

            #create array with range of days from 0 to numebro of days minus 1
            $numberOfDays = range(0, $request->days - 1);
            $startDate = $request->from;

            // get longest number of events in a day to generate right amount of rows for table
            // and generate array with dates to map through.
            $longestArray = 0;
            foreach ($collectionByDate as $value) {
                if (count($value) > $longestArray) {
                    $longestArray = count($value);
                }
            }

            // create array with date from starting date to last day calculated by provided number of days
            $days = array();
            foreach ($numberOfDays as $value) {
                array_push($days, date('Y-m-d', strtotime($startDate . ' + ' . $value . ' days')));
            }

            // below funcion takes collectionByDate object and generate data in grid format
            $a = 0;
            $gridMap = array();
            while ($a !== $longestArray) {
                $row = array();
                foreach ($days as $key => $value) {
                    if (isset($collectionByDate[$value][$a])) {
                        array_push($row, $collectionByDate[$value][$a]);
                    } else {
                        array_push($row, ["is_used" => false]);
                    }
                }

                array_push($gridMap, $row);
                $a += 1;
            }


            return [
                'data' => $gridMap
            ];
        }
        return parent::toArray($request);
    }

    public function with($request)
    {
        if ($request->format === "grid") {
            $format = "grid";
        } else {
            $format = "list";
        }
        return [
            'first_day' => $request->from,
            'number_of_days' => $request->days,
            'format_type' => $format,
            'valid_as_of' => date('D, d M Y H:i:s'),
            'version' => env('APP_VER'),
        ];
    }
}

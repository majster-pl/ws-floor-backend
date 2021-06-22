<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class StatsCollection extends ResourceCollection
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

        // group result into seperate dates, need to be done to carry out further proccesing of 
        // the data
        $collectionByDate = $this->mapToGroups(fn ($item) => [$item['booked_date'] => $item]);

        #create array with range of days from 0 to numebro of days minus 1
        $numberOfDays = range(0, $request->days - 1);
        $startDate = $request->from;

        // get longest number of events in a day to generate right amount of rows for table
        // and generate array with dates to map through.
        // $longestArray = 0;
        // foreach ($collectionByDate as $value) {
        //     if (count($value) > $longestArray) {
        //         $longestArray = count($value);
        //     }
        // }

        // create array with date from starting date to last day calculated by provided number of days
        $days = array();
        foreach ($numberOfDays as $value) {
            array_push($days, date('Y-m-d', strtotime($startDate . ' + ' . $value . ' days')));
        }

        // below funcion takes collectionByDate object and generate data in grid format
        $a = 0;
        $gridMap = array();
        $row = array();
        foreach ($days as $key => $value) {
            if (isset($collectionByDate[$value][$a])) {
                array_push($row, [date('d/m', strtotime($value)), count($collectionByDate[$value])]);
            } else {
                array_push($row, [date('d/m', strtotime($value)), 0]);
            }
        }

        // array_push($gridMap, $row);


        return $row;
        // return parent::toArray($request);
    }
}

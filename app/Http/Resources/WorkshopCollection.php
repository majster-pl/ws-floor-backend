<?php

namespace App\Http\Resources;

use App\Models\Event;

use function PHPSTORM_META\map;
use Illuminate\Http\Resources\Json\ResourceCollection;

class WorkshopCollection extends ResourceCollection
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
        $eventsByDate = $this->sortBy('booked_date')->mapToGroups(fn ($item) => [$item['status'] => $item->id]);
        $tasksByOrder = $this->sortBy('order')->mapToGroups(fn ($item) => [$item['status'] => $item->id]);
        // $tasks = $this->map(fn ($item) => [$item->id => [$item]]);
        // $tasks2 = (object) array();
        function setOrder($grouped)
        {
            $eventIndex = 0;
            foreach ($grouped as $key => $value) {
                $order = ['order' => $eventIndex];
                $event = Event::find($value);
                $event->update($order);
                $eventIndex += 1;
                // return [$value];
            }
            return $grouped;
        }

        // setOrder($tasksByOrder['awaiting_estimates']);
        // setOrder($tasksByOrder->all());

        $columns = [
            'booked' => [
                'id' => 'booked',
                'title' => 'Due in Today',
                'taskIds' => isset($eventsByDate['booked']) ? $eventsByDate['booked'] : []
            ],
            'awaiting_workshop' => [
                'id' => 'awaiting_workshop',
                'title' => 'Waiting Labour',
                'taskIds' => isset($tasksByOrder['awaiting_workshop']) ? setOrder($tasksByOrder['awaiting_workshop']) : []
            ],

            'awaiting_estimates' => [
                'id' => 'awaiting_estimates',
                'title' => 'Awaiting Estimates',
                'taskIds' => isset($eventsByDate['awaiting_estimates']) ? $eventsByDate['awaiting_estimates'] : []
            ],
            'awaiting_part' => [
                'id' => 'awaiting_part',
                'title' => 'Waiting Parts',
                'taskIds' => isset($eventsByDate['awaiting_part']) ? $eventsByDate['awaiting_part'] : []
            ],
            'work_in_progress' => [
                'id' => 'work_in_progress',
                'title' => 'Work in progress',
                'taskIds' => isset($tasksByOrder['work_in_progress']) ? $tasksByOrder['work_in_progress'] : []
            ],


        ];


        $tasks = $this->all();
        $tasks2 = new \stdClass;
        foreach ($tasks as $key => $value) {
            $a = $value->id;
            $tasks2->{$a} = $value;
            // $tasks2[$a];
            // array_push($tasks2, $value->id);

        }

        $columnOrder = [
            'booked',
            'awaiting_workshop',
            'awaiting_estimates',
            'awaiting_part',
            'work_in_progress',
        ];


        // foreach ($tasksStatus as $value) {
        //     array_push($tasks);
        // }

        return [
            'tasks' => $tasks2,
            'columns' => $columns,
            'columnOrder' => $columnOrder,
        ];
    }

    public function with($request)
    {
        return [
            'version' => env('APP_VER'),
            'valid_as_of' => date('D, d M Y H:i:s'),
        ];
    }
}

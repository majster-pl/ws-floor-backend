<?php

namespace App\Http\Resources;

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
        $tasks = $this->all();
        $tasksByStatus = $this->mapToGroups(fn ($item) => [$item['status'] => $item->id]);
        // $tasks = $this->map(fn ($item) => [$item->id => [$item]]);
        // $tasks2 = (object) array();
        $tasks2 = new \stdClass;
        foreach ($tasks as $key => $value) {
            $a = $value->id;
            $tasks2->{$a} = $value;
            // $tasks2[$a];
            // array_push($tasks2, $value->id);

        }
        $columns = [
            'booked' => [
                'id' => 'booked',
                'title' => 'Due in Today',
                'taskIds' => isset($tasksByStatus['booked']) ? $tasksByStatus['booked'] : []
            ],
            'awaiting_workshop' => [
                'id' => 'awaiting_workshop',
                'title' => 'Waiting Labour',
                'taskIds' => isset($tasksByStatus['awaiting_workshop']) ? $tasksByStatus['awaiting_workshop'] : []
            ],

            'awaiting_estimates' => [
                'id' => 'awaiting_estimates',
                'title' => 'Awaiting Estimates',
                'taskIds' => isset($tasksByStatus['awaiting_estimates']) ? $tasksByStatus['awaiting_estimates'] : []
            ],
            'awaiting_part' => [
                'id' => 'awaiting_part',
                'title' => 'Waiting Parts',
                'taskIds' => isset($tasksByStatus['awaiting_part']) ? $tasksByStatus['awaiting_part'] : []
            ],
            'work_in_progress' => [
                'id' => 'work_in_progress',
                'title' => 'Work in progress',
                'taskIds' => isset($tasksByStatus['work_in_progress']) ? $tasksByStatus['work_in_progress'] : []
            ],


        ];

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
            'columnOrder' => $columnOrder
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

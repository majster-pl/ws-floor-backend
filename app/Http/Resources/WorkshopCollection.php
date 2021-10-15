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
        $tasks = $this->all();
        // $tasksGrouped = $this->mapToGroups(fn ($item) => [$item['status'] => $item]);
        $eventIdsByDate = $this->sortByDesc('booked_date_time')->mapToGroups(fn ($item) => [$item['status'] => $item->id]);
        $taskIdsByOrder = $this->sortBy('order')->mapToGroups(fn ($item) => [$item['status'] => $item->id]);
        // $tasks = $this->map(fn ($item) => [$item->id => [$item]]);
        // $tasksList = (object) array();
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

        // reset order numbers
        // foreach ($tasksGrouped as $key => $value) {
        //     setOrder($taskIdsByOrder[$key]);
        // }


        $columns = [
            'booked' => [
                'id' => 'booked',
                'title' => 'Due in Today',
                'options' => 'read-only',
                'taskIds' => isset($eventIdsByDate['booked']) ? $eventIdsByDate['booked'] : [],
                // 'total_time' => 20,
            ],
            'awaiting_labour' => [
                'id' => 'awaiting_labour',
                'title' => 'Waiting Labour',
                'taskIds' => isset($taskIdsByOrder['awaiting_labour']) ? $taskIdsByOrder['awaiting_labour'] : [],
                // 'total_time' => 20,
            ],
            'planned' => [
                'id' => 'planned',
                'title' => 'Planned',
                'taskIds' => isset($taskIdsByOrder['planned']) ? $taskIdsByOrder['planned'] : [],
            ],
            'work_in_progress' => [
                'id' => 'work_in_progress',
                'title' => 'Work in progress',
                'taskIds' => isset($taskIdsByOrder['work_in_progress']) ? $taskIdsByOrder['work_in_progress'] : []
            ],
            'awaiting_estimates' => [
                'id' => 'awaiting_estimates',
                'title' => 'Awaiting Estimates',
                'taskIds' => isset($taskIdsByOrder['awaiting_estimates']) ? $taskIdsByOrder['awaiting_estimates'] : []
            ],
            'awaiting_part' => [
                'id' => 'awaiting_part',
                'title' => 'Waiting Parts',
                'taskIds' => isset($taskIdsByOrder['awaiting_part']) ? $taskIdsByOrder['awaiting_part'] : []
            ],
            'awaiting_authorisation' => [
                'id' => 'awaiting_authorisation',
                'title' => 'Awaiting Authorisation',
                'taskIds' => isset($taskIdsByOrder['awaiting_authorisation']) ? $taskIdsByOrder['awaiting_authorisation'] : []
            ],
            'awaiting_qc' => [
                'id' => 'awaiting_qc',
                'title' => 'Awaiting QC',
                'taskIds' => isset($taskIdsByOrder['awaiting_qc']) ? $taskIdsByOrder['awaiting_qc'] : []
            ],
            'at_3rd_party' => [
                'id' => 'at_3rd_party',
                'title' => 'At 3rd Party',
                'taskIds' => isset($taskIdsByOrder['at_3rd_party']) ? $taskIdsByOrder['at_3rd_party'] : []
            ],
            'completed' => [
                'id' => 'completed',
                'title' => 'Ready',
                'taskIds' => isset($taskIdsByOrder['completed']) ? $taskIdsByOrder['completed'] : []
            ],

        ];


        $tasksList = new \stdClass;
        foreach ($tasks as $key => $value) {
            $a = $value->id;
            $tasksList->{$a} = $value;
            // $tasksList[$a];
            // array_push($tasksList, $value->id);

        }

        $columnOrder = [
            'booked',
            'awaiting_labour',
            'planned',
            'work_in_progress',
            'awaiting_estimates',
            'awaiting_part',
            'awaiting_authorisation',
            'awaiting_qc',
            'at_3rd_party',
            'completed',
        ];


        // foreach ($tasksStatus as $value) {
        //     array_push($tasks);
        // }

        return [
            'tasks' => $tasksList,
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

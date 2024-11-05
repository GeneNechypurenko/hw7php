<?php
class Organizer {
    private $dataFile = 'data.json';

    private function loadTasks() {
        if (file_exists($this->dataFile)) {
            $jsonData = file_get_contents($this->dataFile);
            return json_decode($jsonData, true);
        }
        return [];
    }

    private function saveTasks($tasks) {
        file_put_contents($this->dataFile, json_encode($tasks));
    }

    public function addTask($date, $time, $description) {
        $tasks = $this->loadTasks();
        $tasks[] = [
            'date' => $date,
            'time' => $time,
            'description' => $description
        ];
        $this->saveTasks($tasks);
    }

    public function removeTask($index) {
        $tasks = $this->loadTasks();
        if (isset($tasks[$index])) {
            array_splice($tasks, $index, 1);
            $this->saveTasks($tasks);
        }
    }

    public function getTasksByDate($date) {
        $tasks = $this->loadTasks();
        return array_filter($tasks, function($task) use ($date) {
            return $task['date'] === $date;
        });
    }

    public function getTasksForWeek() {
        $tasks = $this->loadTasks();
        $startDate = new DateTime();
        $endDate = (clone $startDate)->modify('+7 days');

        return array_filter($tasks, function($task) use ($startDate, $endDate) {
            $taskDate = new DateTime($task['date']);
            return $taskDate >= $startDate && $taskDate <= $endDate;
        });
    }

    public function getTasksForMonth() {
        $tasks = $this->loadTasks();
        $startDate = new DateTime();
        $endDate = (clone $startDate)->modify('+1 month');

        return array_filter($tasks, function($task) use ($startDate, $endDate) {
            $taskDate = new DateTime($task['date']);
            return $taskDate >= $startDate && $taskDate <= $endDate;
        });
    }
}
?>

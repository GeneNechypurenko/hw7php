<?php
include 'Organizer.php';
$organizer = new Organizer();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addTask'])) {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $description = $_POST['description'];
    $organizer->addTask($date, $time, $description);
}

if (isset($_GET['delete'])) {
    $organizer->removeTask($_GET['delete']);
}

$todayTasks = $organizer->getTasksByDate(date('Y-m-d'));
$weekTasks = $organizer->getTasksForWeek();
$monthTasks = $organizer->getTasksForMonth();
?>

<!DOCTYPE html>
<html lang="ru">
<?php include 'partials/head.php'; ?>
<body class="bg-light">
<?php include 'partials/navbar.php'; ?>

<div class="container mt-5">
    <div class="card p-4 shadow" style="max-width: 600px; margin: 0 auto;">
        <h2 class="text-center">Органайзер</h2>

        <form method="POST" class="mt-3">
            <div class="mb-3">
                <label for="date" class="form-label">Дата:</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Время:</label>
                <input type="time" name="time" id="time" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание:</label>
                <textarea name="description" id="description" class="form-control" required></textarea>
            </div>
            <button type="submit" name="addTask" class="btn btn-primary w-100">Добавить задачу</button>
        </form>
    </div>

    <div class="card mt-5 p-4 shadow" style="max-width: 800px; margin: 0 auto;">
        <h3>Дела на сегодня</h3>
        <?php if ($todayTasks): ?>
            <ul class="list-group mt-3">
                <?php foreach ($todayTasks as $index => $task): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <?= $task['time'] ?> - <?= $task['description'] ?>
                        <a href="?delete=<?= $index ?>" class="btn btn-sm btn-danger">Отменить</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="mt-3">На сегодня дел нет.</p>
        <?php endif; ?>
    </div>

    <div class="card mt-5 p-4 shadow" style="max-width: 800px; margin: 0 auto;">
        <h3>Дела на неделю</h3>
        <?php if ($weekTasks): ?>
            <ul class="list-group mt-3">
                <?php foreach ($weekTasks as $index => $task): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><?= $task['date'] ?> <?= $task['time'] ?> - <?= $task['description'] ?>
                        <a href="?delete=<?= $index ?>" class="btn btn-sm btn-danger">Отменить</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="mt-3">На неделю дел нет.</p>
        <?php endif; ?>
    </div>

    <div class="card mt-5 p-4 shadow mb-5" style="max-width: 800px; margin: 0 auto;">
        <h3>Дела на месяц</h3>
        <?php if ($monthTasks): ?>
            <ul class="list-group mt-3">
                <?php foreach ($monthTasks as $index => $task): ?>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><?= $task['date'] ?> <?= $task['time'] ?> - <?= $task['description'] ?>
                        <a href="?delete=<?= $index ?>" class="btn btn-sm btn-danger">Отменить</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="mt-3">На месяц дел нет.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

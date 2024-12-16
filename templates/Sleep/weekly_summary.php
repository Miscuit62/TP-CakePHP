<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }

    table th {
        background-color: #f4f4f4;
    }

    canvas {
        margin-top: 20px;
    }
</style>
<h1>Résumé hebdomadaire</h1>
<p>Semaine du <strong><?= h($startOfWeek) ?></strong> au <strong><?= h($endOfWeek) ?></strong></p>
<h2>Statistiques</h2>
<ul>
    <li>Total de cycles de sommeil : <strong><?= $totalCycles ?></strong> <?= $indicators['totalCyclesGreen'] ? '<span style="color:green;">✔</span>' : '<span style="color:red;">✘</span>' ?></li>
    <li>4 jours consécutifs avec au moins 5 cycles : <?= $indicators['consecutiveDaysGreen'] ? '<span style="color:green;">✔</span>' : '<span style="color:red;">✘</span>' ?></li>
</ul>
<h2>Détails par jour</h2>
<table>
    <thead>
        <tr>
            <th>Date</th>
            <th>Heure de coucher</th>
            <th>Heure de lever</th>
            <th>Cycles</th>
            <th>Sieste AM</th>
            <th>Sieste PM</th>
            <th>Sport</th>
            <th>Score matin</th>
            <th>Commentaire</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($weeklyData as $day): ?>
            <tr>
                <td><?= h($day->sleep_date) ?></td>
                <td><?= h($day->sleep_start) ?></td>
                <td><?= h($day->sleep_end) ?></td>
                <td><?= h($day->cycles) ?></td>
                <td><?= $day->nap_afternoon ? '✔' : '✘' ?></td>
                <td><?= $day->nap_evening ? '✔' : '✘' ?></td>
                <td><?= $day->sport ? '✔' : '✘' ?></td>
                <td><?= h($day->morning_score) ?></td>
                <td><?= h($day->comment) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h2>Graphiques</h2>
<div>
    <h3>Cycles de sommeil</h3>
    <canvas id="cyclesChart" width="400" height="200"></canvas>
</div>
<br>
<div>
    <h3>Score du matin</h3>
    <canvas id="morningScoreChart" width="400" height="200"></canvas>
</div>
<br>
<div>
    <h3>Répartitions siestes et sport</h3>
    <canvas id="napSportDonutChart" width="400" height="200"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = <?= json_encode($labels) ?>;
    const cyclesData = <?= json_encode($cyclesData) ?>;
    const morningScores = <?= json_encode(array_map(fn($day) => $day->morning_score ?? 0, $weeklyData)) ?>;
    const napAMTotal = <?= array_sum(array_map(fn($day) => $day->nap_afternoon ? 1 : 0, $weeklyData)) ?>;
    const napPMTotal = <?= array_sum(array_map(fn($day) => $day->nap_evening ? 1 : 0, $weeklyData)) ?>;
    const sportTotal = <?= array_sum(array_map(fn($day) => $day->sport ? 1 : 0, $weeklyData)) ?>;
    console.log('Total Siestes AM:', napAMTotal);
    console.log('Total Siestes PM:', napPMTotal);
    console.log('Total Sport:', sportTotal);

    if (labels.length === 0 || cyclesData.length === 0) {
        console.error('Les données pour les graphiques sont incomplètes.');
    } else {
        const cyclesCtx = document.getElementById('cyclesChart').getContext('2d');
        new Chart(cyclesCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cycles de sommeil',
                    data: cyclesData,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.5)',
                    fill: true,
                    borderWidth: 2
                }]
            }
        });

        const morningScoreCtx = document.getElementById('morningScoreChart').getContext('2d');
        new Chart(morningScoreCtx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Score du matin',
                    data: morningScores,
                    backgroundColor: 'rgba(153, 102, 255, 0.5)',
                    borderColor: 'rgba(153, 102, 255, 1)',
                    borderWidth: 1
                }]
            }
        });

        const napSportCtx = document.getElementById('napSportDonutChart').getContext('2d');
        new Chart(napSportCtx, {
            type: 'doughnut',
            data: {
                labels: ['Sieste AM', 'Sieste PM', 'Sport'],
                datasets: [{
                    data: [napAMTotal, napPMTotal, sportTotal],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)', 
                        'rgba(255, 99, 132, 0.5)'
                    ],
                    borderColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top'
                    }
                }
            }
        });
    }
</script>

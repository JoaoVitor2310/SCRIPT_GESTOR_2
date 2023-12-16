<?php defined('ALTUMCODE') || die() ?>

<?php ob_start() ?>
<div class="card mb-5">
    <div class="card-body">
        <h2 class="h4"><i class="fa fa-fw fa-server fa-xs text-muted"></i> <?= language()->admin_statistics->monitors->header ?></h2>

        <div class="chart-container">
            <canvas id="monitors"></canvas>
        </div>
    </div>
</div>

<?php $html = ob_get_clean() ?>

<?php ob_start() ?>
<script>
    'use strict';

    let color = css.getPropertyValue('--primary');
    let color_gradient = null;

    /* Display chart */
    let monitors_chart = document.getElementById('monitors').getContext('2d');
    color_gradient = monitors_chart.createLinearGradient(0, 0, 0, 250);
    color_gradient.addColorStop(0, 'rgba(63, 136, 253, .1)');
    color_gradient.addColorStop(1, 'rgba(63, 136, 253, 0.025)');

    new Chart(monitors_chart, {
        type: 'line',
        data: {
            labels: <?= $data->monitors_chart['labels'] ?>,
            datasets: [
                {
                    label: <?= json_encode(language()->admin_statistics->monitors->chart) ?>,
                    data: <?= $data->monitors_chart['monitors'] ?? '[]' ?>,
                    backgroundColor: color_gradient,
                    borderColor: color,
                    fill: true
                }
            ]
        },
        options: chart_options
    });
</script>
<?php $javascript = ob_get_clean() ?>

<?php return (object) ['html' => $html, 'javascript' => $javascript] ?>

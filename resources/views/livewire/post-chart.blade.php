<div>
    <canvas id="postChart" width="400" height="200"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js">
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('postChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json(array_keys($chartData)),
                    datasets: [{
                        label: 'Post Per Day',
                        data: @json(array_values($chartData)),
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</div>

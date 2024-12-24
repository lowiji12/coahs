@extends('layouts.admin')

@section('content')
<div class="container-fluid py-6">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 text-center">Dashboard</h1>
            <p class="text-center text-muted">Overview of Metrics</p>
        </div>
    </div>
    <div class="row gy-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">Gender Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">Program Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="programChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">Year Level Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="yearLevelChart"></canvas>
                </div>
            </div>
        </div>
        F
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    boxWidth: 12,
                    padding: 10
                }
            },
            tooltip: {
                bodyFont: {
                    size: 12
                },
                titleFont: {
                    size: 14
                }
            }
        }
    };

    // Gender Distribution Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                data: [60, 40],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                ],
                borderWidth: 1
            }]
        },
        options: chartOptions
    });

    // Program Distribution Chart
    const programCtx = document.getElementById('programChart').getContext('2d');
    new Chart(programCtx, {
        type: 'doughnut',
        data: {
            labels: ['BS in Nursing', 'BS in Midwifery', 'BS in Pharmacy'],
            datasets: [{
                data: [50, 30, 20],
                backgroundColor: [
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                ],
                borderWidth: 1
            }]
        },
        options: chartOptions
    });

    // Year Level Distribution Chart
    const yearLevelCtx = document.getElementById('yearLevelChart').getContext('2d');
    new Chart(yearLevelCtx, {
        type: 'doughnut',
        data: {
            labels: ['1st Year', '2nd Year', '3rd Year', '4th Year'],
            datasets: [{
                data: [25, 25, 25, 25],
                backgroundColor: [
                    'rgba(255, 159, 64, 0.8)',
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                ],
                borderWidth: 1
            }]
        },
        options: chartOptions
    });
</script>
@endsection
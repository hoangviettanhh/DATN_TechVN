@extends('admin.main')
@section('content')
<div class="content-header">
    <div class="row mb-2">
        <div class="col-sm-6">
        </div>
        <div class="col-sm-6">
            <div class="float-end">
                <form action="{{ route('admin.dashboard') }}" method="GET" class="d-inline-block">
                    <div class="input-group">
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                    Năm {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Biểu đồ doanh số -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Thống kê doanh số theo tháng</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ đơn hàng hủy -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Đơn hàng bị hủy theo tháng</h5>
            </div>
            <div class="card-body">
                <canvas id="cancelledChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Biểu đồ đơn hàng pending -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Đơn hàng chờ xử lý trong ngày</h5>
            </div>
            <div class="card-body">
                <canvas id="pendingChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Biểu đồ doanh số
    new Chart(document.getElementById('revenueChart'), {
        type: 'bar',
        data: @json($revenueChart),
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(value);
                        }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return new Intl.NumberFormat('vi-VN', {
                                style: 'currency',
                                currency: 'VND'
                            }).format(context.raw);
                        }
                    }
                }
            }
        }
    });

    // Biểu đồ đơn hàng hủy
    new Chart(document.getElementById('cancelledChart'), {
        type: 'bar',
        data: @json($cancelledChart),
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Biểu đồ đơn hàng pending
    new Chart(document.getElementById('pendingChart'), {
        type: 'line',
        data: @json($pendingChart),
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
});
</script>
@endsection 
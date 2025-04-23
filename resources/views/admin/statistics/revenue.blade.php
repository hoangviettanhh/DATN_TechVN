@extends('admin.main')
@section('content')
<div class="content-header">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h4 class="page-title">Thống kê doanh số</h4>
            <div class="breadcrumb">
                <span class="me-2"><i class="fas fa-home"></i></span>
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a>
                <span class="mx-2">/</span>
                <span>Thống kê doanh số</span>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="float-end">
                <form action="{{ route('admin.statistics.revenue') }}" method="GET" class="d-inline-block me-2">
                    <div class="input-group">
                        <select name="year" class="form-select" onchange="this.form.submit()">
                            @foreach($availableYears as $y)
                                <option value="{{ $y }}" {{ $data['year'] == $y ? 'selected' : '' }}>
                                    Năm {{ $y }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <a href="{{ route('admin.statistics.revenue.export', ['year' => $data['year']]) }}" 
                   class="btn btn-success">
                    <i class="fas fa-file-excel me-2"></i>Xuất Excel
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Tổng doanh số</h6>
                        <h4 class="mb-0">{{ $data['total_revenue_formatted'] }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-primary rounded">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-sm-6 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Tổng đơn hàng</h6>
                        <h4 class="mb-0">{{ number_format($data['total_orders']) }}</h4>
                    </div>
                    <div class="avatar-sm">
                        <span class="avatar-title bg-info rounded">
                            <i class="fas fa-shopping-bag"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Chi tiết doanh số theo tháng</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="revenueTable">
                <thead>
                    <tr>
                        <th>Tháng</th>
                        <th class="text-end">Số đơn hàng</th>
                        <th class="text-end">Doanh số</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['monthly_data'] as $month)
                    <tr>
                        <td>{{ $month['month_name'] }}</td>
                        <td class="text-end">{{ number_format($month['total_orders']) }}</td>
                        <td class="text-end">{{ $month['revenue_formatted'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="fw-bold">
                        <td>Tổng cộng</td>
                        <td class="text-end">{{ number_format($data['total_orders']) }}</td>
                        <td class="text-end">{{ $data['total_revenue_formatted'] }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#revenueTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/vi.json'
        },
        pageLength: 12,
        ordering: false,
        searching: false,
        paging: false,
        info: false
    });
});
</script>
@endsection 
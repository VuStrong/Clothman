@extends('layouts.admin')
@section('title', 'Admin Dashboard')

@section('content')
    <section class="section">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Clothman Dashboard</h2>
                        </div>
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Dashboard
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== title-wrapper end ========== -->
            <div class="row">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon purple">
                            <i class="lni lni-cart-full"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">New Orders Today</h6>
                            <h3 class="text-bold mb-10" id="newOrdersCount">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon orange">
                            <i class="lni lni-user"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">New User Today</h6>
                            <h3 class="text-bold mb-10" id="newUserCount">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
                <!-- End Col -->
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="icon-card mb-30">
                        <div class="icon success">
                            <i class="lni lni-dollar"></i>
                        </div>
                        <div class="content">
                            <h6 class="mb-10">Total Income Today</h6>
                            <h3 class="text-bold mb-10" id="totalIncomeCount">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h3>
                        </div>
                    </div>
                    <!-- End Icon Cart -->
                </div>
            </div>
            <!-- End Row -->
            <div class="row">
                <div class="w-100">
                    <div class="card-style mb-30">
                        <div class="title d-flex flex-wrap justify-content-between">
                            <div class="left">
                                <h6 class="text-medium mb-10">Yearly Stats</h6>
                                <h3 class="text-bold" id="yearlyStatsTotal">0đ</h3>
                            </div>
                            <div class="right">
                                <div class="select-style-1">
                                    <div class="select-position select-sm">
                                        <select class="light-bg" id="yearlyStatsSelect" disabled>
                                            @for ($i = 2023; $i <= \Carbon\Carbon::now()->year; $i++)
                                                <option value="{{ $i }}" @selected($i === \Carbon\Carbon::now()->year)>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <!-- end select -->
                            </div>
                        </div>
                        <!-- End Title -->
                        <div class="chart position-relative" id="yearlyStatsContent">
                            <div class="spinner spinner-grow text-primary position-absolute top-50 start-50 translate-middle"
                                role="status" style="width: 70px; height: 70px; trans">
                                <span class="visually-hidden">Loading...</span>
                            </div>

                            <canvas id="yearlyStatsChart" style="width: 100%; height: 400px; margin-left: -35px;"></canvas>
                        </div>
                        <!-- End Chart -->
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
            <div class="row">
                <!-- End Col -->
                <div class="w-100">
                    <div class="card-style mb-30">
                        <div class="title d-flex flex-wrap justify-content-between align-items-center">
                            <div class="left">
                                <h6 class="text-medium mb-30">Top Selling Products</h6>
                            </div>
                            <div class="right">
                                <div class="select-style-1">
                                    <div class="select-position select-sm">
                                        <select class="light-bg" id="topSellingSelect" disabled>
                                            <option value="week">Weekly</option>
                                            <option value="month">Monthly</option>
                                            <option value="year">Yearly</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- end select -->
                            </div>
                        </div>
                        <!-- End Title -->
                        <div class="table-responsive table-wrapper">
                            <table class="table top-selling-table" id="topSellingProductsTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <h6 class="text-sm text-medium">Products</h6>
                                        </th>
                                        <th class="min-width">
                                            <h6 class="text-sm text-medium">Category</h6>
                                        </th>
                                        <th class="min-width">
                                            <h6 class="text-sm text-medium">Price</h6>
                                        </th>
                                        <th class="min-width">
                                            <h6 class="text-sm text-medium">Sold</h6>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                            <div id="topSellingProductsLoading">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </div>
                                <div class="placeholder-glow">
                                    <span class="placeholder col-12"></span>
                                </div>
                            </div>
                            <!-- End Table -->
                        </div>
                    </div>
                </div>
                <!-- End Col -->
            </div>
            <!-- End Row -->
        </div>
        <!-- end container -->
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    <script>
        const domain = '{{ asset('') }}';
        const fetchTopSellingUrl = '{{ route('api.products.topselling') }}';
        const fetchYearStatsUrl = '{{ route('api.dashboard.yearstats') }}';

        $(function() {
            $.get("{{ route('api.dashboard') }}", function(data, status) {
                if (status === 'success') {
                    const dashboardData = data.data;

                    $('#newOrdersCount').html(dashboardData.new_orders_count);
                    $('#newUserCount').html(dashboardData.new_users_count);
                    $('#totalIncomeCount').html(dashboardData.total_income_today);

                    if (dashboardData.yearly_stats) {
                        renderYearlyStats(dashboardData.yearly_stats);
                    }

                    if (dashboardData.top_week_selling_products) {
                        renderTopSellingProducts(dashboardData.top_week_selling_products);
                    }
                }
            });

            $("#topSellingSelect").on('change', function () {
                fetchTopSellingProducts($(this).val());
            });

            $('#yearlyStatsSelect').on('change', function () {
                fetchYearlyStats($(this).val());
            });
        });

        function fetchTopSellingProducts(time) {
            $('#topSellingSelect').attr('disabled', true);
            $('#topSellingProductsLoading').show();
            $('#topSellingProductsTable tbody').html('');

            $.get(`${fetchTopSellingUrl}?time=${time}`, function(data, status) {
                if (status === 'success') {
                    renderTopSellingProducts(data);
                }
            });
        }

        function fetchYearlyStats(year) {
            $('#yearlyStatsSelect').attr('disabled', true);
            $('#yearlyStatsContent').find('.spinner').show();
            Chart.getChart("yearlyStatsChart").destroy();
            
            $.get(`${fetchYearStatsUrl}?year=${year}`, function(data, status) {
                if (status === 'success') {
                    renderYearlyStats(data);
                }
            });
        }

        function renderTopSellingProducts(items) {
            $('#topSellingProductsLoading').hide();
            $('#topSellingSelect').attr('disabled', false);

            let html = '';

            items.forEach(item => {
                html += `
                    <tr>
                        <td class="">
                            <div class="product">
                                <div class="image">
                                    <img src="${domain}${item.product.thumbnail_url}" alt="${item.product.name}" />
                                </div>
                                <p class="text-sm text-truncate">${item.product.name}</p>
                            </div>
                        </td>
                        <td>
                            <p class="text-sm text-truncate">${item.product.category.name}</p>
                        </td>
                        <td>
                            <p class="text-sm">${item.product.selling_price}đ</p>
                        </td>
                        <td>
                            <p class="text-sm">${item.total}</p>
                        </td>
                    </tr>
                `;
            });

            $('#topSellingProductsTable tbody').html(html);
        }

        function renderYearlyStats(stats) {
            $('#yearlyStatsContent').find('.spinner').hide();
            $('#yearlyStatsTotal').html(stats.total);
            $('#yearlyStatsSelect').attr('disabled', false);

            const months = stats.data.map(d => d.month);
            const amounts = stats.data.map(d => d.total);

            const ctx1 = document.getElementById("yearlyStatsChart").getContext("2d");
            const yearlyStatsChart = new Chart(ctx1, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [{
                        label: "",
                        backgroundColor: "transparent",
                        borderColor: "#365CF5",
                        data: amounts,
                        pointBackgroundColor: "transparent",
                        pointHoverBackgroundColor: "#365CF5",
                        pointBorderColor: "transparent",
                        pointHoverBorderColor: "#fff",
                        pointHoverBorderWidth: 5,
                        borderWidth: 5,
                        pointRadius: 8,
                        pointHoverRadius: 8,
                        cubicInterpolationMode: "monotone", // Add this line for curved line
                    }, ],
                },
                options: {
                    plugins: {
                        tooltip: {
                            callbacks: {
                                labelColor: function(context) {
                                    return {
                                        backgroundColor: "#ffffff",
                                        color: "#171717"
                                    };
                                },
                            },
                            intersect: false,
                            backgroundColor: "#f9f9f9",
                            title: {
                                fontFamily: "Plus Jakarta Sans",
                                color: "#8F92A1",
                                fontSize: 12,
                            },
                            body: {
                                fontFamily: "Plus Jakarta Sans",
                                color: "#171717",
                                fontStyle: "bold",
                                fontSize: 16,
                            },
                            multiKeyBackground: "transparent",
                            displayColors: false,
                            padding: {
                                x: 30,
                                y: 10,
                            },
                            bodyAlign: "center",
                            titleAlign: "center",
                            titleColor: "#8F92A1",
                            bodyColor: "#171717",
                            bodyFont: {
                                family: "Plus Jakarta Sans",
                                size: "16",
                                weight: "bold",
                            },
                        },
                        legend: {
                            display: false,
                        },
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    title: {
                        display: false,
                    },
                    scales: {
                        y: {
                            grid: {
                                display: false,
                                drawTicks: false,
                                drawBorder: false,
                            },
                            ticks: {
                                padding: 35,
                                max: 1200,
                                min: 500,
                            },
                        },
                        x: {
                            grid: {
                                drawBorder: false,
                                color: "rgba(143, 146, 161, .1)",
                                zeroLineColor: "rgba(143, 146, 161, .1)",
                            },
                            ticks: {
                                padding: 20,
                            },
                        },
                    },
                },
            });
        }
    </script>
@endsection

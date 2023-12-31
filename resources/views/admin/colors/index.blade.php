@extends('layouts.admin')
@section('title', 'Quản lý Colors')

@section('content')
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6 d-flex gap-2">
                        <div class="title">
                            <h2>Colors</h2>
                        </div>
                        {{-- <form role="search" method="GET">
                            <input class="form-control me-2" name="q" type="search" placeholder="Search"
                                aria-label="Search" required>
                        </form> --}}
                    </div>
                    <!-- end col -->
                    <div class="col-md-6">
                        <div class="breadcrumb-wrapper">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        Colors
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

            <!-- ========== tables-wrapper start ========== -->
            <div class="tables-wrapper">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card-style mb-30">
                            <div class="btn-toolbar justify-content-between gap-3">

                                <form role="search" method="GET">
                                    <input class="form-control me-2" name="q" type="search"
                                        placeholder="Search" aria-label="Search" required>
                                </form>

                                <a href="{{ route('admin.colors.create') }}" class="btn btn-dark mb-3">Create new color</a>
                            </div>

                            <div class="btn-toolbar">
                                {{-- Filter --}}
                                <form class="filter-form mb-2 " method="GET">
                                    <select name="sort" class="p-1 mx-1 select">
                                        <option value="">Sort By</option>
                                        <option value="name.asc">Name</option>
                                        <option value="created_at.desc">Created At</option>
                                    </select>

                                    <button type="submit" class="btn btn-dark m-1">Filter</button>
                                </form>
                            </div>

                            <div class="table-wrapper table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="lead-email">
                                                <h6>Name</h6>
                                            </th>
                                            <th class="lead-info">
                                                <h6>hex_code</h6>
                                            </th>
                                            <th>
                                                <h6>Actions</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($colors) && $colors->isNotEmpty())

                                            @foreach ($colors as $color)
                                                <tr>
                                                    <td class="min-width">
                                                        <div class="lead">
                                                            <div class="lead-text">
                                                                <p>{{ $color->name }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="min-width">
                                                        <div
                                                            style="background-color: {{ $color->hex_code }}; width: 50px; height: 50px; box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.3);">
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <div class="action gap-2">
                                                            <a href="{{ route('admin.colors.show', [$color->id]) }}"
                                                                class="btn btn-success">Detail</a>
                                                            <a href="{{ route('admin.colors.edit', [$color->id]) }}"
                                                                class="btn btn-success">Edit</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>

                                <!-- end table -->

                                @if (!isset($colors) || !$colors->isNotEmpty())
                                    <div>Không có kết quả</div>
                                @endif
                            </div>

                            {{ $colors->links() }}
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- ========== tables-wrapper end ========== -->
        </div>
        <!-- end container -->
    </section>
@endsection

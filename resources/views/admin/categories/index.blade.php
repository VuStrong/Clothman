@extends('layouts.admin')
@section('title', 'Quản lý Categories')

@section('content')
    <section class="table-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6 d-flex gap-2">
                        <div class="title">
                            <h2>Categories</h2>
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
                                        Categories
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

                                <a href="{{ route('admin.categories.create') }}" class="btn btn-dark mb-3">Create new category</a>
                            </div>

                            <div class="btn-toolbar">
                                {{-- Filter --}}
                                <form class="filter-form mb-2" method="GET">
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
                                            <th class="lead-info">
                                                <h6>ID</h6>
                                            </th>
                                            <th class="lead-email">
                                                <h6>Name</h6>
                                            </th>
                                            <th class="lead-email">
                                                <h6>Parent</h6>
                                            </th>
                                            <th>
                                                <h6>Actions</h6>
                                            </th>
                                        </tr>
                                        <!-- end table row-->
                                    </thead>
                                    <tbody>
                                        @if (isset($categories) && $categories->isNotEmpty())
                                            @foreach ($categories as $category)
                                                <tr>
                                                    <td class="min-width">
                                                        <div class="lead">
                                                            <div class="lead-text">
                                                                <p>{{ $category->id }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="min-width">
                                                        <p>{{ $category->name }}</p>
                                                    </td>
                                                    <td class="min-width">
                                                        <p>{{ $category->parent ? $category->parent->name : 'NULL' }}</p>
                                                    </td>
                                                    <td>
                                                        <div class="action gap-2">
                                                            <a href="{{ route('admin.categories.show', [$category->id]) }}"
                                                                class="btn btn-success">Detail</a>
                                                            <a href="{{ route('admin.categories.edit', [$category->id]) }}"
                                                                class="btn btn-success">Edit</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <!-- end table -->

                                @if (!isset($categories) || !$categories->isNotEmpty())
                                    <div>Không có kết quả</div>
                                @endif

                            </div>

                            {{ $categories->links() }}
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

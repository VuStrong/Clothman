@extends('layouts.admin')
@section('title', 'Edit Product ' . $product->name)

@section('content')
    {{-- Select colors modal --}}
    <div class="modal fade" id="colorsModal" tabindex="-1" aria-labelledby="colorsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="colorsModalLabel">Select a color: <span class="modal-color-name"></span>
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="mb-3">
                            <input id="search-colors-input" class="form-control me-2" type="search"
                                placeholder="Search colors" aria-label="Search">
                        </div>
                        <div class="d-flex flex-wrap gap-2" id="color-select-container">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="onClickColorsModal()">OK</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- ========== title-wrapper start ========== -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Edit Product: {{ $product->name }}</h2>
                    </div>
                </div>
                <!-- end col -->
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.products.index') }}">Products</a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    Edit Product
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
                    @include('includes.errors')

                    <div class="card-style mb-30">
                        <form action="{{ route('admin.products.update', [$product->id]) }}" method="POST"
                            id="edit-product-form" enctype="multipart/form-data">
                            @method('PUT')
                            @csrf

                            <ul class="nav nav-tabs" id="product-tabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="main-infor-tab" data-bs-toggle="tab"
                                        data-bs-target="#main-infor-tab-pane" type="button" role="tab"
                                        aria-controls="main-infor-tab-pane" aria-selected="true">Main</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="images-tab" data-bs-toggle="tab"
                                        data-bs-target="#images-tab-pane" type="button" role="tab"
                                        aria-controls="images-tab-pane" aria-selected="false">Images</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="add-color-tab" data-bs-toggle="tab"
                                        data-bs-target="#add-color-tab-pane" type="button" role="tab"
                                        aria-controls="add-color-tab-pane" aria-selected="false">Add Color</button>
                                </li>
                            </ul>
                            <div class="tab-content py-5" id="myTabContent">
                                <div class="tab-pane fade show active" id="main-infor-tab-pane" role="tabpanel"
                                    aria-labelledby="main-infor-tab" tabindex="0">
                                    <div class="mb-3 input-style-1">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                            value="{{ $product->name }}">
                                    </div>
                                    <div class="mb-3 input-style-1">
                                        <label for="description" class="form-label">Description</label>
                                        <input type="text" class="form-control" id="description" name="description"
                                            value="{{ $product->description }}">
                                    </div>
                                    <div class="mb-3 input-style-1">
                                        <label for="material" class="form-label">Material</label>
                                        <input type="text" class="form-control" id="material" name="material"
                                            value="{{ $product->material }}">
                                    </div>
                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        <div class="form-group input-style-1">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="number" min="0" class="form-control" id="price"
                                                name="price" value="{{ $product->price }}">
                                        </div>
                                        <div class="form-group input-style-1">
                                            <label for="selling_price" class="form-label">Selling Price</label>
                                            <input type="number" min="0" class="form-control" id="selling_price"
                                                name="selling_price" value="{{ $product->selling_price }}">
                                        </div>
                                        <div class="form-group input-style-1">
                                            <label for="discount" class="form-label">Discount</label>
                                            <input type="number" min="0" max="100" class="form-control" id="discount"
                                                name="discount" value="{{ $product->discount }}">
                                        </div>
                                    </div>
                                    <div class="mb-3 select-style-1">
                                        <label for="category_id" class="form-label">Select category</label>
                                        <div class="select-position">
                                            <select class="form-select" name="category_id" id="category_id"
                                                value="{{ $product->category_id }}">
                                                <option selected value="">NULL</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($product->category_id === $category->id)>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="images-tab-pane" role="tabpanel"
                                    aria-labelledby="images-tab" tabindex="0">
                                    <div class="form-group mb-3">
                                        <label for="thumbnail" class="form-label">Attach a thumbnail image: </label>
                                        <input class="form-control mb-2" type="file" name="thumbnail" id="thumbnail">

                                        <img src="{{ asset($product->thumbnail_url) }}" alt="{{ $product->name }}"
                                            style="max-width: 300px; height: 400px; object-fit: cover;">
                                    </div>

                                    <div class="form-group">
                                        <label for="size_guild" class="form-label">Attach a size guild image: </label>
                                        <input class="form-control mb-2" type="file" name="size_guild"
                                            id="size_guild">

                                        <img src="{{ asset($product->size_guild_url) }}" alt="{{ $product->name }}"
                                            style="max-width: 300px; height: 400px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="add-color-tab-pane" role="tabpanel"
                                    aria-labelledby="add-color-tab" tabindex="0">
                                    <button type="button" class="btn btn-dark mb-3" data-bs-toggle="modal"
                                        data-bs-target="#colorsModal">
                                        Add a product color variant
                                    </button>

                                    <div id="colors-container" class="d-flex flex-column gap-3">

                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-success">Save</button>
                        </form>
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- ========== tables-wrapper end ========== -->
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
    <script>
        const getColorsApiUrl = '{{ route('api.colors') }}';
        let selectedColors = {!! json_encode($product->productVariants->unique('color_id')->pluck('color_id')) !!};

        $().ready(function() {
            // jQuery.validator.setDefaults({
            //     debug: true,
            //     success: "valid"
            // });

            $("#edit-product-form").validate({
                rules: {
                    "name": {
                        required: true,
                    },
                    "category_id": {
                        required: true
                    },
                    "thumbnail": {
                        extension: "png|jpg|jpeg|webp"
                    },
                    "size_guild": {
                        extension: "png|jpg|jpeg|webp"
                    },
                    'price': {
                        required: true,
                        digits: true
                    },
                    'selling_price': {
                        required: true,
                        digits: true
                    },
                    'discount': {
                        digits: true
                    }
                },
                messages: {
                    "name": {
                        required: "Name không được để trống",
                    },
                    "category_id": {
                        required: "Chưa chọn thể loại"
                    }
                },
            });
        });
    </script>
    <script src="{{ asset('js/admin-add-product-colors.js') }}"></script>
@endsection

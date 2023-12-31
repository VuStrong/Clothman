<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Something went wrong</title>
    <meta name="description" content="500 Internal Server Error">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
</head>
<body class="py-5">
    <!-- Error Page Content -->
    <div class="container">
        <div class="hero text-center my-4">
            <h1 class="display-5"><i class="bi bi-emoji-frown text-danger mx-3"></i></h1>
            <h1 class="display-5 fw-bold">Oops!, có lỗi gì đó đã xảy ra.</h1>
            <p><btn onclick=javascript:reloadPage(); class="btn btn-outline-success btn-lg">Thử lại</a></btn>
        </div>
    </div>
    <script type="text/javascript">
        function reloadPage() {
            document.location.reload(true);
        }
    </script>
</body>
</html>
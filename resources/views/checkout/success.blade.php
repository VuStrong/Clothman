@extends('layouts.app')
@section('title', 'Đặt hàng thành công')

@section('content')
    <div class="container my-5 mx-auto text-center" style="max-width: 768px;">
        <h2 class="title text-uppercase mb-5">Đặt hàng thành công!</h2>
        <p class="fw-medium">
            Trên thị trường có quá nhiều sự lựa chọn, cảm ơn bạn đã lựa chọn mua sắm tại <strong>Clothman</strong>.
        </p>
        <p class="fw-medium">
            Đơn hàng của bạn CHẮC CHẮN đã được chuyển tới hệ thống xử lý đơn hàng của Clothman.
            Trong quá trình xử lý Clothman sẽ liên hệ lại nếu như cần thêm thông tin từ bạn.
            Ngoài ra Clothman cũng sẽ có gửi xác nhận đơn hàng bằng Email
        </p>
    </div>
    <div class="container my-5 mx-auto" style="max-width: 1200px;">
        <h2 class="title text-center mb-3">Thông tin đơn hàng #{{ $order->code }}</h2>

        <div class="d-flex flex-column gap-3 my-3">
            @foreach ($order->orderItems as $item)
                <x-order-item :item="$item" />
            @endforeach
        </div>

        <div class="d-flex justify-content-between align-items-center p-3 rounded bg-dark">
            <div class="fw-bold fs-6 text-light">Tổng cộng</div>
            <div class="fw-bold fs-6 text-light">{{ $order->getFormatedTotal() }}đ</div>
        </div>
    </div>
    <div class="container my-5 mx-auto" style="max-width: 1200px;">
        <h2 class="title text-center mb-3">Thông tin nhận hàng</h2>

        <div class="d-flex flex-column gap-3 p-4 rounded" style="background-color: #f1f1f1;">
            <div class="row">
                <div class="col col-4 fw-bolder">Tên người nhận: </div>
                <div class="col col-8">{{ $order->customer_name }}</div>
            </div>
            <div class="row">
                <div class="col col-4 fw-bolder">Email: </div>
                <div class="col col-8">{{ App\Utils\Hider::hideEmail($order->email) }}</div>
            </div>
            <div class="row">
                <div class="col col-4 fw-bolder">Số điện thoại: </div>
                <div class="col col-8">{{ App\Utils\Hider::hidePhoneNumber($order->phone_number) }}</div>
            </div>
            <div class="row">
                <div class="col col-4 fw-bolder">Phương thức thanh toán: </div>
                <div class="col col-8">{{ $order->payment->payment_method }}</div>
            </div>
            <div class="row">
                <div class="col col-4 fw-bolder">Địa chỉ giao hàng: </div>
                <div class="col col-8">{{ $order->address }}</div>
            </div>
        </div>  
    </div>
@endsection
<?php

namespace App\Services\Cart\Implementations;

use App\DTOs\Cart\AddToCartDto;
use App\DTOs\Cart\RemoveCartDto;
use App\DTOs\Cart\SessionCartDto;
use App\DTOs\Cart\UpdateCartDto;
use App\Exceptions\Products\ProductOutOfStockException;
use App\Repositories\Interfaces\CartRepository;
use App\Repositories\Interfaces\ProductRepository;
use App\Repositories\Interfaces\ProductVariantRepository;
use App\Services\Cart\Interfaces\CartService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class CartServiceImpl implements CartService
{
    public function __construct(
        private CartRepository $cartRepository,
        private ProductRepository $productRepository,
        private ProductVariantRepository $productVariantRepository,
    ) {}

    public function getCartData(): array {
        $total = 0;

        if (Auth::check()) {
            $carts = $this->cartRepository->getAllByUserId(Auth::id());

            foreach ($carts as $cart) {
                $total += $cart->getPrice();
            }
        } else {
            $carts = $this->getSessionCarts();

            foreach ($carts as $cart) {
                $total += $cart->price;
            }
        }

        return [
            'items' => $carts,
            'total' => $total,
            'formated_total' => number_format($total, 0, '.', '.'),
        ];
    }

    public function getCartCount(): int {
        if (Auth::check()) {
            return $this->cartRepository->getCountByUserId(Auth::id());
        }

        $carts = session('carts', []);

        return count($carts);
    }

    public function addToCart(AddToCartDto $data): bool {
        if (Auth::check()) {
            $userId = Auth::id();
            
            $this->processAddCartToDb($data, $userId);
        } else {
            $this->processAddCartToSession($data);
        }

        return true;
    }

    public function updateCart(UpdateCartDto $data): array {
        $productVariant = $this->productVariantRepository->findById($data->variantId);

        if (!$productVariant) {
            throw new ModelNotFoundException();
        }

        if ($productVariant->quantity < $data->quantity) {
            throw new ProductOutOfStockException("Sản phẩm này không còn đủ hàng.");
        }

        if (Auth::check()) {
            $userId = Auth::id();
            
            $this->updateCartInDb($data->productId, $productVariant->id, $userId, $data->quantity);
        } else {
            $this->updateCartInSession($data->productId, $productVariant->id, $data->quantity);
        }

        return $this->getCartData();
    }

    public function removeCart(RemoveCartDto $data): array {
        if (Auth::check()) {
            $cart = $this->cartRepository->findByDetail($data->productId, $data->variantId, Auth::id());

            if (!$cart) throw new ModelNotFoundException();

            $this->cartRepository->delete($cart->id);
        } else {
            $carts = session('carts', []);
        
            foreach ($carts as $key=>$cart) {
                if ($cart['product_id'] === $data->productId && $cart['product_variant_id'] === $data->variantId) {
                    array_splice($carts, $key, 1);

                    session(['carts' => $carts]);

                    break;
                }
            }
        }

        return $this->getCartData();
    }

    private function processAddCartToDb(AddToCartDto $data, string $userId) {
        $productVariant = $this->productVariantRepository->findByDetail(
            $data->productId,
            $data->colorId,
            $data->size,
        );

        if (!$productVariant) {
            throw new ModelNotFoundException();
        }

        $cart = $this->cartRepository->findByDetail($data->productId, $productVariant->id, $userId);

        if (
            (isset($cart) && $productVariant->quantity < $data->quantity + $cart->quantity) ||
            (!isset($cart) && $productVariant->quantity < $data->quantity)
        ) {
            throw new ProductOutOfStockException("Sản phẩm này đã hết hàng, vui lòng giảm số lượng hoặc chọn một biến thể khác.");
        }
        
        if (isset($cart)) {
            $this->cartRepository->update($cart->id, [
                'quantity' => $cart->quantity + $data->quantity,
            ]);
        } else {
            $this->cartRepository->create([
                'product_id' => $data->productId,
                'product_variant_id' => $productVariant->id,
                'user_id' => $userId,
                'quantity' => $data->quantity,
            ]);
        }
    }

    private function updateCartInDb(string $productId, string $variantId, string $userId, int $quantity) {
        $cart = $this->cartRepository->findByDetail($productId, $variantId, $userId);

        if (!$cart) throw new ModelNotFoundException();

        $this->cartRepository->update($cart->id, [
            'quantity' => $quantity
        ]);
    }

    private function processAddCartToSession(AddToCartDto $data) {
        $productVariant = $this->productVariantRepository->findByDetail(
            $data->productId,
            $data->colorId,
            $data->size,
        );

        if (!$productVariant) {
            throw new ModelNotFoundException();
        }

        $carts = session('carts', []);
        
        // check if session already have cart with same product
        foreach ($carts as $key=>$cart) {
            if ($cart['product_id'] === $data->productId && $cart['product_variant_id'] === $productVariant->id) {
                if ($productVariant->quantity < $data->quantity + $cart['quantity']) {
                    throw new ProductOutOfStockException("Sản phẩm này đã hết hàng, vui lòng giảm số lượng hoặc chọn một biến thể khác.");
                }

                $carts[$key]['quantity'] += $data->quantity;

                session(['carts' => $carts]);
                return;
            }
        }

        if ($productVariant->quantity < $data->quantity) {
            throw new ProductOutOfStockException("Sản phẩm này đã hết hàng, vui lòng giảm số lượng hoặc chọn một biến thể khác.");
        }

        session()->push('carts', [
            'product_id' => $productVariant->product_id,
            'product_variant_id' => $productVariant->id,
            'quantity' => $data->quantity,
        ]);
    }

    private function updateCartInSession(string $productId, string $variantId, int $quantity) {
        $carts = session('carts', []);

        foreach ($carts as $key=>$cart) {
            if ($cart['product_id'] === $productId && $cart['product_variant_id'] === $variantId) {
                $carts[$key]['quantity'] = $quantity;

                break;
            }
        }

        session(['carts' => $carts]);
    }

    private function getSessionCarts() {
        $carts = session('carts', []);
        $carts = array_reverse($carts);

        $sessionCarts = collect();

        foreach ($carts as $cart) {
            $sessionCart = new SessionCartDto();
            $sessionCart->product_id = $cart['product_id'];
            $sessionCart->product_variant_id = $cart['product_variant_id'];
            $sessionCart->quantity = $cart['quantity'];

            $productVariant = $this->productVariantRepository->findById($cart['product_variant_id'], ['product', 'color']);

            if ($productVariant) {
                $sessionCart->product = $productVariant->product;
                $sessionCart->productVariant = $productVariant;
                $sessionCart->price = $sessionCart->product->selling_price * $sessionCart->quantity;
                $sessionCart->formated_price = number_format($sessionCart->price, 0, '.', '.');
            }

            $sessionCarts->push($sessionCart);
        }

        return $sessionCarts;
    }

    public function removeAllCart(string $userId = null): bool {
        if ($userId) {
            $this->cartRepository->deleteByUserId($userId);
        } else {
            session()->forget('carts');
        }

        return true;
    }
}

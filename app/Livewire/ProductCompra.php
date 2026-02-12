<?php

namespace App\Livewire;

use App\Models\Producto;
use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCompra extends Component
{

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $perPage = 12;
    public $quantity = [];

    public function render()
    {
        $products = Producto::whereIn('estado', [1, 3]) // Filtra productos con estado 1 y 3
            ->where('producto', 'like', '%' . $this->search . '%') // Filtro por nombre
            ->orderBy('id', 'asc') // Ordenar por ID ascendente
            ->paginate($this->perPage); // Paginación

        $cartItems = Cart::instance('compras')->content();

        foreach ($cartItems as $item) {
            // Inicializar la cantidad para cada elemento del carrito
            $this->quantity[$item->rowId] = $item->qty;
        }

        return view('livewire.product-compra', ['products' => $products, 'cartItems' => $cartItems]);
    }

    public function addToCart($productId)
    {
        $product = Producto::find($productId);

        Cart::instance('compras')->add([
            'id' => $product->id,
            'name' => $product->producto,
            'price' => $product->precio_compra,
            'qty' => 1
        ]);

        session()->flash('success_message', 'Producto agregado al carrito.');
    }

    public function updateQuantity($rowId)
    {
        $newCant = $this->quantity[$rowId];
        Cart::instance('compras')->update($rowId, ['qty' => $newCant]);
    }
}

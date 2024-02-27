<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

use function array_key_exists;
use function array_keys;

class Home extends Component
{
    public Collection $products;

    public array $categoriesSelected = [];

    public function mount(): void
    {
        $this->products = Product::orderBy('name')->get();
    }

    public function render(): View
    {
        return view('livewire.home', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }

    public function addAndRemoveCategory(string $id): void
    {
        if (array_key_exists($id, $this->categoriesSelected)) {
            unset($this->categoriesSelected[$id]);
        } else {
            $this->categoriesSelected[$id] = [];
        }

        if ($this->categoriesSelected) {
            $this->products = Product::orderBy('name')->whereHas(
                'categories',
                fn ($query) => $query->whereIn('id', array_keys($this->categoriesSelected))
            )->get();
        } else {
            $this->products = Product::orderBy('name')->get();
        }
    }
}

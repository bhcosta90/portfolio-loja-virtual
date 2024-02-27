<div>
    @foreach($categories as $category)
        <x-button type="button" label="{{ $category->name }}" wire:click="addAndRemoveCategory('{{$category->id}}')"
                  class="btn-outline btn-outline"
                  icon="{{ array_key_exists($category->id, $this->categoriesSelected) ? 'o-check' : 'o-x-circle' }}"
        />
    @endforeach

    <div class="grid xl:grid-cols-4 lg:grid-cols-3 sm:grid-cols-2 gap-4 mt-3">
        @foreach($products as $product)
            <x-card title="{{ $product->name }}">
                {{ $product->name }}
                @if($image = $product->media()->first())
                    <x-slot:figure>
                        {{$image}}
                    </x-slot:figure>
                @endif
                <x-slot:menu>
                    <x-button icon="o-share" class="btn-circle btn-sm"/>
                    <x-icon name="o-heart" class="cursor-pointer"/>
                </x-slot:menu>
                <x-slot:actions>
                    <x-button label="Comprar" class="btn-primary"/>
                </x-slot:actions>
            </x-card>
        @endforeach
    </div>
</div>

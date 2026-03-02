<div class="product-grid">
    @foreach($medicines as $item)
        <div class="card">
            <h3>{{ $item->name }} ({{ $item->dosage }})</h3>
            <p>Категория: {{ $item->category }}</p>
            <p>Цена: <strong>{{ $item->price }} руб.</strong></p>
            
            @if($item->is_prescription)
                <span style="color: red;">⚠ Только по рецепту</span>
            @endif

            <button>Купить</button>
        </div>
    @endforeach
</div>

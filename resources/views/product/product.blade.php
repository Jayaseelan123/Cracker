<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<script>
document.querySelectorAll('.qty-plus').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        let qtyElement = document.getElementById('qty-' + id);
        let qty = parseInt(qtyElement.innerText);
        qtyElement.innerText = qty + 1;  // increase count
    });
});

document.querySelectorAll('.qty-minus').forEach(btn => {
    btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        let qtyElement = document.getElementById('qty-' + id);
        let qty = parseInt(qtyElement.innerText);
        if(qty > 0) qtyElement.innerText = qty - 1;  // prevent negative
    });
});
</script>

<body>
    @foreach ($products as $product)
<tr>
  <td>
    <img src="{{ asset('storage/products/' . $product->image) }}" width="70">
  </td>
    <td>
        <div>{{ $product->name_en ?? $product->name ?? '—' }}</div>
        @if(!empty($product->name_ta))
            <div class="small text-muted">{{ $product->name_ta }}</div>
        @endif
    </td>
  <td><strong>₹{{ $product->price }}</strong></td>

  <td>
    <div style="display:flex; align-items:center; gap:8px;">
        <button class="qty-minus btn btn-danger" data-id="{{ $product->id }}">-</button>

        <span id="qty-{{ $product->id }}">0</span>

        <button class="qty-plus btn btn-success" data-id="{{ $product->id }}">+</button>
    </div>
  </td>
</tr>
@endforeach

</body>
</html>
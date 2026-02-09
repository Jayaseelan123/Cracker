<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
      :root{--accent:#6f42c1;--muted:#6b7280;}
      body{font-family: Inter,system-ui,-apple-system,"Segoe UI",Roboto,Helvetica,Arial;margin:0;background:#f6f8fa}
      .app-shell{min-height:100vh;display:flex}
      /* Sidebar */
      .admin-sidebar{width:240px;background:#fff;border-right:1px solid #eef2f6;padding:20px;box-shadow:0 2px 8px rgba(14,30,37,0.03)}
      .admin-sidebar img.logo{max-width:160px;margin-bottom:18px}
      .admin-nav{list-style:none;padding:0;margin:8px 0}
      .admin-nav li{margin:10px 0}
      .admin-nav a{display:flex;align-items:center;gap:12px;padding:12px 14px;border-radius:10px;color:#111;text-decoration:none}
      .admin-nav a.active{background:var(--accent);color:#fff}
      .download-btn{display:block;margin-top:16px;padding:10px 12px;background:#6f42c1;color:#fff;border-radius:8px;text-align:center;text-decoration:none}
      .sidebar-footer{margin-top:24px;border-top:1px solid #f1f3f6;padding-top:16px}

      /* Content */
      .admin-content{flex:1;padding:28px}
      .card-plain{background:#fff;border-radius:10px;padding:20px;box-shadow:0 6px 20px rgba(20,30,50,0.06)}
      .table thead th{border-bottom:1px solid #eef2f6;font-weight:600;color:var(--muted)}
      .order-number{font-weight:700}
      .badge-pending{background:#fff3cd;color:#856404;border-radius:999px;padding:.4rem .65rem}

      @media (max-width:768px){
        .admin-sidebar{display:none}
        .admin-content{padding:16px}
      }
    </style>
  </head>
  <body>

    <div class="app-shell">
      <aside class="admin-sidebar">
        <img class="logo" src="/logo.png" alt="logo">

        <ul class="admin-nav">
          <li><a class="active" href="{{ route('admin.dashboard') }}">
            <span>🟣</span>
            <span>Dashboard</span>
          </a></li>
          <li><a href="{{ route('category.index') }}"><span>Categories</span></a></li>
          <li><a href="{{ route('products.index') }}"><span>Products</span></a></li>
          <li class="nav-item">
    <a href="{{ route('orders.index') }}" class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
        <i class="fa fa-shopping-cart me-2"></i>
        Orders
    </a>
</li>
          <li><a href="#"><span>Orders List</span></a></li>
          <li><a href="#"><span>Contact</span></a></li>
          <li><a href="#"><span>Delivery Address</span></a></li>
        </ul>

        <a class="download-btn" href="#">Download Catalog PDF</a>

        <div class="sidebar-footer">
          <a class="d-block mb-2" href="#">📝 Blogs</a>
          <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link p-0">↩️ Logout</button>
          </form>
          <div class="mt-3"><a href="/">🔗 View Website</a></div>
        </div>
      </aside>

      <main class="admin-content">
        <div class="mb-4">
          <div class="row g-3">
            <div class="col-md-3">
              <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div style="width:56px;height:56px;border-radius:10px;background:#e8f1ff;display:flex;align-items:center;justify-content:center">🛒</div>
                <div>
                  <div style="font-size:20px;font-weight:800" data-count>{{ $totalOrders ?? $totalOrdersCount ?? 0 }}</div>
                  <div style="color:var(--muted)">Total Orders</div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div style="width:56px;height:56px;border-radius:10px;background:#fff7e6;display:flex;align-items:center;justify-content:center">⏳</div>
                <div>
                  <div style="font-size:20px;font-weight:800" data-count>{{ $pendingOrders ?? 0 }}</div>
                  <div style="color:var(--muted)">Pending Orders</div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div style="width:56px;height:56px;border-radius:10px;background:#e9fff0;display:flex;align-items:center;justify-content:center">📦</div>
                <div>
                  <div style="font-size:20px;font-weight:800" data-count>{{ $totalProducts ?? 0 }}</div>
                  <div style="color:var(--muted)">Total Products</div>
                </div>
              </div>
            </div>
            <div class="col-md-3">
              <div class="card-plain d-flex align-items-center" style="gap:16px">
                <div style="width:56px;height:56px;border-radius:10px;background:#f4ecff;display:flex;align-items:center;justify-content:center">📂</div>
                <div>
                  <div style="font-size:20px;font-weight:800" data-count>{{ $totalCategories ?? $categories ?? 0 }}</div>
                  <div style="color:var(--muted)">Categories</div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="card-plain">
          <h4 class="mb-4">Recent Orders</h4>
          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead class="table-light">
                <tr>
                  <th>ORDER #</th>
                  <th>CUSTOMER</th>
                  <th>AMOUNT</th>
                  <th>STATUS</th>
                  <th>DATE</th>
                </tr>
              </thead>
              <tbody>
                @if(!empty($recentOrders) && $recentOrders->count())
                  @foreach($recentOrders as $order)
                    <tr>
                      <td class="order-number">{{ $order->order_number ?? ('ORD-' . ($order->id ?? '')) }}</td>
                      <td>{{ optional($order->user)->name ?? $order->customer_name ?? '—' }}</td>
                      <td>{{ $order->total ?? '—' }}</td>
                      <td><span class="badge-pending">{{ ucfirst($order->status ?? 'pending') }}</span></td>
                      <td>{{ optional($order->created_at)->format('M d, Y') ?? '' }}</td>
                    </tr>
                  @endforeach
                @else
                  @for($i=0;$i<5;$i++)
                    <tr>
                      <td class="order-number">ORD-20251020{{ rand(100000,999999) }}</td>
                      <td>Sample Customer</td>
                      <td>₹{{ number_format(rand(1000,9000)) }}</td>
                      <td><span class="badge-pending">Pending</span></td>
                      <td>{{ now()->subDays($i)->format('M d, Y') }}</td>
                    </tr>
                  @endfor
                @endif
              </tbody>
            </table>
          </div>
        </div>
      </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      // Simple counter animation for elements having numeric content
      (function(){
        function animateCounters(){
          document.querySelectorAll('[data-count]').forEach(function(el){
            var target = parseInt(el.textContent.replace(/[^0-9]/g,'')) || 0;
            var start = 0;
            var duration = 900; // ms
            var startTs = null;
            function step(ts){
              if (!startTs) startTs = ts;
              var progress = Math.min((ts - startTs) / duration, 1);
              var val = Math.floor(progress * (target - start) + start);
              el.textContent = val.toLocaleString();
              if (progress < 1) window.requestAnimationFrame(step);
            }
            window.requestAnimationFrame(step);
          });
        }
        if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', animateCounters);
        else animateCounters();
      })();
    </script>
  </body>
</html>
@extends('layouts.admin')
@section('title','Reviews & Moderation')

@section('content')
@php use Illuminate\Support\Str; @endphp
<div class="page-wrapper">

    <!-- Start Content -->
    <div class="content">
<div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
  <div class="breadcrumb-arrow">
    <h4 class="mb-1">Reviews & Moderation</h4>
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Reviews & Moderation</li>
      </ol>
    </nav>
  </div>
</div>

<!-- Charts row -->
<div class="row g-2 mb-3">
  <div class="col-md-6">
    <div class="card card-h-100">
      <div class="card-header">
        <div class="card-title">Reviews by City</div>
        <p class="mb-0 text-muted">Total reviews per city</p>
      </div>
      <div class="card-body">
        @if(!empty($cityLabels) && count($cityLabels))
          <canvas id="reviewsCityChart" height="300"></canvas>
        @else
          <div class="d-flex align-items-center justify-content-center" style="height:300px">No review location data available</div>
        @endif
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card card-h-100">
      <div class="card-header">
        <div class="card-title">Review Status Distribution</div>
        <p class="mb-0 text-muted">Current status of all reviews</p>
      </div>
      <div class="card-body text-center">
        @if(!empty($statusLabels) && count($statusLabels))
          <canvas id="reviewStatusChart" height="300"></canvas>
        @else
          <div class="d-flex align-items-center justify-content-center" style="height:300px">No status distribution data available</div>
        @endif
        <div class="mt-3">Average rating: <strong>{{ $avgRating ?? '0.00' }}</strong></div>
      </div>
    </div>
  </div>
</div>

<!-- Stat cards -->
<div class="row g-2 mb-3">
  <div class="col-md-3">
    <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
      <p class="mb-2">Total Reviews</p>
      <h6>{{ $totalReviews ?? 0 }} <small class="text-muted">({{ $recentCount ?? 0 }} last 7d)</small></h6>
    </div>
  </div>
  <div class="col-md-3">
    <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
      <p class="mb-2">Pending Review</p>
      <h6>{{ $pendingCount ?? 0 }}</h6>
    </div>
  </div>
  <div class="col-md-3">
    <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
      <p class="mb-2">Flagged Reviews</p>
      <h6>{{ $flaggedCount ?? 0 }}</h6>
    </div>
  </div>
  <div class="col-md-3">
    <div class="bg-white border border-1 ps-3 pt-3 pb-2 h-100">
      <p class="mb-2">Average Rating</p>
      <h6>{{ $avgRating ?? '0.00' }} @if(isset($trendDir))
        <small class="text-muted ms-2">@if($trendDir === 'up') <span class="text-success">▲ {{ $trendPercent }}%</span> @elseif($trendDir === 'down') <span class="text-danger">▼ {{ abs($trendPercent) }}%</span> @else <span class="text-muted">• 0%</span> @endif</small>
      @endif</h6>
    </div>
  </div>
</div>

<!-- Insights panel -->
<div class="row mb-3">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header d-flex align-items-center justify-content-between">
        <h6 class="mb-0">Insights</h6>
        <div>
          <a href="?export=csv" class="btn btn-sm btn-outline-secondary">Export CSV</a>
          <a href="?export=csv&period=weekly" class="btn btn-sm btn-outline-primary ms-2">Generate Weekly Report</a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <p class="mb-1 small text-muted">Top Flagged Providers</p>
            @if(!empty($topFlagged) && $topFlagged->isNotEmpty())
              <ul class="list-unstyled">
                @foreach($topFlagged as $tf)
                  <li>{{ $providerNames[$tf->provider_id] ?? $tf->provider_id }} — <strong>{{ $tf->cnt }}</strong> flags</li>
                @endforeach
              </ul>
            @else
              <div class="text-muted small">No flagged providers</div>
            @endif
          </div>
          <div class="col-md-6">
            <p class="mb-1 small text-muted">Most Active City</p>
            <div class="fw-semibold">{{ $mostActiveCity ?? '—' }}</div>
            <p class="mb-0 small text-muted">Top cities by review volume</p>
            <div class="mt-2">
              @foreach($cityLabels ?? [] as $i => $c)
                <div class="d-flex justify-content-between"><div>{{ $c }}</div><div class="text-muted">{{ $approvedCounts[$i] + $flaggedCounts[$i] ?? 0 }}</div></div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-header d-flex align-items-center justify-content-between">
    <h6 class="mb-0">Recent Reviews</h6>
    <form method="GET" action="{{ route('admin.reviews.index') }}" class="d-flex align-items-center gap-2">
      <div class="d-flex align-items-center gap-2">
        <label class="small mb-0">City</label>
        <input type="text" name="city" value="{{ request('city') }}" class="form-control form-control-sm" placeholder="City">
      </div>
      <div class="d-flex align-items-center gap-2">
        <label class="small mb-0">From</label>
        <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-control form-control-sm">
      </div>
      <div class="d-flex align-items-center gap-2">
        <label class="small mb-0">To</label>
        <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-control form-control-sm">
      </div>
      <div class="d-flex align-items-center gap-2">
        <label class="small mb-0">Min Rating</label>
        <select name="min_rating" class="form-select form-select-sm">
          <option value="">Any</option>
          @for($r=1;$r<=5;$r++)
            <option value="{{ $r }}" {{ request('min_rating') == $r ? 'selected' : '' }}>{{ $r }}+</option>
          @endfor
        </select>
      </div>
      <div class="form-check form-switch">
        <input class="form-check-input" type="checkbox" id="only_flagged" name="only_flagged" value="1" {{ request('only_flagged') ? 'checked' : '' }}>
        <label class="form-check-label small" for="only_flagged">Only Flagged</label>
      </div>
      <input type="search" name="q" class="form-control form-control-sm" placeholder="Search reviews..." value="{{ request('q') }}">
      <select name="status" class="form-select form-select-sm">
        <option value="">All statuses</option>
        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
        <option value="approved" {{ request('status')=='approved' ? 'selected' : '' }}>Approved</option>
        <option value="flagged" {{ request('status')=='flagged' ? 'selected' : '' }}>Flagged</option>
        <option value="hidden" {{ request('status')=='hidden' ? 'selected' : '' }}>Hidden</option>
        <option value="rejected" {{ request('status')=='rejected' ? 'selected' : '' }}>Rejected</option>
      </select>
      <button class="btn btn-sm btn-primary">Filter</button>
      @if(request()->has('status') || request()->has('q'))
        <a href="{{ route('admin.reviews.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
      @endif
    </form>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table id="reviewsTable" class="table table-hover mb-0">
        <thead>
          <tr>
            <th><input type="checkbox" id="selectAllReviews"></th>
            <th>Parent</th>
            <th>Provider</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Date</th>
            <th class="no-sort">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reviews as $r)
            <tr>
              <td><input type="checkbox" class="review-checkbox" value="{{ $r->id }}"></td>
              <td>
                <div class="d-flex align-items-center">
                  <img src="{{ asset('vendor/admin/img/profiles/avatar-12.jpg') }}" class="avatar-sm rounded-circle me-2" alt="">
                  <div>
                    <div class="fw-semibold">{{ $r->parent->name ?? 'Parent' }}</div>
                    <small class="text-muted">{{ $r->parent->email ?? '' }}</small>
                  </div>
                </div>
              </td>
              <td>{{ $r->provider->name ?? 'Provider' }}</td>
              <td>
                <span class="text-warning">{{ str_repeat('★', $r->rating) . str_repeat('☆', max(0,5-$r->rating)) }}</span>
              </td>
              <td>{{ Str::limit($r->content, 120) }}</td>
              <td>{{ $r->created_at->format('Y-m-d') }}</td>
              <td class="text-end">
                <div class="btn-group" role="group">
                  <button class="btn btn-sm btn-success btn-approve" data-id="{{ $r->id }}">Approve</button>
                  <button class="btn btn-sm btn-warning btn-flag" data-id="{{ $r->id }}">Flag</button>
                  <button class="btn btn-sm btn-secondary btn-reject" data-id="{{ $r->id }}">Reject</button>
                  <a href="{{ route('admin.reviews.show', $r) }}" class="btn btn-sm btn-outline-light">View</a>
                  <button class="btn btn-sm btn-light btn-history" data-id="{{ $r->id }}">History</button>
                </div>
                <form method="POST" action="{{ route('admin.reviews.destroy', $r) }}" style="display:inline-block">@csrf @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
              </td>
            </tr>
          @empty
            <tr><td colspan="6" class="text-muted">No reviews found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-2 mb-3 d-flex gap-2">
      <button id="bulkApproveBtn" class="btn btn-sm btn-primary">Approve Selected</button>
    </div>
    <div class="mt-3 pagination-row">
      <div class="admin-pagination">
        {{ $reviews->onEachSide(1)->links() }}
      </div>
      <div class="results-summary text-muted ms-3">
        Showing {{ $reviews->firstItem() ?? 0 }} to {{ $reviews->lastItem() ?? 0 }} of {{ $reviews->total() ?? 0 }} results
      </div>
    </div>
  </div>
</div>

@push('scripts')
<style>
  /* Page-scoped pagination tweaks for admin reviews */
  .pagination-row { display:flex; align-items:center; gap:1rem; justify-content:flex-start; margin-top:0.5rem; }
  .admin-pagination .pagination { margin:0; }
  .admin-pagination .page-link { padding: .28rem .6rem; font-size: .9rem; }
  .admin-pagination .page-item.active .page-link { background-color:#0d6efd; border-color:#0d6efd; }
  /* Limit any oversized decorative element that pushed content down */
  .big-deco, .hero-deco { max-height: 160px !important; overflow:hidden !important; }
  /* Make the reviews table container scrollable on very tall pages to keep pager visible */
  .table-responsive { max-height: 58vh; overflow:auto; }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function(){
    // Reviews by City
    try{
      var cityLabels = @json($cityLabels ?? []);
      var approvedCounts = @json($approvedCounts ?? []);
      var flaggedCounts = @json($flaggedCounts ?? []);
      var ctx = document.getElementById('reviewsCityChart');
      if(ctx && cityLabels.length){
        new Chart(ctx.getContext('2d'), {
          type: 'bar',
          data: { labels: cityLabels, datasets: [
            { label: 'Approved', data: approvedCounts, backgroundColor: 'rgba(25,135,84,0.8)' },
            { label: 'Flagged', data: flaggedCounts, backgroundColor: 'rgba(220,53,69,0.8)' }
          ] },
          options: { responsive:true, plugins:{legend:{position:'top'}}, scales:{ x:{ stacked:true }, y:{ stacked:true } } }
        });
      }
    }catch(e){console.warn(e)}

    // Diagnostic: verify header/row column counts before initializing DataTables
    try{
      var reviewsEl = document.getElementById('reviewsTable');
      if (reviewsEl) {
        var thCount = reviewsEl.querySelectorAll('thead th').length;
        var rows = reviewsEl.querySelectorAll('tbody tr');
        var mismatch = false;
        rows.forEach(function(row, idx){
          var tdCount = row.querySelectorAll('td').length;
          if (tdCount !== thCount) {
            console.warn('Reviews table column mismatch at row', idx, 'tds=', tdCount, 'thead=', thCount);
            mismatch = true;
          }
        });

        if (mismatch) {
          console.error('DataTables init aborted: header/row column count mismatch. See console above for details.');
        } else if (window.jQuery && jQuery.fn.DataTable) {
          // If a DataTable instance already exists for this table, destroy it first to avoid reinitialise error
          try {
            if (jQuery.fn.DataTable.isDataTable(reviewsEl)) {
              try { jQuery(reviewsEl).DataTable().destroy(); } catch (e) { console.warn('Failed to destroy existing DataTable', e); }
            }
          } catch (e) { /* ignore detection errors */ }
          // build columns array dynamically to match header count
          var cols = [];
          for (var i = 0; i < thCount; i++) {
            var isFirst = (i === 0);
            var isLast = (i === thCount - 1);
            cols.push({ orderable: !(isFirst || isLast), searchable: !isFirst && !isLast });
          }
          jQuery(reviewsEl).DataTable({
            responsive: true,
            autoWidth: false,
            paging: false,        // use server-side Blade pagination instead
            info: false,          // avoid duplicate "showing x to y" info
            searching: false,     // page already has a search field
            lengthChange: false,
            columns: cols,
            language: { emptyTable: 'No reviews found.' }
          });
        }
      }
    } catch (e) { console.warn('DataTable diagnostic/init error', e); }

    // Wire up moderation actions with event delegation to avoid duplicate handlers
    function postAction(id, action, note) {
      return fetch("{{ url('admin/reviews') }}/"+id+"/action", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ action: action, note: note })
      }).then(r=>r.json());
    }

    // Lightweight client-side guard and diagnostics to detect duplicate handlers/requests
    window.__reviewActionGuard = window.__reviewActionGuard || new Map();
    function __shouldRunOnce(actionKey, windowMs) {
      windowMs = windowMs || 3000;
      var now = Date.now();
      var last = window.__reviewActionGuard.get(actionKey) || 0;
      if (now - last < windowMs) return false;
      window.__reviewActionGuard.set(actionKey, now);
      return true;
    }

    var tableContainer = document.getElementById('reviewsTable');
    if (tableContainer) {
      tableContainer.addEventListener('click', function(e){
        var btn = e.target.closest('button');
        if (!btn) return;
        var id = btn.dataset.id;
        if (btn.classList.contains('btn-approve')) {
          if (btn.dataset.inflight) return; btn.dataset.inflight = '1';
          postAction(id,'approve').then(()=> location.reload()).catch(()=> btn.dataset.inflight = '');
        } else if (btn.classList.contains('btn-flag')) {
          if (btn.dataset.inflight) return; btn.dataset.inflight = '1';
          postAction(id,'flag').then(()=> location.reload()).catch(()=> btn.dataset.inflight = '');
        } else if (btn.classList.contains('btn-reject')) {
          if (btn.dataset.inflight) return; btn.dataset.inflight = '1';
          postAction(id,'reject').then(()=> location.reload()).catch(()=> btn.dataset.inflight = '');
        } else if (btn.classList.contains('btn-history')) {
          // Diagnostic log + dedupe guard
          try { console.log('reviews:history click', { id: id, time: new Date().toISOString() }, new Error().stack); } catch (e) {}
          if (btn.dataset.inflight) return;
          // prevent duplicate rapid clicks / duplicate handler runs
          var actionKey = 'history:' + id;
          if (!__shouldRunOnce(actionKey, 3000)) return;
          btn.dataset.inflight = '1';
          fetch("{{ url('admin/reviews') }}/"+id+"/history").then(r=>r.text()).then(html=>{
            var modal = document.getElementById('historyModal');
            if(!modal){
              modal = document.createElement('div'); modal.id='historyModal'; modal.className='modal'; modal.innerHTML = '<div class="modal-dialog modal-sm"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Moderation History</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div><div class="modal-body"></div></div></div>'; document.body.appendChild(modal);
            }
            modal.querySelector('.modal-body').innerHTML = html;
            var bs = new bootstrap.Modal(modal); bs.show();
          }).catch(function(err){
            console.warn('Failed to load history', err);
          }).finally(function(){
            // allow subsequent opens after a short delay
            setTimeout(function(){ try{ delete btn.dataset.inflight; }catch(e){} }, 1200);
          });
        }
      });
    }

    // Bulk approve and select-all (attach once)
    var selectAll = document.getElementById('selectAllReviews');
    if (selectAll) {
      selectAll.addEventListener('change', function(){
        var checked = this.checked; document.querySelectorAll('.review-checkbox').forEach(function(cb){ cb.checked = checked; });
      });
    }
    var bulkBtn = document.getElementById('bulkApproveBtn');
    if (bulkBtn) {
      bulkBtn.addEventListener('click', function(){
        if (bulkBtn.dataset.inflight) return; bulkBtn.dataset.inflight = '1';
        var ids = Array.from(document.querySelectorAll('.review-checkbox:checked')).map(function(cb){ return cb.value; });
        if(ids.length === 0){ alert('No reviews selected'); bulkBtn.dataset.inflight = ''; return; }
        fetch("{{ route('admin.reviews.bulk.approve') }}", { method:'POST', headers: {'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'}, body: JSON.stringify({ ids: ids }) }).then(r=>r.json()).then(res=>{ location.reload(); }).catch(()=> bulkBtn.dataset.inflight = '');
      });
    }
    // Status distribution
    try{
      var statusLabels = @json($statusLabels ?? []);
      var statusCounts = @json($statusCounts ?? []);
      var ctx2 = document.getElementById('reviewStatusChart');
      if(ctx2){
        // Map known statuses to colors
        var colorMap = { approved: '#198754', pending: '#ffc107', hidden: '#6c757d', flagged: '#dc3545', rejected:'#0d6efd' };
        var colors = statusLabels.map(function(l){ return colorMap[l] || '#adb5bd'; });
        new Chart(ctx2.getContext('2d'), {
          type: 'doughnut',
          data: { labels: statusLabels, datasets: [{ data: statusCounts, backgroundColor: colors }] },
          options: { responsive:true }
        });
      }
    }catch(e){console.warn(e)}
  });
</script>
@endpush

@endsection

@extends('layouts.main')

@section('title', 'Review Analysis')

@section('content')
<div class="page-wrapper">
  <div class="content">
    <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
      <div class="breadcrumb-arrow">
        <h4 class="mb-1">Review Sentiment & Keywords</h4>
        <div class="text-end">
          <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin-home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.analytics') }}">Analytics</a></li>
            <li class="breadcrumb-item active">Review Analysis</li>
          </ol>
        </div>
      </div>
    </div>

    <div class="row g-2 mb-3">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h6>Positive</h6>
            <h3>{{ $summary['counts']['positive'] ?? 0 }}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h6>Neutral</h6>
            <h3>{{ $summary['counts']['neutral'] ?? 0 }}</h3>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
            <h6>Negative</h6>
            <h3>{{ $summary['counts']['negative'] ?? 0 }}</h3>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Sentiment Distribution</div>
            <p class="mb-0 text-muted">Across last {{ config('analysis.recent_days') }} days</p>
          </div>
          <div class="card-body" style="height:300px;">
            <canvas id="sentimentChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <div class="card-title">Top Keywords</div>
            <p class="mb-0 text-muted">Most frequent non-stopwords</p>
          </div>
          <div class="card-body">
            <ul class="list-unstyled">
              @foreach($summary['keywords'] ?? [] as $word => $count)
                <li class="mb-2"><strong>{{ $word }}</strong> — {{ $count }}</li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>

    <div class="card mt-3">
      <div class="card-header">
        <div class="card-title">Flagged Reviews</div>
        <p class="mb-0 text-muted">Reviews matching configured flag words</p>
      </div>
      <div class="card-body">
        <table class="table table-sm">
          <thead>
            <tr>
              <th>ID</th>
              <th>Provider</th>
              <th>Snippet</th>
              <th>Matches</th>
              <th>Date</th>
            </tr>
          </thead>
          <tbody>
            @foreach($summary['flagged'] ?? [] as $f)
              <tr>
                <td><a href="{{ route('admin.reviews.show', [$f['id']]) }}">{{ $f['id'] }}</a></td>
                <td>{{ $f['provider_id'] }}</td>
                <td>{{ \\Illuminate\\Support\\Str::limit($f['snippet'], 120) }}</td>
                <td>{{ implode(', ', $f['matched']) }}</td>
                <td>{{ $f['created_at'] }}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const summary = @json($summary);
  const data = [summary.counts.positive || 0, summary.counts.neutral || 0, summary.counts.negative || 0];
  new Chart(document.getElementById('sentimentChart'), {
    type: 'doughnut',
    data: { labels: ['Positive','Neutral','Negative'], datasets: [{ data: data, backgroundColor: ['#2ecc71','#95a5a6','#e74c3c'] }] },
    options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'right' } }, cutout: '60%' }
  });
</script>
@endpush

@endsection

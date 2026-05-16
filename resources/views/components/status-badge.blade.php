@php
  $badgeClasses = match($status) {
    'pending' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200',
    'on_progress' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
    default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200'
  };

  $statusLabel = match($status) {
    'pending' => 'Pending',
    'on_progress' => 'On Progress',
    'completed' => 'Completed',
    default => 'Unknown'
  };
@endphp

<span class="inline-flex rounded-full px-3 py-1 text-sm font-medium {{ $badgeClasses }}">
  {{ $statusLabel }}
</span>

<div class="flex items-center gap-2">
  <div class="flex-1">
    <div class="h-2 w-full rounded-full bg-gray-200 dark:bg-gray-700">
      <div
        class="h-2 rounded-full bg-blue-500 transition-all duration-300"
        style="width: {{ $progress ?? 0 }}%"
      ></div>
    </div>
  </div>
  <span class="text-sm font-medium text-gray-600 dark:text-gray-400 w-12 text-right">
    {{ $progress ?? 0 }}%
  </span>
</div>

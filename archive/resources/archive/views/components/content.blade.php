@if ($date)
    <div class="text-sm italic">
        Last update: {{ $date }}
    </div>
@endif
<div id="content" class="prose prose-lg dark:prose-light mt-6">
    {{ $title ?? '' }}
    {!! $content !!}
    {{ $slot }}
</div>

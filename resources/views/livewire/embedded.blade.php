<div class="my-12">
  @if ($is_unknown && ($og = $this->getOpenGraph()))
    <x-open-graph :og="$og" />
  @else
    {!! $embedded !!}
  @endif
</div>

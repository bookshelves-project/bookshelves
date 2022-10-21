<div class="my-8">
  @if ($is_unknown && ($og = $this->getOpenGraph()))
    <x-open-graph
      :og="$og"
      :margin="false"
    />
  @else
    {!! $embedded !!}
  @endif
</div>

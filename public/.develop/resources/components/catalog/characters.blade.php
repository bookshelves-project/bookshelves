<div class="u-row-container" style="padding: 0px;background-color: transparent">
    @foreach ($entities->chunk(3) as $characters)
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                @foreach ($characters as $key => $authors)
                    <a href="{{ route($route, ['character' => strtolower($key)]) }}"
                        class="u-col u-col-33p33 button button-{{ $color ?? 'primary' }}"
                        style="max-width: 320px;min-width: 150px;display: table-cell;vertical-align: top; border: 1rem solid white;">
                        <div style="width: 100% !important;">
                            <div
                                style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent; font-size: 6rem; text-align: center;">
                                {{ $key }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endforeach
</div>

<div class="u-row-container" style="padding: 0px;background-color: transparent">
    <div class="u-row"
        style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
        <form action="{{ route('front.catalog.search') }}" method="GET" class="u-row-container"
            style="padding: 0px;background-color: transparent">
            <div class="u-row"
                style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
                <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                    <div class="u-col u-col-66p67"
                        style="max-width: 320px;min-width: 400px;display: table-cell;vertical-align: middle;">
                        <input type="search" name="q" placeholder="Search" required
                            style="display: block; width: 100%; height: 2.5rem; margin: 0.25rem auto; border-radius: 0.25rem">
                    </div>
                    <div class="u-col u-col-33p33"
                        style="max-width: 320px;min-width: 150px;display: table-cell;vertical-align: top;">
                        <div style="width: 100% !important;">
                            <div
                                style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                                <table style="font-family:'Cabin',sans-serif;" role="presentation" cellpadding="0"
                                    cellspacing="0" width="100%" border="0">
                                    <tbody>
                                        <tr>
                                            <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;"
                                                align="left">
                                                <div align="center">
                                                    <button
                                                        class="button button-{{ $color ?? 'primary' }}">Search</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

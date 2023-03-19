<div class="u-row-container"
    style="padding: 0px;background-color: transparent">
    <div class="u-row"
        style="Margin: 0 auto;min-width: 320px;max-width: 600px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
        <div
            style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
            <div class="u-col u-col-100"
                style="max-width: 320px;min-width: 600px;display: table-cell;vertical-align: top;">
                <div style="width: 100% !important;">
                    <div
                        style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">

                        <table style="font-family:'Cabin',sans-serif;"
                            role="presentation"
                            cellpadding="0"
                            cellspacing="0"
                            width="100%"
                            border="0">
                            <tbody>
                                <tr>
                                    <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;"
                                        align="left">

                                        <div class="menu"
                                            style="text-align:center">
                                            <a href="{{ route('catalog.search') }}"
                                                target="_self"
                                                style="padding:5px 30px;display:inline;color:#0068A5;font-family:arial,helvetica,sans-serif;font-size:20px;text-decoration:none">
                                                Home
                                            </a>
                                            @foreach ($navigation as $key => $item)
                                                <a href="{{ route($item['route']) }}"
                                                    target="_self"
                                                    style="padding:5px 30px;display:inline;color:#0068A5;font-family:arial,helvetica,sans-serif;font-size:20px;text-decoration:none">
                                                    {{ $item['title'] }}
                                                </a>
                                            @endforeach
                                        </div>

                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table style="font-family:'Cabin',sans-serif;"
                            role="presentation"
                            cellpadding="0"
                            cellspacing="0"
                            width="100%"
                            border="0">
                            <tbody>
                                <tr>
                                    <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:'Cabin',sans-serif;"
                                        align="left">

                                        <table height="0px"
                                            align="center"
                                            border="0"
                                            cellpadding="0"
                                            cellspacing="0"
                                            width="100%"
                                            style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;border-top: 1px solid #BBBBBB;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                            <tbody>
                                                <tr style="vertical-align: top">
                                                    <td
                                                        style="word-break: break-word;border-collapse: collapse !important;vertical-align: top;font-size: 0px;line-height: 0px;mso-line-height-rule: exactly;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%">
                                                        <span>&#160;</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

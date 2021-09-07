@extends('layouts.catalog', ['title' => 'Catalog'])

@section('content')
    <table
        style="border-collapse: collapse;table-layout: fixed;border-spacing: 0;mso-table-lspace: 0pt;mso-table-rspace: 0pt;vertical-align: top;min-width: 320px;Margin: 0 auto;background-color: transparent;width:100%"
        cellpadding="0" cellspacing="0">
        <tbody>
            <tr style="vertical-align: top">
                <td style="word-break: break-word;border-collapse: collapse !important;vertical-align: top">
                    <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color: #e7e7e7;"><![endif]-->


                    <div class="u-row-container" style="padding: 0px;background-color: transparent">
                        <x-catalog.entities :entities="$series" type="serie" />
                    </div>

                    <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
                </td>
            </tr>
        </tbody>
    </table>
@endsection

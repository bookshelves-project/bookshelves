@extends('layouts.catalog', ['title' => $book->title])

@section('content')
    <x-catalog.back-button />
    <div class="u-row-container" style="padding: 0px;background-color: transparent">
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">

                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="500" style="width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
                                cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td style="padding-right: 0px;padding-left: 0px;" align="center">
                                                        <img align="center" border="0" src="{{ $book->cover->simple }}"
                                                            alt="Image" title="Image"
                                                            style="outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;clear: both;display: inline-block !important;border: none;height: auto;float: none;width: 100%;max-width: 200px;"
                                                            width="200">
                                                    </td>
                                                </tr>
                                            </table>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
        <div class="u-row"
            style="Margin: 0 auto;min-width: 320px;max-width: 500px;overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;background-color: transparent;">
            <div style="border-collapse: collapse;display: table;width: 100%;background-color: transparent;">
                <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding: 0px;background-color: transparent;" align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:500px;"><tr style="background-color: transparent;"><![endif]-->

                <!--[if (mso)|(IE)]><td align="center" width="500" style="width: 500px;padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;" valign="top"><![endif]-->
                <div class="u-col u-col-100"
                    style="max-width: 320px;min-width: 500px;display: table-cell;vertical-align: top;">
                    <div style="width: 100% !important;">
                        <!--[if (!mso)&(!IE)]><!-->
                        <div
                            style="padding: 0px;border-top: 0px solid transparent;border-left: 0px solid transparent;border-right: 0px solid transparent;border-bottom: 0px solid transparent;">
                            <!--<![endif]-->

                            <table style="font-family:arial,helvetica,sans-serif;" role="presentation" cellpadding="0"
                                cellspacing="0" width="100%" border="0">
                                <tbody>
                                    <tr>
                                        <td style="overflow-wrap:break-word;word-break:break-word;padding:10px;font-family:arial,helvetica,sans-serif;"
                                            align="left">

                                            <div style="line-height: 140%; text-align: left; word-wrap: break-word;">
                                                <h2>
                                                    {{ $book->title }}
                                                </h2>
                                                @if ($book->serie)
                                                    <div>
                                                        {{ $book->serie->title }}, vol. {{ $book->volume }}
                                                    </div>
                                                @endif
                                                <div>
                                                    Wrote by
                                                    @foreach ($book->authors as $key => $author)
                                                        {{ $author->name }}
                                                        @if (sizeof($book->authors) !== $key + 1)
                                                            <span>, </span>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div>
                                                    {!! $book->summary !!}
                                                </div>
                                                <div>
                                                    <i>Tags</i> : Action &amp; Adventure, Fiction, Historical, Romance
                                                </div>
                                                @if ($book->serie)
                                                    <div><i>Series</i> : {{ $book->serie->title }}, vol.
                                                        {{ $book->volume }}</div>
                                                @endif
                                            </div>

                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <!--[if (!mso)&(!IE)]><!-->
                        </div>
                        <!--<![endif]-->
                    </div>
                </div>
                <!--[if (mso)|(IE)]></td><![endif]-->
                <!--[if (mso)|(IE)]></tr></table></td></tr></table><![endif]-->
            </div>
        </div>
    </div>
    <x-catalog.button :route="$book->epub->download">
        Download ({{ $book->epub->size }})
    </x-catalog.button>

@endsection

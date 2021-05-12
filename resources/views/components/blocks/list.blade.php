<section>
    <h3 class="px-5 text-3xl font-semibold tracking-tight text-gray-900 font-handlee sm:text-4xl">
        {{ $title }}
    </h3>
    <table cellpadding="20px" cellspacing="0" height="100%" width="100%" class="table-fixed">
        <tbody>
            @foreach ($data->chunk(2) as $chunk)
                <tr>
                    @foreach ($chunk as $item)
                        <td height="300px" valign="top">
                            <div style=" background-image: url({{ $item['picture_og'] }})"
                                class="h-32 bg-center bg-cover">
                            </div>
                            <div class="p-5">
                                <div>
                                    {{ ucfirst($item['meta']['entity']) }} by {{ $item['author'] }}
                                </div>
                                <div class="mt-2 text-2xl font-semibold">
                                    {{ $item['title'] }}
                                </div>
                            </div>
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</section>

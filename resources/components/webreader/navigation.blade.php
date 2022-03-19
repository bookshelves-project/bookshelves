<div id="navigation-options"
    class="fixed transform -translate-x-1/2 top-1 left-1/2 flex items-center bg-gray-200 bg-opacity-75 z-50 text-white rounded-md">
    <x-webreader.button id="firstPage" icon="chevron-double-left" />
    <x-webreader.button id="prevPage" icon="arrow-left" />
    <x-webreader.button id="sidebar-header-button" icon="menu" />
    <x-webreader.button :link="$home" id="sidebar-header-button" icon="home" />
    <a href="{{ $download }}" download>
        <x-webreader.button id="download" icon="download" />
    </a>
    <x-webreader.button id="nextPage" icon="arrow-right" />
    <x-webreader.button id="lastPage" icon="chevron-double-right" />
</div>

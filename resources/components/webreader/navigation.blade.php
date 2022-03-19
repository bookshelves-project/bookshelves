<div x-show="$store.navigation.on"
    class="fixed transform -translate-x-1/2 top-1 left-1/2 flex items-center bg-gray-200 bg-opacity-75 z-50 text-white rounded-md">
    <x-webreader.button id="pageFirstBtn" icon="chevron-double-left" />
    <x-webreader.button id="pagePrevBtn" icon="chevron-left" />
    <x-webreader.button id="sidebarBtn" icon="menu" />
    <x-webreader.button :link="$home" icon="home" />
    <x-webreader.button :link="$download" icon="download" />
    <x-webreader.button id="pageNextBtn" icon="chevron-right" />
    <x-webreader.button id="pageLastBtn" icon="chevron-double-right" />
</div>

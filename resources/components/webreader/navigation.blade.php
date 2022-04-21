<div x-show="navigationIsEnabled"
    class="fixed transform -translate-x-1/2 top-1 left-1/2 flex items-center bg-gray-200 bg-opacity-75 z-50 text-white rounded-md">
    <x-webreader.button icon="chevron-double-left" @click="first" />
    <x-webreader.button icon="chevron-left" @click="previous" />
    <x-webreader.button icon="menu" @click="toggleSidebar" />
    <x-webreader.button :link="$download" icon="download" />
    <x-webreader.button icon="chevron-right" @click="next" />
    <x-webreader.button icon="chevron-double-right" @click="last" />
</div>

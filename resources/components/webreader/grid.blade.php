<div x-show="$store.webreader.showGrid" class="fixed z-10 w-full overflow-auto h-screen bg-gray-900">
    <div class="grid grid-cols-4 gap-3">
        <template x-for="(file,key) in $store.webreader.grid">
            <button class="relative" @click="$store.webreader.currentPage = key, setReader(), displayGrid()">
                <div class="absolute bottom-0 left-0 p-2 bg-gray-800 z-10">
                    Page <span x-text="key"></span>
                </div>
                <img x-show="file.img" :src="file.img" alt="" class="object-cover">
                <div x-show="!$store.webreader.gridIsAvailable" class="min-h-64 w-full bg-gray-700 animate-pulse"></div>
            </button>
        </template>
    </div>
</div>

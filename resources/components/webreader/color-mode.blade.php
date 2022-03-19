<div class="fixed z-50 top-0 right-0 bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300 bg-opacity-40">
    <button x-data @click="$store.darkMode.toggle()" class="p-3">
        <span x-show="!$store.darkMode.on" class="my-auto">
            <x-icons.sun class="w-6 h-6 dark:text-white" />
        </span>
        <span x-show="$store.darkMode.on" class="my-auto">
            <x-icons.moon class="w-6 h-6 dark:text-white" />
        </span>
    </button>
</div>

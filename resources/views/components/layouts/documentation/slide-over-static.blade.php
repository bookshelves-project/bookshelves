<div class="hidden lg:flex lg:w-64 lg:flex-col lg:fixed lg:inset-y-0 right-0">
    <div x-data="tocStatic" class="h-full p-6 bg-gray-800 text-gray-200 overflow-y-auto scrollbar-thin"
        style="direction: rtl">
        <div id="toc-static" class="prose prose-invert list-none" style="direction: ltr">
            <div x-html="tocContent"></div>
        </div>
    </div>
</div>

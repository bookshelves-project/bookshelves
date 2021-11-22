<template>
  <div>
    <Link
      v-if="!item.disclosure"
      :href="item.href ? route(item.href) : ''"
      :class="[route().current(item.href) ? 'bg-primary-800 text-white' : '']"
      class="
        flex
        items-center
        text-primary-100
        hover:text-white hover:bg-primary-600
        rounded-md
        text-sm
        leading-6
        font-medium
        px-2
        py-2
        group
      "
      :aria-current="item.current ? 'page' : undefined"
    >
      <component
        :is="item.icon"
        class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200"
        aria-hidden="true"
      />
      {{ item.name }}
    </Link>
    <Disclosure v-else v-slot="{ open }">
      <DisclosureButton
        class="
          flex
          items-center
          w-full
          justify-between
          text-primary-100
          hover:text-white hover:bg-primary-600
          rounded-md
          text-sm
          leading-6
          font-medium
          px-2
          py-2
        "
      >
        <div class="flex items-center">
          <component
            :is="item.icon"
            class="mr-4 flex-shrink-0 h-6 w-6 text-primary-200"
            aria-hidden="true"
          />
          {{ item.name }}
        </div>
        <ChevronRightIcon
          :class="open ? 'transform rotate-90' : ''"
          class="h-5 w-5 transition-transform duration-75"
        />
      </DisclosureButton>
      <transition
        enter-active-class="transition duration-100 ease-out"
        enter-from-class="transform scale-95 opacity-0"
        enter-to-class="transform scale-100 opacity-100"
        leave-active-class="transition duration-75 ease-out"
        leave-from-class="transform scale-100 opacity-100"
        leave-to-class="transform scale-95 opacity-0"
      >
        <DisclosurePanel class="ml-4 mt-1 mb-3">
          <Link
            v-for="subItem in item.disclosure"
            :key="subItem.id"
            :href="subItem.href ? route(subItem.href) : ''"
            class="
              flex
              items-center
              text-primary-100
              hover:text-white hover:bg-primary-600
              rounded-md
              text-sm
              leading-6
              font-medium
              px-4
              py-2
            "
            :class="[
              route().current(subItem.href) ? 'bg-primary-800 text-white' : '',
            ]"
            :aria-current="subItem.current ? 'page' : undefined"
          >
            <ArrowSmRightIcon class="h-5 w-5" />
            <span class="ml-1">
              {{ subItem.name }}
            </span>
          </Link>
        </DisclosurePanel>
      </transition>
    </Disclosure>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3";
import { ref, onMounted } from "vue";
import { ChevronRightIcon, ArrowSmRightIcon } from "@heroicons/vue/outline";

const props = defineProps({
  item: Object,
});

let open = ref(false);

onMounted(() => {
  if (props.item.disclosure) {
    let current = false;
    props.item.disclosure.forEach((el) => {
      current = route().current(el.href);
    });
    if (current) {
      open.value = true;
    }
  }
});
</script>

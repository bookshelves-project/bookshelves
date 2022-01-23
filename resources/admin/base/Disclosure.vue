<template>
  <div
    v-if="items.length"
    class="flex flex-col border border-gray-300 shadow rounded-md"
    :class="{ 'mb-4': editable }"
  >
    <draggable
      v-model="items"
      group="group"
      :item-key="itemKey"
      handle=".handle"
    >
      <template #item="{ element, index }">
        <Disclosure
          v-slot="{ open }"
          as="div"
          :default-open="element[itemKey] === null"
        >
          <div
            class="flex item-center w-full border-t border-gray-300"
            :class="{ 'border-t-0': index === 0 }"
          >
            <DisclosureButton
              class="flex-1 flex item-center px-6 py-4 focus:outline-none"
            >
              <chevron-right-icon
                :class="open ? 'transform rotate-90' : ''"
                class="w-5 h-5 text-gray-500"
              />
              <span class="ml-2">{{
                itemText ? element[itemText] : element
              }}</span>
            </DisclosureButton>
            <div v-if="editable" class="flex items-center gap-4 px-6">
              <button type="button" @click="deletePanel(index)">
                <trash-icon class="w-5 h-5 text-red-500" />
              </button>
              <span class="handle cursor-move">
                <switch-vertical-icon class="w-5 h-5 text-gray-500" />
              </span>
            </div>
          </div>
          <transition
            enter-active-class="transition duration-100 ease-out"
            enter-from-class="transform scale-95 opacity-0"
            enter-to-class="transform scale-100 opacity-100"
            leave-active-class="transition duration-75 ease-out"
            leave-from-class="transform scale-100 opacity-100"
            leave-to-class="transform scale-95 opacity-0"
          >
            <DisclosurePanel class="px-6 py-4 text-sm text-gray-500">
              <slot :item="element" :index="index" />
              <slot :name="`panel-${index}`" :item="element" :open="open" />
            </DisclosurePanel>
          </transition>
        </Disclosure>
      </template>
    </draggable>
  </div>
  <button
    type="button"
    class="inline-flex items-center text-green-600 ml-6"
    @click="addPanel()"
  >
    <plus-icon class="w-5 h-5 mr-2" />
    {{ $t('admin.actions.add') }}
  </button>
</template>

<script lang="ts" setup>
  import {
    Disclosure,
    DisclosureButton,
    DisclosurePanel,
  } from '@headlessui/vue'
  import { PropType, computed } from 'vue'

  const props = defineProps({
    modelValue: Array as PropType<{ [key: string]: string }[]>,
    label: String,
    group: String,
    itemText: String,
    itemKey: {
      type: String,
      default: 'id',
    },
    editable: Boolean,
    newItem: Object,
  })

  const emit = defineEmits(['update:modelValue'])

  const deletePanel = (index: number) => {
    emit(
      'update:modelValue',
      (props.modelValue || []).filter((v, i) => i !== index)
    )
  }

  const addPanel = () => {
    emit('update:modelValue', [
      ...(props.modelValue || []),
      { ...props.newItem },
    ])
  }

  const items = computed({
    get: () => props.modelValue || [],
    set: (val) => emit('update:modelValue', val),
  })
</script>

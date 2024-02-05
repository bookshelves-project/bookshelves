<script lang="ts" setup generic="T extends App.Route.Name">
defineProps<{
  breadcrumbs?: { label?: string, route: { name: T, params?: T extends keyof App.Route.Params ? App.Route.Params[T] : never } }[]
}>()
</script>

<template>
  <nav
    class="flex mb-5"
    aria-label="Breadcrumb"
  >
    <ol
      role="list"
      class="flex items-center space-x-3"
    >
      <li>
        <div>
          <ILink
            href="/"
            class="text-gray-100 hover:text-gray-300"
          >
            <svg
              class="h-5 w-5 flex-shrink-0"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 24 24"
              stroke-width="1.5"
              stroke="currentColor"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"
              />
            </svg>
            <span class="sr-only">Home</span>
          </ILink>
        </div>
      </li>
      <li
        v-for="(breadcrumb, index) in breadcrumbs"
        :key="index"
      >
        <div class="flex items-center">
          <svg
            class="h-5 w-5 flex-shrink-0 text-gray-100"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
          >
            <path
              fill-rule="evenodd"
              d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
              clip-rule="evenodd"
            />
          </svg>
          <ILink
            :href="$route(breadcrumb.route.name, breadcrumb.route.params)"
            class="ml-3 text-sm font-medium text-gray-100 hover:text-gray-300"
          >
            {{ breadcrumb.label }}
          </ILink>
        </div>
      </li>
    </ol>
  </nav>
</template>

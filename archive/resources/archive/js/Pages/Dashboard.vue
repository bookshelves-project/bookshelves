<template>
  <LayoutDefault title="Dashboard">
    <main class="flex-1 pb-8">
      <!-- Page header -->
      <div class="bg-white shadow">
        <div class="px-4 sm:px-6 lg:max-w-6xl lg:mx-auto lg:px-8">
          <div
            class="
              py-6
              md:flex md:items-center md:justify-between
              lg:border-t lg:border-gray-200
            "
          >
            <div class="flex-1 min-w-0">
              <!-- Profile -->
              <div class="flex items-center">
                <img
                  class="hidden h-16 w-16 rounded-full sm:block"
                  src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.6&w=256&h=256&q=80"
                  alt=""
                />
                <div>
                  <div class="flex items-center">
                    <img
                      class="h-16 w-16 rounded-full sm:hidden"
                      src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.6&w=256&h=256&q=80"
                      alt=""
                    />
                    <h1
                      class="
                        ml-3
                        text-2xl
                        font-bold
                        leading-7
                        text-gray-900
                        sm:leading-9 sm:truncate
                      "
                    >
                      Good morning, Emilia Birch
                    </h1>
                  </div>
                  <dl
                    class="
                      mt-6
                      flex flex-col
                      sm:ml-3 sm:mt-1 sm:flex-row sm:flex-wrap
                    "
                  >
                    <dt class="sr-only">Company</dt>
                    <dd
                      class="
                        flex
                        items-center
                        text-sm text-gray-500
                        font-medium
                        capitalize
                        sm:mr-6
                      "
                    >
                      <OfficeBuildingIcon
                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400"
                        aria-hidden="true"
                      />
                      Duke street studio
                    </dd>
                    <dt class="sr-only">Account status</dt>
                    <dd
                      class="
                        mt-3
                        flex
                        items-center
                        text-sm text-gray-500
                        font-medium
                        sm:mr-6 sm:mt-0
                        capitalize
                      "
                    >
                      <CheckCircleIcon
                        class="flex-shrink-0 mr-1.5 h-5 w-5 text-green-400"
                        aria-hidden="true"
                      />
                      Verified account
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
            <div class="mt-6 flex space-x-3 md:mt-0 md:ml-4">
              <button
                type="button"
                class="
                  inline-flex
                  items-center
                  px-4
                  py-2
                  border border-gray-300
                  shadow-sm
                  text-sm
                  font-medium
                  rounded-md
                  text-gray-700
                  bg-white
                  hover:bg-gray-50
                  focus:outline-none
                  focus:ring-2
                  focus:ring-offset-2
                  focus:ring-primary-500
                "
              >
                Add money
              </button>
              <button
                type="button"
                class="
                  inline-flex
                  items-center
                  px-4
                  py-2
                  border border-transparent
                  shadow-sm
                  text-sm
                  font-medium
                  rounded-md
                  text-white
                  bg-primary-600
                  hover:bg-primary-700
                  focus:outline-none
                  focus:ring-2
                  focus:ring-offset-2
                  focus:ring-primary-500
                "
              >
                Send money
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
          <h2 class="text-lg leading-6 font-medium text-gray-900">Overview</h2>
          <div
            class="mt-2 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3"
          >
            <!-- Card -->
            <div
              v-for="card in cards"
              :key="card.name"
              class="bg-white overflow-hidden shadow rounded-lg"
            >
              <div class="p-5">
                <div class="flex items-center">
                  <div class="flex-shrink-0">
                    <component
                      :is="card.icon"
                      class="h-6 w-6 text-gray-400"
                      aria-hidden="true"
                    />
                  </div>
                  <div class="ml-5 w-0 flex-1">
                    <dl>
                      <dt class="text-sm font-medium text-gray-500 truncate">
                        {{ card.name }}
                      </dt>
                      <dd>
                        <div class="text-lg font-medium text-gray-900">
                          {{ card.amount }}
                        </div>
                      </dd>
                    </dl>
                  </div>
                </div>
              </div>
              <div class="bg-gray-50 px-5 py-3">
                <div class="text-sm">
                  <a
                    :href="card.href"
                    class="font-medium text-primary-700 hover:text-primary-900"
                  >
                    View all
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h2
          class="
            max-w-6xl
            mx-auto
            mt-8
            px-4
            text-lg
            leading-6
            font-medium
            text-gray-900
            sm:px-6
            lg:px-8
          "
        >
          Recent activity
        </h2>

        <!-- Activity list (smallest breakpoint only) -->
        <div class="shadow sm:hidden">
          <ul
            role="list"
            class="
              mt-2
              divide-y divide-gray-200
              overflow-hidden
              shadow
              sm:hidden
            "
          >
            <li v-for="transaction in transactions" :key="transaction.id">
              <a
                :href="transaction.href"
                class="block px-4 py-4 bg-white hover:bg-gray-50"
              >
                <span class="flex items-center space-x-4">
                  <span class="flex-1 flex space-x-2 truncate">
                    <CashIcon
                      class="flex-shrink-0 h-5 w-5 text-gray-400"
                      aria-hidden="true"
                    />
                    <span class="flex flex-col text-gray-500 text-sm truncate">
                      <span class="truncate">{{ transaction.name }}</span>
                      <span
                        ><span class="text-gray-900 font-medium">{{
                          transaction.amount
                        }}</span>
                        {{ transaction.currency }}</span
                      >
                      <time :datetime="transaction.datetime">{{
                        transaction.date
                      }}</time>
                    </span>
                  </span>
                  <ChevronRightIcon
                    class="flex-shrink-0 h-5 w-5 text-gray-400"
                    aria-hidden="true"
                  />
                </span>
              </a>
            </li>
          </ul>

          <nav
            class="
              bg-white
              px-4
              py-3
              flex
              items-center
              justify-between
              border-t border-gray-200
            "
            aria-label="Pagination"
          >
            <div class="flex-1 flex justify-between">
              <a
                href="#"
                class="
                  relative
                  inline-flex
                  items-center
                  px-4
                  py-2
                  border border-gray-300
                  text-sm
                  font-medium
                  rounded-md
                  text-gray-700
                  bg-white
                  hover:text-gray-500
                "
              >
                Previous
              </a>
              <a
                href="#"
                class="
                  ml-3
                  relative
                  inline-flex
                  items-center
                  px-4
                  py-2
                  border border-gray-300
                  text-sm
                  font-medium
                  rounded-md
                  text-gray-700
                  bg-white
                  hover:text-gray-500
                "
              >
                Next
              </a>
            </div>
          </nav>
        </div>

        <!-- Activity table (small breakpoint and up) -->
        <div class="hidden sm:block">
          <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col mt-2">
              <div
                class="
                  align-middle
                  min-w-full
                  overflow-x-auto
                  shadow
                  overflow-hidden
                  sm:rounded-lg
                "
              >
                <table class="min-w-full divide-y divide-gray-200">
                  <thead>
                    <tr>
                      <th
                        class="
                          px-6
                          py-3
                          bg-gray-50
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Transaction
                      </th>
                      <th
                        class="
                          px-6
                          py-3
                          bg-gray-50
                          text-right text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Amount
                      </th>
                      <th
                        class="
                          hidden
                          px-6
                          py-3
                          bg-gray-50
                          text-left text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                          md:block
                        "
                      >
                        Status
                      </th>
                      <th
                        class="
                          px-6
                          py-3
                          bg-gray-50
                          text-right text-xs
                          font-medium
                          text-gray-500
                          uppercase
                          tracking-wider
                        "
                      >
                        Date
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    <tr
                      v-for="transaction in transactions"
                      :key="transaction.id"
                      class="bg-white"
                    >
                      <td
                        class="
                          max-w-0
                          w-full
                          px-6
                          py-4
                          whitespace-nowrap
                          text-sm text-gray-900
                        "
                      >
                        <div class="flex">
                          <a
                            :href="transaction.href"
                            class="group inline-flex space-x-2 truncate text-sm"
                          >
                            <CashIcon
                              class="
                                flex-shrink-0
                                h-5
                                w-5
                                text-gray-400
                                group-hover:text-gray-500
                              "
                              aria-hidden="true"
                            />
                            <p
                              class="
                                text-gray-500
                                truncate
                                group-hover:text-gray-900
                              "
                            >
                              {{ transaction.name }}
                            </p>
                          </a>
                        </div>
                      </td>
                      <td
                        class="
                          px-6
                          py-4
                          text-right
                          whitespace-nowrap
                          text-sm text-gray-500
                        "
                      >
                        <span class="text-gray-900 font-medium"
                          >{{ transaction.amount }}
                        </span>
                        {{ transaction.currency }}
                      </td>
                      <td
                        class="
                          hidden
                          px-6
                          py-4
                          whitespace-nowrap
                          text-sm text-gray-500
                          md:block
                        "
                      >
                        <span
                          :class="[
                            statusStyles[transaction.status],
                            'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium capitalize',
                          ]"
                        >
                          {{ transaction.status }}
                        </span>
                      </td>
                      <td
                        class="
                          px-6
                          py-4
                          text-right
                          whitespace-nowrap
                          text-sm text-gray-500
                        "
                      >
                        <time :datetime="transaction.datetime">{{
                          transaction.date
                        }}</time>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <!-- Pagination -->
                <nav
                  class="
                    bg-white
                    px-4
                    py-3
                    flex
                    items-center
                    justify-between
                    border-t border-gray-200
                    sm:px-6
                  "
                  aria-label="Pagination"
                >
                  <div class="hidden sm:block">
                    <p class="text-sm text-gray-700">
                      Showing
                      {{ " " }}
                      <span class="font-medium">1</span>
                      {{ " " }}
                      to
                      {{ " " }}
                      <span class="font-medium">10</span>
                      {{ " " }}
                      of
                      {{ " " }}
                      <span class="font-medium">20</span>
                      {{ " " }}
                      results
                    </p>
                  </div>
                  <div class="flex-1 flex justify-between sm:justify-end">
                    <a
                      href="#"
                      class="
                        relative
                        inline-flex
                        items-center
                        px-4
                        py-2
                        border border-gray-300
                        text-sm
                        font-medium
                        rounded-md
                        text-gray-700
                        bg-white
                        hover:bg-gray-50
                      "
                    >
                      Previous
                    </a>
                    <a
                      href="#"
                      class="
                        ml-3
                        relative
                        inline-flex
                        items-center
                        px-4
                        py-2
                        border border-gray-300
                        text-sm
                        font-medium
                        rounded-md
                        text-gray-700
                        bg-white
                        hover:bg-gray-50
                      "
                    >
                      Next
                    </a>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </LayoutDefault>
</template>

<script setup>
import { ref } from "vue";
import {
  Dialog,
  DialogOverlay,
  Menu,
  MenuButton,
  MenuItem,
  MenuItems,
  TransitionChild,
  TransitionRoot,
} from "@headlessui/vue";
import {
  BellIcon,
  ClockIcon,
  CogIcon,
  CreditCardIcon,
  DocumentReportIcon,
  HomeIcon,
  MenuAlt1Icon,
  QuestionMarkCircleIcon,
  ScaleIcon,
  ShieldCheckIcon,
  UserGroupIcon,
  XIcon,
} from "@heroicons/vue/outline";
import {
  CashIcon,
  CheckCircleIcon,
  ChevronDownIcon,
  ChevronRightIcon,
  OfficeBuildingIcon,
  SearchIcon,
} from "@heroicons/vue/solid";

const navigation = [
  { name: "Home", href: "#", icon: HomeIcon, current: true },
  { name: "History", href: "#", icon: ClockIcon, current: false },
  { name: "Balances", href: "#", icon: ScaleIcon, current: false },
  { name: "Cards", href: "#", icon: CreditCardIcon, current: false },
  { name: "Recipients", href: "#", icon: UserGroupIcon, current: false },
  { name: "Reports", href: "#", icon: DocumentReportIcon, current: false },
];
const secondaryNavigation = [
  { name: "Settings", href: "#", icon: CogIcon },
  { name: "Help", href: "#", icon: QuestionMarkCircleIcon },
  { name: "Privacy", href: "#", icon: ShieldCheckIcon },
];
const cards = [
  { name: "Account balance", href: "#", icon: ScaleIcon, amount: "$30,659.45" },
  // More items...
];
const transactions = [
  {
    id: 1,
    name: "Payment to Molly Sanders",
    href: "#",
    amount: "$20,000",
    currency: "USD",
    status: "success",
    date: "July 11, 2020",
    datetime: "2020-07-11",
  },
  // More transactions...
];
const statusStyles = {
  success: "bg-green-100 text-green-800",
  processing: "bg-yellow-100 text-yellow-800",
  failed: "bg-gray-100 text-gray-800",
};

const sidebarOpen = ref(false);
</script>

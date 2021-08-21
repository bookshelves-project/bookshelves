<template>
  <section class="wrapper relative">
    <Head :title="title" />
    <main class="content">
      <slot></slot>
    </main>
    <app-footer class="footer" />
  </section>
</template>

<script>
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import JetBanner from '@/Jetstream/Banner.vue'
import JetDropdown from '@/Jetstream/Dropdown.vue'
import JetDropdownLink from '@/Jetstream/DropdownLink.vue'
import JetNavLink from '@/Jetstream/NavLink.vue'
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue'
import { Head, Link } from '@inertiajs/inertia-vue3'
import AppFooter from '@/components/layout/app-footer.vue'

export default {
  props: {
    title: String,
  },

  components: {
    Head,
    JetApplicationMark,
    JetBanner,
    JetDropdown,
    JetDropdownLink,
    JetNavLink,
    JetResponsiveNavLink,
    Link,
    AppFooter,
  },

  data() {
    return {
      showingNavigationDropdown: false,
    }
  },

  methods: {
    switchToTeam(team) {
      this.$inertia.put(
        route('current-team.update'),
        {
          team_id: team.id,
        },
        {
          preserveState: false,
        }
      )
    },

    logout() {
      this.$inertia.post(route('logout'))
    },
  },
}
</script>

<style lang="css">
.wrapper {
  min-height: 100vh;
}
.wrapper {
  display: flex;
  flex-direction: column;
}
.content {
  flex: 1 0 auto;
}
.footer {
  flex-shrink: 0;
}
</style>

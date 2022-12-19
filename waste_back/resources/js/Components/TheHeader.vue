<template>
  <header
    class="flex justify-between items-center gap-5 bg-white border-b-2 px-4 sm:justify-end sm:px-6"
  >
    <a href="http://inspection.gov.mn/new/" target="_blank"
      ><img src="../../../public/img/mergejil.jpg" class="object-contain w-48 ..."
    /></a>
    <a
      href="https://www.eda.admin.ch/countries/mongolia/mn/home/chegzhlijn.html"
      target="_blank"
      ><img src="../../../public/img/sha.png" class="object-contain w-48 ..."
    /></a>
    <a
      href="http://www.ubservice.mn/?fbclid=IwAR0DRdfuer1AfiIURNjUTtXk4-XIjHP3H2dRBMwLw-dcMwQ1WA11mxS0fMc"
      target="_blank"
      ><img src="../../../public/img/zaa.png" class="object-contain w-20 ..."
    /></a>

    <button class="sm:hidden">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        class="h-6 w-6 text-gray-600"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"
        />
      </svg>
    </button>

    <Menu as="div" class="relative">
      <MenuButton
        class="flex items-center space-x-2 px-2 py-3 text-sm hover:bg-gray-200 focus:outline-none"
      >
        <img
          class="h-8 w-8 rounded-full"
          :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user.name}`"
          alt=""
        />
        <span> {{ $page.props.auth.user.name }}</span>
        <svg
          xmlns="http://www.w3.org/2000/svg"
          class="h-4 w-4 text-gray-600"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M19 9l-7 7-7-7"
          />
        </svg>
      </MenuButton>
      <transition
        enter-active-class="transition ease-out duration-100"
        enter-from-class="transform opacity-0 scale-95"
        enter-to-class="transform opacity-100 scale-100"
        leave-active-class="transition ease-in duration-75"
        leave-from-class="transform opacity-100 scale-100"
        leave-to-class="transform opacity-0 scale-95"
      >
        <MenuItems
          class="origin-top-right absolute right-0 w-48 shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-200 focus:outline-none"
        >
          <div>
            <MenuItem v-slot="{ active }">
              <a
                href="#"
                :class="[
                  active ? 'bg-gray-200' : '',
                  'block px-4 py-2 text-sm text-gray-700',
                ]"
                >Гарын авлага</a
              >
            </MenuItem>
            <MenuItem v-slot="{ active }">
              <a
                href="/app-release.apk"
                :class="[
                  active ? 'bg-gray-200' : '',
                  'block px-4 py-2 text-sm text-gray-700',
                ]"
                >Андройд татах</a
              >
            </MenuItem>
          </div>
          <MenuItem v-slot="{ active }">
            <inertia-link
              :href="route('logout')"
              method="post"
              :class="[
                active ? 'bg-gray-200' : '',
                'block px-4 py-2 text-sm text-gray-700',
              ]"
              >Гарах</inertia-link
            >
          </MenuItem>
        </MenuItems>
      </transition>
    </Menu>
  </header>
</template>

<script>
import { Menu, MenuButton, MenuItems, MenuItem } from "@headlessui/vue";

export default {
  components: {
    Menu,
    MenuButton,
    MenuItems,
    MenuItem,
  },
};
</script>

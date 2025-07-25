<template>
  <header class="flex items-center justify-between gap-5 px-4 bg-white border-b-2 sm:justify-end sm:px-6">
    <!-- <a href="http://inspection.gov.mn/new/" target="_blank"><img src="../../../public/img/mergejil.jpg"
                        class="object-contain w-48 ..." /></a>
                    <a href="https://www.eda.admin.ch/countries/mongolia/mn/home/chegzhlijn.html" target="_blank"><img
                        src="../../../public/img/sha.png" class="object-contain w-48 ..." /></a>
                    <a href="http://www.ubservice.mn/?fbclid=IwAR0DRdfuer1AfiIURNjUTtXk4-XIjHP3H2dRBMwLw-dcMwQ1WA11mxS0fMc"
                      target="_blank"><img src="../../../public/img/zaa.png" class="object-contain w-20 ..." /></a> -->
    <div>
      <ILink :href="route('admin.notifications.index')">
        <strong class="relative inline-flex items-center rounded border-gray-200 px-2.5 py-1.5 text-xs font-medium">
          <span v-if="$page.props.notifiCount" class="absolute flex items-center justify-center w-5 h-5 bg-red-600 rounded-full -top-2 -right-2 items"><span class="text-white">{{ $page.props.notifiCount }}</span></span>
          <span class="ml-1.5 text-gray-700"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
              <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg> </span>
        </strong>
      </ILink>
    </div>
    <button class="sm:hidden">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
      </svg>
    </button>

    <Menu as="div" class="relative ">
      <MenuButton class="flex items-center px-2 py-3 space-x-2 text-sm hover:bg-gray-200 focus:outline-none">
        <img class="w-8 h-8 rounded-full" :src="`https://ui-avatars.com/api/?name=${$page.props.auth.user.name}`" alt="" />
        <span> {{ $page.props.auth.user.name }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </MenuButton>
      <transition enter-active-class="transition duration-100 ease-out" enter-from-class="transform scale-95 opacity-0" enter-to-class="transform scale-100 opacity-100" leave-active-class="transition duration-75 ease-in" leave-from-class="transform scale-100 opacity-100" leave-to-class="transform scale-95 opacity-0">
        <MenuItems class="absolute right-0 w-48 py-1 origin-top-right bg-white divide-y divide-gray-200 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
          <div>
            <MenuItem v-slot="{ active }">
            <ILink href="/profile" :class="[
              active ? 'bg-gray-200' : '',
              'block px-4 py-2 text-sm text-gray-700',
            ]">Нууц үг солих</ILink>
            </MenuItem>
            <MenuItem v-slot="{ active }">
            <a href="/Waste_usermanual.pdf" target="_blank" :class="[
              active ? 'bg-gray-200' : '',
              'block px-4 py-2 text-sm text-gray-700',
            ]">Гарын авлага</a>
            </MenuItem>
            <MenuItem v-slot="{ active }">
            <a href="https://waste.mecc.gov.mn/waste.apk" target="_blank" :class="[
              active ? 'bg-gray-200' : '',
              'block px-4 py-2 text-sm text-gray-700',
            ]">Андройд татах</a>
            </MenuItem>
          </div>
          <MenuItem v-slot="{ active }">
          <ILink :href="route('logout')" method="post" as="button" class="w-full text-left" :class="[
            active ? 'bg-gray-200' : '',
            'block px-4 py-2 text-sm text-gray-700',
          ]">Гарах</ILink>
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
